<?php

namespace App\Http\Middleware;

use Closure;

class AuthBusiness
{
    /**
     * Solo permite sesiones de empresa (no de candidatos).
     */
    public function handle($request, Closure $next)
    {
        if (!session()->get('id') || session()->get('role') !== 'business') {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'No autorizado'], 403);
            }
            return redirect()->route('/');
        }
        return $next($request);
    }
}
