<?php
/**
 * Setting Class
 *
 * @package    SettingsController
 * @copyright  2023
 * @author     Irfan Ahmad <irfan.ahmad@globiztechnology.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Libraries\General;

use App\Models\Admin\Setting;
use App\Models\Admin\AdminAuth;

class SettingsController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function index(Request $request)
    {
		if(!AdminAuth::isAdmin())
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	if($request->isMethod('post'))
    	{
    		$data = $request->toArray();
    		
    		$validator = Validator::make(
	            $request->toArray(),
	            [
	                'company_name' => 'required',
	                'company_address' => 'required',
	                'admin_second_auth_factor' => 'required',
	                'currency_code' => 'required',
	                'currency_symbol' => 'required',
	                'admin_notification_email' => [
	                	'required',
	                	'email'
	                ]
	            ]
	        );

	        if(!$validator->fails())
	        {
	        	$logo = null;
	        	if(isset($data['logo']) && $data['logo']) 
	        	{
	        		$logo = $data['logo'];
	        	}
	        	
	        	$favicon = null;
	        	if(isset($data['favicon']) && $data['favicon']) 
	        	{
	        		$favicon = $data['favicon'];
	        	}

	        	unset($data['logo']);
	        	unset($data['favicon']);
	        	unset($data['_token']);

	        	foreach ($data as $key => $value)
	        	{
	        		Setting::put($key, $value);
	        	}

	        	if($logo)
	        	{
	        		Setting::put('logo', $logo);
	        	}

	        	if($favicon)
	        	{
	        		Setting::put('favicon', $favicon);
	        	}
	        	
        		$request->session()->flash('success', 'Settings updated successfully.');
        		return redirect()->route('admin.settings');
			}
			else
			{
				$request->session()->flash('error', 'Please provide valid inputs.');
			    return redirect()->back()->withErrors($validator)->withInput();
			}
		}

		return view("admin/settings/index", []);
	}

	function recaptcha(Request $request)
    {
		if(!AdminAuth::isAdmin())
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	if($request->isMethod('post'))
    	{
    		$data = $request->toArray();
    		$validator = Validator::make(
	            $request->toArray(),
	            [
	                'admin_recaptcha' => 'required',
	                'recaptcha_key' => 'required',
	                'recaptcha_secret' => 'required'
	            ]
	        );

	        if(!$validator->fails())
	        {
	        	unset($data['_token']);
	        	foreach ($data as $key => $value) {
	        		Setting::put($key, $value);
	        	}
	
        		$request->session()->flash('success', 'Recaptcha settings updated.');
        		return redirect()->route('admin.settings');
			}
			else
			{
				$request->session()->flash('error', 'Please provide valid inputs.');
			    return redirect()->back()->withErrors($validator)->withInput();
			}
		}
		else
		{
			abort(404);
		}
	}

	function dateTimeFormats(Request $request)
	{
		if(!AdminAuth::isAdmin())
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

		if($request->isMethod('post'))
    	{
    		$data = $request->toArray();
    		$validator = Validator::make(
	            $request->toArray(),
	            [
	                'date_format' => 'required',
	                'time_format' => 'required'
	            ]
	        );

	        if(!$validator->fails())
	        {
	        	unset($data['_token']);
	        	
	        	foreach ($data as $key => $value) {
	        		Setting::put($key, $value);
	        	}

	        	$request->session()->flash('success', 'Date and time format updated.');
        		return redirect()->route('admin.settings');
			}
			else
			{
				$request->session()->flash('error', 'Please provide valid inputs.');
			    return redirect()->back()->withErrors($validator)->withInput();
			}
		}
		else
		{
			abort(404);
		}
	}

	function email(Request $request)
    {
		if(!AdminAuth::isAdmin())
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	if($request->isMethod('post'))
    	{
    		$data = $request->toArray();
    		$validator = Validator::make(
	            $request->toArray(),
	            [
	                //'email_method' => 'required',
	                'from_email' => 'required',
	                'smtp_host' => 'required',
	                'smtp_encryption' => 'required',
	                'smtp_port' => 'required',
	                'smtp_username' => 'required',
	                'smtp_email' => 'required',
	                'sendgrid_email' => 'required',
	                'sendgrid_api_key' => 'required'
	            ]
	        );

	        if(!$validator->fails())
	        {
	        	unset($data['_token']);
	        	
	        	$password = null;
	        	if(isset($data['smtp_password']) && $data['smtp_password'])
	        	{
	        		$password = $data['smtp_password'];
	        	}
	        	unset($data['smtp_password']);

	        	foreach($data as $key => $value) {
	        		Setting::put($key, $value);
	        	}

	        	if(isset($password) && $password)
	        	{
	        		//$password = General::encrypt($password);
	        		Setting::put('smtp_password', $password);
	        	}
	
        		$request->session()->flash('success', 'Password updated successfully.');
        		return redirect()->route('admin.settings');
			}
			else
			{
				$request->session()->flash('error', 'Please provide valid inputs.');
			    return redirect()->back()->withErrors($validator)->withInput();
			}
		}
		else
		{
			abort(404);
		}
	}
}
