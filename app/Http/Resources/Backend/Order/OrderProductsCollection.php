<?php

namespace App\Http\Resources\Backend\Order;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderProductsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'result' => [
                'customer' => [
                    'id' => $this->collection->first()->customer_id,
                    'name' => $this->collection->first()->customer_name
                ],
                'products' => $this->collection->map(function ($productGroup) {
                    return [
                        'id' => $productGroup->id,
                        'full_price' => $productGroup->full_price,
                        'count' => $productGroup->count,
                        'image' => $productGroup->image,
                        'price_for_one' => $productGroup->price_for_one,
                    ];
                })
            ]
        ];
    }
}
