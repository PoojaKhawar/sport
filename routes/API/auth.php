<?php

Route::post('/auth/signup', '\App\Http\Controllers\API\AuthController@signup')
    ->name('api.signup');          

Route::post('/auth/login', '\App\Http\Controllers\API\AuthController@login')
    ->name('api.login');

Route::post('/auth/logout', '\App\Http\Controllers\API\AuthController@logout')
    ->name('api.logout');

Route::post('/auth/forgot-password', '\App\Http\Controllers\API\AuthController@forgotPassword')
    ->name('api.forgotPassword');

Route::post('/auth/forgot-resend-otp/{hash}', '\App\Http\Controllers\API\AuthController@resendForgotOtp')
    ->name('api.resendForgotOtp');

Route::post('/auth/forgot-verify-otp/{hash}', '\App\Http\Controllers\API\AuthController@verifyForgotOtp')
    ->name('api.verifyForgotOtp');

Route::post('/auth/recover-password/{hash}', '\App\Http\Controllers\API\AuthController@recoverPassword')
    ->name('api.recoverPassword');

Route::post('/auth/email-verification/{hash}', '\App\Http\Controllers\API\AuthController@emailVerification')
    ->name('api.emailVerification');  

Route::post('/auth/email-resend-otp/{hash}', '\App\Http\Controllers\API\AuthController@resendEmailOtp')
    ->name('api.resendEmailOtp');

Route::post('/auth/email-verify-otp/{hash}', '\App\Http\Controllers\API\AuthController@verifyEmailOtp')
    ->name('api.verifyEmailOtp');    

Route::get('/auth/check-email-exist', '\App\Http\Controllers\API\AuthController@checkEmailExist')
    ->name('api.checkEmailExist');