<?php
/**
 * API Auth Class
 *
 * @package    ActionController
 * @copyright  2021 Globiz Technology Inc..
 * @author     Irfan Ahmad <irfan.ahmad@globiztechnology.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin\Country;

class ActionController extends AppController
{
	public function countries(Request $request)
	{
		$where = [];

		if($request->get('search'))
    	{
    		$search = $request->get('search');
    		$search = '%' . $search . '%';
    		$where['(countries.iso2 LIKE ? or countries.name LIKE ?)'] = [$search, $search];
    	}

		$where['countries.status = ?'] = [1];
		$select = [
			'countries.id',
			'countries.name',
			'countries.currency_code',
			'countries.currency_symbol',
		];
		
		$orderBy = 'countries.name asc';

		$getCountries = Country::getAll($select, $where, $orderBy);
		
		return response()->json([
			'status' 	=> true,
			'data' 		=> $getCountries
		]);
	}
}