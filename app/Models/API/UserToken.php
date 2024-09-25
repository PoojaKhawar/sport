<?php
namespace App\Models\API;

use Illuminate\Http\Request;
use App\Models\AppModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Libraries\FileSystem;
use App\Models\Admin\Setting;

class UserToken extends AppModel
{

    protected $table = 'user_tokens';
    protected $primaryKey = 'id';

    /**
    * UserToken -> Users belongsTO relation
    * 
    * @return Users
    */
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id', 'id');
    }

    /**
    * To get single record by id
    * @param $id
    */
    public static function get($token)
    {
    	$record = UserToken::where('token', $token)
            ->where('expire_on', '>', date('Y-m-d H:i:s'))
            ->with(['user'])
            ->first();

	    return $record;
    }

    /**
    * To get single record by id
    * @param $id
    */
    public static function getUserId($token)
    {
        return UserToken::where('token', $token)
            ->where('expire_on', '>', date('Y-m-d H:i:s'))
            ->pluck('user_id')
            ->first();
    }

    /**
    * To get all records
    * @param $where
    * @param $orderBy
    * @param $limit
    */
    public static function getAll($select = [], $where = [], $orderBy = 'user_tokens.id desc', $limit = null)
    {
        $listing = UserToken::orderByRaw($orderBy);

        if(!empty($select))
        {
            $listing->select($select);
        }
        else
        {
            $listing->select([
                'user_tokens.*'
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
    * To insert
    * @param $where
    * @param $orderBy
    */
    public static function create($data)
    {
    	$token = new UserToken();

    	foreach($data as $k => $v)
    	{
    		$token->{$k} = $v;
    	}

    	// In case of timestamp true from setting table, Disabled default timestamps will be false
        if(Setting::get('timestamps'))
        {
            $token->created_at = date('Y-m-d H:i:s');
            $token->updated_at = date('Y-m-d H:i:s');
        }

	    if($token->save())
	    {
	    	return $token;
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
    	$token = UserToken::find($id);
    	foreach($data as $k => $v)
    	{
    		$token->{$k} = $v;
    	}

    	// In case of timestamp true from setting table, Disabled default timestamps will be false
        if(Setting::get('timestamps'))
        {
            $token->updated_at = date('Y-m-d H:i:s');
        }

	    if($token->save())
	    {
	    	return $token;
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
    	$token = UserToken::find($id);
    	return $token->delete();
    }
}