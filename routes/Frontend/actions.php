<?php
Route::post('/actions/uploadFile', '\App\Http\Controllers\Frontend\ActionsController@uploadFile')
    ->name('actions.uploadFile');

Route::post('/actions/removeFile', '\App\Http\Controllers\Frontend\ActionsController@removeFile')
    ->name('actions.removeFile');

Route::post('/actions/{relation}/switchUpdate/{field}/{id}', '\App\Http\Controllers\Frontend\ActionsController@switchUpdate')
    ->name('actions.switchUpdate');

Route::get('/video-streaming', '\App\Http\Controllers\Frontend\ActionsController@videoStreaming')
    ->name('actions.videoStreaming');

//Route::get('/language/{slug}', '\App\Http\Controllers\Frontend\ActionsController@convertLanguage')
    //->name('actions.convertLanguage');
    
Route::match(['get', 'post'], '/actions/states/{id}', '\App\Http\Controllers\Frontend\ActionsController@getStatesByCountryId')
    ->name('actions.getStatesByCountryId');

Route::match(['get', 'post'], '/actions/cities/{id}', '\App\Http\Controllers\Frontend\ActionsController@getCitiesByStateId')
    ->name('actions.getCitiesByStateId');

Route::match(['get', 'post'], '/actions/postal-codes/{id}', '\App\Http\Controllers\Frontend\ActionsController@getPostalCodesByCityId')
    ->name('actions.getPostalCodesByCityId');

Route::post('/actions/cropperUploadFile', '\App\Http\Controllers\Frontend\ActionsController@cropperUploadFile')
    ->name('actions.cropperUploadFile');

Route::post('/actions/removeFileCropper', '\App\Http\Controllers\Frontend\ActionsController@cropperRemoveFile')
    ->name('actions.cropperRemoveFile');

Route::match(['get', 'post'], '/actions/toUserList', '\App\Http\Controllers\Frontend\ActionsController@toUserList')
    ->name('actions.toUserList');

Route::match(['get', 'post'], '/actions/ccUserList', '\App\Http\Controllers\Frontend\ActionsController@ccUserList')
    ->name('actions.ccUserList');