<?php

namespace App\Http\Resources\Backend\Comment;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "body" => $this->body,
            "author" => [

            ],
            "product_id": 1,
         "created_at"=> $this->created_at->format()
        ];
    }
}
