<?php
Route::get('/blogs', '\App\Http\Controllers\Frontend\BlogsController@index')
    ->name('blog.index');

Route::get('/category/{slug?}', '\App\Http\Controllers\Frontend\BlogsController@category')
    ->name('blog.category');

Route::get('/blog/{slug}', '\App\Http\Controllers\Frontend\BlogsController@single')
    ->name('blog.single');