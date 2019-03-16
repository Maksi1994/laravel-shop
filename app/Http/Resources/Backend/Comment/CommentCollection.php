<?php

namespace App\Http\Resources\Backend\Comment;

use App\Traits\CollectionPaginationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentCollection extends ResourceCollection
{

    use CollectionPaginationTrait;

    public function __construct($resource)
    {
        $this->makePagination($resource);
        parent::__construct($resource->getCollection());
    }


    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'result' => $this->collection->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'body' => $comment->body,
                    'created_at' => $comment->created_at->format('Y M d    -   h:m A'),
                    'author' => [
                        'name' => $comment->author->first_name.' '.$comment->author->last_name,
                        'id' => $comment->author->id,
                        'email' => $comment->author->email,
                    ]
                ];
            }),
            'meta' => $this->pagination
        ];
    }
}
