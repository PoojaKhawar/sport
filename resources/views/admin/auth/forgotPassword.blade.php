@extends('layouts.adminloginlayout')
@section('content')
	<h4 class="mb-2">Forgot Password?</h4>
	<p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
	<!--!! FLAST MESSAGES !!-->
	@include('admin.partials.flash_messages')
	<form action="{{ route('admin.forgotPassword') }}" method="post" class="mb-3 form-validation">
		<!--!! CSRF FIELD !!-->
		{{ csrf_field() }}
	    <div class="mb-3">
	        <label for="email" class="form-label">Email</label>
	        <input type="text" class="form-control" name="email" placeholder="Enter your email" autofocus required />
	        <label id="email-error" class="error" for="email"></label>
	    </div>
	    <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
	</form>
	<div class="text-center">
	    <a href="{{ route('admin.login') }}" class="d-flex align-items-center justify-content-center">
	        <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
	        Back to login
	    </a>
	</div>
@endsection