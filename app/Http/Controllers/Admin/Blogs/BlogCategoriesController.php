<?php

/**
 * BlogCategory Class
 *
 * @package    BlogCategoriesController
 * @copyright  2023
 * @author     Irfan Ahmad <irfanahmed1555@gmail.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */


namespace App\Http\Controllers\Admin\Blogs;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Admin\Permission;
use App\Models\Admin\Admin;
use App\Models\Admin\Setting;
use App\Models\Admin\BlogCategory;
use App\Libraries\FileSystem;
use App\Http\Controllers\Admin\AppController;

class BlogCategoriesController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function index(Request $request)
    {
    	if(!Permission::hasPermission('blog_categories', 'listing'))
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
    			blog_categories.title LIKE ? 
    			or 
    			parent.title LIKE ? 
    			or 
    			concat(owner.first_name," ",owner.last_name) LIKE ? 
    			or 
    			owner.last_name LIKE ?
    		)'] = [$search, $search, $search, $search];
    	}

    	if($request->get('created_on'))
    	{
    		$createdOn = $request->get('created_on');
    		if(isset($createdOn[0]) && !empty($createdOn[0]))
    			$where['blog_categories.created_at >= ?'] = [
    				date('Y-m-d 00:00:00', strtotime($createdOn[0]))
    			];
    		if(isset($createdOn[1]) && !empty($createdOn[1]))
    			$where['blog_categories.created_at <= ?'] = [
    				date('Y-m-d 23:59:59', strtotime($createdOn[1]))
    			];
    	}

    	if($request->get('category'))
    	{
    		$parentIds = $request->get('category');
    		$parentIds = implode(',', $parentIds);
    		$where[] = 'blog_categories.parent_id IN ('.$parentIds.')';
    	}

    	if($request->get('admins'))
    	{
    		$admins = $request->get('admins');
    		$admins = $admins ? implode(',', $admins) : 0;
    		$where[] = 'blog_categories.created_by IN ('.$admins.')';
    	}

    	// In case of subcategory enable
		if(!Setting::get('sub_category_enable'))
		{
    		$where[] = "blog_categories.parent_id is null";
		}

    	$listing = BlogCategory::getListing($request, $where);

    	if($request->ajax())
    	{
		    $html = view(
	    		"admin/blogs/categories/listingLoop", 
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
	    		"admin/blogs/categories/index", 
	    		[
	    			'listing' => $listing,
	    			'categories' => $filters['categories'],
	    			'admins' => $filters['admins']
	    		]
	    	);
	    }
    }

    function filters(Request $request)
    {
    	$categories = BlogCategory::getAll(
    		[
    			'blog_categories.id',
    			'blog_categories.title'
    		],
    		[
    			'blog_categories.parent_id is null'
    		],
    		'blog_categories.title desc'
    	);

		$admins = [];
		$adminIds = BlogCategory::distinct()->whereNotNull('created_by')->pluck('created_by')->toArray();
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
    		'categories' => $categories,
	    	'admins' => $admins
    	];
    }

    function view(Request $request, $id)
    {
    	if(!Permission::hasPermission('blog_categories', 'listing'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$category = BlogCategory::get($id);
    	if($category)
    	{
	    	return view("admin/blogs/categories/view", [
    			'category' => $category
    		]);
		}
		else
		{
			abort(404);
		}
    }

    function add(Request $request)
    {
    	if(!Permission::hasPermission('blog_categories', 'create'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	if($request->isMethod('post'))
    	{
    		$data = $request->toArray();
    		unset($data['_token']);

    		if(isset($data['parent_id']) && $data['parent_id'])
    			$data['parent_id'] = $data['parent_id'];
    		else
    			unset($data['parent_id']);


    		$validator = Validator::make(
	            $request->toArray(),
	            [
	                'title' => 'required|unique:blog_categories,title'
	            ]
	        );

	        if(!$validator->fails())
	        {
	        	$category = BlogCategory::create($data);

	        	if($category)
	        	{
	        		$request->session()->flash('success', 'Blog category created successfully.');
	        		return redirect()->route('admin.blogs.categories');
	        	}
	        	else
	        	{
	        		$request->session()->flash('error', 'Blog could not be save. Please try again.');
		    		return redirect()->back()->withErrors($validator)->withInput();
	        	}
		    }
		    else
		    {
		    	$request->session()->flash('error', 'Please provide valid inputs.');
		    	return redirect()->back()->withErrors($validator)->withInput();
		    }
		}
	    
	    $categories = BlogCategory::getAll(
    		[
    			'blog_categories.id',
    			'blog_categories.title'
    		],
    		[
    			'blog_categories.parent_id is null'
    		],
    		'blog_categories.title desc'
    	);

	    return view("admin/blogs/categories/add", [
    		'categories' => $categories
		]);
    }

    function edit(Request $request, $id)
    {
    	if(!Permission::hasPermission('blog_categories', 'update'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$category = BlogCategory::get($id);

    	if($category)
    	{
	    	if($request->isMethod('post'))
	    	{
	    		$data = $request->toArray();

	    		if(isset($data['parent_id']) && $data['parent_id'])
    				$data['parent_id'] = $data['parent_id'];
	    		else
	    			unset($data['parent_id']);

	    		$validator = Validator::make(
		            $request->toArray(),
		            [
		                'title' => [
		                	'required',
		                	Rule::unique('blog_categories')->ignore($category->id)
		                ]
		            ]
		        );

		        if(!$validator->fails())
		        {
		        	unset($data['_token']);
	        		
	        		/** IN CASE OF SINGLE UPLOAD **/
		        	if(isset($data['image']) && $data['image'])
		        	{
		        		$oldImage = $category->image;
		        	}
		        	else
		        	{
		        		unset($data['image']);
		        		
		        	}
		        	/** IN CASE OF SINGLE UPLOAD **/
		        	if(BlogCategory::modify($id, $data))
		        	{
		        		/** IN CASE OF SINGLE UPLOAD **/
		        		if(isset($oldImage) && $oldImage)
		        		{
		        			FileSystem::deleteFile($oldImage);
		        		}
		        		/** IN CASE OF SINGLE UPLOAD **/

		        		$request->session()->flash('success', 'Blog category updated successfully.');
		        		return redirect()->route('admin.blogs.categories');
		        	}
		        	else
		        	{
		        		$request->session()->flash('error', 'Blog category could not be save. Please try again.');
			    		return redirect()->back()->withErrors($validator)->withInput();
		        	}
			    }
			    else
			    {
			    	$request->session()->flash('error', 'Please provide valid inputs.');
			    	return redirect()->back()->withErrors($validator)->withInput();
			    }
			}

    		$categories = BlogCategory::getAll(
	    		[
	    			'blog_categories.id',
	    			'blog_categories.title'
	    		],
	    		[
	    			'blog_categories.parent_id is null'
	    		],
	    		'blog_categories.title desc'
	    	);
		    return view("admin/blogs/categories/edit", [
		    		'categories' => $categories,
		    		'category' => $category
	    		]);
		}
		else
		{
			abort(404);
		}
    }

    function delete(Request $request, $id)
    {
    	if(!Permission::hasPermission('blog_categories', 'delete'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$admin = BlogCategory::find($id);
    	if($admin->delete())
    	{
    		$request->session()->flash('success', 'Blog category deleted successfully.');
    		return redirect()->route('admin.blogs.categories');
    	}
    	else
    	{
    		$request->session()->flash('error', 'Blog category could not be delete.');
    		return redirect()->route('admin.blogs.categories');
    	}
    }

    function bulkActions(Request $request, $action)
    {
    	if( ($action != 'delete' && !Permission::hasPermission('blog_categories', 'update')) || ($action == 'delete' && !Permission::hasPermission('blog_categories', 'delete')) ) 
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}
    	
    	$ids = $request->get('ids');
    	if(is_array($ids) && !empty($ids))
    	{
    		switch ($action) {
    			case 'delete':
    				BlogCategory::removeAll($ids);
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
}
