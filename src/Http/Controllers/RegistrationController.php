<?php

namespace Mediusware\Affiliate\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Mediusware\Affiliate\Models\Affiliate;
use Mediusware\Affiliate\Models\AffiliateInvitation;

class RegistrationController extends Controller
{
    public function index()
    {
        $lp = \App\Models\LandingPage::where('id', '=', 1)->first();
        $countries = \App\Models\Country::select('id','name','phonecode')->get();

        return view('affiliate::affiliate', compact('lp', 'countries'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'firstname' => 'required|string|min:3|max:18',
            'lastname' => 'required|string|min:3|max:18',
            'email' => 'required|string|email|max:55|unique:users',
            'password' => 'required|string|min:6|max:18',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        $input = $request->all();
        $formData = [
            'name' => $input['firstname'],
            'last_name' => $input['lastname'],
            'country_id' => $input['country_id'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ];
        $user = User::create($formData);
        // Auto generate username based on there email
        $username = explode('@',$input['email'])[0];
        $user->username = strtolower($username).'-'.$user->id;
        $user->save();

        if ($user) {
            $aff = Affiliate::create([
                'user_id' => $user->id,
                'promotion_message' => $input['promotion_message'],
                'website_url' => $input['website_url'],
            ]);

            Mail::send('affiliate::emails.reg-affiliate-notify-user', ['user' => $user, 'aff' => $aff], function ($message) use ($user) {
                $message->subject('Registration Complete');
                $message->from(config('affiliate.admin_mail_from'), config('affiliate.admin_mail_name'));
                $message->to($user->email, $user->name.' '.$user->last_name);
            });

            Mail::send('affiliate::emails.reg-affiliate-notify-admin', ['user' => $user, 'aff' => $aff], function ($message) {
                $message->subject('New User Send A Affiliate Request');
                $message->from(config('affiliate.admin_mail_from'), config('affiliate.admin_mail_name'));
                $message->to(config('affiliate.admin_mail_to'), config('affiliate.admin_mail_name'));
            });
        }
        if ($aff) {
            return response()->json(['success' =>true , 'message' =>'Account created successfully! When activated your account you will notify via email.']);
        } else {
            return response()->json(['success' =>false , 'message' =>'Account creating failed.']);
        }
    }

    public function registration(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'promotion_message' => 'required',
            'website_url' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        $input = $request->all();
        $aff = Affiliate::create([
            'user_id' =>Auth::user()->id,
            'promotion_message' => $input['promotion_message'],
            'website_url' => $input['website_url'],
        ]);

        if ($aff) {
            $user = User::find(Auth::user()->id);
            Mail::send('affiliate::emails.reg-affiliate-notify-user', ['user' => $user, 'aff' => $aff], function ($message) use ($user) {
                $message->subject('Registration Complete');
                $message->from(config('affiliate.admin_mail_from'), config('affiliate.admin_mail_name'));
                $message->to($user->email, $user->name.' '.$user->last_name);
            });

            Mail::send('affiliate::emails.reg-affiliate-notify-admin', ['user' => $user, 'aff' => $aff], function ($message) {
                $message->subject('New User Send A Affiliate Request');
                $message->from(config('affiliate.admin_mail_from'), config('affiliate.admin_mail_name'));
                $message->to(config('affiliate.admin_mail_to'), config('affiliate.admin_mail_name'));
            });

            return response()->json(['success' =>true , 'message' =>'Account created successfully! When activated your account you will notify via email.']);
        } else {
            return response()->json(['success' =>false , 'message' =>'Account creating failed.']);
        }
    }


    public function invitation($code)
    {
        $affiliate = Affiliate::where('affiliate_code', $code)->first();
        if (empty($affiliate)) {
            echo 'Invalid URL';exit;
        }

        Cookie::queue('affiliate', $code, 1800);

        $lp = \App\Models\LandingPage::where('id', '=', 1)->first();
        $countries = \App\Models\Country::select('id','name','phonecode')->get();

        return view('affiliate::reg-form', compact('lp', 'countries', 'affiliate'));
    }

    public function invitationStore(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'firstname' => 'required|string|min:3|max:18',
            'lastname' => 'required|string|min:3|max:18',
            'country_id' => 'required',
            'phone' => 'required',
            'password' => 'required|string|min:6|max:18',
            'dob' => 'required',
            'email' => 'required|string|email|max:55|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        $input = $request->all();
        $formData = [
            'name' => $input['firstname'],
            'last_name' => $input['lastname'],
            'country_id' => $input['country_id'],
            'phone' => $input['phone'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ];
        $user = User::create($formData);
        // Auto generate username based on there email
        $username = explode('@',$input['email'])[0];
        $user->username = strtolower($username).'-'.$user->id;
        $user->save();

        if ($user) {
            $code = Cookie::get('affiliate');
            $affiliate = Affiliate::where('affiliate_code', $code)->first();
            $aff = AffiliateInvitation::create([
                'register_user_id' => $user->id,
                'affiliate_id' => $affiliate->id,
                'affiliate_user_id' => $affiliate->user_id,
                'affiliate_commission' => $affiliate->commission,
            ]);

            Cookie::forget('affiliate');

            Mail::send('affiliate::emails.registration-notify-admin', ['user' => $user], function ($message) {
                $message->subject('New User Register');
                $message->from(config('affiliate.admin_mail_from'), config('affiliate.admin_mail_name'));
                $message->to(config('affiliate.admin_mail_to'), config('affiliate.admin_mail_name'));
            });
        }
        if ($aff) {
            return response()->json(['success' =>true , 'message' =>'Account created successfully! Please verify your email.']);
        } else {
            return response()->json(['success' =>false , 'message' =>'Account creating failed.']);
        }
    }
}
