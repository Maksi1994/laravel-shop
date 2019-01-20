<?php

namespace App\Http\Resources\Backend\Order;

use App\Http\Resources\Backend\Product\ProductResource;
use App\Http\Resources\Backend\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'customer' => UserResource::make($this->whenLoaded('user')),
            'products' => ProductResource::make($this->whenLoaded('products')),
            'created_at' => $this->created_at,
            'count' => $this->count,
            'full_price' => $this->full_price
        ];
    }
}
