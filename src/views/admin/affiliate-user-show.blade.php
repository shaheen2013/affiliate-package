@extends('admin.master')

@section('title')
    Admin | News and update
@endsection

@section('breadcrumbs')
    <li>Affiliate and update</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 mt-5">
        <h3 class="col-sm-12 text-center">{{ Session::get('success') ?:'' }}</h3>
        <div class="box">
            <div class="box-body">
                <h4 class="header-title">{{ $title }}</h4>
                @if(!empty($data->activeBanner))
                <div class="col-sm-12">
                    <img src="{!! url('images/affiliateBanners/'.$data->activeBanner->banner_image) !!}" style="width:100%;" /></td>
                </div>
                @endif

                <div class="col-sm-6">
                    <table class="table table-hover w-100">
                        <tbody>
                        <tr>
                            <th>Name: </th>
                            <td>{{ $data->user->name }} {{ $data->user->last_name }}</td>
                        </tr>
                        <tr>
                            <th>Username: </th>
                            <td>{{ $data->user->username }}</td>
                        </tr>
                        <tr>
                            <th>Email: </th>
                            <td>{{ $data->user->email }}</td>
                        </tr>
                        <tr>
                            <th>Affiliate Code: </th>
                            <td>{{ $data->affiliate_code }}</td>
                        </tr>
                        <tr>
                            <th>User Code: </th>
                            <td>{{ $data->user_code }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-sm-6">
                    <table class="table table-hover w-100">
                        <tbody>
                        <tr>
                            <th>Commission: </th>
                            <td>{{ $data->commission }} %</td>
                        </tr>
                        <tr>
                            <th>Use Limit: </th>
                            <td>{{ $data->use_limit }}</td>
                        </tr>
                        <tr>
                            <th>Website URL: </th>
                            <td>{{ $data->website_url }}</td>
                        </tr>
                        <tr>
                            <th>Promotion Message: </th>
                            <td>{{ $data->promotion_message }}</td>
                        </tr>
                        @if(!empty($data->payment))
                            @if($data->payment->paypal_email!='')
                            <tr>
                                <th>Paypal: </th>
                                <td>{{ $data->payment->paypal_email }}</td>
                            </tr>
                            @endif
                            @if($data->payment->card_number!='')
                            <tr>
                                <th>Card: </th>
                                <td>
                                    Card Holder Name: {{ $data->payment->card_holder_name }}<br>
                                    Card Number: {{ $data->payment->card_number }}<br>
                                    Card Expire: {{ $data->payment->card_expire }}<br>
                                    Card CVC: {{ $data->payment->card_cvc }}
                                </td>
                            </tr>
                            @endif
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
