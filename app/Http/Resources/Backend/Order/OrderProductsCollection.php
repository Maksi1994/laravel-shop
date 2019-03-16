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
        $last_row = $this->collection->pop();

        return [
            'result' => [
                'order_id' => $this->collection->first()->order_id,
                'customer' => [
                    'id' => $this->collection->first()->customer_id,
                    'name' => $this->collection->first()->customer_name
                ],
                'products' => $this->collection->map(function ($productGroup) {
                    return [
                        'id' => $productGroup->id,
                        'name' => $productGroup->name,
                        'full_price' => $productGroup->full_price,
                        'category_name' => $productGroup->category_name,
                        'category_id' => $productGroup->categories_id,
                        'count' => $productGroup->count,
                        'image' =>  !empty($productGroup->image) ? env('DO_SPACES_DOMAIN') . $productGroup->image : asset('/img/products/no-image.svg'),
                        'price_for_one' => $productGroup->price_for_one,
                    ];
                }),
                'full_price' => $last_row->full_price,
                'created_at' =>  $this->collection->first()->created_at->format('Y M d    -   h:m A')
            ]
        ];
    }
}
