<?php

/**
 * User Auth Class
 *
 * @package    AuthController
 * @copyright  2023
 * @author     Irfan Ahmad <irfan.ahmad@globiztechnology.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */


namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User\UserAuth;
use App\Models\User\User;
use App\Models\Admin\Setting;
use App\Models\Frontend\UserLog;
use App\Libraries\General;
use Session;

class AuthController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

	function login(Request $request)
    {
    	if(UserAuth::isLogin())
    	{
            return redirect()->route('user.profile');
    	}

    	if($request->isMethod('post'))
    	{
	    	if($request->has(['email', 'password']))
	    	{
	    		$validator = Validator::make(
		            $request->toArray(),
		            [
		                'email' => 'required|email',
		                'password' => 'required'
		            ]
		        );

		        if(!$validator->fails())
		        {
		        	$data = $request->toArray();
		        	unset($data['_token']);

			    	// Make user login
			    	$user = UserAuth::attemptLogin($request);

			    	if($user)
			    	{
			    		if(!$user->token)
			    		{
			    			$user->token = General::hash(64);
			    			$user->save(); 
			    		}

			    		if($user->status == 0)
			    		{
			    			$request->session()->flash('error', 'Your account has been deactivated. Please contact the administrator.');
			    			return redirect()->back();
			    		}
			    		elseif(!$user->email_verified_at)
			    		{
			    			$otp = $user->email_otp ? $user->email_otp : General::randomNumber(6);
			    			$user->email_otp = $otp;
			    			$codes = [
					    	    '{first_name}' => $user->first_name,
					    	    '{last_name}' => $user->last_name,
					    	    '{otp}' => $otp,
					    	    '{company_name}' => Setting::get('company_name')
					    	];
					    	General::sendTemplateEmail(
					    	    $user->email, 
					    	    'registration-otp',
					    	    $codes
					    	);

					    	$user->save();

					    	$request->session()->flash('success', 'We have sent an otp on your email. Kindly check it.');
			    			return redirect()->route('user.emailVerification', ['token' => $user->token]);
			    		}
			    		elseif(!$user->phone_verified_at)
			    		{
			    			$otp = $user->otp ? $user->otp : General::randomNumber(6);
			    			$user->otp = $otp;
			    			$codes = [
					    	    '{first_name}' => $user->first_name,
					    	    '{last_name}' => $user->last_name,
					    	    '{one_time_password}' => $otp,
					    	    '{company_name}' => Setting::get('company_name')
					    	];
					    	General::sendTemplateEmail(
					    	    $user->email, 
					    	    'phone-verification-otp',
					    	    $codes
					    	);

					    	$user->save();

					    	$request->session()->flash('success', 'We have sent an otp on your email. Kindly check it.');
			    			return redirect()->route('user.phoneVerification', ['token' => $user->token]);
			    		}
			    		else
			    		{
			    			$makeLoginSession = UserAuth::makeLoginSession($request, $user);
			    			if($makeLoginSession)
			    			{
			    				if($request->get('redirectUrl'))
			    				{
			    					return redirect()->away(urldecode($request->get('redirectUrl')));
			    				}
			    				else if(isset($data['redirectUrl']) && $data['redirectUrl'])
			    				{
			    					return Redirect::to($data['redirectUrl']);
			    				}
			    				else
			    				{
			    					return redirect()->route('user.dashboard');
			    				}
			    			}
			    			else
			    			{
			    				$request->session()->flash('error', 'Could not be able to make login session. Please contact us.');
                    			return redirect()->back();
			    			}
			    		}		    		
			    	}
			    	else
			    	{
			    		$request->session()->flash('error', 'The email that you\'ve entered doesn\'t match any account');
			        	return redirect()->back();
			    	}
		        }
		        else
		        {
		        	$request->session()->flash('error', 'Please provide valid inputs.');
			    	return redirect()->back()->withErrors($validator)->withInput();
		        }
		    }
		}

		return view("user/auth/login");
	}

    function forgotPassword(Request $request)
    {
    	if(UserAuth::isLogin())
    	{
            return redirect()->route('user.profile');
    	}

    	if($request->isMethod('post'))
    	{
	    	if($request->get('email'))
	    	{
	    		$email = $request->get('email');
	    		$user = User::getRow([
	    			'email' => $email,
	    			'status' => 1
	    		]);

	    		if($user)
	    		{
	    			$user->token = General::hash();
	    			if($user->save())
	    			{
	    				$codes = [
	        				'{first_name}' => $user->first_name,
	        				'{last_name}' => $user->last_name,
	        				'{email}' => $user->email,
	        				'{recovery_link}' => url()->route('user.recoverPassword', ['token' => $user->token])
	        			];

	        			General::sendTemplateEmail(
	        				$user->email, 
	        				'forgot-password',
	        				$codes
	        			);

				    	$request->session()->flash('success', 'We have sent you a recovery link on your email. Please follow the email.');
		    			return redirect()->route('user.forgotPassword');
	    			}
	    			else
	    			{
	    				$request->session()->flash('error', 'Something went wrong. Please try again.');
			    		return redirect()->route('user.forgotPassword');
	    			}
	    		}
	    		else
	    		{
	    			$request->session()->flash('error', 'Email is not registered with us.');
			    	return redirect()->route('user.forgotPassword');
	    		}
	    	}
	    	else
	    	{
		    	$request->session()->flash('error', 'Please enter your registered email to recover your password.');
    			return redirect()->route('user.forgotPassword');
	    	}
	    }

    	return view("user/auth/forgotPassword");
    }

    function recoverPassword(Request $request, $token)
    {
    	if(UserAuth::isLogin())
    	{
            return redirect()->route('user.profile');
    	}
        
    	$user = User::getRow([
			'token' => $token,
			'status' => 1
		]);
		
    	if($user)
    	{
	    	if($request->isMethod('post'))
	    	{
	    		$data = $request->toArray();
	    		unset($data['_token']);

	            $validator = Validator::make(
		            $request->toArray(),
		            [
		                'new_password' => [
		                	'required',
						    'min:8'
		                ],
		                'confirm_password' => [
		                	'required',
						    'min:8'
		                ]
		            ]
		        );

		        if(!$validator->fails())
		        {
		        	if(Hash::check($data['new_password'], $user->password))
                    {
                    	$request->session()->flash('error', 'New Password cannot be same as your current password. Please choose a different password.');
                        return redirect()->back()->withErrors($validator)->withInput();
	        		}
                    else
                    {
                        if($data['new_password'] && $data['confirm_password'] && $data['new_password'] == $data['confirm_password'])
		        		{
		        			$user->password = $data['new_password'];
		        			$user->token = null;
		        			if($user->save())
		        			{
		        				return redirect()->route('user.signup.success', ['message' => 'Your password has been updated successfully.']);
		        			}
		        			else
		        			{
		        				$request->session()->flash('error', 'New password could not be updated.');
			    				return redirect()->back()->withErrors($validator)->withInput();				
		        			}
		        		}
		        		else
		        		{
		        			$request->session()->flash('error', 'Your new password and confirm password does not match.');
			    			return redirect()->back()->withErrors($validator)->withInput();		
		        		}
                    }
			    }
			    else
			    {
			    	$request->session()->flash('error', current( current( $validator->errors()->getMessages() ) ));
			    	return redirect()->back()->withErrors($validator)->withInput();
			    }
			}
			return view("user/auth/recoverPassword");
		}
		else
		{
			abort(404);
		}
    }

    function emailVerification(Request $request, $token)
    {
    	$user = User::getRow([
            'token like ?' => [$token],
            'email_verified_at is null',
            'status' => 1
        ]);

		if($user)
		{
			if($request->isMethod('post'))
		    {
		    	$data = $request->toArray();
		    	unset($data['_token']);

		    	$otp = $data['otp1'].$data['otp2'].$data['otp3'].$data['otp4'].$data['otp5'].$data['otp6'];

    			if($user->email_otp == $otp)
    			{
    				$user->email_otp = null;
    				$user->token = null;
    				$user->email_verified_at = date('Y-m-d H:i:s');
    				
    				if($user->save())
    				{
    					$user = UserAuth::find($user->id);
						
						if($user)
						{
					    	return redirect()->route('user.signup.success', ['message' => 'Hooray! Your email verification is completed.']);
					    }
					    else
					    {
					    	return redirect()->route('user.signup.error', ['message' => 'Something went wrong. Please try again.']);
					    }

    					/*$user = UserAuth::makeLoginSession($request, $user);
			        	
			        	if($user)
			        	{
			        		return redirect()->route('user.profile');
			        	}
			        	else
			        	{
			        		$request->session()->flash('error', 'Session could not be establised. Please try again.');
			        		return redirect()->route('user.login');
			        	}*/
    				}
    				else
    				{
    					$request->session()->flash('error', 'Something went wrong. Please try again.');
    					return redirect()->route('user.login');
    				}
    			}
    			else
    			{
    				$request->session()->flash('error', 'Your OTP is incorrect.');
		    		return redirect()->back()->withInput();
    			}
		    }

			return view("user/auth/emailVerification", ['token' => $token]);
		}
    	else
    	{
    		return redirect()->route('user.signup.error', ['message' => 'Something went wrong. Please try again.']);
    	}
    }

    function resendEmailOtp(Request $request)
    {
    	if($request->ajax())
    	{
	    	$user = UserAuth::getRow([
				'token LIKE ?' => [$request->get('token')],
				'status' => 1
			]);

	    	if($user)
	    	{
				$otp = $user->email_otp ? $user->email_otp : General::randomNumber(6);
				$user->email_otp = $otp;

				$codes = [
		    	    '{first_name}' => $user->first_name,
		    	    '{last_name}' => $user->last_name,
		    	    '{otp}' => $otp,
		    	    '{company_name}' => Setting::get('company_name')
		    	];
		    	
		    	General::sendTemplateEmail(
		    	    $user->email, 
		    	    'registration-otp',
		    	    $codes
		    	);

		    	$user->save();
				
				return Response()->json([
					'status' => 'success',
					'message' => "OTP sent."
				]);
			}
			else
			{
				return Response()->json([
					'status' => 'error',
					'message' => "User not found."
				]);	
			}
    	}
    	else
    	{
    		return Response()->json([
    			'status' => 'error',
    			'message' => "Invalid request"
    		]);
    	}
    }

    function phoneVerification(Request $request, $token)
    {
    	$user = UserAuth::getRow([
			'token LIKE ?' => [$token],
			'status' => 1
		]);

		if($user)
		{
			if($request->isMethod('post'))
		    {
		    	$data = $request->toArray();
		    	unset($data['_token']);

		    	$otp = $data['otp1'].$data['otp2'].$data['otp3'].$data['otp4'].$data['otp5'].$data['otp6'];

    			if($user->otp == $otp)
    			{
    				$user->otp = null;
    				$user->token = null;
    				$user->phone_verified_at = date('Y-m-d H:i:s');
    				
    				if($user->save())
    				{
    					$user = UserAuth::find($user->id);
						
						if($user)
						{
					    	return redirect()->route('user.signup.success', ['message' => 'Hooray! Your phone verification is completed.']);
					    }
					    else
					    {
					    	return redirect()->route('user.signup.error', ['message' => 'Something went wrong. Please try again.']);
					    }

    					$user = UserAuth::makeLoginSession($request, $user);
			        	
			        	/*if($user)
			        	{
			        		return redirect()->route('user.profile');
			        	}
			        	else
			        	{
			        		$request->session()->flash('error', 'Session could not be establised. Please try again.');
			        		return redirect()->route('user.login');
			        	}*/
    				}
    				else
    				{
    					$request->session()->flash('error', 'Something went wrong. Please try again.');
    					return redirect()->route('user.login');
    				}
    			}
    			else
    			{
    				$request->session()->flash('error', 'Your OTP is incorrect.');
		    		return redirect()->back()->withInput();
    			}
		    }

			return view("user/auth/phoneVerification", ['token' => $token]);
		}
    	else
    	{
    		return redirect()->route('user.signup.error', ['message' => 'Something went wrong. Please try again.']);
    	}
    }

    function resendOtp(Request $request)
    {
    	if($request->ajax())
    	{
	    	$user = UserAuth::getRow([
				'token LIKE ?' => [$request->get('token')],
				'status' => 1
			]);
	    	if($user)
	    	{
				$otp = $user->otp ? $user->otp : General::randomNumber(6);
				$user->otp = $otp;
				
				$codes = [
		    	    '{first_name}' => $user->first_name,
		    	    '{last_name}' => $user->last_name,
		    	    '{one_time_password}' => $otp,
		    	    '{company_name}' => Setting::get('company_name')
		    	];
		    	
		    	General::sendTemplateEmail(
		    	    $user->email, 
		    	    'phone-verification-otp',
		    	    $codes
		    	);

		    	$user->save();
				
				return Response()->json([
					'status' => 'success',
					'message' => "OTP sent."
				]);
			}
			else
			{
				return Response()->json([
					'status' => 'error',
					'message' => "User not found."
				]);	
			}
    	}
    	else
    	{
    		return Response()->json([
    			'status' => 'error',
    			'message' => "Invalid request"
    		]);
    	}
    }

    function logout(Request $request)
    {
    	$userId = UserAuth::getLoginId();
    	
    	if($userId)
    	{
	    	UserAuth::logout();
	    	return redirect()->route('user.login');	
    	}
    }
}
