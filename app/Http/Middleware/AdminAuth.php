<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Admin\AdminAuth as AdminAuthModal;
use App\Models\Admin\Activities;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $adminId = AdminAuthModal::getLoginId();
        Activities::log($request, $adminId);

        if($adminId)
        {
            return $next($request);
        }
        else
        {
            return redirect()->route('admin.login');
        }
    }
}
