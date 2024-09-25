<?php
namespace App\Libraries;

use App\Models\Admin\Settings;
use Google_Client;
use Google_Service_Analytics;
use Google_Service_Oauth2;
use Illuminate\Support\Facades\Http;

class GoogleLib
{
	public static function client()
	{
		$client = new Google_Client();
		$client->setClientId(Settings::get('google_client_id'));
		$client->setClientSecret(Settings::get('google_secret_key'));
		$client->setRedirectUri(Settings::get('google_redirect_uri'));
		$client->setDeveloperKey(Settings::get('google_api_key'));
		$client->setScopes(explode(',',Settings::get('google_scopes')));
		$client->setApprovalPrompt(Settings::get('google_approvel_prompt'));
		$client->setAccessType(Settings::get('google_access_type'));
		
		$oauth2  = new Google_Service_Oauth2($client);
		
		return ['client' => $client, 'oauth2' => $oauth2];
	}

	public static function verifyLogin($accessToken)
	{
		$response = Http::asForm()
			->get('https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $accessToken);
		return $response->successful() && $response->json() && isset($response->json()['id']) && $response->json()['id'] ? $response->json() : null;	
	}

	public static function getAddressCoordinates($address)
	{

		$key = Settings::get('google_api_key');
		$address = str_replace(" ", "+", $address);
		$response = Http::asForm()
			->get("https://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false&region=gb&key=" . $key);
		return $response->successful() && $response->json() ? $response->json() : null;
	}

	public static function loginURL() {

        $data = GoogleLib::client();

        return $data['client']->createAuthUrl();
    }
    
    public static function getAuthenticate($code) {

    	$data = GoogleLib::client();
    	$res = $data['client']->fetchAccessTokenWithAuthCode($code);
        return $res;
    }
    
    public static function getAccessToken() {

    	$data = GoogleLib::client();

        return $data['client']->getAccessToken();
    }
    
    public static function setAccessToken() {

    	$data = GoogleLib::client();

        return $data['client']->setAccessToken();
    }
    
    public static function revokeToken() {

        $data = GoogleLib::client();

        return $data['client']->revokeToken();
    }
    
    public static function getUserInfo($accessToken) {

    	$response = Http::withHeaders([
            'Authorization' => 'Bearer '.$accessToken,
        ])
		->get('https://www.googleapis.com/oauth2/v1/userinfo');

		return $response->successful() && $response->json() ? $response->json() : null;
    }
}