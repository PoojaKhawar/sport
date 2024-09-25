<?php

namespace App\Models\User;

use App\Models\AppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use App\Models\API\UserToken;
use App\Models\Admin\Setting;

use App\Libraries\FileSystem;
use App\Libraries\General;

class UserAuth extends User
{

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;

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
    * To get single row by conditions
    * @param $where
    * @param $orderBy
    */
    public static function getRow($where = [], $orderBy = 'users.id desc')
    {
        $record = UserAuth::orderByRaw($orderBy);

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
    * To make admin login
    * @param Request $request
    */
    public static function attemptLogin(Request $request)
    {
    	//Get user
    	$user = UserAuth::where('email', 'LIKE', $request->get('email'))
    		//->where('status', 1)
    		->first();
        if($user)
        {
            if(Hash::check( $request->get('password'), $user->password))
            {
            	return $user;
            }
        }

        return null;
    }

    public static function makeLoginSession(Request $request, $user)
    {
        //Make login
        if($user)
        {
            Auth::guard('user')->login($user);
            if(Auth::guard('user')->check())
            {
                $request->session()->regenerate();
                $sessionId = $request->session()->getId();
                $user->session_id = $sessionId;
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();
                return $user;
            }
        }
        return null;
    }

    public static function isLogin()
    {
        return Auth::guard('user')->check();
    }

    public static function isUser()
    {
        return Auth::guard('user')->user()->is_admin;
    }

    public static function getLoginId()
    {
        $user = Auth::guard('user')->user();
        return $user ? $user->id : null;
    }

    public static function getLoginUserName()
    {
        $user = Auth::guard('user')->user();
        return $user ? $user->first_name . ' ' . $user->last_name : null;
    }

    public static function getLoginUserType()
    {
        $user = Auth::guard('user')->user();
        return $user ? $user->user_type : null;
    }

    public static function getLoginUserImage()
    {
        $user = Auth::guard('user')->user();
        return $user && $user->image ? $user->image : null;
    }

    public static function getLoginUser()
    {
        $user = Auth::guard('user')->user();
        return $user ? $user : null;
    }

    public static function logout()
    {
        return Auth::guard('user')->logout();
        UserToken::where('user_id', $id)->where('device_type', 'web')->delete();
    }

    public static function getToken()
    {
        $id = UserAuth::getLoginId();
        $exist = UserToken::where('user_id', $id)->where('device_type', 'web')->where('expire_on', '>', date('Y-m-d H:i:s'))->first();
        return $exist ? $exist->token : null;
    }

    public static function makeWebToken()
    {
        $id = UserAuth::getLoginId();

        if($id)
        {
            $exist = UserToken::where('user_id', $id)->where('device_type', 'web')->where('expire_on', '>', date('Y-m-d H:i:s'))->first();
            if(!$exist)
            {
                UserToken::where('user_id', $id)->where('device_type', 'web')->delete();
                $expireMins = Setting::get('session_web_expires_in_minutes');
                $token = General::hash(64);

                $token = UserToken::create([
                    'user_id' => $id,
                    'token' => $token,
                    'device_id' => null,
                    'device_type' => 'web',
                    'device_name' => $_SERVER['HTTP_USER_AGENT'],
                    'fcm_token' => null,
                    'expire_on' => date('Y-m-d H:i:s', strtotime("+{$expireMins} minutes"))
                ]);
            }
        }
    }

    public static function updateWebToken($userId)
    {
        if($userId)
        {
            $expireMins = 30;
            
            $userToken = UserToken::where('user_id', $userId)
                ->where('device_type', 'web')
                ->where('expire_on', '>', date('Y-m-d H:i:s'))
                ->first();
            $userToken->expire_on = date('Y-m-d H:i:s', strtotime("+{$expireMins} minutes +15 seconds"));
            return $userToken->save();
        }
        else
        {
            return null;
        }
    }
}