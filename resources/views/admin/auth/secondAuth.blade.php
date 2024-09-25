@extends('layouts.adminloginlayout')
@section('content')
	<h4 class="mb-2">Second Factor Authentication?</h4>
	<p class="mb-4">Enter one time password to login.</p>
	<!--!! FLAST MESSAGES !!-->
	@include('admin.partials.flash_messages')
	<form action="" method="post" class="mb-3 form-validation">
		<!--!! CSRF FIELD !!-->
		{{ csrf_field() }}
	    <div class="mb-3">
	        <label for="otp" class="form-label">OTP</label>
	        <input type="text" class="form-control number_only" minlength="6" maxlength="6" name="otp" placeholder="Enter the OTP" autofocus required />
	        <label id="otp-error" class="error" for="otp"></label>
	    </div>
	    <div class="mb-3">
	        <button class="btn btn-primary w-100" type="submit">Submit</button>
	    </div>
	</form>
@endsection