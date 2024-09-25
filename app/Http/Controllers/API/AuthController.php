<?php
/**
 * API Auth Class
 *
 * @package    AuthController
 * @copyright  2021 Globiz Technology Inc..
 * @author     Irfan Ahmad <irfan.ahmad@globiztechnology.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Admin\Setting;
use App\Models\API\User;
use App\Models\API\ApiAuth;
use App\Libraries\General;
use App\Libraries\Facebook;
use App\Libraries\Google;

class AuthController extends AppController
{
	function signup(Request $request)
	{
		$allowed = ['first_name', 'last_name','email', 'password', 'device_id', 'device_type', 'device_name', 'fcm_token', 'phonenumber'];
    	if($request->has($allowed))
    	{
    		$data = $request->toArray();
    		if(isset($data['phonenumber']) && $data['phonenumber'])
    		{
	    		$data['phonenumber'] = str_replace([' ', '(', ')', '-'], ['', '', '', ''], $data['phonenumber']);
	    		$data['phonenumber'] = is_numeric($data['phonenumber']) ? $data['phonenumber'] : null;
	    	}

    		$validator = Validator::make(
	            $data,
	            [
	            	'first_name' => 'required',
	            	'phonenumber' => [
				    	'required',
				    	Rule::unique('users')->whereNull('deleted_at'),
				    ],
				    'email' => [
				    	'required',
				    	'email',
				    	Rule::unique('users')->whereNull('deleted_at'),
				    ],
	                'password' => [
	                	'required',
					    'min:8',
	                ],
	                'device_type' => 'required',
	                'device_id' => Rule::requiredIf(function () use ($request) {
				        return $request->get('device_type') != 'web';
				    }),
				    'device_name' => Rule::requiredIf(function () use ($request) {
				        return $request->get('device_type') != 'web';
				    }),
				    'fcm_token' => Rule::requiredIf(function () use ($request) {
				        return $request->get('device_type') != 'web';
				    })
	            ]
	        );

	        if(!$validator->fails())
	        {
	        	$password = $request->get('password');
	        	$otp 	  = General::randomNumber(4);

	        	$user = [
	        		'first_name' 	=> $data['first_name'],
	        		'last_name' 	=> $data['last_name'],
	        		'email' 		=> $data['email'],
	        		'password' 		=> $password,
	        		'phonenumber' 	=> $data['phonenumber'],
	        		'email_otp' 	=> $otp,
	        		'token' 		=> General::hash(64)
	        	];

	        	if($user = User::createApi($user))
	        	{
        			$codes = [
        				'{first_name}' => $user->first_name,
        				'{last_name}' => $user->last_name,
        				'{email}' => $user->email,
        				'{otp}' 	=> $otp,
        			];

        			General::sendTemplateEmail(
        				$user->email,
        				'registration-otp',
        				$codes
        			);

        			if(Setting::get('direct_login_after_registration'))
        			{
        				$user = ApiAuth::makeLoginSession($request, $user);
        				if($user)
        				{
        					// unset($user->email_otp);
        					return Response()->json([
						    	'status' => true,
						    	'message' => 'Registration successfully!',
						    	'user' => $user
						    ]);
        				}
        				else
        				{
        					return Response()->json([
						    	'status' => false,
						    	'message' => 'Unable to register new user. Please try again.'
						    ], 400);
        				}
        			}
        			else
        			{
        				// unset($user->email_otp);
        				return Response()->json([
					    	'status' => true,
					    	'message' => 'Registration successfully!',
					    	'user'    => $user,
					    ]);
        			}
	        	}
	        	else
	        	{
	        		return Response()->json([
				    	'status' => false,
				    	'message' => 'Unable to register new user. Please try again.'
				    ], 400);
	        	}
		    }
		    else
		    {
		    	return Response()->json([
			    	'status' => false,
			    	'message' => current( current( $validator->errors()->getMessages() ) )
			    ], 400);
		    }
	    }
	    else
	    {
	    	return Response()->json([
		    	'status' => false,
		    	'message' => 'Some of inputs are invalid in request.',
		    ], 400);
	    }
	}

	// Login
	function login(Request $request)
	{
		$allowed = ['email', 'password'];
		if($request->has($allowed))
		{
			$validator = Validator::make(
				$request->toArray(),
				[
					'email' => 'required|email',
					'password' => 'required',
					'device_type' => 'required',
					'device_id' => Rule::requiredIf(function () use ($request) {
						return $request->get('device_type') != 'web';
					}),
					'device_name' => Rule::requiredIf(function () use ($request) {
						return $request->get('device_type') != 'web';
					}),
					'fcm_token' => Rule::requiredIf(function () use ($request) {
						return $request->get('device_type') != 'web';
					}),
				]
			);

			if(!$validator->fails())
			{
				//Validate recaptcha and throw error.
				if(Setting::get('client_recaptcha'))
				{
					if(!$request->get('g-recaptcha-response') || !General::validateReCaptcha($request->get('g-recaptcha-response')))
					{
						$request->session()->flash('error', 'Captcha does not match. Please try again.');
						return redirect()->back()->withInput();
					}
				}
				
				// Make user login
				$user = ApiAuth::attemptLogin($request);
                
				if($user && $user->status == 1)
				{
					if(!$user->email_verified_at)
					{
						$otp = General::hash(4);
						$user->token = General::hash(64);
						$user->otp = $otp;
						if($user->save())
						{
							$codes = [
								'{first_name}' => $user->first_name,
								'{last_name}' => $user->last_name,
								'{company_name}' => Setting::get('company_name'),
								'{otp}' => isset($user->email_otp) && $user->email_otp ? $user->email_otp : General::randomNumber(4)
							];

							General::sendTemplateEmail(
								$user->email,
								'email-verification-otp',
								$codes
							);

                            unset($user->email_otp);
							return Response()->json([
								'status' => true,
								'message' => 'Please verify your Email account first. We have sent to you verification OTP in your email.',
								'user' => $user,
								'token' => $user->token
							]);
						}
						else
						{
							return Response()->json([
								'status' => false,
								'message' => 'Session could not be establised. Please try again.',
							], 400);
						}
					}
					/*elseif(!$user->phone_verification)
					{
						return Response()->json([
							'message' => 'Please verify your Phone account first',
						]);
					}*/
					else
					{
						$user = ApiAuth::makeLoginSession($request, $user);
						if($user)
						{
							unset($user->email_otp);
							return Response()->json([
								'status' => true,
								'message' => 'Login successfully',
								'user' => $user
							]);
						}
						else
						{
							return Response()->json([
								'status' => false,
								'message' => 'Session could not be establised. Please try again.',
							], 400);
						}
					}
				}
				elseif($user && $user->status == 0)
				{
					return Response()->json([
						'status' => false,
						'message' => 'Account is in inactive state and contact administrator.',
					], 400);
				}
				else
				{
					return Response()->json([
						'status' => false,
						'message' => 'The credentials that you\'ve entered doesn\'t match any account.',
					], 400);
				}
			}
			else
			{
				return Response()->json([
					'status' => false,
					'message' => current(current($validator->errors()->getMessages()))
				], 400);
			}
		}
		else
		{
			return Response()->json([
				'status' => false,
				'message' => 'Some of inputs are invalid in request.',
			], 400);
		}
	}

	// Email Verification
	function emailVerification(Request $request, $hash)
	{
		$user = User::getRow([
			'token like ?' => [$hash]
		]);

		if($user && $request->isMethod('post'))
		{
			$allowed = ['otp'];
			$data = $request->toArray();
			if($request->has($allowed))
			{
				$validator = Validator::make(
					$request->toArray(),
					[
						'otp' => 'required',
						'device_type' => 'required',
						'device_id' => Rule::requiredIf(function () use ($request) {
							return $request->get('device_type') != 'web';
						}),
						'device_name' => Rule::requiredIf(function () use ($request) {
							return $request->get('device_type') != 'web';
						}),
						'fcm_token' => Rule::requiredIf(function () use ($request) {
							return $request->get('device_type') != 'web';
						}),
					]
				);

				if(!$validator->fails())
			    {
					if($data['otp'] == $user->email_otp)
					{
						$user->token = null;
						$user->email_verified_at = date('Y-m-d H:i:s');
						$user->status = 1;
						$user->email_otp = null;
						
						if($user->save())
						{
							$loginUser = ApiAuth::makeLoginSession($request, $user);
							$user['access'] = ['id' => $loginUser->access['id'],'token' => $loginUser->access['token']];


							$codes = [
								'{first_name}' => $user->first_name,
								'{last_name}' => $user->last_name,
								'{company_name}' => Setting::get('company_name'),
							];

							General::sendTemplateEmail(
								$user->email,
								'registration-successful',
								$codes
							);

							unset($user->email_otp);
							
							return Response()->json([
								'status'  => true,
								'message' => 'Your email verification has been completed.',
								'user'    => $user
							], 200);
						}
						else
						{
							return Response()->json([
								'status' => false,
								'message' => 'Email could not be verified. The otp is expired or used.'
							], 400);
						}
					}
					else
					{
						return Response()->json([
							'status' => false,
							'message' => 'Please input the correct OTP.'
						], 400);
					}
				}
				else
				{
					return Response()->json([
						'status' => false,
						'message' => current(current($validator->errors()->getMessages()))
					], 400);
				}
			}
			else
			{
				return Response()->json([
					'status' => false,
					'message' => 'Some of inputs are invalid in request.',
				], 400);
			}		
		}
		else
		{
			return Response()->json([
				'status' => false,
				'message' => 'Email could not be verified. The otp is expired or used.',
			], 400);
		}
	}

	// Email Verify OTP
	function verifyEmailOtp(Request $request, $hash)
	{
		if($request->get('otp'))
		{
			$user = User::getRow([
				'token like ?' => [$hash],
				'email_otp' => $request->get('otp'),
				'status' => 1
			]);

			if($user)
			{
				return Response()->json([
					'status' => true,
					'message' => 'Otp verified'
				]);
			}
			else
			{
				return Response()->json([
					'status' => false,
					'message' => 'OTP did not match.',
				], 400);
			}
		}
		else
		{
			return Response()->json([
				'status' => false,
				'message' => 'Please enter otp to proceed.',
			], 400);
		}
	}

	// Email Resend OTP
	function resendEmailOtp(Request $request, $hash)
	{
		if($hash)
		{
			$user = User::getRow([
				'token like ?' => [$hash],
				'status' => 1
			]);

			if($user)
			{
				$user->email_otp = General::randomNumber(4);
				if($user->save())
				{
					$codes = [
						'{first_name}' => $user->first_name,
						'{last_name}' => $user->last_name,
						'{company_name}' => Setting::get('company_name'),
						'{otp}' => $user->email_otp
					];

					General::sendTemplateEmail(
						$user->email,
						'registration-otp',
						$codes
					);

					return Response()->json([
						'status' => true,
						'message' => 'Recover code sent to email.'
					]);
				}
				else
				{
					return Response()->json([
						'status' => false,
						'message' => 'Something went wrong. Please try again.',
					], 400);
				}
			}
			else
			{
				return Response()->json([
					'status' => false,
					'message' => 'Email is not register with us.',
				], 400);
			}
		}
		else
		{
			return Response()->json([
				'status' => false,
				'message' => 'Please enter your register email to recover password.',
			], 400);
		}
	}

	// Forgot Password
	function forgotPassword(Request $request)
	{
		$allowed = ['email'];
		if($request->has($allowed))
		{
			if($request->get('email'))
			{
				$email = $request->get('email');
				$user = User::getRow([
					'email LIKE ?' => [$email],
					'status' => 1
				]);

				if($user)
				{
					$user->token = General::hash(64);
					$user->otp   = General::randomNumber(4);

					if($user->save())
					{
						$codes = [
							'{first_name}' => $user->first_name,
							'{last_name}' => $user->last_name,
							'{email}' => $user->email,
							'{otp}' => $user->otp
						];

						General::sendTemplateEmail(
							$user->email,
							'forgot-password-otp',
							$codes
						);

						return Response()->json([
							'status'  => true,
							'message' => 'We have sent you a recovery code on your email. Please follow the email.',
							'token'   => $user->token
						]);
					}
					else
					{
						return Response()->json([
							'status' => false,
							'message' => 'Something went wrong. Please try again.',
						], 400);
					}
				}
				else
				{
					return Response()->json([
						'status' => false,
						'message' => 'Email is not register with us.',
					], 400);
				}
			}
			else
			{
				return Response()->json([
					'status' => false,
					'message' => 'Please enter your register email to recover password.',
				], 400);
			}
		}
		else
		{
			return Response()->json([
				'status' => false,
				'message' => 'Some of inputs are invalid in request.',
			], 400);
		}
	}

	// Verify Forgot Password
	function verifyForgotOtp(Request $request, $hash)
	{
		if($request->get('otp'))
		{
			$user = User::getRow([
				'token like ?' => [$hash],
				'otp' => $request->get('otp'),
				'status' => 1
			]);

			if($user)
			{
				return Response()->json([
					'status' => true,
					'message' => 'Otp verified'
				]);
			}
			else
			{
				return Response()->json([
					'status' => false,
					'message' => 'OTP did not match.',
				], 400);
			}
		}
		else
		{
			return Response()->json([
				'status' => false,
				'message' => 'Please enter otp to proceed.',
			], 400);
		}
	}

	// Resend Forgot OTP
	function resendForgotOtp(Request $request, $hash)
	{
		if($hash)
		{
			$user = User::getRow([
				'token like ?' => [$hash],
				'status' => 1
			]);

			if($user)
			{
				$user->otp = General::randomNumber(4);
				if($user->save())
				{
					$codes = [
						'{first_name}' => $user->first_name,
						'{last_name}' => $user->last_name,
						'{email}' => $user->email,
						'{otp}' => '<span style="font-size: 30px; letter-spacing: 7px;">' . $user->otp . '</span>'
					];

					General::sendTemplateEmail(
						$user->email,
						'forgot-password-otp',
						$codes
					);

					return Response()->json([
						'status' => true,
						'message' => 'Recover code sent to email.'
					]);
				}
				else
				{
					return Response()->json([
						'status' => false,
						'message' => 'Something went wrong. Please try again.',
					], 400);
				}
			}
			else
			{
				return Response()->json([
					'status' => false,
					'message' => 'Email is not register with us.',
				], 400);
			}
		}
		else
		{
			return Response()->json([
				'status' => false,
				'message' => 'Please enter your register email to recover password.',
			], 400);
		}
	}

	// Recover Password
	function recoverPassword(Request $request, $hash)
	{
		$allowed = ['new_password', 'confirm_password'];
		if($request->has($allowed))
		{
			$data = $request->toArray();

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
					],
					// 'otp' => [
					// 	'required'
					// ]
				]
			);

			if(!$validator->fails())
			{
				$user = User::getRow([
					'token like ?' => [$hash],
					// 'otp' => $request->get('otp'),
					'status' => 1
				]);

				if($user)
				{
					if($data['new_password'] && $data['confirm_password'] && $data['new_password'] == $data['confirm_password'])
					{
						$user->password = $data['new_password'];
						$user->token = null;
						$user->otp = null;

						if($user->save())
						{
							return Response()->json([
								'status' => true,
								'message' => 'Password updated successfully. Login with new credentials to proceed.'
							], 200);
						}
						else
						{
							return Response()->json([
								'status' => false,
								'message' => 'New password could be updated.'
							], 400);
						}
					}
					else
					{
						return Response()->json([
							'status' => false,
							'message' => 'Password did not match.'
						], 400);
					}
				}
				else
				{
					return Response()->json([
						'status' => false,
						'message' => 'Token is invalid.'
					], 400);
				}
			}
			else
			{
				return Response()->json([
					'status' => false,
					'message' => current(current($validator->errors()->getMessages()))
				], 400);
			}
		}
		else
		{
			return Response()->json([
				'status' => false,
				'message' => 'Some of inputs are invalid in request.',
			], 400);
		}
	}

	// Check Email Exists
	function checkEmailExist(Request $request)
	{
		$userId = ApiAuth::getLoginId();
		$exist = false;
		if($request->get('email'))
		{
			$exist = User::select(['email'])
				->where('id', '!=', $userId)
				->where('email', 'LIKE', $request->get('email'))
				->first();
			$exist = !empty($exist) ? true : false;
		}

		return Response()->json([
			'status' => true,
			'exist' => $exist
		]);
	}

	// Logout
	function logout(Request $request)
	{
		ApiAuth::logout();
		return Response()->json([
			'status' => true
		]);
	}
}