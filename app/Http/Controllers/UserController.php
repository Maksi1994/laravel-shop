<?php

namespace App\Http\Controllers;

use App\Http\Resources\Backend\User\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function regist(Request $request)
    {
        $data = $request->all();
        $success = false;

        $validator = Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'role_id' => ['exists:roles,id']
        ]);

        if (!$validator->fails()) {
            User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'role_id' => $data['role_id'],
                'password' => Hash::make($data['password']),
            ]);

            $success = true;
        }

        return $this->success($success);
    }

    public function login(Request $request)
    {
        $creditionals = $request->only('email', 'password');
        $faiResponse = response()->json([
            'success' => false
        ]);

        if ($request->has('email') &&
            $request->has('password')) {

            if (!Auth::attempt($creditionals)) {
                return $faiResponse;
            }
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if (empty($request->remember_me)) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    public function logout(Request $request)
    {
        $success = false;

        if (Auth::check()) {
            $request->user()->token()->revoke();

            $success = true;
        }

        return $this->success($success);
    }

    public function getAuthUser(Request $request)
    {
        $user = Auth::user()->load('role');

        return new UserResource($user);
    }

    public function getAllRoles(Request $request)
    {
        return response()->json(Role::all()->map(function ($role) {
            return [
                'name' => $role->name,
                'id' => $role->id
            ];
        }));
    }

}
