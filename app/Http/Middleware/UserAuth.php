<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\User\UserAuth as UserAuthModal;
use App\Models\Admin\User;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $userId = UserAuthModal::getLoginId();
        $user = User::find($userId);

        if($userId)
        {
            if($user['status'] == 1)
            {
                if($request->session()->getId() == $user->session_id) 
                {
                    UserAuthModal::makeWebToken();
                    return $next($request);
                }
                else
                {
                    return redirect()->route('user.logout');
                }
            }
            else
            {
                return redirect()->route('user.logout');
            }    
        }
        else
        {
            return redirect()->route('user.login',['redirectUrl' => url()->current()]);
        }
    }
}
