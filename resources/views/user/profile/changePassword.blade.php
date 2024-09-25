@extends('layouts.frontLayout')
@section('content')

<section class="dashboard_section">
    <div class="dashboard_inner">
        @include('user.dashboard.sidebar')
        <div class="right_side_wrap top-space">
            <div class="heading_area el">
                <h2>Change password</h2>
            </div>
            <div class="change_password">
                @include('frontend.partials.flash_messages')
                <form method="post" id="changePassword">
                    {{ csrf_field() }}
                    <div class="container">
                        <div class="row">
                            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-10 col-sm-12 col-12 mx-auto">
                                <div class="row">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label class="set_error">Old Password</label>
                                            <input type="password" class="form-control" name="old_password" value="" placeholder="Enter Your Password" autocomplete="off" required />
                                            <label id="old_password-error" class="error" for="old_password">@error('old_password') {{ $message }} @enderror</label>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label class="set_error">Enter New Password</label>
                                            <input type="password" class="form-control" name="new_password" value="" placeholder="New Password" autocomplete="off" required />
                                            <label id="new_password-error" class="error" for="new_password">@error('new_password') {{ $message }} @enderror</label>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label class="set_error">Confirm Password</label>
                                            <input type="password" class="form-control" name="confirm_password" value="" placeholder="Confirm New Password" autocomplete="off" required />
                                            <label id="confirm_password-error" class="error" for="confirm_password">@error('confirm_password') {{ $message }} @enderror</label>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="button">
                                            <button type="submit" class="btn btn-primary-1">Change password</button>
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
</section>

@endsection