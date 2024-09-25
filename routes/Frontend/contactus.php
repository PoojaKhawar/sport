<?php
Route::post('/contact-us', '\App\Http\Controllers\Frontend\ContactUsController@index')
    ->name('contactus.index');