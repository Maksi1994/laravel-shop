<?php

namespace App\Http\Resources\Backend\Product;

use App\Http\Resources\Backend\Category\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'image' => env('DO_SPACES_DOMAIN') . $this->image,
            'price' => $this->price
        ];
    }
}
