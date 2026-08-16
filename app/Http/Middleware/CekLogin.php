<?php

namespace App\Http\Middleware;

use Closure;

class CekLogin
{
    public function handle($request, Closure $next)
    {
        if(!session()->has('login'))
        {
            return redirect('/login');
        }

        return $next($request);
    }
}