<?php

namespace App\Http\Resources\Backend\Product;

use App\Http\Resources\Backend\Category\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'category' => [
                'id' => $this->category_id,
                'name' => $this->category_name
            ],
            'image' => env('DO_SPACES_DOMAIN') . $this->image,
            'price' => $this->price,
            'created_at' => $this->created_at->format('Y M d    -   h:m A'),
            'sum_boughts' => $this->sum_boughts
        ];
    }
}
