@extends('layouts.adminlayout')
@section('content')

<div class="header-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="left_area">
					<h6>Change Password</h6>
				</div>
			</div>
			<div class="col-lg-6 col-5">
				<div class="right_area text-right">
					{{-- <a href="javascript:;" class="btn btn-default">
						<i class="fas fa-angle-left"></i> Back
					</a> --}}
				</div>
			</div>
			<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="button_area">
					<a class="btn btn-default me-1" href="{{ route('admin.profile') }}"><i class="bx bx-user me-1"></i> Account</a>
					<a class="btn btn-default me-1" href="{{ route('admin.changePassword') }}"><i class="bx bx-cog me-1"></i> Change Password</a>
					
					@if(AdminAuth::isAdmin() != 1)
					{{-- <a class="btn btn-default me-1" href="{{ route('admin.permissions') }}"><i class="bx bx-link-alt me-1"></i> Permissions</a> --}}
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

<div class="content_area">
    <div class="container-xxl flex-grow-1 container-p-y">
		<div class="row">
			<div class="col-md-12">
				<div class="card mb-4">
					@include('admin.partials.flash_messages')
					<h5 class="card-header">Enter Your Password Here.</h5>
					<div class="card-body">
						<form method="post" action="{{ route('admin.changePassword') }}" class="change_password">
							<!--!! CSRF FIELD !!-->
							{{ csrf_field() }}
							<div class="row">
								<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<div class="form-password-toggle">
										    <div class="d-flex justify-content-between">
										        <label class="form-label">Old Password</label>
										    </div>
										    <div class="input-group">
										        <input type="password" class="form-control" name="old_password" placeholder="******" aria-describedby="password" value="" required />
										        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
										    </div>
										    <label id="old_password-error" class="error" for="old_password">@error('old_password') {{ $message }} @enderror</label>
										</div>
									</div>
								</div>
								<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<div class="form-password-toggle">
										    <div class="d-flex justify-content-between">
										        <label class="form-label">New Password</label>
										    </div>
										    <div class="input-group">
										        <input type="password" class="form-control" name="new_password" placeholder="******" aria-describedby="password" value="" required />
										        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
										    </div>
										    <label id="new_password-error" class="error" for="new_password">@error('new_password') {{ $message }} @enderror</label>
										</div>
									</div>
								</div>
								<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<div class="form-password-toggle">
										    <div class="d-flex justify-content-between">
										        <label class="form-label">Confirm Password</label>
										    </div>
										    <div class="input-group">
										        <input type="password" class="form-control" name="confirm_password" placeholder="******" aria-describedby="password" value="" required />
										        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
										    </div>
										    <label id="confirm_password-error" class="error" for="confirm_password">@error('confirm_password') {{ $message }} @enderror</label>
										</div>
									</div>
								</div>
								<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<small class="text-danger d-block">Password must be minimum 8 characters long.</small>
										<small class="text-danger d-block">Password should contain at least one capital letter (A-Z), one small letter (a-z), one number (0-9) and one special character (!@#$%^&amp;*).</small>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="mt-2 clearfix">
									<button type="submit" class="btn btn-primary float-end">Submit</button>
								</div>		
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection