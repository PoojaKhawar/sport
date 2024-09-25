@extends('layouts.frontlayout')
@section('content')

<section class="login_section top-space">
    <div class="container">
        <div class="row">
            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-7 col-sm-12 col-12 mx-auto">
                <div class="login_section_area">
                    <div class="header_area">
                        <h3>Reset password</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>
                        <!--!! FLAST MESSAGES !!-->
                        @include('frontend.partials.flash_messages')
                    </div>
                    <div class="box_area reset_password_area dl">
                        <form method="post" id="resetUser">
                            <!--!! CSRF FIELD !!-->
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label class="set_error">New Password</label>
                                        <input type="password" class="form-control" name="new_password" placeholder="Enter password" autocomplete="off" required />
                                        <label id="new_password-error" class="error" for="new_password">@error('new_password') {{ $message }} @enderror</label>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label class="set_error">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm password" autocomplete="off" required />
                                        <label id="confirm_password-error" class="error" for="confirm_password">@error('confirm_password') {{ $message }} @enderror</label>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="login_button">
                                        <button type="submit" class="btn btn-primary-1">Reset password</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection