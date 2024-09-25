@extends('layouts.frontLayout')
@section('content')

<section class="dashboard_section ">
    <div class="dashboard_inner">
        @include('user.dashboard.sidebar')
        <div class="right_side_wrap top-space">
            <div class="dashboard_section edit_profile_section">
                <div class="dashboard_area">
                    <div class="dashboard_inner_area">
                        <div class="right_area_dashboard gz_profile_section">
                            <div class="inner_right_dashboard">
                                <div class="user_breadcame">
                                    <div class="left_breadcame">
                                        <ul class="list-inline">
                                            <li>
                                                <a href="javascript:;">Profile</a>
                                                <span class="icon"><i class="fas fa-user"></i></span>
                                            </li>
                                            <li class="active">
                                                <a href="javascript:;">Profile View</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="right_breadcame">
                                        <div class="bars">
                                            <i class="fa-solid fa-bars-sort"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="user_panel">
                                    <div class="edit_profile_area profileUpdateImage">
                                        <div class="edit_image">
                                            <div class="inner_image">
                                                <img class="profile-user-img" src="{{ General::renderImageUrl($user->image, 'medium') }}" alt="..." />
                                            </div>
                                            <div class="iconwrap">
                                                <label for="profile_pic" class="icon_row">
                                                    <i class="far fa-pen"></i>
                                                </label>
                                                <input type="file" class="d-none" id="profile_pic" data-url="{{ route('user.updatePicture') }}" />
                                            </div>
                                        </div>
                                        <div class="form_rows_area">
                                            @include('frontend.partials.flash_messages')
                                            <form method="post" action="{{ route('user.editProfile') }}" id="editProfileUser">
                                                <!--!! CSRF FIELD !!-->
                                                {{ @csrf_field() }}
                                                <div class="row">
                                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label class="set_error">First Name</label>
                                                            <input type="text" class="form-control alpha_space" name="first_name" value="{{ isset($user->first_name) && $user->first_name ? $user->first_name : @old('first_name') }}" placeholder="Enter First Name" autocomplete="off" required />
                                                            @error('first_name')
                                                            <label id="first_name-error" class="error" for="first_name">{{ $message }}</label>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label class="set_error">Last Name</label>
                                                            <input type="text" class="form-control alpha_no_space" name="last_name" value="{{ isset($user->last_name) && $user->last_name ? $user->last_name : @old('last_name') }}" placeholder="Enter Last Name" autocomplete="off" required />
                                                            @error('last_name')
                                                            <label id="last_name-error" class="error" for="last_name">{{ $message }}</label>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label class="set_error">Email Address</label>
                                                            <input type="email" class="form-control" name="email" value="{{ isset($user->email) && $user->email ? $user->email : @old('email') }}" placeholder="Enter Email" autocomplete="off" required />
                                                            @error('email')
                                                            <label id="email-error" class="error" for="email">{{ $message }}</label>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label class="set_error">Phone Number</label>
                                                            <input type="text" class="form-control" name="phonenumber" value="{{ isset($user->phonenumber) && $user->phonenumber ? $user->phonenumber : @old('phonenumber') }}" placeholder="Enter phonenumber" autocomplete="off" required />
                                                            @error('phonenumber')
                                                            <label id="phonenumber-error" class="error" for="phonenumber">{{ $message }}</label>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="button_area">
                                                            <a href="{{ route('user.profile') }}" class="btn btn-primary">Cancel</a>
                                                            <button type="submit" class="btn btn-primary btn-save">Save Changes</button>
                                                        </div>
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
            </div>
        </div>
    </div>
</section>

@endsection