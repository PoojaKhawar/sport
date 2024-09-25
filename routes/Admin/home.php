<?php
Route::match(['get' ,'post'],'/home-content', '\App\Http\Controllers\Admin\HomeController@index')
    ->name('admin.home');