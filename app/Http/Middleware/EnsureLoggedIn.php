<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureLoggedIn
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('user')) {
            return redirect()->route('login');
        }

        if (!session()->has('active_role') && !$request->is('roles/seleccionar')) {
            return redirect()->route('roles.seleccionar');
        }

        return $next($request);
    }
}
