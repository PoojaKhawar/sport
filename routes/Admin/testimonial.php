<?php
Route::get('/testimonials', '\App\Http\Controllers\Admin\TestimonialsController@index')
    ->name('admin.testimonials');

Route::get('/testimonial/add', '\App\Http\Controllers\Admin\TestimonialsController@add')
    ->name('admin.testimonials.add');

Route::post('/testimonial/add', '\App\Http\Controllers\Admin\TestimonialsController@add')
    ->name('admin.testimonials.add');

Route::get('/testimonial/{id}/view', '\App\Http\Controllers\Admin\TestimonialsController@view')
    ->name('admin.testimonials.view');

Route::get('/testimonial/{id}/edit', '\App\Http\Controllers\Admin\TestimonialsController@edit')
    ->name('admin.testimonials.edit');

Route::post('/testimonial/{id}/edit', '\App\Http\Controllers\Admin\TestimonialsController@edit')
    ->name('admin.testimonials.edit');

Route::post('/testimonial/bulkActions/{action}', '\App\Http\Controllers\Admin\TestimonialsController@bulkActions')
    ->name('admin.testimonials.bulkActions');

Route::get('/testimonial/{id}/delete', '\App\Http\Controllers\Admin\TestimonialsController@delete')
    ->name('admin.testimonials.delete');