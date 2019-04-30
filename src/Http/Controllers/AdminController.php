<?php

namespace Mediusware\Affiliate\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Mediusware\Affiliate\Models\Affiliate;
use Mediusware\Affiliate\Models\AffiliateBanner;
use Mediusware\Affiliate\Models\AffiliateInvitation;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $records = Affiliate::with('user')->where('status', 'Approved')->get();
        return view('affiliate::admin.affiliate-user', compact('records'))->with('title', 'Affiliate Users');
    }

    public function show($id)
    {
        $data = Affiliate::with('user', 'payment', 'activeBanner')->where('status', 'Approved')->where('id', $id)->first();
        return view('affiliate::admin.affiliate-user-show', compact('data'))->with('title', 'Affiliate Users');
    }

    //Affiliate Request Section...
    public function allAffiliate()
    {
        $records = Affiliate::with('user')->get();
        return view('affiliate::admin.request-list', compact('records'))->with('title', 'All');
    }

    public function pendingAffiliate()
    {
        $records = Affiliate::with('user')->where('status', 'Pending')->get();
        return view('affiliate::admin.request-list', compact('records'))->with('title', 'Pending');
    }

    public function approvedAffiliate()
    {
        $records = Affiliate::with('user')->where('status', 'Approved')->get();
        return view('affiliate::admin.request-list', compact('records'))->with('title', 'Approved');
    }

    public function rejectedAffiliate()
    {
        $records = Affiliate::with('user')->where('status', 'Rejected')->get();
        return view('affiliate::admin.request-list', compact('records'))->with('title', 'Rejected');
    }

    public function statusAffiliate(Request $request, $id, $status)
    {
        $statusData = [];
        if ($status=='rejected') {
            $statusData = [
                'status' => ucwords($status),
            ];
        }
        if ($status=='approved') {
            $validator = \Validator::make($request->all(), [
                'commission' => 'required|numeric|min:1|max:99',
                'use_limit' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('success', $validator->errors()->first());
            }

            $statusData = [
                'commission' => $request->commission,
                'use_limit' => $request->use_limit,
                'affiliate_code' => Str::random(10),
                'status' => ucwords($status),
            ];
        }
        $affiliate = Affiliate::findOrFail($id);
        $affiliate->update($statusData);
        return redirect()->back()->with('success', ucwords($status).' successfully');
    }

    public function deleteAffiliate($id)
    {
        $affiliate = Affiliate::findOrFail($id);
        $affiliate->delete();
        return redirect()->back()->with('success', 'Delete successfully');
    }

    //Dashboard Section...
    public function dashboard(Request $request, $key = null)
    {
        $showTab = $key;
        $invitations = AffiliateInvitation::with(['registerUser', 'affiliateUser'])->get();
        // if ($key=='sign-up') {
        // }
        return view('affiliate::admin.dashboard', compact('showTab', 'invitations'));
    }

    //Banner Section...
    public function banner($id = null)
    {
        $data = [];
        if ($id) {
            $data = AffiliateBanner::find($id);
        }

        $records = AffiliateBanner::get();
        return view('affiliate::admin.banner', compact('records', 'data'));
    }

    public function bannerPost(Request $request)
    {
        if ($request->id=='') {
            $data = $this->validate($request, [
                'banner_image' => 'required|image:jpg'
            ]);
        }

        if ($request->hasFile('banner_image')) {
            $image = $request->file('banner_image');
            $imageName = $image->getClientOriginalName();
            $ext = $image->getClientOriginalExtension();
            $fileName = "b-".time().'.'.$ext;

            $directory = public_path('images/affiliateBanners/');

            if(!is_dir($directory)) {
                mkdir($directory, 0777);
            }

            $imageUrl = $directory.$fileName;
            Image::make($image)->resize(800, 530)->save($imageUrl);

            $data['banner_image'] = $fileName;
        }

        $data['banner_heading'] = $request->banner_heading;
        $data['banner_message'] = $request->banner_message;
        $data['status'] = $request->status;
        $data['user_id'] = Auth::id();
        if ($request->id>0) {
            $find = AffiliateBanner::find($request->id);
            $find->update($data);
        } else {
            AffiliateBanner::create($data);
        }
        return redirect()->back()->with('success', 'Save successfully');
    }

    public function bannerDestroy($id)
    {
        $banner = AffiliateBanner::findOrFail($id);
        $path = public_path('images/affiliateBanners/').$banner->image;
        if (file_exists($path)){
            unlink($path);
        }
        $banner->delete();
        return redirect('admin/affiliate-banner')->with('success', 'Deleted successfully');
    }


}
