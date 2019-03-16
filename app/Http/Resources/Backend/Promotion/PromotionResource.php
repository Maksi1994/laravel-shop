<?php

namespace App\Http\Resources\Backend\Promotion;

use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
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
            'image' => $this->image,
            'products_count' => $this->products_count,
            'created_at' => $this->created_at->format('Y M d    -   h:m A'),
            'products' => $this->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'promotionType' => [
                        'id' => $product->promotionType->first()->id,
                        'name' => $product->promotionType->first()->name
                    ],
                    'image' => !empty($product->image) ? env('DO_SPACES_DOMAIN') . $product->image : asset('/img/products/no-image.svg'),
                    'price' => $product->price,
                    'category_name' => $product->category->name,
                    'category_id' => $product->category->id
                ];
            })
        ];
    }
}
