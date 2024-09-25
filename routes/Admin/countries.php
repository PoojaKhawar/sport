<?php
Route::get('/countries', '\App\Http\Controllers\Admin\CountriesController@index')
    ->name('admin.countries');

Route::match(['get', 'post'], '/countries/add', '\App\Http\Controllers\Admin\CountriesController@add')
    ->name('admin.countries.add');

Route::get('/countries/{id}/view', '\App\Http\Controllers\Admin\CountriesController@view')
    ->name('admin.countries.view');

Route::match(['get', 'post'], '/countries/{id}/edit', '\App\Http\Controllers\Admin\CountriesController@edit')
    ->name('admin.countries.edit');

Route::post('/countries/bulkActions/{action}', '\App\Http\Controllers\Admin\CountriesController@bulkActions')
    ->name('admin.countries.bulkActions');

Route::get('/countries/{id}/delete', '\App\Http\Controllers\Admin\CountriesController@delete')
    ->name('admin.countries.delete');