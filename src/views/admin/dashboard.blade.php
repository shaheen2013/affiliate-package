@extends('admin.master')

@section('title')
    Admin | News and update
@endsection

@section('breadcrumbs')
    <li>Affiliate and update</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admin/affiliate-dashboard/sign-up') }}">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Signups</span>
                <span class="info-box-number">{{count($invitations)}}</span>
            </div>
        </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Income</span>
                <span class="info-box-number">$90</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Paidout Amount</span>
                <span class="info-box-number">$90</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Remaining Paidout Amount</span>
                <span class="info-box-number">$90</span>
            </div>
        </div>
    </div>
</div>

@if($showTab=='sign-up')
<div class="row">
    <div class="col-sm-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Signup Users</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2">Signup Datetime</th>
                                <th colspan="2" class="text-center">Register User</th>
                                <th colspan="3" class="text-center">Affiliate User</th>
                            </tr>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>

                                <th>Image</th>
                                <th>Name</th>
                                <th>Commission</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invitations as $inv)
                            <tr>
                                <td>{{$inv->created_at}}</td>
                                <td><img src="./images/users/profile/{{$inv->registerUser->profile_img}}"></td>
                                <td>{{$inv->registerUser->name}} {{$inv->registerUser->last_name}}</td>

                                <td><img src="./images/users/profile/{{$inv->affiliateUser->profile_img}}"></td>
                                <td>{{$inv->affiliateUser->name}} {{$inv->affiliateUser->last_name}}</td>
                                <td>{{$inv->affiliate_commission}}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
