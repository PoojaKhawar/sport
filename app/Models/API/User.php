<?php

namespace App\Models\API;

use App\Models\Admin\User as AdminUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\FileSystem;
use App\Libraries\General;
use Illuminate\Support\Str;
use App\Models\Admin\Setting;

class User extends AdminUsers
{
	protected $hidden = ['password'];

	/**
    * Get resize images
    *
    * @return array
    */
    public function getImageAttribute($value)
    {
        return $value ? FileSystem::getAllSizeImages($value) : null;
    }


    public static function getPermissions($userId)
    {
        $permissions = UsersPermissions::where('user_id', $userId)->get();
        $return = [];
        foreach($permissions as $k => $p)
        {
            $return[$p->permission] = $p->status ? true : false;
        }
        return $return;
    }

    public static function handlePermissions($userId, $permissions)
    {
        UsersPermissions::where('user_id', $userId)->delete();
        foreach($permissions as $k => $p)
        {
            $usersPermissions = new UsersPermissions();
            $usersPermissions->user_id = $userId;
            $usersPermissions->status = $p;
            $usersPermissions->permission = $k;
            $usersPermissions->created = date('Y-m-d H:i:s');
            $usersPermissions->save();
        }
    }

     /**
    * To insert
    * @param $where
    * @param $orderBy
    */
    public static function createApi($data)
    {
        $user = new User();

        foreach($data as $k => $v)
        {
            $user->{$k} = $v;
        }

        $user->status = 1;
        // In case of timestamp true from setting table, Disabled default timestamps will be false
        if(Setting::get('timestamps'))
        {
            $user->created_at = date('Y-m-d H:i:s');
            $user->updated_at = date('Y-m-d H:i:s');
        }

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
}