<?php

namespace App\Http\Middleware;

use Closure;

class AuthBackHome
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( !session()->get('id') ) {
            return redirect()->route('/');
        }
        return $next($request);
    }
}
