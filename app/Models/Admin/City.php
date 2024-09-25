<?php

namespace App\Models\Admin;

use App\Models\AppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Libraries\General;

class City extends AppModel
{
    protected $table = 'cities';
    protected $primaryKey = 'id';
    
    /**
    * Cities -> State belongsTO relation
    * 
    * @return State
    */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    /**
    * To search and get pagination listing
    * @param Request $request
    * @param $limit
    */

    public static function getListing(Request $request, $where = [])
    {
        $orderBy = $request->get('sort') ? $request->get('sort') : 'cities.id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = self::$paginationLimit;
        $offset = ($page - 1) * $limit;
        
        $listing = City::select([
                'cities.*',
                'states.name as state_name',
                'countries.name as country_name'
            ])
            ->leftJoin('states', 'states.id', '=', 'cities.state_id')
            ->leftJoin('countries', 'countries.id', '=', 'states.country_id')
            ->orderBy($orderBy, $direction);

        if(!empty($where))
        {
            foreach($where as $query => $values)
            {
                if(is_array($values))
                    $listing->whereRaw($query, $values);
                elseif(!is_numeric($query))
                    $listing->where($query, $values);
                else
                    $listing->whereRaw($values);
            }
        }

        // Put offset and limit in case of pagination
        if($page !== null && $page !== "" && $limit !== null && $limit !== "")
        {
            $listing->offset($offset);
            $listing->limit($limit);
        }

        $listing = $listing->paginate($limit);

        return $listing;
    }

    /**
    * To get all records
    * @param $where
    * @param $orderBy
    * @param $limit
    */
    public static function getAll($select = [], $where = [], $orderBy = 'cities.id desc', $limit = null)
    {
        $listing = City::orderByRaw($orderBy);

        if(!empty($select))
        {
            $listing->select($select);
        }
        else
        {
            $listing->select([
                'cities.*'
            ]); 
        }

        if(!empty($where))
        {
            foreach($where as $query => $values)
            {
                if(is_array($values))
                    $listing->whereRaw($query, $values);
                elseif(!is_numeric($query))
                    $listing->where($query, $values);
                else
                    $listing->whereRaw($values);
            }
        }
        
        if($limit !== null && $limit !== "")
        {
            $listing->limit($limit);
        }

        $listing = $listing->get();

        return $listing;
    }

    /**
    * To get single record by id
    * @param $id
    */
    public static function get($id)
    {
        $record = City::where('id', $id)
            ->with([
                'state' => function($query) {
                    $query->select([
                        'states.id',
                        'states.name',                            
                        'countries.id as country_id',
                        'countries.name as country_name'
                    ])
                    ->leftJoin('countries', 'countries.id', '=', 'states.country_id');
                }
            ])
            ->first();
        return $record;
    }

    /**
    * To get single row by conditions
    * @param $where
    * @param $orderBy
    */
    public static function getRow($where = [], $orderBy = 'cities.id desc')
    {
        $record = City::orderByRaw($orderBy);

        foreach($where as $query => $values)
        {
            if(is_array($values))
                $record->whereRaw($query, $values);
            elseif(!is_numeric($query))
                $record->where($query, $values);
            else
                $record->whereRaw($values);
        }
        
        $record = $record->limit(1)->first();

        return $record;
    }

    /**
    * To insert
    * @param $where
    * @param $orderBy
    */
    public static function create($data)
    {
        $cities = new City();

        foreach($data as $k => $v)
        {
            $cities->{$k} = $v;
        }

        if($cities->save())
        {
            if(isset($data['name']) && $data['name'])
            {
                $cities->save();
            }

            return $cities;
        }
        else
        {
            return null;
        }
    }

    /**
    * To update
    * @param $id
    * @param $where
    */
    public static function modify($id, $data)
    {
        $cities = City::find($id);
        foreach($data as $k => $v)
        {
            $cities->{$k} = $v;
        }
        
        if($cities->save())
        {
            if(isset($data['name']) && $data['name'])
            {
                $cities->save();
            }

            return $cities;
        }
        else
        {
            return null;
        }
    }
    
    /**
    * To update all
    * @param $id
    * @param $where
    */
    public static function modifyAll($ids, $data)
    {
        if(!empty($ids))
        {
            return City::whereIn('cities.id', $ids)
                    ->update($data);
        }
        else
        {
            return null;
        }
    }

    /**
    * To delete
    * @param $id
    */
    public static function remove($id)
    {
        $cities = City::find($id);
        return $cities->delete();
    }

    /**
    * To delete all
    * @param $id
    * @param $where
    */
    public static function removeAll($ids)
    {
        if(!empty($ids))
        {
            return City::whereIn('cities.id', $ids)
                    ->delete();
        }
        else
        {
            return null;
        }
    }

    /**
    * To get count
    * @param $where
    */
    public static function getCount($where = [])
    {
        $record = City::select([
                DB::raw('COUNT(cities.id) as count'),
            ]);

        if(!empty($where))
        {
            foreach($where as $query => $values)
            {
                if(is_array($values))
                    $record->whereRaw($query, $values);
                elseif(!is_numeric($query))
                    $record->where($query, $values);
                else
                    $record->whereRaw($values);
            }

            $record = $record->limit(1)->first();
        }

        return $record ? $record->count : 0;
    }
}