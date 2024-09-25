<?php

namespace App\Models\Admin;

use App\Models\AppModel;
use Illuminate\Http\Request;
use App\Models\Admin\Setting;

class EmailLog extends AppModel
{
    protected $table = 'email_logs';
    protected $primaryKey = 'id';
    
    /**
    * To search and get pagination listing
    * @param Request $request
    * @param $limit
    */

    public static function getListing(Request $request, $where = [], $limit = null)
    {
        $orderBy = $request->get('sort') ? $request->get('sort') : 'email_logs.id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = $limit ? $limit : self::$paginationLimit;
        $offset = ($page - 1) * $limit;
        
        $listing = EmailLog::select([
            'email_logs.*'
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
    * To get single record by id
    * @param $id
    */
    public static function get($id)
    {
    	$record = EmailLog::where('id', $id)
            ->first();
            
	    return $record;
    }

    /**
    * To get single row by conditions
    * @param $where
    * @param $orderBy
    */
    public static function getRow($where = [], $orderBy = 'email_logs.id desc')
    {
    	$record = EmailLog::orderByRaw($orderBy);

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
    	$log = new EmailLog();

    	foreach($data as $k => $v)
    	{
    		$log->{$k} = $v;
    	}

	    if($log->save())
	    {
	    	return $log;
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
    	$log = EmailLog::find($id);
        
    	foreach($data as $k => $v)
    	{
    		$log->{$k} = $v;
    	}

    	if($log->save())
	    {
	    	return $log;
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
    	$log = EmailLog::find($id);
    	return $log->delete();
    }
}