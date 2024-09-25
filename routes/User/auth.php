<?php
Route::match(['get','post'], '/login', '\App\Http\Controllers\User\AuthController@login')
    ->name('user.login');

Route::match(['get', 'post'], '/phone-verification/{token}', '\App\Http\Controllers\User\AuthController@phoneVerification')
    ->name('user.phoneVerification');

Route::match(['get', 'post'], '/resend-otp', '\App\Http\Controllers\User\AuthController@resendOtp')
    ->name('user.resendOtp');

Route::match(['get','post'], '/forgot-password', '\App\Http\Controllers\User\AuthController@forgotPassword')
    ->name('user.forgotPassword');

Route::match(['get','post'], '/recover-password/{token}', '\App\Http\Controllers\User\AuthController@recoverPassword')
    ->name('user.recoverPassword');

Route::match(['get','post'], '/second-auth/{token}', '\App\Http\Controllers\User\AuthController@secondAuth')
    ->name('user.secondAuth');

Route::match(['get', 'post'], '/email-verification/{token}', '\App\Http\Controllers\User\AuthController@emailVerification')
    ->name('user.emailVerification');

Route::match(['get', 'post'], '/resend-verification-email', '\App\Http\Controllers\User\AuthController@resendEmailOtp')
    ->name('user.resendEmailOtp');

Route::get('/user/logout', '\App\Http\Controllers\User\AuthController@logout')
    ->name('user.logout');