<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XSS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();
        array_walk_recursive($input, function(&$input) {
            if($input)
            {
                if(is_string($input))
                {
                    $input = preg_replace('#<script(.*?)>(.*?)</script>#is', '',$input);
                }
                else
                {
                    $input = $input;   
                }
            }
            elseif ($input = 0) 
            {
                $input = 0;
            }
            else
            {
                $input = null;
            }
            //$input = preg_replace('#<script(.*?)>(.*?)</script>#is', '',$input);
        });
        $request->merge($input);

        return $next($request);
    }
}