<?php
Route::match(['get','post'], '/user/signup', '\App\Http\Controllers\User\SignupController@index')
    ->name('user.signup');

Route::match(['get','post'], '/user/success', '\App\Http\Controllers\User\SignupController@success')
    ->name('user.signup.success');

Route::match(['get','post'], '/user/error', '\App\Http\Controllers\User\SignupController@error')
    ->name('user.signup.error');