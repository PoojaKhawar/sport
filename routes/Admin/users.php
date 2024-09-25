<?php
Route::get('/users', '\App\Http\Controllers\Admin\UsersController@index')
    ->name('admin.users');

Route::get('/users/add', '\App\Http\Controllers\Admin\UsersController@add')
    ->name('admin.users.add');

Route::post('/users/add', '\App\Http\Controllers\Admin\UsersController@add')
    ->name('admin.users.add');

Route::get('/users/{id}/view', '\App\Http\Controllers\Admin\UsersController@view')
    ->name('admin.users.view');

Route::get('/users/{id}/edit', '\App\Http\Controllers\Admin\UsersController@edit')
    ->name('admin.users.edit');

Route::post('/users/{id}/edit', '\App\Http\Controllers\Admin\UsersController@edit')
    ->name('admin.users.edit');

Route::get('/users/{id}/reset-password', '\App\Http\Controllers\Admin\UsersController@resetPassword')
    ->name('admin.users.resetPassword');

Route::post('/users/{id}/reset-password', '\App\Http\Controllers\Admin\UsersController@resetPassword')
    ->name('admin.users.resetPassword');

Route::post('/users/bulkActions/{action}', '\App\Http\Controllers\Admin\UsersController@bulkActions')
    ->name('admin.users.bulkActions');

Route::get('/users/{id}/delete', '\App\Http\Controllers\Admin\UsersController@delete')
    ->name('admin.users.delete');

Route::post('/users/update-picture', '\App\Http\Controllers\Admin\UsersController@updatePicture')
    ->name('admin.users.updatePicture');

Route::get('/users/export/{action?}', '\App\Http\Controllers\Admin\UsersController@export')
    ->name('admin.users.export');