@extends('layouts.adminlayout')
@section('content')

<div class="header-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="left_area">
					<h6>My Profile</h6>
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
					<h5 class="card-header">Profile Details</h5>
					<div class="card-body">
						<div class="d-flex align-items-start align-items-sm-center gap-4 profileUpdateImage">
							<img src="{{ General::renderProfileImage(FileSystem::getAllSizeImages($admin->image), 'large') }}" alt="user-avatar" class="d-block rounded profile-user-img" height="100" width="100" id="uploadedAvatar" />
							<div class="button-wrapper">
								<label for="profile_img" class="btn btn-primary me-2 mb-4" tabindex="0">
									<span class="d-none d-sm-block">Upload new photo</span>
									<i class="bx bx-upload d-block d-sm-none"></i>
									<input type="file" id="profile_img" class="account-file-input" hidden accept="image/png, image/jpeg" data-url="{{ route('admin.profile.updatePicture') }}" data-id="{{ $admin->id }}"/>
								</label>
								<p class="text-muted mb-0">Allowed JPG and PNG. Max size of 800K</p>
							</div>
						</div>
					</div>
					<hr class="my-0" />
					<div class="card-body">
						<form method="post" action="{{ route('admin.profile') }}" class="form-validation">
							<!--!! CSRF FIELD !!-->
							{{ csrf_field() }}
							<div class="row">
								<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<div class="form-group">
										<label class="form-label">First Name</label>
										<input type="text" class="form-control" name="first_name" value="{{ old("first_name",$admin->first_name ? $admin->first_name : "") }}" placeholder="Enter first name" required />
										<label id="first_name-error" class="error" for="first_name">@error('first_name') {{ $message }} @enderror</label>
									</div>
								</div>
								<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<div class="form-group">
										<label class="form-label">Last Name</label>
										<input type="text" class="form-control" name="last_name" value="{{ old("last_name",$admin->last_name ? $admin->last_name : "") }}" placeholder="Enter last name" required />
										<label id="last_name-error" class="error" for="last_name">@error('last_name') {{ $message }} @enderror</label>
									</div>
								</div>
								<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<div class="form-group">
										<label class="form-label">E-mail</label>
										<input type="text" class="form-control" name="email" value="{{ old("email",$admin->email ? $admin->email : "") }}" placeholder="Enter email" required />
										<label id="email-error" class="error" for="email">@error('email') {{ $message }} @enderror</label>
									</div>
								</div>
								<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<div class="form-group">
										<label class="form-label">Phone Number</label>
										<div class="input-group input-group-merge">
											<span class="input-group-text">IN (+91)</span>
											<input type="text" name="phonenumber" class="form-control" value="{{ old("phonenumber",$admin->phonenumber ? $admin->phonenumber : "") }}" placeholder="Enter phonenumber" required />
										</div>
										<label id="phonenumber-error" class="error" for="phonenumber">@error('phonenumber') {{ $message }} @enderror</label>
									</div>
								</div>
								<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<label class="form-label">Address</label>
										<input type="text" class="form-control" name="address" value="{{ old("address",$admin->address ? $admin->address : "") }}" placeholder="Enter address" required />
										<label id="address-error" class="error" for="address">@error('address') {{ $message }} @enderror</label>
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
				{{-- <div class="card">
					<h5 class="card-header">Delete Account</h5>
					<div class="card-body">
						<div class="mb-3 col-12 mb-0">
							<div class="alert alert-warning">
								<h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
								<p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
							</div>
						</div>
						<form id="formAccountDeactivation" onsubmit="return false">
							<div class="form-check mb-3">
								<input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation" />
								<label class="form-check-label" for="accountActivation">I confirm my account deactivation</label>
							</div>
							<button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
						</form>
					</div>
				</div> --}}
			</div>
		</div>
	</div>
</div>
	
@endsection