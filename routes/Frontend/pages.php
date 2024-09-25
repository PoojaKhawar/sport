<?php
Route::get('/{slug}', '\App\Http\Controllers\Frontend\PagesController@index')
    ->name('pages.index');