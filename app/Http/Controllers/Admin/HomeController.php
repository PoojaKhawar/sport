<?php

/**
 * pageContent Class
 *
 * @package    HomeController
 * @copyright  2024 Globiz Technology Inc..
 * @author     Irfan Ahmad <irfan.ahmad@globiztechnology.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\Admin\PageContent;
use App\Libraries\FileSystem;


class HomeController extends AppController
{
    function __construct()
    {
        parent::__construct();
    }

    function index(Request $request)
    {
        return view('admin.home.index');
    } 

}
