<?php
Route::match(['get','post'], '/user/dashboard', '\App\Http\Controllers\User\DashboardController@index')
    ->name('user.dashboard');