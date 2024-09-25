@extends('layouts.frontlayout')
@section('content')

<section class="auth_section forgot_pass_sec otp_sec">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="auth_inner_area">   
                    <div class="right_area">
                        <div class="content_area">
                            <h5>OTP Verification</h5>
                            <p>Please enter the OTP sent to your registered Email Address</p>
                            <div class="form_area">
                                <!--!! FLAST MESSAGES !!-->
                                @include('frontend.partials.flash_messages')
                                <form method="post" class="otp_validate">
                                    <!--!! CSRF FIELD !!-->
                                    {{ csrf_field() }}
                                    <div class="form_area_box">
                                        <div class="response_message"></div>
                                        <div class="form-group">
                                            <div class="passcode-wrapper">
                                                <input type="text" name="otp1" maxlength="1" />
                                                <input type="text" name="otp2" maxlength="1"/>
                                                <input type="text" name="otp3" maxlength="1"/>
                                                <input type="text" name="otp4" maxlength="1"/>
                                                <input type="text" name="otp5" maxlength="1"/>
                                                <input type="text" name="otp6" maxlength="1"/>
                                            </div>
                                            <div class="otp_error"></div>
                                        </div>
                                        <div class="forgot_pass_sec">
                                            <a 
                                                href="javascript:;" 
                                                class="password_forgot resend_email_otp" 
                                                aria-label="resend otp"
                                                data-token="{{ isset($token) && $token ? $token : '' }}" 
                                                data-url="{{ route('user.resendEmailOtp') }}"
                                            >
                                                Resend OTP
                                            </a>
                                        </div>
                                        <div class="btn_area">
                                            <button type="button" class="btn btn-primary-2">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection