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
                    <div id="tab-stats" class="tab-pane active">
                        <div class="form-row">
                            <div class="form-group col-md-3 text-center">
                                <div class="subscribe-card">
                                    <h3><span class="color-orange">Total Signups</span></h3>
                                    <p class="premium-sub-title">{{count($invitations)}}</p>
                                    <div class="text-center premium-position">
                                        <a class="btn btn-free" onclick="showDetails('signup')">Show Details</a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-3 text-center">
                                <div class="subscribe-card">
                                    <h3><span class="color-orange">Total Income</span></h3>
                                    <p class="premium-sub-title">$100</p>
                                    <div class="text-center premium-position">
                                        <a class="btn btn-free">Show Details</a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-3 text-center">
                                <div class="subscribe-card">
                                    <h3><span class="color-orange">Paidout Amount</span></h3>
                                    <p class="premium-sub-title">$60</p>
                                    <div class="text-center premium-position">
                                        <a class="btn btn-free">Show Details</a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-3 text-center">
                                <div class="subscribe-card">
                                    <h3><span class="color-orange">Balance Amount</span></h3>
                                    <p class="premium-sub-title">$40</p>
                                    <div class="text-center premium-position">
                                        <a class="btn btn-free">Show Details</a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <form action="{{ route('affiliate.invitation') }}" method="post" id="invitationForm" autocomplete="off">
                                    @csrf

                                    <div class="form-row seprator-group">
                                        <div class="form-group col-md-12">
                                            <div class="seprator">SEND INVITATION</div>
                                            <p class="invitation-success text-success"></p>
                                            <p class="text-success"><strong>Invitation Link: {{url('/i/'.$affiliate->affiliate_code.'/'.$affiliate->user_code)}}</strong></p>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Email ID</label>
                                            <input type="text" class="form-control" id="emails" name="emails" placeholder="Use coma separator for multiple email">
                                            <div class="ee error-emails" style="display:none;color: red;">Email ID is required.</div>
                                        </div>
                                        <div class="col-md-12">&nbsp;</div>

                                        <div class="form-group col-md-12">
                                            <label>Custom Message:</label>
                                            <textarea class="form-control" id="custom_message" name="custom_message" placeholder="Custom Message"></textarea>
                                        </div>
                                        <div class="form-group col-md-12 text-center">
                                            <button type="submit" class="btn btn-danger" id="invitationSubmit">Send</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="tab-payments" class="tab-pane fade">
                        <form action="{{ route('affiliate.payment.store') }}" method="post" id="alliliatePaymentForm" autocomplete="off">
                            @csrf

                            <div class="form-row seprator-group">
                                <div class="form-group col-md-12">
                                    <div class="seprator">PAYMENT INFORMATION</div>
                                    <p class="text-success success"></p>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Paypal Email ID</label>
                                    <input type="text" class="form-control" id="paypal_email" name="paypal_email" placeholder="Paypal Email ID" value="{{ isset($payments->paypal_email)?$payments->paypal_email:'' }}">
                                    <div class="ee error-paypal_email" style="display:none;color: red;">Paypal Email ID is required.</div>
                                </div>
                                <div class="col-md-12">&nbsp;</div>

                                <div class="form-group col-md-6">
                                    <label>Card Holder Name:</label>
                                    <input type="text" class="form-control" id="card_holder_name" name="card_holder_name" placeholder="Card Holder Name" value="{{ isset($payments->card_holder_name)?$payments->card_holder_name:'' }}">
                                    <div class="ee error-card_holder_name" style="display:none;color: red;">Card Holder Name is required.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Card Number:</label>
                                    <input type="text" class="form-control" id="card_number" name="card_number" placeholder="Card Number" value="{{ isset($payments->card_number)?$payments->card_number:'' }}">
                                    <div class="ee error-card_number" style="display:none;color: red;">Card Number is required.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Expiration Date:</label>
                                    <input type="text" class="form-control" id="card_expire" name="card_expire" placeholder="MM/YYYY" value="{{ isset($payments->card_expire)?$payments->card_expire:'' }}">
                                    <div class="ee error-card_expire" style="display:none;color: red;">Expiration Date is required.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Secure Code (CVV2):</label>
                                    <input type="text" class="form-control" id="card_cvc" name="card_cvc" placeholder="CVC" value="{{ isset($payments->card_cvc)?$payments->card_cvc:'' }}">
                                    <div class="ee error-card_cvc" style="display:none;color: red;">Secure Code (CVV2) is required.</div>
                                </div>
                                <div class="form-group col-md-12 text-center">
                                    <button type="submit" class="btn btn-danger" id="alliliatePaymentSubmit">Setup Payment Information</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="tab-banners" class="tab-pane fade">
                        <div class="form-row">
                            @if(!empty($banners))
                                @foreach($banners as $ban)
                                <div class="form-group col-md-6 text-center">
                                    <div class="subscribe-card">
                                        <h3><span class="color-orange">{{$ban->banner_heading}}</span></h3>
                                        <img src="{!! url('images/affiliateBanners/'.data('banner_image', $ban))!!}" style="width:100%;" />
                                        <div class="text-center premium-position" id="buttonGroup{{$ban->id}}">
                                            @if(!empty($ban->activeBannerUser))
                                                <p class="text-success"><strong>Copy Link & Share: {{url('/i/'.$affiliate->affiliate_code.'/'.$affiliate->user_code)}}</strong></p>
                                                <a class="btn btn-success">Activated</a>
                                            @else
                                                <p class="text-success">&nbsp;</p>
                                                <a class="btn btn-free" onclick="activeBanner({{$ban->id}})">Active</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="form-group col-md-12 text-center">
                                    <h3>No banner set yet!</h3>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="bannerModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('affiliate.banner.store') }}" id="bannerForm">
            <input type="hidden" name="_token" id="aff_banner_token" required>
            <input type="hidden" name="banner_id" id="banner_id" required>
            <div class="modal-content">
                <div class="modal-body">
                    <p class="banner-errors text-danger"></p>
                    <p class="banner-success text-success"></p>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Custom Short Code: </span>
                            </div>
                            <input type="text" class="form-control" name="user_code" id="user_code" placeholder="Min 8 digit & Max 20 Digit">
                        </div>
                        <div class="ee error-banner_id" style="display:none;color: red;">Banner ID is required.</div>
                        <div class="ee error-user_code" style="display:none;color: red;"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
                    <button type="submit" class="btn btn-success" id="bannerSubmit">Set</button>
                </div>
            </div>
        </form>
    </div>
</div>



<div class="modal" id="detailsModal">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">User Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Commission</th>
                        </thead>
                        <tbody id="responseDetails">

                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        //Invitation Form Submit...
        $("#invitationForm").on("submit", function (e) {
            e.preventDefault();

            var emails = $("#emails").val();
            var custom_message = $("#custom_message").val();
            var errorStatus = false;

            if (emails == "") {
                $(".error-emails").show();
            }

            $('.ee').hide();
            $('#invitationSubmit').prop('disabled',true);

            $.ajax({
                type: "POST",
                url: "{{ route('affiliate.invitation') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    emails: emails,
                    custom_message: custom_message,
                },
                complete : function (data) {
                    $('#invitationSubmit').prop('disabled',false);
                },
                success: function (data) {
                    if (!data.success) {
                        var err = data.errors;
                        for (var key in err) {
                            if (err.hasOwnProperty(key)) {
                                if (err[key] != "") {
                                    $(".error-" + key).text(err[key]).show();
                                };
                            }
                        }
                    }

                    if (data.success) {
                        $(".invitation-success").text(data.message);
                        $('#invitationForm').trigger("reset");
                    }
                }
            });
        });

        //Payment Form Submit...
        $("#alliliatePaymentForm").on("submit", function (e) {
            e.preventDefault();

            var paypal_email = $("#paypal_email").val();
            var card_holder_name = $("#card_holder_name").val();
            var card_number = $("#card_number").val();
            var card_expire = $("#card_expire").val();
            var card_cvc = $("#card_cvc").val();
            var errorStatus = 0;

            $('.ee').hide();
            $('#alliliatePaymentSubmit').prop('disabled',true);


            if (paypal_email == "") {
                errorStatus += 1;
            }
            if (card_holder_name == "" || card_number == "" || card_expire == "" || card_cvc == "") {
                errorStatus += 1;
            }

            if(errorStatus==2){
                $(".error-paypal_email").show();

                if (card_holder_name == "") {
                    $(".error-card_holder_name").show();
                }
                if(card_number == ""){
                    $(".error-card_number").show();
                }
                if(card_expire == ""){
                    $(".error-card_expire").show();
                }
                if (card_cvc == "") {
                    $(".error-card_cvc").show();
                }
            }

            $.ajax({
                type: "POST",
                url: "{{ route('affiliate.payment.store') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    paypal_email: paypal_email,
                    card_holder_name: card_holder_name,
                    card_number: card_number,
                    card_expire: card_expire,
                    card_cvc: card_cvc,
                },
                complete : function (data) {
                    $('#alliliatePaymentSubmit').prop('disabled',false);
                },
                success: function (data) {
                    if (!data.success) {
                        var err = data.errors;
                        for (var key in err) {
                            if (err.hasOwnProperty(key)) {
                                if (err[key] != "") {
                                    $("#basicplan .error-" + key).text(err[key]).show();
                                };
                            }
                        }
                    }

                    if (data.success) {
                        $(".success").text(data.message);
                    }
                }
            });
        });

        //Banner Form Submit...
        $("#bannerForm").on("submit", function (e) {
            e.preventDefault();

            var banner_id = $("#banner_id").val();
            var user_code = $("#user_code").val();
            var errorStatus = false;

            if (banner_id == "") {
                $(".error-banner_id").show();
            }

            $('.ee').hide();
            $('#bannerSubmit').prop('disabled',true);

            $.ajax({
                type: "POST",
                url: "{{ route('affiliate.banner.store') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    banner_id: banner_id,
                    user_code: user_code,
                },
                complete : function (data) {
                    $('#bannerSubmit').prop('disabled',false);
                },
                success: function (data) {
                    if (!data.success) {
                        $(".banner-errors").text(data.message);

                        var err = data.errors;
                        for (var key in err) {
                            if (err.hasOwnProperty(key)) {
                                if (err[key] != "") {
                                    $(".error-" + key).text(err[key]).show();
                                };
                            }
                        }
                    }

                    if (data.success) {
                        $(".banner-success").text(data.message);
                        $('#bannerForm').trigger("reset");
                        $('#buttonGroup'+banner_id).html('<a class="btn btn-success">Activated</a>');
                    }
                }
            });
        });
    });

    function showDetails(key) {
        $.ajax({
            type: "GET",
            url: "{{ route('affiliate.show.details') }}",
            data: {
                key: key,
            },
            success: function (data) {
                var html = '';
                var records = data.records;
                for(var x = 0; x < records.length; x++) {
                    html += '<tr>'+
                        '<td><img src="./images/users/profile/'+records[x].register_user.profile_img+'"></td>'+
                        '<td>'+records[x].register_user.name+' '+records[x].register_user.last_name+'</td>'+
                        '<td>'+records[x].affiliate_commission+'%</td>'+
                    '</tr>';
                }
                $('#responseDetails').html(html);
                $('#detailsModal').modal();

                //responseDetails
                //profile_img
            }
        });
    }

    function activeBanner(id) {
        $('#banner_id').val(id);
        $('#aff_banner_token').val($('meta[name="csrf-token"]').attr('content'));
        $('#bannerModal').modal();
    }
</script>
@endsection
