<?php

namespace App\Http\Resources\Backend\Comment;

use App\Traits\CollectionPaginationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentatorCollection extends ResourceCollection
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
            'result' => $this->collection->map(function ($commentator) {
                return [
                    'name' => $commentator->first_name . ' ' . $commentator->last_name,
                    'id' => $commentator->id,
                    'email' => $commentator->email,
                    'comments_count' => $commentator->comments_count
                ];
            }),
            'meta' => $this->pagination
        ];
    }
}
