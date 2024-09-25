@extends('layouts.frontlayout')
@section('content')

<section class="login_section">
    <div class="container">
        <div class="row">
            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-7 col-sm-12 col-12 mx-auto">
                <div class="login_section_area">
                    <div class="header_area">
                        <h3>Login</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>
                    </div>
                    <div class="box_area">
                        <h2>Welcome back!</h2>
                        <!--!! FLAST MESSAGES !!-->
                        @include('frontend.partials.flash_messages')
                        <form action="{{ route('user.login') }}" method="post" id="loginUser">
                            <!--!! CSRF FIELD !!-->
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label class="set_error">Email</label>
                                        <input type="text" class="form-control" name="email" value="" placeholder="Enter username or email" autocomplete="off" required/>
                                        <label id="email-error" class="error" for="email">@error('email') {{ $message }} @enderror</label>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label class="set_error">Password</label>
                                        <input type="password" class="form-control" name="password" value="" placeholder="Enter password" autocomplete="off" required/>
                                        <label id="password-error" class="error" for="password">@error('password') {{ $message }} @enderror</label>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="forgot_button">
                                        <a href="{{ route('user.forgotPassword') }}">Forgot password?</a>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="login_button">
                                        <button type="submit" class="btn btn-primary-1">Login</button>
                                    </div>
                                    <div class="sign_up_button">
                                        <p>Don't have an account? <a href="{{ route('user.signup') }}">Sign Up</a></p>
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