<?php

/**
 * Cities Class
 *
 * @package    CitiesController
 * @copyright  2023
 * @author     Irfan Ahmad <irfan.ahmad@globiztechnology.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Admin\Permission;
//use App\Libraries\Location;
use App\Models\Admin\City;

use App\Trait\Location;

class CitiesController extends AppController
{
	use Location;

	function __construct()
	{
		parent::__construct();
	}

    function index(Request $request)
    {
    	if(!Permission::hasPermission('cities', 'listing'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$where['countries.status = ?'] = [1];
    	if($request->get('search'))
    	{
    		$search = $request->get('search');
    		$search = '%' . $search . '%';
    		$where['(
    			countries.name LIKE ? 
    			or 
    			states.name LIKE ? 
    			or 
    			cities.name LIKE ?
    		)'] = [$search, $search, $search];
    	}

    	if($request->get('status') !== "" && $request->get('status') !== null)
    	{    		
    		$where['cities.status'] = $request->get('status');
    	}

    	if($request->get('created_on'))
    	{
    		$createdOn = $request->get('created_on');
    		if(isset($createdOn[0]) && !empty($createdOn[0]))
    			$where['cities.created_at >= ?'] = [
    				date('Y-m-d 00:00:00', strtotime($createdOn[0]))
    			];
    		if(isset($createdOn[1]) && !empty($createdOn[1]))
    			$where['cities.created_at <= ?'] = [
    				date('Y-m-d 23:59:59', strtotime($createdOn[1]))
    			];
    	}

    	$listing = City::getListing($request, $where);

    	if($request->ajax())
    	{
		    $html = view(
	    		"admin/cities/listingLoop", 
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
	    		"admin/cities/index", 
	    		[
	    			'listing' => $listing
	    		]
	    	);
	    }
    }

    function add(Request $request)
    {
    	if(!Permission::hasPermission('cities', 'create'))
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
	                'name' => 'required'
	            ]
	        );

	        if(!$validator->fails())
	        {
	        	$states = City::create($data);
	        	if($states)
	        	{
	        		$request->session()->flash('success', 'City created successfully.');
	        		return redirect()->route('admin.cities');
	        	}
	        	else
	        	{
	        		$request->session()->flash('error', 'City could not be save. Please try again.');
		    		return redirect()->back()->withErrors($validator)->withInput();
	        	}
		    }
		    else
		    {
		    	$request->session()->flash('error', 'Please provide valid inputs.');
		    	return redirect()->back()->withErrors($validator)->withInput();
		    }
		}

		$countries = $this->getCountries($request);
		
	    return view("admin/cities/add", [
	    	'countries' => $countries
	    ]);
    }

    function view(Request $request, $id)
    {
    	if(!Permission::hasPermission('cities', 'listing'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$cities = City::get($id);
    	if($cities)
    	{
	    	return view("admin/cities/view", [
    			'cities' => $cities
    		]);
		}
		else
		{
			abort(404);
		}
    }

    function edit(Request $request, $id)
    {
    	if(!Permission::hasPermission('cities', 'update'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$cities = City::get($id);

    	if($cities)
    	{
	    	if($request->isMethod('post'))
	    	{
	    		$data = $request->toArray();
	    		unset($data['_token']);

	    		$validator = Validator::make(
		            $request->toArray(),
		            [
		                'name' => [
		                	'required'
		                ],		                
		            ]
		        );

		        if(!$validator->fails())
		        {
		        	if(City::modify($id, $data))
		        	{

		        		$request->session()->flash('success', 'City updated successfully.');
		        		return redirect()->route('admin.cities');
		        	}
		        	else
		        	{
		        		$request->session()->flash('error', 'City could not be save. Please try again.');
			    		return redirect()->back()->withErrors($validator)->withInput();
		        	}
			    }
			    else
			    {
			    	$request->session()->flash('error', 'Please provide valid inputs.');
			    	return redirect()->back()->withErrors($validator)->withInput();
			    }
			}

			$countries = $this->getCountries($request);
			$states = $this->getStatesByCountryId($request, $cities->state->country_id);

			return view("admin/cities/edit", [
    			'cities' => $cities,
    			'states' => $states,
    			'countries' => $countries
    		]);
		}
		else
		{
			abort(404);
		}
    }

    function delete(Request $request, $id)
    {
    	if(!Permission::hasPermission('cities', 'delete'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$admin = City::find($id);
    	if($admin->delete())
    	{
    		$request->session()->flash('success', 'City deleted successfully.');
    		return redirect()->route('admin.cities');
    	}
    	else
    	{
    		$request->session()->flash('error', 'City could not be delete.');
    		return redirect()->route('admin.cities');
    	}
    }

    function bulkActions(Request $request, $action)
    {
    	if( ($action != 'delete' && !Permission::hasPermission('cities', 'update')) || ($action == 'delete' && !Permission::hasPermission('cities', 'delete')) )
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$ids = $request->get('ids');
    	if(is_array($ids) && !empty($ids))
    	{
    		switch ($action) {
    			case 'active':
    				City::modifyAll($ids, [
    					'status' => 1
    				]);
    				$message = count($ids) . ' records has been published.';
    			break;
    			case 'inactive':
    				City::modifyAll($ids, [
    					'status' => 0
    				]);
    				$message = count($ids) . ' records has been unpublished.';
    			break;
    			case 'delete':
    				City::removeAll($ids);
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