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
                            <div class="form-group col-md-12">
                                @if (!empty($affiliate) && $affiliate->status=='Pending')
                                    <h3 class="text-center">Your Affliate Account is not activated yet!</h3>
                                @elseif(!empty($affiliate) && $affiliate->status=='Rejected')
                                    <h3 class="text-center">Your Affliate request is rejected!</h3>
                                @else
                                    <h3 class="text-center">Register your Affliate Account</h3>
                                    <form action="{{ route('affiliate.registration') }}" method="post" id="alliliateRegiForm" autocomplete="off">
                                        @csrf

                                        <div class="form-row seprator-group">
                                            <div class="form-group col-md-12">
                                                <div class="seprator">PAYMENT INFORMATION</div>
                                                <p class="text-success success"></p>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>How will you Produce Us?*</label>
                                                <textarea class="form-control" id="promotion_message" name="promotion_message" placeholder="How will you Produce Us?*"></textarea>
                                                <div class="ee error-promotion_message" style="display:none;color: red;">Produce Message is required.</div>
                                            </div>
                                            <div class="col-md-12">&nbsp;</div>

                                            <div class="form-group col-md-12">
                                                <label>Website URL*</label>
                                                <input type="text" class="form-control" id="website_url" name="website_url" placeholder="Website URL">
                                                <div class="ee error-website_url" style="display:none;color: red;">Website URL is required.</div>
                                            </div>
                                            <div class="form-group col-md-12 text-center">
                                                <button type="submit" class="btn btn-danger" id="alliliateRegiSubmit">Apply</button>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#alliliateRegiForm").on("submit", function (e) {
            e.preventDefault();
            var promotion_message = $("#promotion_message").val();
            var website_url = $("#website_url").val();
            var errorStatus = false;

            $('.ee').hide();
            $('#alliliateRegiSubmit').prop('disabled',true);

            if (website_url == "") {
                $(".error-website_url").show();
                errorStatus = true;
            }
            if (promotion_message == "") {
                $(".error-promotion_message").show();
                errorStatus = true;
            }
            if(errorStatus){
                errorStatus = true;
            }

            $.ajax({
                type: "POST",
                url: "{{ route('affiliate.registration') }}",
                data: {
                    promotion_message: promotion_message,
                    website_url: website_url,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                complete : function (data) {
                    $('#alliliateRegiSubmit').prop('disabled',false);
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
                        $(".success").text(data.message);
                        setTimeout(function () {
                            window.location.reload(true);
                        }, 5000);
                    }
                }
            });
        });
    });
</script>
@endsection
