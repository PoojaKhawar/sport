<?php
namespace App\Libraries;

use App\Models\Admin\Settings;
use Facebook\Facebook as FB;
use Facebook\Authentication\AccessToken; 
use Facebook\Exceptions\FacebookResponseException; 
use Facebook\Exceptions\FacebookSDKException; 
use Facebook\Helpers\FacebookJavaScriptHelper; 
use Facebook\Helpers\FacebookRedirectLoginHelper; 
use Illuminate\Http\Request;

class Facebook
{
	/** 
	* @var FB 
	*/ 
    private $fb; 

    /** 
	* @var FacebookRedirectLoginHelper|FacebookJavaScriptHelper 
	*/ 
    private $helper; 

	public static function connect()
	{
		if(!session_id())
		{
		    session_start();
		}
		
		return new FB([
			'app_id' => Settings::get('facebook_app_id'),
			'app_secret' => Settings::get('facebook_app_secret'),
			'default_graph_version' => Settings::get('facebook_api_version'),
		]);
	}

	public static function verifyLogin($accessToken)
	{
		$fb = self::connect();
		try
		{  
			$response = $fb->get('/me', $accessToken);
		}
		catch(\Facebook\Exceptions\FacebookResponseException $e)
		{
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		}
		catch(\Facebook\Exceptions\FacebookSDKException $e)
		{
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		$me = $response->getGraphUser();
		return $me && $me->getId() ? $me->getId() : null;
	}

	/** 
	* Generate Facebook login url for web 
	* 
	* @return  string 
	*/ 
    public static function loginUrl()
    {
    	$fb = self::connect();
    	// pr($fb);die;
        $fbRedireect = $fb->getRedirectLoginHelper();

        // Get login url 
        $loginUrl = $fbRedireect->getLoginUrl(
        	Settings::get('facebook_redirect_uri'),
        	explode(',',Settings::get('facebook_scopes'))
        );

       return $loginUrl;
    }

    /** 
	* Check whether the user is logged in. 
	* by access token 
	* 
	* @return mixed|boolean 
	*/ 
    public static function is_authenticated($request)
    {
        $access_token = self::authenticate($request); 
        if(isset($access_token))
        {
            return $access_token; 
        }
        return false; 
    }

    /** 
	* Get a new access token from Facebook 
	* 
	* @return array|AccessToken|null|object|void 
	*/ 
    private static function authenticate($request)
    {
    	$fb = self::connect();
       
        $fbRedireect = $fb->getRedirectLoginHelper();

        $access_token = self::get_access_token($request); 
        if($access_token && self::get_expire_time($request) > (time() + 30) || $access_token && !self::get_expire_time($request))
        {	
            $fb->setDefaultAccessToken($access_token); 
            return $access_token; 
        }

        // If we did not have a stored access token or if it has expired, try get a new access token 
        if(!$access_token)
        {
            try
            { 
                $access_token = $fbRedireect->getAccessToken(); 
            }
            catch(FacebookSDKException $e)
            { 
                self::logError($e->getCode(), $e->getMessage()); 
                return null; 
            } 
            
            // If we got a session we need to exchange it for a long lived session. 
            if(isset($access_token))
            { 
                $access_token = self::long_lived_token($access_token); 
                self::set_expire_time($access_token->getExpiresAt(),$request); 
                self::set_access_token($access_token,$request); 
                $fb->setDefaultAccessToken($access_token); 
                return $access_token; 
            } 
        }
        
        // Collect errors if any when using web redirect based login        
        if($fbRedireect->getError())
        { 
            // Collect error data 
            $error = array( 
                'error'             => $fbRedireect->getError(), 
                'error_code'        => $fbRedireect->getErrorCode(), 
                'error_reason'      => $fbRedireect->getErrorReason(), 
                'error_description' => $fbRedireect->getErrorDescription() 
            ); 
            return $error; 
        }

        return $access_token; 
    }

    /** 
	* Get stored access token 
	* 
	* @return mixed 
	*/ 
    private static function get_access_token($request)
    {
        return $request->session()->get('fb_access_token'); 
    }

	/** 
	* @return mixed 
	*/ 
    private static function get_expire_time($request)
    { 
        return $request->session()->get('fb_expire'); 
    }

    /** 
	* Exchange short lived token for a long lived token 
	* 
	* @param AccessToken $access_token 
	* 
	* @return AccessToken|null 
	*/ 
    private static function long_lived_token(AccessToken $access_token)
    {
    	$fb = self::connect();
        if(!$access_token->isLongLived())
        { 
            $oauth2_client = $fb->getOAuth2Client(); 
            try
            { 
                return $oauth2_client->getLongLivedAccessToken($access_token); 
            }
            catch(FacebookSDKException $e)
            { 
                self::logError($e->getCode(), $e->getMessage()); 
                return null; 
            } 
        }
        return $access_token; 
    }

	/** 
	* Store access token 
	* 
	* @param AccessToken $access_token 
	*/ 
    private static function set_access_token(AccessToken $access_token,$request)
    {
    	$request->session()->put('fb_access_token', $access_token->getValue());
    }

	/** 
	* @param DateTime $time 
	*/ 
    private static function set_expire_time($time = null,$request)
    {
        if($time)
        {
        	$request->session()->put('fb_expire', $time->getTimestamp());
        } 
    }

	/** 
	* @param $code 
	* @param $message 
	* 
	* @return array 
	*/ 
    private static function logError($code, $message)
    { 
        return ['error' => $code, 'message' => $message]; 
    }

	/** 
	* Do Graph request 
	* 
	* @param       $method 
	* @param       $endpoint 
	* @param array $params 
	* @param null  $access_token 
	* 
	* @return array 
	*/ 
    public static function request($method, $endpoint, $params = [], $access_token = null)
    {
    	$fb = self::connect();
		$response = $fb->get('/me?fields=id,first_name,last_name,email,link,gender,picture', $access_token);
		if($response)
		{
			$response = $response->getDecodedBody();
			if($response)
			{
				return $response;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}		
    } 
}