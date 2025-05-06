<?php

namespace Modules\Chat\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateDoctorOrClient
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('doctor')->check()) {
            Auth::shouldUse('doctor');
        } elseif (Auth::guard('client')->check()) {
            Auth::shouldUse('client');
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
