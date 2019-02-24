<?php

namespace App\Http\Controllers\Backend;

use App\Models\Backend\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    public function getList(Request $request)
    {
        $users = User::list($request->all())->paginate(15, null, null, $request->page ?? 1);

        return response()->json($users->values());
    }

    public function getOne(Request $request)
    {
        $user = User::getOne($request->all());

        return response()->json($user->all());
    }

    public function toggleBlock(Request $request)
    {
        $user = User::find($request->id);
        $success = false;

        if ($user) {
            $is_blocked = $user->is_blocked;

            $user->update(['is_blocked' => !$is_blocked ? 1 : 0]);
            $success = true;
        }

        return $this->success($success);
    }

    public function delete(Request $request)
    {
        $success = (boolean)User::destroy($request->id);

        $this->success($success);
    }
}
