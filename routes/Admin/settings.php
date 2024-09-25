<?php 
Route::get('/settings', '\App\Http\Controllers\Admin\SettingsController@index')
    ->name('admin.settings');

Route::post('/settings', '\App\Http\Controllers\Admin\SettingsController@index')
    ->name('admin.settings');

Route::post('/settings/email', '\App\Http\Controllers\Admin\SettingsController@email')
    ->name('admin.settings.email');

Route::post('/settings/recaptcha', '\App\Http\Controllers\Admin\SettingsController@recaptcha')
    ->name('admin.settings.recaptcha');

Route::post('/settings/date-time-formats', '\App\Http\Controllers\Admin\SettingsController@dateTimeFormats')
    ->name('admin.settings.dateTimeFormats');