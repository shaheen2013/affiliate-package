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
use Mediusware\Affiliate\Models\AffiliateIncome;
use Mediusware\Affiliate\Models\AffiliatePayment;
use Mediusware\Affiliate\Models\AffiliateInvitation;

class AffiliateController extends Controller
{
    public function dashboard(Request $request)
    {
        $affiliate = Affiliate::where('user_id', Auth::user()->id)->first();

        if (empty($affiliate) || $affiliate->status!='Approved') {
            return view('affiliate::user.registration', compact('affiliate'));
        }
        $payments = AffiliatePayment::where('user_id', Auth::user()->id)->first();
        $banners = AffiliateBanner::with('activeBannerUser')->where('status', 'Active')->get();
        $invitations = AffiliateInvitation::where('affiliate_user_id', Auth::user()->id)->get();
        $incomes = AffiliateIncome::where('income_user_id', Auth::user()->id)->sum('income_amount');
        return view('affiliate::user.dashboard', compact('affiliate', 'payments', 'banners', 'invitations', 'incomes'));
    }

    public function showDetails(Request $request)
    {
        if ($request->key=='signup') {
            $invitations = AffiliateInvitation::with('registerUser')->where('affiliate_user_id', Auth::user()->id)->get();
            return response()->json(['success' =>true , 'records' => $invitations]);
        } elseif ($request->key=='income') {
            $incomes = AffiliateIncome::with('paidUser')->where('income_user_id', Auth::user()->id)->get();
            return response()->json(['success' =>true , 'records' => $incomes]);
        }
        return response()->json(['success' =>false , 'message' =>'No Request found']);

    }

    public function invitation(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'emails' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()]);
        }


        $emails = explode(',', $request->emails);
        $affiliate = Affiliate::with('user')->where('user_id', Auth::user()->id)->first();
        Mail::send('affiliate::emails.invitation', ['affiliate' => $affiliate, 'request' => $request], function ($message) use($emails) {
            $message->subject(env('SITE_NAME').' Registration Invitation');
            $message->from(config('affiliate.admin_mail_from'), config('affiliate.admin_mail_name'));
            $message->to($emails);
        });
        return response()->json(['success' =>true , 'message' =>'Invitation link sent successfully.', 'to' => $emails]);
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

    public function getCommission($amount)
    {
        $invitations = AffiliateInvitation::where('register_user_id', Auth::user()->id)->first();
        if (!empty($invitations)) {
            $aff = AffiliateIncome::create([
                'paid_user_id' => Auth::user()->id,
                'paid_amount' => $amount,
                'income_user_id' => $invitations->affiliate_user_id,
                'income_commission' => $invitations->affiliate_commission,
                'income_amount' => (($amount*$invitations->affiliate_commission)/100),
            ]);
            return true;
        }
        return false;
    }
}
