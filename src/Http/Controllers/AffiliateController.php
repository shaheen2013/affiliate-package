<?php

namespace Mediusware\Affiliate\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Mediusware\Affiliate\Models\Affiliate;
use Mediusware\Affiliate\Models\AffiliateBanner;
use Mediusware\Affiliate\Models\AffiliatePayment;

class AffiliateController extends Controller
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

            Mail::send('affiliate::emails.registration-notify-user', ['user' => $user, 'aff' => $aff], function ($message) use ($user) {
                $message->subject('Registration Complete');
                $message->from(config('affiliate.admin_mail_from'), config('affiliate.admin_mail_name'));
                $message->to($user->email, $user->name.' '.$user->last_name);
            });

            Mail::send('affiliate::emails.registration-notify-admin', ['user' => $user, 'aff' => $aff], function ($message) {
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


    //User Panel Process...
    public function dashboard(Request $request)
    {
        $affiliate = Affiliate::where('user_id', Auth::user()->id)->where('status', 'Approved')->first();

        if (empty($affiliate)) {
            return view('affiliate::user.blank');
        }
        $banners = AffiliateBanner::with('activeBannerUser')->where('status', 'Active')->get();
        $payments = AffiliatePayment::where('user_id', Auth::user()->id)->first();
        return view('affiliate::user.dashboard', compact('affiliate', 'payments', 'banners'));
    }

    public function paymentStore(Request $request)
    {
        $input = $request->all();
        $user = AffiliatePayment::updateOrCreate(
            ['user_id' => Auth::user()->id],
            [
                'user_id' => Auth::user()->id,
                'paypal_email' => $input['paypal_email'],
                'card_holder_name' => $input['card_holder_name'],
                'card_number' => $input['card_number'],
                'card_expire' => $input['card_expire'],
                'card_cvc' => $input['card_cvc']
            ]
        );

        if ($user) {
            return response()->json(['success' =>true , 'message' =>'Payment details added successfully.']);
        } else {
            return response()->json(['success' =>false , 'message' =>'Payment details adding failed.']);
        }
    }

    public function bannerStore(Request $request)
    {
        if ($request->user_code!='') {
            $validator = \Validator::make($request->all(), [
                'banner_id' => 'required',
                'user_code' => 'string|min:8|max:20',
            ]);
        } else {
            $validator = \Validator::make($request->all(), [
                'banner_id' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }

        $input = $request->all();
        $data = Affiliate::where('user_id', Auth::user()->id)->first();
        $return = $data->update([
            'banner_id' => $input['banner_id'],
            'user_code' => $input['user_code'],
        ]);

        if ($return) {
            return response()->json(['success' =>true , 'message' =>'Banner added successfully.']);
        } else {
            return response()->json(['success' =>false , 'message' =>'Banner adding failed.']);
        }
    }
}
