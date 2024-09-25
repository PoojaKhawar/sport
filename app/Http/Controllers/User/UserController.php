<?php

/**
 * User Class
 *
 * @package    UserController
 * @copyright  2023
 * @author     Irfan Ahmad <irfan.ahmad@globiztechnology.com>
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Libraries\FileSystem;
use App\Models\User\UserAuth;
use App\Models\Admin\User;

class UserController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function profile(Request $request)
    {
        $id = UserAuth::getLoginId();
        $user = User::get($id);

        if($user)
        {
            return view("user.profile.index", [
                'user' => $user
            ]);
        }
        else
        {
            abort(404);
        }
    }

    function editProfile(Request $request)
    {
        $id = UserAuth::getLoginId();
        $user = User::get($id);

        if($user)
        {
            if($request->isMethod('post'))
            {
                $data = $request->toArray();
                $data['phonenumber'] = sanitizePhone($data['phonenumber']);
                unset($data['_token']);

                $validator = Validator::make(
                    $request->toArray(),
                    [
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'email' => [
                            'required',
                            'email',
                            Rule::unique('users')->ignore($user->id),
                        ]
                    ]
                );

                if(!$validator->fails())
                {                    
                    $user = User::modify($id, $data);
                    if($user)
                    {
                        $request->session()->flash('success', 'Profile updated successfully.');
                        redirect()->route('user.profile');
                    }
                    else
                    {
                        $request->session()->flash('error', 'Profile could not be saved. Please try again.');
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                }
                else
                {
                    $request->session()->flash('error', 'Please provide valid inputs.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }            

            return view("user.profile.edit", [
                'user' => $user
            ]);
        }
        else
        {
            abort(404);
        }
    }

    function updatePicture(Request $request)
    {
        $id = UserAuth::getLoginId();
        $user = User::get($id);

        if($request->ajax() && $request->isMethod('post'))
        {
            $data = $request->toArray();

            $validator = Validator::make(
                $request->toArray(),
                [
                    'file' => 'mimes:jpg,jpeg,png,gif',
                ]
            );

            if(!$validator->fails())
            {
                if($user)
                {
                    $oldImage = $user->image;

                    if($request->file('image')->isValid())
                    {
                        $file = FileSystem::uploadImage(
                            $request->file('image'),
                            'user'
                        );

                        if($file)
                        {
                            $user->image = $file;
                            if($user->save())
                            {
                                $originalName = FileSystem::getFileNameFromPath($file);
                                
                                FileSystem::resizeImage($file, 'L-' . $originalName, "300*300");
                                FileSystem::resizeImage($file, 'M-' . $originalName, "200*200");
                                FileSystem::resizeImage($file, 'S-' . $originalName, "100*100");
                                $picture = $user->getResizeImagesAttribute()['medium'];

                                if($oldImage)
                                {
                                    FileSystem::deleteFile($oldImage);
                                }
                                
                                return Response()->json([
                                    'status' => true,
                                    'message' => 'Profile picture uploaded successfully.',
                                    'image' => url($picture)
                                ]);     
                            }
                            else
                            {
                                FileSystem::deleteFile($file);
                                return Response()->json([
                                    'status' => false,
                                    'message' => 'Profile picture could not be uploaded.'
                                ]); 
                            }
                        }
                        else
                        {
                            return Response()->json([
                                'status' => false,
                                'message' => 'Profile picture could not be uploaded.'
                            ]);     
                        }
                    }
                    else
                    {
                        return Response()->json([
                            'status' => false,
                            'message' => 'Profile picture could not be uploaded. Please try again.'
                        ]);
                    }
                }
                else
                {
                    return Response()->json([
                        'status' => false,
                        'message' => 'Something went wrong. Please try again.'
                    ]);
                }
            }
        }
        else
        {
            return Response()->json([
                'status' => false,
                'message' => 'Something went wrong. Please try again.'
            ]);
        }
    }

    function changePassword(Request $request)
    {
        $id = UserAuth::getLoginId();
        $user = User::find($id);
        if($user)
        {
            if($request->isMethod('post'))
            {
                $data = $request->toArray();

                $validator = Validator::make(
                    $request->toArray(),
                    [
                        'password' => [
                            'min:8'
                        ],
                        'new_password' => [
                            'min:8'
                        ],
                        'confirm_password' => [
                            'min:8'
                        ]
                    ]
                );

                if(!$validator->fails())
                {
                    unset($data['_token']);
                    if(Hash::check($data['old_password'], $user->password))
                    {
                        if($request->get('old_password') != $request->get('new_password'))
                        {
                            if($data['new_password'] && $data['confirm_password'] && $data['new_password'] == $data['confirm_password'])
                            {
                                $user->password = $data['new_password'];

                                if($user->save())
                                {
                                    $request->session()->flash('success', 'Password updated successfully.');
                                    return redirect()->route('user.changePassword');
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
                        else
                        {
                            $request->session()->flash('error', 'New Password cannot be same as your current password. Please choose a different password.');
                            return redirect()->back()->withErrors($validator)->withInput();  
                        }
                    }
                    else
                    {
                        $request->session()->flash('error', 'Old password is wrong.');
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                }
                else
                {
                    $request->session()->flash('error', 'Please provide valid inputs.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }

            return view("user/profile/changePassword", [
                'user' => $user
            ]);
        }
        else
        {
            abort(404);
        }
    }
}
