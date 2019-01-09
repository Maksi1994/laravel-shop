<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $failResponce = responce()->json([
          'success' => false
        ]);

        if (!Auth::check()) {
            return $failResponce;
        }

        $user = Auth::user();

        if ($guard === 'admin' && $user->role !== 'admin') {
             return $failResponce;
        }

        return $next($request);
    }
}
