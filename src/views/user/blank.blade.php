@extends('affiliate::user.layout')
@section('content')
<div>
    <div class="col-lg-12">
        <ul class="nav nav-tabs theme">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab-stats">STATS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-payments">PAYMENTS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-banners">BANNERS</a>
            </li>
        </ul>
    </div>

    <div class="col-lg-12">
        <div class="row">
            <div class="col">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="form-row">
                            <div class="form-group col-md-12 text-center">
                                <h3>Your Account is not activated yet!</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
