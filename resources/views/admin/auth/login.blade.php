@php
$favicon = Setting::get('favicon');
$logo = Setting::get('logo');
$companyName = Setting::get('company_name');
$recaptchaEnabled = Setting::get('admin_recaptcha');
$recaptchaSiteKey = Setting::get('recaptcha_key');
@endphp

@extends('layouts.adminloginlayout')
@section('content')
	<h4 class="mb-2">Welcome to {{ $companyName }}</h4>
	<p class="mb-4">Please sign-in to your account and start the adventure</p>
	<!--!! FLAST MESSAGES !!-->
	@include('admin.partials.flash_messages')
	<form action="{{ route('admin.login') }}" method="post" class="mb-3" id="login">
		<!--!! CSRF FIELD !!-->
		{{ csrf_field() }}
		<?php if(isset($recaptchaEnabled) && $recaptchaEnabled): ?>
			<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
		<?php endif; ?>
	    <div class="mb-3">
	        <label for="email" class="form-label">Email</label>
	        <input type="text" class="form-control" name="email" placeholder="Enter your email" autofocus required />
	        <label id="email-error" class="error" for="email"></label>
	    </div>
	    <div class="mb-3 form-password-toggle">
	        <div class="d-flex justify-content-between">
	            <label for="password" class="form-label">Password</label>
	            <a href="{{ route('admin.forgotPassword') }}">
	                <small>Forgot Password?</small>
	            </a>
	        </div>
	        <div class="input-group input-group-merge">
	            <input type="password" class="form-control" name="password" placeholder="Enter your password" aria-describedby="password" required />
	            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
	        </div>
	        <label id="password-error" class="error" for="password"></label>
	    </div>
	    <div class="mb-3">
	        <div class="form-check">
	            <input class="form-check-input" type="checkbox" id="remember-me" />
	            <label class="form-check-label" for="remember-me"> Remember Me </label>
	        </div>
	    </div>
	    <div class="mb-3">
	        <button class="btn btn-primary w-100" type="submit">Sign in</button>
	    </div>
	</form>
@endsection