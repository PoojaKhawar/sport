@extends('layouts.frontlayout')
@section('content')

<!-- ==== Sign Up Start ==== -->
<section class="sign_up_section">
    <div class="sign_up_area">
        <div class="left_area">
            <div class="left_inne">
                <div class="info_area">
                    <h1>Sign Up</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam maximus orci at turpis suscipit
                        rutrum.</p>
                </div>
                <div class="back-img d-md-block d-none">
                    <img src="{{ url('frontend/images/Rectangle20.png') }}" alt="...." />
                </div>
                <div class="bottom-img d-md-block d-none">
                    <img src="{{ url('frontend/images/Layers1.png') }}" alt="..." />
                </div>
            </div>
        </div>
        <div class="right_area">
            <div class="steps_formed">
                <div class="query-form">
                    @include('frontend.partials.flash_messages')
                    <form method="post" action="{{ route('user.signup') }}" id="signUpUser">
                        <!--!! CSRF FIELD !!-->
                        {{ @csrf_field() }}
                        <div class="row">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form_steps1">
                                    <div class="set_head">
                                        <h1>Enter your detail</h1>
                                    </div>
                                    <!--!! FLAST MESSAGES !!-->
                                    @include('frontend.partials.flash_messages')
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label class="set_label">First name</label>
                                                <input type="text" class="form-control" name="first_name" placeholder="Enter your first name" value="{{ old('first_name') }}" required>
                                                <label id="first_name-error" class="error" for="first_name" style="display: none;">
                                                    @error('first_name') {{ $message }} @enderror
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label class="set_label">Last name</label>
                                                <input type="text" class="form-control" name="last_name" placeholder="Enter your last name" value="{{ old('last_name') }}" required>
                                                <label id="last_name-error" class="error" for="last_name" style="display: none;">
                                                    @error('last_name') {{ $message }} @enderror
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label class="set_label">Email</label>
                                                <input type="text" class="form-control" name="email" placeholder="Enter your email address" value="{{ old('email') }}" required>
                                                <label id="email-error" class="error" for="email" style="display: none;">
                                                    @error('email') {{ $message }} @enderror
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label class="set_label">Phone Number</label>
                                                <input type="text" class="form-control" name="phonenumber" placeholder="Enter phone number" value="{{ old('phonenumber') }}" required>
                                                <label id="phonenumber-error" class="error" for="phonenumber" style="display: none;">
                                                    @error('phonenumber') {{ $message }} @enderror
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label class="set_label">Password</label>
                                                <input type="password" class="form-control toggle-password" id="signup_password" name="password" value="{{ old('password') }}" placeholder="Enter password" required>
                                            </div>
                                            <div class="icon_view pass_view">
                                                <i class="far fa-eye-slash"></i>
                                            </div>
                                            <label id="password-error" class="error" for="password">
                                                @error('password') {{ $message }} @enderror
                                            </label>
                                        </div>
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label class="set_label">Confirm Password</label>
                                                <input type="password" class="form-control toggle-password" name="confirm_password" placeholder="Enter confirm password" value="{{ old('confirm_password') }}" required>
                                                <div class="icon_view pass_view">
                                                    <i class="far fa-eye-slash"></i>
                                                </div>
                                                <label id="confirm_password-error" class="error" for="confirm_password">
                                                    @error('confirm_password') {{ $message }} @enderror
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="view">
                                                <button type="submit" class="btn btn-primary-1 next_steps_1" >Submit</button>
                                            </div>
                                            <div class="sign_up_button">
                                                <p>Already have an account ? <a href="{{ route('user.login') }}">Login</a></p>
                                            </div>
                                        </div>
                                    </div>                                                                                     
                                </div>
                            </div>
                        </div>
                    </form>
                </div>                
            </div>
        </div>
    </div>
</section>

@endsection