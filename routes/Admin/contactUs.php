<?php
Route::get('/contact-us', '\App\Http\Controllers\Admin\ContactUsController@index')
    ->name('admin.contactUs');

Route::get('/contact-us/add', '\App\Http\Controllers\Admin\ContactUsController@add')
    ->name('admin.contactUs.add');

Route::post('/contact-us/add', '\App\Http\Controllers\Admin\ContactUsController@add')
    ->name('admin.contactUs.add');

Route::get('/contact-us/{id}/view', '\App\Http\Controllers\Admin\ContactUsController@view')
    ->name('admin.contactUs.view');

Route::get('/contact-us/{id}/edit', '\App\Http\Controllers\Admin\ContactUsController@edit')
    ->name('admin.contactUs.edit');

Route::post('/contact-us/{id}/edit', '\App\Http\Controllers\Admin\ContactUsController@edit')
    ->name('admin.contactUs.edit');

Route::post('/contact-us/bulkActions/{action}', '\App\Http\Controllers\Admin\ContactUsController@bulkActions')
    ->name('admin.contactUs.bulkActions');

Route::get('/contact-us/{id}/delete', '\App\Http\Controllers\Admin\ContactUsController@delete')
    ->name('admin.contactUs.delete');