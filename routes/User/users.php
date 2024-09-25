<?php
Route::match(['get', 'post'], '/user/profile', '\App\Http\Controllers\User\UserController@profile')
    ->name('user.profile');

Route::match(['get', 'post'], '/user/edit-profile', '\App\Http\Controllers\User\UserController@editProfile')
    ->name('user.editProfile');

Route::match(['get', 'post'], '/change-password', '\App\Http\Controllers\User\UserController@changePassword')
    ->name('user.changePassword');

Route::post('/update-picture', '\App\Http\Controllers\User\UserController@updatePicture')
    ->name('user.updatePicture');