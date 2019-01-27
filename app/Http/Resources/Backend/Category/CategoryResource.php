<?php

namespace App\Http\Resources\Backend\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            $this->mergeWhen(!empty($this->parent), ['parent' => [
                'id' => $this->parent['id'],
                'name' => $this->parent['name']
            ]]),
            'created_at' => $this->created_at->format('Y M d    -   h:m A'),
            'productsCount' => $this->products_count
        ];
    }
}
