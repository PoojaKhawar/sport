<?php
Route::match(['get' ,'post'],'/content/{type}', '\App\Http\Controllers\Admin\PageContentController@index')
    ->name('admin.pageContent');