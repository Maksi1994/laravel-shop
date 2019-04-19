<?php

namespace App\Http\Resources\Backend\Comment;

use App\Traits\CollectionPaginationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentSubjectCollection extends ResourceCollection
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
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'result' => $this->collection->map(function($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'image' => $product->image,
                        'comments_count' => $product->comments_count
                    ];
            }),
            'pagination' => $this->pagination
        ];
    }
}
