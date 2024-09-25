<?php
namespace App\Trait;

use Illuminate\Http\Request;

use App\Models\Admin\Country;
use App\Models\Admin\State;
use App\Models\Admin\City;

trait Location
{
	// Country
	public function getCountries(Request $request)
	{
		$where['countries.status = ?'] = [1];
		$countries = Country::getAll($select = [], $where);
		return $countries;
	}

	// States
	public function getStatesByCountryId(Request $request, $countryId)
	{
		$where['states.status = ?'] = [1];
		$where['states.country_id'] = $countryId;

		$order = 'states.name asc';
		$states = State::getAll($select = [], $where);
		
		return $states;
	}

	// Cities
	public function getCitiesByStateId(Request $request, $stateId)
	{
		$where['cities.status = ?'] = [1];
		$where['cities.state_id'] = $stateId;
		$cities = City::getAll($select = [], $where);
		return $cities;
	}

	public function getPhoneCodes(Request $request)
	{
		// Country
		$where['countries.status'] = 1;
		$select = [
			'countries.id',
			'countries.calling_code'
		];
		$phoneCodes = Country::getAll($select, $where);
		return $phoneCodes;
	}
}