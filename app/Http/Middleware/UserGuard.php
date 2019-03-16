<?php

namespace App\Http\Middleware;

use App\Models\User;
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
        $userRole = User::find(Auth::user()->id)->role->name;

        if ($userRole !== $guard) {
             return response()->json([
                 'success' => false
             ]);
        }

        return $next($request);
    }
}
