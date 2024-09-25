<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Admin\Activities;
use App\Libraries\General;
//use App\Libraries\Language;

class Guest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data =  !empty($request->toArray()) ? json_encode($request->toArray()) : null;
        $data = $data ? General::encrypt($data) : null;
        Activities::create([
            'url' => url()->current(),
            'data' => $data,
            'admin' => null,
            'client' => null,
            'ip' => $request->getClientIp()
        ]);

        //Language::setLocale($request->session()->get('language') ? $request->session()->get('language') : 'en');
        return $next($request);
    }
}
