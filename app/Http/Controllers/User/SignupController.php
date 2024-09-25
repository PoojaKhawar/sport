<?php

/**
 * User Class
 *
 * @package    SignupController
 * @copyright  2023 Globiz Technology Inc..
 * @author     Irfan Ahmad <irfan.ahmad@globiztechnology.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

use App\Libraries\General;
use App\Models\Admin\Setting;
use App\Models\Admin\User;
use App\Models\User\UserAuth;

class SignupController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function index(Request $request)
    {
        if(UserAuth::isLogin())
        {
            return redirect()->route('user.profile');
        }

        if($request->isMethod('post'))
        {
            $data = $request->toArray();
            
            unset($data['_token']);
            unset($data['confirm_password']);

            $validator = Validator::make(
                $request->toArray(),
                [
                    'first_name' => 'required',
                    'email' => [
                        'required',
                        Rule::unique('users')->where('deleted_at', NULL),
                    ],
                    'phonenumber' => [
                        'required',
                        Rule::unique('users')->where('deleted_at', NULL),
                    ],
                    'password' => 'required'
                ],

                [
                    'email.unique' => 'Email already registered with us.',
                    'phonenumber.unique' => 'Phone number is already registered with us.'
                ]

            );
                
            if(!$validator->fails())
            {
                $data['token'] = General::hash(64);
                $data['password_set'] = 1;
                $user = User::create($data);

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

                    $request->session()->flash('success', 'Thank you for registration with us. We have sent an otp on your email. Please verify your email to login.');
                    return redirect()->route('user.emailVerification', ['token' => $user->token]);
                }
                else
                {
                    $request->session()->flash('error', 'Account could not be created. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }
            else
            {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        return view("user/signup/index");
    }

    function success(Request $request)
    {
        return view("user/signup/success");
    }

    function error(Request $request)
    {
        return view("user/signup/error");
    }
}
