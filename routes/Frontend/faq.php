<?php
Route::get('/faq', '\App\Http\Controllers\Frontend\FaqController@index')
    ->name('faq.index');