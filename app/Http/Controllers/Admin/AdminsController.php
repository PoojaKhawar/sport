<?php

/**
 * Admin Class
 *
 * @package    AdminsController
 * @copyright  2023
 * @author     Irfan Ahmad <irfan.ahmad@globiztechnology.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Libraries\General;
use App\Models\Admin\Permission;
use App\Models\Admin\AdminAuth;
use App\Models\Admin\Admin;
use App\Models\Admin\Roles;
use App\Models\Admin\RolePermissions;

class AdminsController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function index(Request $request)
    {
    	if(!AdminAuth::isAdmin())
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$where = [];
    	if($request->get('search'))
    	{
    		$search = $request->get('search');
    		$search = '%' . $search . '%';
    		$where['(concat(admins.first_name, " ", admins.last_name) LIKE ? or email LIKE ? or phonenumber LIKE ?)'] = [$search, $search, $search];
    	}

    	if($request->get('last_login'))
    	{
    		$lastLogin = $request->get('last_login');
    		if(isset($lastLogin[0]) && !empty($lastLogin[0]))
    			$where['admins.last_login >= ?'] = [
    				date('Y-m-d 00:00:00', strtotime($lastLogin[0]))
    			];
    		if(isset($lastLogin[1]) && !empty($lastLogin[1]))
    			$where['admins.last_login <= ?'] = [
    				date('Y-m-d 23:59:59', strtotime($lastLogin[1]))
    			];
    	}

    	if($request->get('admins'))
    	{
    		switch ($request->get('admins')) {
    			case 'admin':
    				$where['admins.is_admin'] = 0;
    			break;
    			case 'super_admin':
    				$where['admins.is_admin'] = 1;
    			break;
    		}
    	}

    	if($request->get('status'))
    	{
    		switch ($request->get('status')) {
    			case 'active':
    				$where['admins.status'] = 1;
    			break;
    			case 'non_active':
    				$where['admins.status'] = 0;
    			break;
    		}    		
    	}

    	$listing = Admin::getListing($request, $where);

    	if($request->ajax())
    	{
		    $html = view(
	    		"admin/admins/listingLoop", 
	    		[
	    			'listing' => $listing
	    		]
	    	)->render();

		    return Response()->json([
		    	'status' => 'success',
	            'html' => $html,
	            'page' => $listing->currentPage(),
	            'counter' => $listing->perPage(),
	            'count' => $listing->total(),
	            'pagination_counter' => $listing->currentPage() * $listing->perPage()
	        ], 200);
		}
		else
		{
	    	return view(
	    		"admin/admins/index", 
	    		[
	    			'listing' => $listing,
	    		]
	    	);
	    }
    }

    function add(Request $request)
    {
    	if(!AdminAuth::isAdmin())
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	if($request->isMethod('post'))
    	{
    		$data = $request->toArray();

    		// Get Role Permissions
    		if(isset($data['role']) && $data['role'])
    		{
	    		$role = [];
	    		$selectRole = ['roles_permissions.permission_id', 'roles_permissions.mode'];
	    		$whereRole['roles_permissions.role_id = ?'] = [$data['role']];
	    		$orderByRole = 'roles_permissions.id asc';
	    		$role = RolePermissions::getRoleAll($selectRole, $whereRole, $orderByRole, $limit = null, $groupBy = 'permission_id')->toArray();
	    		
	    		if(isset($role) && $role && count($role) > 0)
	    		{
		    		foreach($role as $rk => $rv)
		    		{
		    			foreach($rv as $vk => $vv)
		    			{
		    				$role[$rk][$vk] = $vv['mode'];
		    			}
		    		}
	    		}
	    		$data['permissions'] = $role;
    		}

    		/** Set random password in case send email button is on **/
    		$sendPasswordEmail = isset($data['send_password_email']) && $data['send_password_email'] > 0 ? true : false;
        	if($sendPasswordEmail)
        	{
        		$data['password'] = Str::random(20);
        	}

        	/** Set random password in case send email button is on **/
    		$validator = Validator::make(
	            $data,
	            [
	                'first_name' => 'required',
	                'last_name' => 'required',
	                'email' => [
	                	'required',
	                	'email',
	                	Rule::unique('admins')->whereNull('deleted_at')
	                ],
	                'send_password_email' => 'required',
	                'is_admin' => 'required',
	                'password' => [
	                	'required',
					    'min:8',
	                ],
	                /*'permissions' => [
	                	Rule::requiredIf(function () use ($request) {
					        return $request->get('is_admin') === null || $request->get('is_admin') == '0';
					    })
	                ],*/
	            ]
	        );

	        if(!$validator->fails())
	        {
	        	$password = $data['password'];
	        	$isAdmin = isset($data['is_admin']) && $data['is_admin'] > 0 ? true : false;
	        	$permissions = isset($data['permissions']) && $data['permissions'] ? $data['permissions'] : [];
	        	unset($data['permissions']);
	        	unset($data['_token']);
	        	unset($data['send_password_email']);

	        	$admin = Admin::create($data);
	        	if($admin)
	        	{
	        		//Send Email
	        		if($sendPasswordEmail)
	        		{
	        			$codes = [
	        				'{first_name}' => $admin->first_name,
	        				'{last_name}' => $admin->last_name,
	        				'{email}' => $admin->email,
	        				'{password}' => $password
	        			];

	        			General::sendTemplateEmail(
	        				$admin->email, 
	        				'admin-registration', 
	        				$codes
	        			);
	        		}

	        		//Make Permissions
	        		if(!$isAdmin && !empty($permissions))
	        		{
        				Permission::savePermissions(
        					$admin->id,
        					$permissions
        				);
	        		}

	        		$request->session()->flash('success', 'Admin created successfully.');
	        		return redirect()->route('admin.admins');
	        	}
	        	else
	        	{
	        		$request->session()->flash('error', 'Admin could not be save. Please try again.');
		    		return redirect()->back()->withErrors($validator)->withInput();
	        	}
		    }
		    else
		    {
		    	$request->session()->flash('error', 'Please provide valid inputs.');
		    	return redirect()->back()->withErrors($validator)->withInput();
		    }
		}
	    
	    $roles = Roles::getAll([],['status' => 1])->sortByDesc("status");

	    return view("admin/admins/add", [
			'permissions' => Permission::all(),
			'roles' => $roles,
		]);
    }

    function edit(Request $request, $id)
    {
    	if(!AdminAuth::isAdmin())
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$admin = Admin::get($id);

    	if($admin)
    	{
	    	if($request->isMethod('post'))
	    	{
	    		$data = $request->toArray();

	    		// Get Role Permissions
	    		if(isset($data['role']) && $data['role'] != $admin->role)
	    		{
		    		$role = [];
		    		$selectRole = ['roles_permissions.permission_id', 'roles_permissions.mode'];
		    		$whereRole['roles_permissions.role_id = ?'] = [$data['role']];
		    		$orderByRole = 'roles_permissions.id asc';
		    		$role = RolePermissions::getRoleAll($selectRole, $whereRole, $orderByRole, $limit = null, $groupBy = 'permission_id')->toArray();
		    		
		    		if(isset($role) && $role && count($role) > 0)
		    		{
			    		foreach($role as $rk => $rv)
			    		{
			    			foreach($rv as $vk => $vv)
			    			{
			    				$role[$rk][$vk] = $vv['mode'];
			    			}
			    		}
		    		}
		    		$data['permissions'] = $role;
	    		}

	    		/** Set random password in case send email button is on **/
	    		$sendPasswordEmail = isset($data['send_password_email']) && $data['send_password_email'] > 0 ? true : false;
	        	if($sendPasswordEmail)
	        	{
	        		$data['password']  = $password = Str::random(20);
	        	}
	        	elseif(!isset($data['password']) || !$data['password'])
	        	{
	        		unset($data['password']);
	        	}

	        	/** Set random password in case send email button is on **/
	    		$validator = Validator::make(
		            $data,
		            [
		                'first_name' => 'required',
		                'last_name' => 'required',
		                'email' => [
		                	'required',
		                	'email',
		                	Rule::unique('admins')->ignore($admin->id)->whereNull('deleted_at'),
		                ],
		                'is_admin' => 'required',
		                'password' => [
		                	'nullable',
						    'min:8',
		                ],
		                /*'permissions' => [
		                	Rule::requiredIf(function () use ($request) {
						        return $request->get('is_admin') === null || $request->get('is_admin') == '0';
						    })
		                ],*/
		            ]
		        );

		        if(!$validator->fails())
		        {
		        	/** IN CASE OF SINGLE UPLOAD **/
		        	if(isset($data['image']) && $data['image'])
		        	{
		        		$oldImage = $admin->image;
		        	}
		        	else
		        	{
		        		unset($data['image']);
		        		
		        	}
		        	/** IN CASE OF SINGLE UPLOAD **/

		        	$isAdmin = isset($data['is_admin']) && $data['is_admin'] > 0 ? true : false;
		        	$permissions = isset($data['permissions']) && $data['permissions'] ? $data['permissions'] : [];
		        	
		        	unset($data['permissions']);
		        	unset($data['_token']);
		        	unset($data['send_password_email']);

		        	$admin = Admin::modify($id, $data);
		        	if($admin)
		        	{
		        		/** IN CASE OF SINGLE UPLOAD **/
		        		if(isset($oldImage) && $oldImage)
		        		{
		        			FileSystem::deleteFile($oldImage);
		        		}
		        		/** IN CASE OF SINGLE UPLOAD **/
		        		
		        		//Send Email
		        		if($sendPasswordEmail)
		        		{
		        			$codes = [
		        				'{first_name}' => $admin->first_name,
		        				'{last_name}' => $admin->last_name,
		        				'{email}' => $admin->email,
		        				'{password}' => $password
		        			];

		        			General::sendTemplateEmail(
		        				$admin->email, 
		        				'admin-registration', 
		        				$codes
		        			);
		        		}

		        		//Make Permissions
		        		if(!$isAdmin && !empty($permissions))
		        		{
	        				Permission::savePermissions(
		        					$admin->id,
		        					$permissions
		        				);
		        		}

		        		$request->session()->flash('success', 'Admin updated successfully.');
		        		return redirect()->route('admin.admins');
		        	}
		        	else
		        	{
		        		$request->session()->flash('error', 'Admin could not be save. Please try again.');
			    		return redirect()->back()->withErrors($validator)->withInput();
		        	}
			    }
			    else
			    {
			    	$request->session()->flash('error', 'Please provide valid inputs.');
			    	return redirect()->back()->withErrors($validator)->withInput();
			    }
			}

			$roles = Roles::getAll([],['status' => 1])->sortByDesc("status");

			return view("admin/admins/edit", [
				'adminPermissions' => Permission::getUserPermissions($admin->id),
    			'permissions' => Permission::all(),
    			'admin' => $admin,
    			'roles' => $roles
    		]);
		}
		else
		{
			abort(404);
		}
    }

    function delete(Request $request, $id)
    {
    	if(!AdminAuth::isAdmin())
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$admin = Admin::find($id);
    	if($admin->delete())
    	{
    		$request->session()->flash('success', 'Admin deleted successfully.');
    		return redirect()->route('admin.admins');
    	}
    	else
    	{
    		$request->session()->flash('error', 'Admin could not be delete.');
    		return redirect()->route('admin.admins');
    	}
    }

    function bulkActions(Request $request, $action)
    {
    	if(!AdminAuth::isAdmin()) 
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$ids = $request->get('ids');
    	if(is_array($ids) && !empty($ids))
    	{
    		switch ($action) {
    			case 'active':
    				Admin::modifyAll($ids, [
    					'status' => 1
    				]);
    				$message = count($ids) . ' records has been activated.';
    			break;
    			case 'inactive':
    				Admin::modifyAll($ids, [
    					'status' => 0
    				]);
    				$message = count($ids) . ' records has been inactivated.';
    			break;
    			case 'delete':
    				Admin::removeAll($ids);
    				$message = count($ids) . ' records has been deleted.';
    			break;
    		}

    		$request->session()->flash('success', $message);

    		return Response()->json([
    			'status' => 'success',
	            'message' => $message,
	        ], 200);		
    	}
    	else
    	{
    		return Response()->json([
    			'status' => 'error',
	            'message' => 'Please select atleast one record.',
	        ], 200);	
    	}
    }

    function resetPassword(Request $request, $id)
    {
    	if(!AdminAuth::isAdmin())
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$admin = Admin::get($id);
    	if($admin)
    	{
	    	if($request->isMethod('post'))
	    	{
	    		$data = $request->toArray();

	    		/** Set random password in case send email button is on **/
	    		$sendPasswordEmail = isset($data['send_password_email']) && $data['send_password_email'] > 0 ? true : false;
	        	if($sendPasswordEmail)
	        	{
	        		$data['password'] = $password = Str::random(20);
	        	}
	        	elseif(!isset($data['password']) || !$data['password'])
	        	{
	        		unset($data['password']);
	        	}
	        	/** Set random password in case send email button is on **/

	        	unset($data['_token']);
	        	unset($data['send_password_email']);
	        	$admin = Admin::modify($id, $data);
	        	if($admin)
	        	{
	        		//Send Email
	        		if($sendPasswordEmail)
	        		{
	        			$link = url('admin/login');
	        			$codes = [
	        				'{first_name}' => $admin->first_name,
	        				'{last_name}' => $admin->last_name,
	        				'{login_link}' => $link,
	        				'{email}' => $admin->email,
	        				'{password}' => $password
	        			];

	        			General::sendTemplateEmail(
	        				$admin->email, 
	        				'admin-password-updated',
	        				$codes
	        			);
	        		}

	        		$request->session()->flash('success', 'Admin updated successfully.');
	        		return redirect()->route('admin.admins');
	        	}
	        	else
	        	{
	        		$request->session()->flash('error', 'Admin could not be save. Please try again.');
		    		return redirect()->back()->withErrors($validator)->withInput();
	        	}
			}

			return view("admin/admins/edit", [
    			'admin' => $admin
    		]);
		}
		else
		{
			abort(404);
		}
    }

    function view(Request $request, $id)
    {
    	if(!AdminAuth::isAdmin())
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$admin = Admin::get($id);

    	if($admin)
    	{
	    	return view(
	    		"admin/admins/view", 
	    		[
	    			'adminPermissions' => Permission::getUserPermissions($admin->id),
    				'permissions' => Permission::all(),
	    			'admin' => $admin
	    		]
	    	);
		}
		else
		{
			abort(404);
		}
    }
}