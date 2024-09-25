<?php
Route::get('/activities/logs', '\App\Http\Controllers\Admin\ActivitiesController@logs')
    ->name('admin.activities.logs');

Route::get('/activities/logs/{id}/view', '\App\Http\Controllers\Admin\ActivitiesController@logView')
    ->name('admin.activities.logView');

Route::get('/activities/emails', '\App\Http\Controllers\Admin\ActivitiesController@emails')
    ->name('admin.activities.emails');

Route::get('/activities/emails/{id}/view', '\App\Http\Controllers\Admin\ActivitiesController@emailView')
    ->name('admin.activities.emailView');

Route::get('/activities/pages', '\App\Http\Controllers\Admin\ActivitiesController@pages')
    ->name('admin.activities.pages');

Route::post('/activities/bulkActions/{action}', '\App\Http\Controllers\Admin\ActivitiesController@bulkActions')
    ->name('admin.activities.bulkActions');

Route::get('/activities/user-logs-truncate', '\App\Http\Controllers\Admin\ActivitiesController@userLogsTruncate')
    ->name('admin.activities.userLogsTruncate');

Route::get('/activities/activities-truncate', '\App\Http\Controllers\Admin\ActivitiesController@activitiesTruncate')
    ->name('admin.activities.activitiesTruncate');

Route::get('/activities/email-logs-truncate', '\App\Http\Controllers\Admin\ActivitiesController@emailLogsTruncate')
    ->name('admin.activities.emailLogsTruncate');

Route::get('/activities/cron-logs-truncate', '\App\Http\Controllers\Admin\ActivitiesController@cronLogsTruncate')
    ->name('admin.activities.cronLogsTruncate');

// Route::get('/activities/users/{id?}', '\App\Http\Controllers\Admin\ActivitiesController@users')
//     ->name('admin.activities.users');

// Route::get('/activities/users/{id}/view', '\App\Http\Controllers\Admin\ActivitiesController@userView')
//     ->name('admin.activities.userView');
