<?php
Route::post('/actions/uploadFile', '\App\Http\Controllers\Admin\ActionsController@uploadFile')
    ->name('admin.actions.uploadFile');

Route::post('/actions/removeFile', '\App\Http\Controllers\Admin\ActionsController@removeFile')
    ->name('admin.actions.removeFile');

Route::post('/actions/mediaSort', '\App\Http\Controllers\Admin\ActionsController@mediaSort')
    ->name('admin.actions.mediaSort');

Route::post('/actions/{relation}/switchUpdate/{field}/{id}', '\App\Http\Controllers\Admin\ActionsController@switchUpdate')
    ->name('admin.actions.switchUpdate');

Route::match(['get', 'post'], '/actions/states/{id}', '\App\Http\Controllers\Admin\ActionsController@getStatesByCountryId')
    ->name('admin.actions.getStatesByCountryId');

Route::match(['get', 'post'], '/actions/cities/{id}', '\App\Http\Controllers\Admin\ActionsController@getCitiesByStateId')
    ->name('admin.actions.getCitiesByStateId');