<?php
Route::get('/faqs', '\App\Http\Controllers\Admin\FaqsController@index')
    ->name('admin.faqs');

Route::get('/faq/add', '\App\Http\Controllers\Admin\FaqsController@add')
    ->name('admin.faqs.add');

Route::post('/faq/add', '\App\Http\Controllers\Admin\FaqsController@add')
    ->name('admin.faqs.add');

Route::get('/faq/{id}/view', '\App\Http\Controllers\Admin\FaqsController@view')
    ->name('admin.faqs.view');

Route::get('/faq/{id}/edit', '\App\Http\Controllers\Admin\FaqsController@edit')
    ->name('admin.faqs.edit');

Route::post('/faq/{id}/edit', '\App\Http\Controllers\Admin\FaqsController@edit')
    ->name('admin.faqs.edit');

Route::post('/faq/bulkActions/{action}', '\App\Http\Controllers\Admin\FaqsController@bulkActions')
    ->name('admin.faqs.bulkActions');

Route::get('/faq/{id}/delete', '\App\Http\Controllers\Admin\FaqsController@delete')
    ->name('admin.faqs.delete');