<?php
Route::get('/admins', '\App\Http\Controllers\Admin\AdminsController@index')
    ->name('admin.admins');

Route::get('/admins/add', '\App\Http\Controllers\Admin\AdminsController@add')
    ->name('admin.admins.add');

Route::post('/admins/add', '\App\Http\Controllers\Admin\AdminsController@add')
    ->name('admin.admins.add');

Route::get('/admins/{id}/view', '\App\Http\Controllers\Admin\AdminsController@view')
    ->name('admin.admins.view');

Route::get('/admins/{id}/edit', '\App\Http\Controllers\Admin\AdminsController@edit')
    ->name('admin.admins.edit');

Route::post('/admins/{id}/edit', '\App\Http\Controllers\Admin\AdminsController@edit')
    ->name('admin.admins.edit');

Route::get('/admins/{id}/reset-password', '\App\Http\Controllers\Admin\AdminsController@resetPassword')
    ->name('admin.admins.resetPassword');

Route::post('/admins/{id}/reset-password', '\App\Http\Controllers\Admin\AdminsController@resetPassword')
    ->name('admin.admins.resetPassword');

Route::post('/admins/bulkActions/{action}', '\App\Http\Controllers\Admin\AdminsController@bulkActions')
    ->name('admin.admins.bulkActions');

Route::get('/admins/{id}/delete', '\App\Http\Controllers\Admin\AdminsController@delete')
    ->name('admin.admins.delete');