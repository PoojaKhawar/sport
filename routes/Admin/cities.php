<?php
Route::get('/cities', '\App\Http\Controllers\Admin\CitiesController@index')
    ->name('admin.cities');

Route::match(['get', 'post'], '/cities/add', '\App\Http\Controllers\Admin\CitiesController@add')
    ->name('admin.cities.add');

Route::get('/cities/{id}/view', '\App\Http\Controllers\Admin\CitiesController@view')
    ->name('admin.cities.view');

Route::match(['get', 'post'], '/cities/{id}/edit', '\App\Http\Controllers\Admin\CitiesController@edit')
    ->name('admin.cities.edit');

Route::post('/cities/bulkActions/{action}', '\App\Http\Controllers\Admin\CitiesController@bulkActions')
    ->name('admin.cities.bulkActions');

Route::get('/cities/{id}/delete', '\App\Http\Controllers\Admin\CitiesController@delete')
    ->name('admin.cities.delete');