<?php

/**
 * Admin Dashboard Class
 *
 * @package    DashboardController
 * @copyright  2023
 * @author     Irfan Ahmad <irfan.ahmad@globiztechnology.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Libraries\General;


class DashboardController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function index(Request $request)
    {

        return view("admin/dashboard/dashboard");
    }
}
