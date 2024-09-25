<?php

Route::get('/roles', '\App\Http\Controllers\Admin\RolesController@index')
    ->name('admin.roles');

Route::post('/roles/add', '\App\Http\Controllers\Admin\RolesController@add')
    ->name('admin.roles.add');

Route::get('/roles/add', '\App\Http\Controllers\Admin\RolesController@add')
    ->name('admin.roles.add');    

Route::get('/roles/{id}/view', '\App\Http\Controllers\Admin\RolesController@view')
    ->name('admin.roles.view');

Route::get('/roles/{id}/edit', '\App\Http\Controllers\Admin\RolesController@edit')
    ->name('admin.roles.edit');

Route::post('/roles/{id}/edit', '\App\Http\Controllers\Admin\RolesController@edit')
    ->name('admin.roles.edit');

Route::post('/roles/bulkActions/{action}', '\App\Http\Controllers\Admin\RolesController@bulkActions')
    ->name('admin.roles.bulkActions');

Route::get('/roles/{id}/delete', '\App\Http\Controllers\Admin\RolesController@delete')
    ->name('admin.roles.delete');

Route::get('/roles/{id}/get', '\App\Http\Controllers\Admin\RolesController@get')
->name('admin.get.receiversList');