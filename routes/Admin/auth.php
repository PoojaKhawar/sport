<?php
Route::match(['get', 'post'], '/admin', '\App\Http\Controllers\Admin\AuthController@login')
    ->name('admin.admin');

Route::match(['get', 'post'], '/admin/login', '\App\Http\Controllers\Admin\AuthController@login')
    ->name('admin.login');

Route::match(['get', 'post'], '/admin/forgot-password', '\App\Http\Controllers\Admin\AuthController@forgotPassword')
    ->name('admin.forgotPassword');

Route::match(['get', 'post'], '/admin/recover-password/{token}', '\App\Http\Controllers\Admin\AuthController@recoverPassword')
    ->name('admin.recoverPassword');

Route::match(['get', 'post'], '/admin/second-auth/{token}', '\App\Http\Controllers\Admin\AuthController@secondAuth')
    ->name('admin.secondAuth');

Route::get('/admin/logout', '\App\Http\Controllers\Admin\AuthController@logout')
    ->name('admin.logout');