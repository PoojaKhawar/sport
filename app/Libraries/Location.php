<?php
namespace App\Libraries;

use App\Models\Admin\Country;
use App\Models\Admin\State;
use App\Models\Admin\City;

class Location
{
	// Country
	public static function getCountries()
	{
		$where['countries.status = ?'] = [1];
		$countries = Country::getAll($select = [], $where);
		return $countries;
	}

	// States
	public static function getStatesByCountryId($countryId)
	{
		$where['states.status = ?'] = [1];
		$where['states.country_id'] = $countryId;
		$states = State::getAll($select = [], $where);
		return $states;
	}

	// Cities
	public static function getCitiesByStateId($stateId)
	{
		$where['cities.status = ?'] = [1];
		$where['cities.state_id'] = $stateId;
		$cities = City::getAll($select = [], $where);
		return $cities;
	}

	public static function getPhoneCodes()
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