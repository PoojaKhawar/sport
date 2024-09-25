<?php

/**
 * Roles Class
 *
 * @package    RolesController
 * @copyright  2023
 * @author     Irfan Ahmad <irfan.ahmad@globiztechnology.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Artisan;

use App\Models\Admin\Admin;
use App\Models\Admin\Permission;

use App\Models\Admin\Roles;
use App\Models\Admin\RolePermissions;

use App\Http\Controllers\Admin\AppController;

class RolesController extends AppController
{
    function index(Request $request)
    {
    	if(!Permission::hasPermission('roles', 'listing'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$where = [];
    	if($request->get('search'))
    	{
    		$search = $request->get('search');
    		$search = '%' . $search . '%';
    		$where['( 
                roles.id LIKE ? 
                or 
                roles.title LIKE ?
            )'] = [$search, $search];
    	}

    	if($request->get('created_on'))
    	{
    		$createdOn = $request->get('created_on');
    		if(isset($createdOn[0]) && !empty($createdOn[0]))
            {
    			$where['roles.created >= ?'] = [
    				date('Y-m-d 00:00:00', strtotime($createdOn[0]))
    			];
            }

    		if(isset($createdOn[1]) && !empty($createdOn[1]))
            {
    			$where['roles.created <= ?'] = [
    				date('Y-m-d 23:59:59', strtotime($createdOn[1]))
    			];
            }
    	}

    	if($request->get('status') !== "" && $request->get('status') !== null)
        {           
            $where['roles.status'] = $request->get('status');
        }
    	
    	$listing = Roles::getListing($request, $where);
        
    	if($request->ajax())
    	{
		    $html = view(
	    		"admin/roles/listingLoop", 
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
	    		"admin/roles/index", 
	    		[
	    			'listing' => $listing
	    		]
	    	);
	    }
    }

    function add(Request $request)
    {
    	if(!Permission::hasPermission('roles', 'create'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	if($request->isMethod('post'))
    	{
    		$data = $request->toArray();
    		unset($data['_token']);

    		$validator = Validator::make(
	            $request->toArray(),
	            [
	                'title' => 'required',
                    'permissions' => 'required',
	            ]
	        );

	        if(!$validator->fails())
	        {   
                $permissions = isset($data['permissions']) && $data['permissions'] ? $data['permissions'] : [];
                unset($data['permissions']);

	        	$receivers = Roles::create($data);
                
	        	if($receivers)
                {
                    if(!empty($permissions))
                    {
                        Permission::saveRolePermissions(
                            $receivers->id,
                            $permissions
                        );
                        Artisan::call('migration:permissions');
                    }
                    
                    $request->session()->flash('success', 'Role created successfully.');
                    return redirect()->route('admin.roles');
                }
                else
                {
                    $request->session()->flash('error', 'Role could not be save. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }
            else
            {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        return view("admin/roles/add", [
            'permissions' => Permission::all(),
        ]);    
    }

    function edit(Request $request, $id)
    {
        if(!Permission::hasPermission('roles', 'update'))
        {
            $request->session()->flash('error', 'Permission denied.');
            return redirect()->route('admin.dashboard');
        }

        $page = Roles::get($id);
      
        if($page)
        {
            if($request->isMethod('post'))
            {
                $data = $request->toArray();
                $validator = Validator::make(
                $request->toArray(),
                    [
                        'title' => 'required',
                        'permissions' => 'required',
                    ]
                );

                if(!$validator->fails())
                {
                    $permissions = isset($data['permissions']) && $data['permissions'] ? $data['permissions'] : [];

                    unset($data['permissions']);
                    unset($data['_token']);

                    if($receivers = Roles::modify($id, $data))
                    {
                        if(!empty($permissions))
                        {
                            Permission::saveRolePermissions(
                                $receivers->id,
                                $permissions
                            );
                            Artisan::call('migration:permissions');
                        }
                        
                        $request->session()->flash('success', 'Role updated successfully.');
                        return redirect()->route('admin.roles');
                    }
                    else
                    {
                        $request->session()->flash('error', 'Role could not be save. Please try again.');
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                }
                else
                {
                    $request->session()->flash('error', 'Please provide valid inputs.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }
    
            return view("admin/roles/edit", [
                'page'  => $page,
                'adminPermissions' => Permission::getRolePermissions($page->id),
                'permissions' => Permission::all(),
            ]);
        }
        else
        {
            abort(404);
        }
    }

    function delete(Request $request, $id)
    {
    	if(!Permission::hasPermission('roles', 'delete'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$receivers = Roles::find($id);

        $where['admins.role'] = $receivers->id;
        $role = Admin::getRow($where);

        if(!$role)
        { 
        	if($receivers->delete())
        	{
        		$request->session()->flash('success', 'Role deleted successfully.');
        		return redirect()->route('admin.roles');
        	}
        	else
        	{
        		$request->session()->flash('error', 'Role could not be delete.');
        		return redirect()->route('admin.roles');
        	}
        }
        else
        {
            $request->session()->flash('error', 'Role could not be delete.');
            return redirect()->route('admin.roles');
        }    
    }

    function bulkActions(Request $request, $action)
    {
    	if( ($action != 'delete' && !Permission::hasPermission('roles', 'update')) || ($action == 'delete' && !Permission::hasPermission('roles', 'delete')) ) 
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$ids = $request->get('ids');
    	if(is_array($ids) && !empty($ids))
    	{
    		switch($action)
            {
    			case 'active':
    				Roles::modifyAll($ids, [
    					'status' => 1
    				]);
    				$message = count($ids) . ' records has been published.';
    			break;
    			case 'inactive':
    				Roles::modifyAll($ids, [
    					'status' => 0
    				]);
    				$message = count($ids) . ' records has been unpublished.';
    			break;
    			case 'delete':
    				Roles::removeAll($ids);
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

    function view(Request $request, $id)
    {
    	if(!Permission::hasPermission('roles', 'listing'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$receivers = Roles::get($id);
    	if($receivers)
    	{
	    	return view("admin/roles/view", [
    			'receivers' => $receivers
    		]);
		}
		else
		{
			abort(404);
		}
    }
}	