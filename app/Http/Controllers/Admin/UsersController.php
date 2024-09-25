<?php

/**
 * User Class
 *
 * @package    UsersController
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
use App\Libraries\FileSystem;
use App\Libraries\Excel;
use App\Models\Admin\Permission;
use App\Models\Admin\User;
use App\Models\Admin\Admin;


class UsersController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function index(Request $request)
    {
    	if(!Permission::hasPermission('users', 'listing'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$where = [];

    	if($request->get('search'))
    	{
    		$search = $request->get('search');
    		$search = '%' . $search . '%';
    		$where['
    			(concat(users.first_name, " ", users.last_name) LIKE ? 
    			or 
    			users.email LIKE ? 
    			or 
    			users.phonenumber LIKE ?
    		)'] = [$search, $search, $search];
    	}

    	if($request->get('last_login'))
    	{
    		$lastLogin = $request->get('last_login');
    		if(isset($lastLogin[0]) && !empty($lastLogin[0]))
    			$where['users.last_login >= ?'] = [
    				date('Y-m-d 00:00:00', strtotime($lastLogin[0]))
    			];
    		if(isset($lastLogin[1]) && !empty($lastLogin[1]))
    			$where['users.last_login <= ?'] = [
    				date('Y-m-d 23:59:59', strtotime($lastLogin[1]))
    			];
    	}

    	if($request->get('created_on'))
    	{
    		$created = $request->get('created_on');
    		if(isset($created[0]) && !empty($created[0]))
    			$where['users.created_at >= ?'] = [
    				date('Y-m-d 00:00:00', strtotime($created[0]))
    			];
    		if(isset($created[1]) && !empty($created[1]))
    			$where['users.created_at <= ?'] = [
    				date('Y-m-d 23:59:59', strtotime($created[1]))
    			];
    	}

    	if($request->get('status') !== "" && $request->get('status') !== null)
    	{    		
    		$where['users.status'] = $request->get('status');
    	}

    	if($request->get('admins'))
    	{
    		$admins = $request->get('admins');
    		$admins = $admins ? implode(',', $admins) : 0;
    		$where[] = 'users.created_by IN ('.$admins.')';
    	}

    	$listing = User::getListing($request, $where);
    	if($request->ajax())
    	{
		    $html = view(
	    		"admin/users/listingLoop", 
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
			/** Filter Data **/
			$filters = $this->filters($request);
	    	/** Filter Data **/
	    	return view(
	    		"admin/users/index", 
	    		[
	    			'listing' 	=> $listing,
	    			'admins' 	=> $filters['admins']
	    		]
	    	);
	    }
    }

    function add(Request $request)
    {
    	if(!Permission::hasPermission('users', 'create'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	if($request->isMethod('post'))
    	{
    		$data = $request->toArray();

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
	                	Rule::unique('users')->whereNull('deleted_at')
	                ],
	                'send_password_email' => 'required',
	                'password' => [
	                	'nullable',
					    'min:8',
	                ]
	            ]
	        );

    		// Gender
	        if(!$data['gender'])
	        {
	        	unset($data['gender']);
	        }

	        if(!$validator->fails())
	        {
	        	$password = $data['password'];
	        	unset($data['_token']);
	        	unset($data['send_password_email']);

	        	$data['email_verified_at'] = date('Y-m-d H:i:s');
	        	$data['phone_verified_at'] = date('Y-m-d H:i:s');

	        	$user = User::create($data);

	        	if($user)
	        	{
	        		//Send Email
	        		if($sendPasswordEmail)
	        		{
	        			/*$codes = [
	        				'{first_name}' => $user->first_name,
	        				'{last_name}' => $user->last_name,
	        				'{email}' => $user->email,
	        				'{password}' => $password
	        			];

	        			General::sendTemplateEmail(
	        				$user->email, 
	        				'customer-admin-registration', 
	        				$codes
	        			);*/
	        		}

	        		$request->session()->flash('success', 'User created successfully.');
	        		return redirect()->route('admin.users');
	        	}
	        	else
	        	{
	        		$request->session()->flash('error', 'User could not be save. Please try again.');
		    		return redirect()->back()->withErrors($validator)->withInput();
	        	}
		    }
		    else
		    {
		    	$request->session()->flash('error', 'Please provide valid inputs.');
		    	return redirect()->back()->withErrors($validator)->withInput();
		    }
		}
		
	    return view("admin/users/add",[
    	]);
    }

    function edit(Request $request, $id)
    {
    	if(!Permission::hasPermission('users', 'update'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$user = User::get($id);
    	if($user)
    	{
	    	if($request->isMethod('post'))
	    	{
	    		$data = $request->toArray();

	    		if(isset($data['dol']) && ($data['dol'] == null || $data['dol'] == ''))
	    		{
	    			$data['dol'] = null;
	    		}

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
	    		$validator = Validator::make(
		            $data,
		            [
		                'first_name' => 'required',
		                'last_name' => 'required',
		                'email' => [
		                	'required',
		                	'email',
		                	Rule::unique('users')->ignore($user->id)->whereNull('deleted_at')
		                ],
		                'password' => [
		                	'nullable',
						    'min:8',
		                ],
		            ]
		        );

	    		// Gender
		        if(!$data['gender'])
		        {
		        	unset($data['gender']);
		        }

		        if(!$validator->fails())
		        {
		        	unset($data['_token']);
		        	unset($data['send_password_email']);

		        	/** IN CASE OF SINGLE UPLOAD **/
		        	if(isset($data['image']) && $data['image'])
		        	{
		        		$oldImage = $user->image;
		        	}
		        	else
		        	{
		        		unset($data['image']);
		        		
		        	}
		        	/** IN CASE OF SINGLE UPLOAD **/

		        	$user = User::modify($id, $data);
		        	if($user)
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
		        				'{first_name}' => $user->first_name,
		        				'{last_name}' => $user->last_name,
		        				'{email}' => $user->email,
		        				'{password}' => $password
		        			];

		        			/*General::sendTemplateEmail(
		        				$user->email, 
		        				'customer-admin-registration',
		        				$codes
		        			);*/
		        		}

		        		$request->session()->flash('success', 'Employee updated successfully.');
		        		return redirect()->route('admin.users');
		        	}
		        	else
		        	{
		        		$request->session()->flash('error', 'Employee could not be save. Please try again.');
			    		return redirect()->back()->withErrors($validator)->withInput();
		        	}
			    }
			    else
			    {
			    	$request->session()->flash('error', 'Please provide valid inputs.');
			    	return redirect()->back()->withErrors($validator)->withInput();
			    }
			}
			
			return view("admin/users/edit", [
    			'user' => $user,
    		]);
		}
		else
		{
			abort(404);
		}
    }

    function resetPassword(Request $request, $id)
    {
    	if(!Permission::hasPermission('users', 'update'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$user = User::get($id);
    	if($user)
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
	        	$user = User::modify($id, $data);
	        	if($user)
	        	{
	        		//Send Email
	        		if($sendPasswordEmail)
	        		{
	        			$link = General::urlToAnchor(url('users/login'));
	        			$codes = [
	        				'{first_name}' => $user->first_name,
	        				'{last_name}' => $user->last_name,
	        				'{login_link}' => $link,
	        				'{email}' => $user->email,
	        				'{password}' => $password
	        			];

	        			General::sendTemplateEmail(
	        				$user->email, 
	        				'user-password-updated',
	        				$codes
	        			);
	        		}

	        		$request->session()->flash('success', 'User updated successfully.');
	        		return redirect()->route('admin.users');
	        	}
	        	else
	        	{
	        		$request->session()->flash('error', 'User could not be save. Please try again.');
		    		return redirect()->back()->withErrors($validator)->withInput();
	        	}
			}

			return view("admin/users/edit", [
    			'user' => $user
    		]);
		}
		else
		{
			abort(404);
		}
    }

    function filters(Request $request)
    {
		$admins = [];
		$adminIds = User::distinct()->whereNotNull('created_by')->pluck('created_by')->toArray();
		if($adminIds)
		{
	    	$admins = Admin::getAll(
	    		[
	    			'admins.id',
	    			'admins.first_name',
	    			'admins.last_name',
	    			'admins.status',
	    		],
	    		[
	    			'admins.id in ('.implode(',', $adminIds).')'
	    		],
	    		'concat(admins.first_name, admins.last_name) desc'
	    	);
	    }
    	return [
	    	'admins' => $admins
    	];
    }

    function view(Request $request, $id)
    {
    	if(!Permission::hasPermission('users', 'listing'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$user = User::get($id);
    	if($user)
    	{
    		return view(
	    		"admin/users/view", 
	    		[
	    			'user' => $user
	    		]
	    	);	
		}
		else
		{
			abort(404);
		}
    }

    function delete(Request $request, $id)
    {
    	if(!Permission::hasPermission('users', 'delete'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$user = User::find($id);
    	
    	if($user)
    	{
	    	if($user->delete())
	    	{
	    		$request->session()->flash('success', 'User deleted successfully.');
	    		return redirect()->route('admin.users');
	    	}
	    	else
	    	{
	    		$request->session()->flash('error', 'User category could not be delete.');
	    		return redirect()->route('admin.users');
	    	}
	    }
	    else
	    {
	    	abort(404);
	    }
    }

    function bulkActions(Request $request, $action)
    {
    	if( ($action != 'delete' && !Permission::hasPermission('users', 'update')) || ($action == 'delete' && !Permission::hasPermission('users', 'delete')) ) 
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$ids = $request->get('ids');
    	if(is_array($ids) && !empty($ids))
    	{
    		switch ($action) {
    			case 'active':
    				User::modifyAll($ids, [
    					'status' => 1
    				]);
    				$message = count($ids) . ' records has been activated.';
    			break;
    			case 'inactive':
    				User::modifyAll($ids, [
    					'status' => 0
    				]);
    				$message = count($ids) . ' records has been inactivated.';
    			break;
    			case 'delete':
    				User::removeAll($ids);
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

    function updatePicture(Request $request)
    {
    	if(!Permission::hasPermission('users', 'update'))
    	{
    		return Response()->json([
		    	'status' => 'error',
		    	'message' => 'Permission denied.'
		    ]);
    	}

    	if($request->isMethod('post'))
    	{
    		$data = $request->toArray();

            $validator = Validator::make(
	            $request->toArray(),
	            [
	                'file' => 'mimes:jpg,jpeg,png,gif',
	            ]
	        );

	        if(!$validator->fails())
	        {
				$id = $data['id'];

		    	$user = User::find($id);
		    	if($user)
		    	{
		    		$oldImage = $user->image;
		    		if($request->file('file')->isValid())
		    		{
		    			$file = FileSystem::uploadImage(
		    				$request->file('file'),
		    				'users'
		    			);

		    			if($file)
		    			{
		    				$user->image = $file;
		    				if($user->save())
		    				{
		    					$originalName = FileSystem::getFileNameFromPath($file);
		    					
		    					FileSystem::resizeImage($file, 'M-' . $originalName, "350*350");
		    					FileSystem::resizeImage($file, 'S-' . $originalName, "100*100");
		    					$picture = $user->getResizeImagesAttribute()['medium'];

		    					if($oldImage)
		    					{
		    						FileSystem::deleteFile($oldImage);
		    					}

		    					return Response()->json([
							    	'status' => 'success',
							    	'message' => 'Picture uploaded successfully.',
							    	'picture' => url($picture)
							    ]);		
		    				}
		    				else
		    				{
		    					FileSystem::deleteFile($file);
		    					return Response()->json([
							    	'status' => 'error',
							    	'message' => 'Picture could not be uploaded.'
							    ]);	
		    				}
		    			}
		    			else
		    			{
		    				return Response()->json([
						    	'status' => 'error',
						    	'message' => 'Picture could not be upload.'
						    ]);		
		    			}
		    		}
					else
					{
						return Response()->json([
					    	'status' => 'error',
					    	'message' => 'Picture could not be uploaded. Please try again.'
					    ]);
					}
				}
				else
				{
					return Response()->json([
				    	'status' => 'error',
				    	'message' => 'User member is missing.'
				    ]);
				}
			}
		}
		else
		{
			return Response()->json([
		    	'status' => 'error',
		    	'message' => 'User member is missing.'
		    ]);
		}
    }

    // Export
    function export(Request $request, $action = null)
    {
        $data = $request->toArray();

        $limit = 3000;
        $where = [];
        
        $header = [
            'Id',
            'First Name',
            'Last Name',
            'Email',
            'Phonenumber',
            'Gender',
            'Date Of Birth',
            'Address'
        ];

        $select = [
            'users.id',
            'users.first_name',
            'users.last_name',
            'users.email',
            'users.phonenumber',
            'users.gender',
            'users.dob',
            'users.address'
        ];

        if($data['t'] == 'all' && isset($data['d']) && $data['d'])
        {
        	$dates = explode('-', $data['d']);

        	if(count($dates)  === 2)
        	{
	        	if(isset($dates[0]) && !empty($dates[0]))
	        	{
	        		$where['users.created_at >= ?'] = [
	        			date('Y-m-d 00:00:00', strtotime($dates[0]))
	        		];
	        	}

	        	if(isset($dates[1]) && !empty($dates[1]))
	        	{
	        		$where['users.created_at <= ?'] = [
	        			date('Y-m-d 23:59:59', strtotime($dates[1]))
	        		];
	        	}
        	}
        }
        else if($data['t'] == 'filtered')
        {
	        if($request->get('search'))
	        {
	        	$search = $request->get('search');
	        	$search = '%' . $search . '%';
	        	$where['(concat(users.first_name, " ", users.last_name) LIKE ? or users.email LIKE ? or users.phonenumber LIKE ?)'] = [$search, $search, $search];
	        }

	        if($request->get('last_login'))
	        {
	        	$lastLogin = $request->get('last_login');
	        	if(isset($lastLogin[0]) && !empty($lastLogin[0]))
	        		$where['users.last_login >= ?'] = [
	        			date('Y-m-d 00:00:00', strtotime($lastLogin[0]))
	        		];
	        	if(isset($lastLogin[1]) && !empty($lastLogin[1]))
	        		$where['users.last_login <= ?'] = [
	        			date('Y-m-d 23:59:59', strtotime($lastLogin[1]))
	        		];
	        }

	        if($request->get('created_on'))
	        {
	        	$created = $request->get('created_on');
	        	if(isset($created[0]) && !empty($created[0]))
	        		$where['users.created_at >= ?'] = [
	        			date('Y-m-d 00:00:00', strtotime($created[0]))
	        		];
	        	if(isset($created[1]) && !empty($created[1]))
	        		$where['users.created_at <= ?'] = [
	        			date('Y-m-d 23:59:59', strtotime($created[1]))
	        		];
	        }


	        if($request->get('status') !== "" && $request->get('status') !== null)
	    	{    		
	    		$where['users.status'] = $request->get('status');
	    	}

	    	if($request->get('admins'))
	    	{
	    		$admins = $request->get('admins');
	    		$admins = $admins ? implode(',', $admins) : 0;
	    		$where[] = 'users.created_by IN ('.$admins.')';
	    	}
        }

        $data = User::getExportAll($select, $where, $limit);

        $filename = time().'-users.xlsx';

        return Excel::download($data->toArray(), $header, $filename);
    }
}