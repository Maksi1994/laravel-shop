<?php

namespace App\Http\Controllers\Backend;

use App\Http\Resources\Backend\Comment\CommentatorCollection;
use App\Http\Resources\Backend\Comment\CommentCollection;
use App\Http\Resources\Backend\Comment\CommentResource;
use App\Http\Resources\Backend\Comment\CommentSubjectCollection;
use App\Models\Backend\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    public function getList(Request $request)
    {
        $items = Comment::getList($request->all())->paginate(20, null, null . $request->page ?? 1);

        switch ($request->filter) {
            case 'comments':
                return new CommentCollection($items);
            case 'users':
                return new CommentatorCollection($items);
            case 'products':
                return new CommentSubjectCollection($items);
            case 'user_comments':
                return new CommentCollection($items);
        }
    }

    public function getOne(Request $request)
    {
        $comment = Comment::with([
            'author',
            'product'
        ])->find($request->id);

        return new CommentResource($comment);
    }

    public function delete(Request $request)
    {
        $success = (boolean)Comment::destroy($request->id);

        return $this->success($success);
    }


}
