<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{

    public function getProductComments(Request $request)
    {
        $user = Auth::user();
        $comments = Comment::with('user')
            ->where('product_id', $request->product_id)
            ->orderBy('created_at', 'desc')
            ->paginate(15, ['*'], ['page'], $request->page ?? 1);

        return response()->json([
            'result' => $comments->map(function ($comment) use ($user) {
                return [
                    'id' => $comment->id,
                    'body' => $comment->body,
                    'created_at' => $comment->created_at,
                    'authorName' => $comment->user->first_name.' '.$comment->user->last_name,
                    'author_id' => $comment->user_id,
                    'estimate' => $comment->estimate,
                    'isEditable' => $comment->user_id === $user['id']
                ];
            })
        ]);
    }

    public function create(Request $request)
    {
        $success = false;
        $request->merge(['user_id' => Auth::user()['id']]);

        $validation = Validator::make($request->all(), [
            'body' => 'required|min:10|max:1000',
            'product_id' => 'required|exists:products,id',
            'estimate' => 'required|integer|min:1|max:5'
        ]);

        if (!$validation->fails()) {
            Comment::create($request->all());

            $success = true;
        }

        return response()->json(compact('success'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $comment = Comment::where([
            'id' => $request->id,
            'user_id' => $user['id']
        ]);

        $success = false;

        $validation = Validator::make($request->all(), [
            'body' => 'required|min:10|max:1000',
            'product_id' => 'required|exists:products,id',
            'estimate' => 'required|integer|min:1|max:5'
        ]);

        if ($comment && !$validation->fails()) {
            $comment->update($request->all());

            $success = true;
        }

        return response()->json(compact('success'));
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        $comment = Comment::find($request->comment_id)->where('user_id', $user['id']);

        if ($comment) {
            $comment->destroy();

            $success = true;
        }

        return response()->json(compact('success'));
    }

    public function getAllMyComments(Request $request)
    {
        $user = Auth::user();
        $comments = Comment::where('user_id', $user['id'])
            ->orderBy('created_at', 'desc')
            ->paginate(15, ['*'], ['page'], $request->page ?? 1);

        return response()->json([
            'result' => $comments->map(function($comment) {
                return [
                    'id' => $comment->id,
                    'body' => $comment->body,
                    'estimate' => $comment->estimate,
                    'created_at' => $comment->created_at->format('Y M d    -   h:m A')
                ];
            })
        ]);
    }
}
