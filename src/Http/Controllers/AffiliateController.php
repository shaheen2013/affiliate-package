<?php

namespace Mediusware\Affiliate\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mediusware\Affiliate\Models\Affiliate;

class AffiliateController extends Controller
{

    public function index()
    {
        return view('affiliate::affiliate');
    }

    public function store(Request $request)
    {
        Affiliate::create(['name' => $request->name, 'email' => config('affiliate.admin_mail_to')]);
        return redirect()->route('test');
    }

}
