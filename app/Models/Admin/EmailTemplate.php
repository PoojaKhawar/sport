<?php

namespace App\Models\Admin;

use App\Models\AppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Setting;


class EmailTemplate extends AppModel
{
    protected $table = 'email_templates';
    protected $primaryKey = 'id';
    
    /**
    * To search and get pagination listing
    * @param Request $request
    * @param $limit
    */

    public static function getListing(Request $request, $where = [], $limit = null)
    {
        $orderBy = $request->get('sort') ? $request->get('sort') : 'email_templates.id';
        $direction = $request->get('direction') ? $request->get('direction') : 'asc';
        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = $limit ? $limit : self::$paginationLimit;
        $offset = ($page - 1) * $limit;
        
        $listing = EmailTemplate::select([
            'email_templates.*'
        ])
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
    public static function getAll($select = [], $where = [], $orderBy = 'email_templates.title asc', $limit = null)
    {
    	$listing = EmailTemplate::orderByRaw($orderBy);

    	if(!empty($select))
    	{
    		$listing->select($select);
    	}
    	else
    	{
    		$listing->select([
    			'email_templates.*'
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

        $listing->orderByRaw($orderBy);

	    $listing = $listing->get();

	    return $listing;
    }

    /**
    * To get single record by id
    * @param $id
    */
    public static function get($id)
    {
    	$record = EmailTemplate::where('id', $id)
            ->first();

	    return $record;
    }

    /**
    * To get single row by conditions
    * @param $where
    * @param $orderBy
    */
    public static function getRow($where = [], $orderBy = 'email_templates.id desc')
    {
    	$record = EmailTemplate::orderByRaw($orderBy);

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
    * To update
    * @param $id
    * @param $where
    */
    public static function modify($id, $data)
    {
    	$emailTemplate = EmailTemplate::find($id);
        
    	foreach($data as $k => $v)
    	{
    		$emailTemplate->{$k} = $v;
    	}

    	if($emailTemplate->save())
	    {
	    	return $emailTemplate;
	    }
	    else
	    {
	    	return null;
	    }
    }
}