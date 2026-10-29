<?php

namespace App\Http\Middleware;

use Closure;

class AuthAdmin
{
    /**
     * Solo permite sesiones de administrador.
     */
    public function handle($request, Closure $next)
    {
        if (!session()->get('id') || session()->get('role') !== 'administrador') {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'No autorizado'], 403);
            }
            return redirect()->route('/');
        }
        return $next($request);
    }
}
