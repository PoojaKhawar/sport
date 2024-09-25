<?php
Route::get('/states', '\App\Http\Controllers\Admin\StatesController@index')
    ->name('admin.states');

Route::match(['get', 'post'], '/states/add', '\App\Http\Controllers\Admin\StatesController@add')
    ->name('admin.states.add');

Route::get('/states/{id}/view', '\App\Http\Controllers\Admin\StatesController@view')
    ->name('admin.states.view');

Route::match(['get', 'post'], '/states/{id}/edit', '\App\Http\Controllers\Admin\StatesController@edit')
    ->name('admin.states.edit');

Route::post('/states/bulkActions/{action}', '\App\Http\Controllers\Admin\StatesController@bulkActions')
    ->name('admin.states.bulkActions');

Route::get('/states/{id}/delete', '\App\Http\Controllers\Admin\StatesController@delete')
    ->name('admin.states.delete');