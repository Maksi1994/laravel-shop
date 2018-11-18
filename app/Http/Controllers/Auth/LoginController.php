<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function login(Request $request)
    {
        $creditionals = $request->only('email', 'password');

        if ($request->has('email') &&
            $request->has('password')) {

            return response()->json(Auth::attempt($creditionals));
        }

        return response()->json(false);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();

            return response()->json(true);
        }

        return response()->json(false);
    }

    public function getAuthUser(Request $request) {
        return response()->json(Auth::user());
    }

}
