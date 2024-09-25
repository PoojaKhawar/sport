<?php
Route::get('/blogs', '\App\Http\Controllers\Admin\Blogs\BlogsController@index')
    ->name('admin.blogs');

Route::get('/blog/add', '\App\Http\Controllers\Admin\Blogs\BlogsController@add')
    ->name('admin.blogs.add');

Route::post('/blog/add', '\App\Http\Controllers\Admin\Blogs\BlogsController@add')
    ->name('admin.blogs.add');

Route::get('/blog/{id}/view', '\App\Http\Controllers\Admin\Blogs\BlogsController@view')
    ->name('admin.blogs.view');

Route::get('/blog/{id}/edit', '\App\Http\Controllers\Admin\Blogs\BlogsController@edit')
    ->name('admin.blogs.edit');

Route::post('/blog/{id}/edit', '\App\Http\Controllers\Admin\Blogs\BlogsController@edit')
    ->name('admin.blogs.edit');

Route::post('/blog/bulkActions/{action}', '\App\Http\Controllers\Admin\Blogs\BlogsController@bulkActions')
    ->name('admin.blogs.bulkActions');

Route::get('/blog/{id}/delete', '\App\Http\Controllers\Admin\Blogs\BlogsController@delete')
    ->name('admin.blogs.delete');


/*** Categories **/
Route::get('/blog/categories', '\App\Http\Controllers\Admin\Blogs\BlogCategoriesController@index')
    ->name('admin.blogs.categories');

Route::get('/blog/category/add', '\App\Http\Controllers\Admin\Blogs\BlogCategoriesController@add')
    ->name('admin.blogs.categories.add');

Route::post('/blog/category/add', '\App\Http\Controllers\Admin\Blogs\BlogCategoriesController@add')
    ->name('admin.blogs.categories.add');

Route::get('/blog/category/{id}/edit', '\App\Http\Controllers\Admin\Blogs\BlogCategoriesController@edit')
    ->name('admin.blogs.categories.edit');

Route::post('/blog/category/{id}/edit', '\App\Http\Controllers\Admin\Blogs\BlogCategoriesController@edit')
    ->name('admin.blogs.categories.edit');

Route::get('/blog/category/{id}/view', '\App\Http\Controllers\Admin\Blogs\BlogCategoriesController@view')
    ->name('admin.blogs.categories.view');

Route::post('/blog/category/bulkActions/{action}', '\App\Http\Controllers\Admin\Blogs\BlogCategoriesController@bulkActions')
    ->name('admin.blogs.categories.bulkActions');

Route::get('/blog/category/{id}/delete', '\App\Http\Controllers\Admin\Blogs\BlogCategoriesController@delete')
    ->name('admin.blogs.categories.delete');