@extends('layouts.adminloginlayout')
@section('content')
	<h4 class="mb-2">Recover Password!</h4>
	<p class="mb-4">Create new password for account.</p>
	<!--!! FLAST MESSAGES !!-->
	@include('admin.partials.flash_messages')
	<form action="" method="post" class="mb-3" id="recover_password">
		<!--!! CSRF FIELD !!-->
		{{ csrf_field() }}
		<div class="mb-3 form-password-toggle">
		    <div class="d-flex justify-content-between">
		        <label class="form-label" for="password">New Password</label>
		    </div>
		    <div class="input-group input-group-merge">
		        <input type="password" class="form-control" name="new_password" placeholder="Enter your new password" aria-describedby="password" required />
		        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
		    </div>
		    <label id="new_password-error" class="error" for="new_password"></label>
		</div>
		<div class="mb-3 form-password-toggle">
		    <div class="d-flex justify-content-between">
		        <label class="form-label" for="password">Confirm Password</label>
		    </div>
		    <div class="input-group input-group-merge">
		        <input type="password" class="form-control" name="confirm_password" placeholder="Enter the confirm password" aria-describedby="password" required />
		        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
		    </div>
		    <label id="confirm_password-error" class="error" for="confirm_password"></label>
		</div>
		<div class="mb-3">
			<small class="text-danger d-block">Password must be minimum 8 characters long.</small>
			<small class="text-danger d-block">Password should contain at least one capital letter (A-Z), one small letter (a-z), one number (0-9) and one special character (!@#$%^&amp;*).</small>
		</div>
	    <button type="submit" class="btn btn-primary w-100">Submit</button>
	</form>
@endsection