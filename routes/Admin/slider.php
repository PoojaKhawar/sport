<?php
Route::get('/sliders', '\App\Http\Controllers\Admin\SlidersController@index')
    ->name('admin.sliders');

Route::get('/slider/add', '\App\Http\Controllers\Admin\SlidersController@add')
    ->name('admin.sliders.add');

Route::post('/slider/add', '\App\Http\Controllers\Admin\SlidersController@add')
    ->name('admin.sliders.add');

Route::get('/slider/{id}/view', '\App\Http\Controllers\Admin\SlidersController@view')
    ->name('admin.sliders.view');

Route::get('/slider/{id}/edit', '\App\Http\Controllers\Admin\SlidersController@edit')
    ->name('admin.sliders.edit');

Route::post('/slider/{id}/edit', '\App\Http\Controllers\Admin\SlidersController@edit')
    ->name('admin.sliders.edit');

Route::post('/slider/bulkActions/{action}', '\App\Http\Controllers\Admin\SlidersController@bulkActions')
    ->name('admin.sliders.bulkActions');

Route::get('/slider/{id}/delete', '\App\Http\Controllers\Admin\SlidersController@delete')
    ->name('admin.sliders.delete');