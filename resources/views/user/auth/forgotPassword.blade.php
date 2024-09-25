@extends('layouts.frontlayout')
@section('content')

<section class="login_section top-space">
    <div class="container">
        <div class="row">
            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-7 col-sm-12 col-12 mx-auto">
                <div class="login_section_area">
                    <div class="header_area">
                        <h3>Forgot password</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>
                        <!--!! FLAST MESSAGES !!-->
                        @include('frontend.partials.flash_messages')
                    </div>
                    <div class="box_area forgot_password_area el">
                        <form method="post" id="forgotUser">
                            <!--!! CSRF FIELD !!-->
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label class="set_error">Email </label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter your email address" autocomplete="off" requierd/>
                                        <label id="email-error" class="error" for="email">@error('email') {{ $message }} @enderror</label>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="login_button">
                                        <button type="submit" class="btn btn-primary-1">Submit</button>
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