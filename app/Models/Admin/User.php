<?php

namespace App\Models\Admin;

use App\Models\AppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\FileSystem;
use Illuminate\Support\Str;
use App\Libraries\General;
use App\Models\Admin\Setting;

class User extends AppModel
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    /**** ONLY USE FOR MAIN TALBLES NO NEED TO USE FOR RELATION TABLES OR DROPDOWNS OR SMALL SECTIONS ***/
    use SoftDeletes;

    /**
    * Get resize images
    *
    * @return array
    */
    public function getResizeImagesAttribute()
    {
        return $this->image ? FileSystem::getAllSizeImages($this->image) : null;
    }

    /**
    * Get resize cover images
    *
    * @return array
    */
    public function getResizeCoverAttribute()
    {
        return $this->cover_image ? FileSystem::getAllSizeImages($this->cover_image) : null;
    }
    
    /**
    * Name getter
    */
    function getNameAttribute()
    {
    	return $this->first_name . ' ' . $this->last_name;
    }
    
    /**
    * Password setter
    * @param $value
    */
    function setPasswordAttribute($value)
    {
        return $this->attributes['password'] = Hash::make($value);
    }
    
    /**
    * To search and get pagination listing
    * @param Request $request
    * @param $limit
    */

    public static function getListing(Request $request, $where = [], $limit = null)
    {
    	$orderBy = $request->get('sort') ? $request->get('sort') : 'users.id';
    	$direction = $request->get('direction') ? $request->get('direction') : 'desc';
    	$page = $request->get('page') ? $request->get('page') : 1;
    	$limit = $limit ? $limit : self::$paginationLimit;
    	$offset = ($page - 1) * $limit;
    	

    	$listing = User::select([
    		'users.*'
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
    public static function getAll($select = [], $where = [], $orderBy = 'users.id desc', $limit = null)
    {
    	$listing = User::orderByRaw($orderBy);

    	if(!empty($select))
    	{
    		$listing->select($select);
    	}
    	else
    	{
    		$listing->select([
    			'users.*',
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
    	$record = User::select([
            'users.*'
        ])
        ->find($id);
        
	    return $record;
    }

    /**
    * To get single row by conditions
    * @param $where
    * @param $orderBy
    */
    public static function getRow($where = [], $orderBy = 'users.id desc')
    {
    	$record = User::orderByRaw($orderBy);

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
    	$user = new User();

    	foreach($data as $k => $v)
    	{
    		$user->{$k} = $v;
    	}

        $user->status = 1;
        $user->created_by = AdminAuth::getLoginId();

    	if($user->save())
	    {
            if(isset($data['first_name']) && $data['first_name'])
            {
                $user->username = Str::slug($user->first_name.' '.$user->last_name,'.') . '.' . strtolower(General::encode($user->id));
                $user->save();
            }
	    	return $user;
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
    	$user = User::find($id);
        
    	foreach($data as $k => $v)
    	{
    		$user->{$k} = $v;
    	}

	    if($user->save())
	    {
	    	return $user;
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
    		return User::whereIn('users.id', $ids)
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
    	$user = User::find($id);
    	return $user->delete();
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
    		return User::whereIn('users.id', $ids)
		    		->delete();
	    }
	    else
	    {
	    	return null;
	    }

    }

    /**
    * To get count
    * @param $id
    */
    public static function getCount($where = [])
    {
        $record = User::select([
            DB::raw('COUNT(users.id) as count'),
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

        return $record ? $record->count : '';
    }

    /**
    * To get all
    */
    public static function getExportAll($select = [], $where = [], $limit = null)
    {
        $listing = User::orderBy('users.id', 'DESC');

        if(!empty($select))
        {
            $listing->select($select);
        }
        else
        {
            $listing->select([
                'users.*'
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

}