<?php
Route::get('/', '\App\Http\Controllers\Frontend\HomeController@index')
    ->name('homepage.index');