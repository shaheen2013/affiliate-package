@extends('layouts.app')
@section('content')
<div class="col-md-12 main-content">
    <div class="row bgImage">
        <div class="col-md-6 col-md-offset-3 cont-left">
            <div class="packagesinner">
                <form action="{{ route('affiliate.invitationStore') }}" method="post" id="alliliateForm">
                    @csrf
                    <div class="popupTitle">Sign Up</div>
                    <div class="success" style="color: green; font-weight: bold;">
                    </div>

                    <div class="popupformo">
                        <div class="popupform">
                            <input type="text" id="af_firstname" name="firstname" placeholder="First name*" class="text rqd">
                            <div class="ee error-af_firstname" style="display:none;color: red;">First name is required.</div>
                        </div>
                        <div class="popupform">
                            <input type="text" id="af_lastname" name="lastname" placeholder="Last name*" class="text rqd">
                            <div class="ee error-af_lastname" style="display:none;color: red;">Last name is required.</div>
                        </div>
                    </div>

                    <div class="popupformo">
                        <div class="popupform">
                            <select id="af_country_id" name="af_country_id" style="outline:none;" onchange="showCode(this)" class="text custom-select">
                                <option disabled selected>Country*</option>
                                @foreach($countries as $country)
                                <option value="{{$country->id}}"  title="+{{$country->phonecode}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                            <div class="ee error-af_country_id" style="display:none;color: red;">Country name is required.</div>
                        </div>

                        <div class="popupform">
                            <input type="tel" id="af_code" name="af_code" disabled placeholder="+00" class="text rqd" style="position: absolute; width: 42px;">
                            <input type="text" minlength="8" maxlength="15" id="af_phone" name="af_phone" style="padding-left: 42px;" placeholder="Phone*" class="text rqd">
                            <div class="ee error-af_phone" style="display:none;color: red;">Phone number is required.</div>
                        </div>
                    </div>

                    <div class="popupformo">
                        <div class="popupform">
                            <input type="password" id="af_password" name="password" placeholder="Password*" class="text rqd"
                                autocomplete="off">
                            <div class="ee error-af_password" style="display:none;color: red;">Password is required.</div>
                        </div>
                        <div class="popupform">
                            <input type="af_password" id="c_af_password" name="c_af_password" placeholder="Confirm password*" class="text rqd"
                                autocomplete="off">
                            <div class="ee error-c_af_password" style="display:none;color: red;">Confirm af_password is required.</div>
                            <div class="ee error-c_af_password_not_match" style="display:none;color: red;">Passwords do not match</div>
                        </div>
                    </div>

                    <div class="popupformo">
                        <div class="popupform">
                            <input type="text" id="af_dob" name="af_dob" placeholder="Date of birth*" class="text rqd"
                                autocomplete="off">
                            <div class="ee error-af_dob" style="display:none;color: red;">Date of birth field is required.</div>
                        </div>
                        <div class="popupform">
                            <input type="email" id="af_email" name="af_email" placeholder="Email*" class="text rqd">
                            <div class="ee error-af_email" style="display:none;color: red;">Email is required.</div>
                        </div>
                    </div>

                    <div class="popupformf">
                        <div class="squaredTwo">
                            <input type="checkbox" onchange="this.value=this.checked" id="af_squaredTwo" name="check" />
                            <label for="af_squaredTwo"></label>
                        </div>

                        <span>By creating an account you agree to our <a target="_blank" href="{{url('terms/aimstar-terms-and-conditions')}}">ToS</a> and <a target="_blank" href="{{url('terms/aimstar-global-privacy-policy')}}">Privacy Policy</a></span>
                        <div class="ee error-check" style="display:none;color: red;">Please accept this terms.</div>
                    </div>

                    <div class="popupformb">
                        <input class="subbtn" id="alliliateSubmit" type="submit" value="Apply" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .cont-left {
        display: inline-block;
        margin-top: 220px;
        margin-bottom: 40px;
    }
    @media(min-width:767px){
        .content-right {
            margin-top: 220px;
            margin-bottom: 40px;
        }
    }

    .panel-group .panel {
        background: none;
        border-radius: 0;
        border-color: #000;
    }
    .panel-group .panel-heading+.panel-collapse>.panel-body {
        border-top: 1px solid #000;
    }
    .panel-dark>.panel-heading {
        color: #fff;
        background-color: #323441;
        border-color: #323441;
    }
    .panel-dark>.panel-heading .panel-title {
        text-align: left;
    }
    .panel-dark .panel-body {
        color: #fff;
        background-color: #323441;
        border-color: #323441;
    }
    .table-bordered>tbody>tr>th,
    .table-bordered>tbody>tr>td {
        border-color: #000;
    }
</style>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        $("#alliliateForm").on("submit", function (e) {
            e.preventDefault();
            var af_firstname = $("#af_firstname").val();
            var af_lastName = $("#af_lastname").val();
            var af_country_id = $("#af_country_id").val();
            var af_phone = $("#af_phone").val();
            var af_dob = $("#af_dob").val();
            var af_email = $("#af_email").val();
            var af_password = $("#af_password").val();
            var c_af_password = $("#c_af_password").val();
            var errorStatus = false;

            $('.ee').hide();
            $('#alliliateSubmit').prop('disabled',true);


            if (af_firstname == "") {
                $(".error-af_firstname").show();
                errorStatus = true;
            }
            if (af_lastName == "") {
                $(".error-af_lastname").show();
                errorStatus = true;
            }
            if (af_country_id == null) {
                $(".error-af_country_id").show();
                errorStatus = true;
            }
            if (af_phone == "") {
                $(".error-af_phone").show();
                errorStatus = true;
            }
            if(af_email == ""){
                $(".error-af_email").show();
                errorStatus = true;
            }
            if(af_dob == ""){
                $(".error-af_dob").show();
                errorStatus = true;
            }
            if(af_password == ""){
                $(".error-af_password").show();
                errorStatus = true;
            }
            if(c_af_password == ""){
                $(".error-c_af_password").show();
                errorStatus = true;
            }
            if(af_password !== c_af_password){
                $(".error-c_af_password_not_match").show();
                errorStatus = true;
            }
            if(errorStatus){
                errorStatus = true;
            }

            if(!errorStatus) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('affiliate.invitationStore') }}",
                    data: {
                        firstname: af_firstname,
                        lastname: af_lastName,
                        country_id: af_country_id,
                        phone: af_phone,
                        email: af_email,
                        dob: af_dob,
                        password: af_password,
                    },
                    complete : function (data) {
                        $('#alliliateSubmit').prop('disabled',false);
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
                            setTimeout(function () {
                                window.location.reload(true);
                            }, 5000);
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
