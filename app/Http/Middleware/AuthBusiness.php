<?php

namespace App\Http\Middleware;

use App\Models\Business;
use Closure;

class AuthBusiness
{
    /**
     * Solo permite sesiones de empresa o administrador (no de candidatos).
     */
    public function handle($request, Closure $next)
    {
        $id = session()->get('id');
        $role = session()->get('role');

        if (! $id) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'No autorizado'], 403);
            }
            return redirect()->route('business.login')
                ->with('message', ['warning', 'Debes iniciar sesión como empresa para acceder']);
        }

        if ($role === 'user') {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'No autorizado'], 403);
            }
            return redirect()->route('/')
                ->with('message', ['warning', 'Esta sección es exclusiva para empresas']);
        }

        if (! in_array($role, ['business', 'administrador'], true)) {
            $business = Business::find($id);
            if (! $business) {
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'No autorizado'], 403);
                }
                return redirect()->route('business.login');
            }
            session(['role' => 'business']);
        }

        return $next($request);
    }
}

