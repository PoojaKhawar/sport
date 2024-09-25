<?php

/**
 * Dashboard Class
 *
 * @package    DashboardController
 * @copyright  2023
 * @author     Irfan Ahmad <irfan.ahmad@globiztechnology.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */


namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Admin\User;
use App\Models\User\UserAuth;

class DashboardController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

	function index(Request $request)
    {
    	$userId = UserAuth::getLoginId();
    	$user = User::get($userId);

		return view("user/dashboard/index",
			[
				'user' => $user
			]
		);
	}
}
