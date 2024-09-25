<?php

Route::get('/countries/list', '\App\Http\Controllers\API\ActionController@countries')
    ->name('api.countries');