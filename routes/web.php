<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function(){

    /*Route::get('/', function () {
        return view('welcome');
    });*/

    /*Route::get('/mail', function () {
        return view("mail");
    });*/

    // Artisan Routes
    //include "Frontend/artisanRoutes.php";

    //Admin public
    include "Admin/auth.php";

    // User Public
    include "User/auth.php";
    include "User/signup.php";

    // Actions
    include "Frontend/actions.php";

    include "Frontend/home.php";
    include "Frontend/blog.php";
    include "Frontend/contactus.php";
    include "Frontend/faq.php";
    include "Frontend/pages.php";
});


Route::prefix('admin')->middleware(['adminAuth'])->group(function () {
    include "Admin/dashboard.php";
    include "Admin/profile.php";
    include "Admin/settings.php";
    include "Admin/actions.php";
    include "Admin/activities.php";
    include "Admin/pages.php";
    include "Admin/users.php";
    include "Admin/admins.php";
    include "Admin/countries.php";
    include "Admin/states.php";
    include "Admin/cities.php";
    include "Admin/roles.php";
    include "Admin/emailTemplates.php";
    include "Admin/blogs.php";
    include "Admin/faq.php";
    include "Admin/testimonial.php";
    include "Admin/slider.php";
    include "Admin/contactUs.php";
    include "Admin/home.php";
    include "Admin/pageContent.php";
});

Route::middleware(['userAuth'])->group(function () {    
    include "User/users.php";
    include "User/dashboard.php";
});

if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != 'localhost')
{
    Route::fallback(function () {
        abort(404);
    });

    Route::any('{url}', function(){
        return redirect('/');
    })->where('url', '.*');
}