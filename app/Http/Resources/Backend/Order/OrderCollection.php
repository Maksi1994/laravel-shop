<?php

namespace App\Http\Resources\Backend\Order;

use App\Traits\CollectionPaginationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
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
            'result' => $this->collection->map(function ($order) {
                return [
                    'id' => $order->id,
                    'customer' => [
                        'id' => $order->customer_id,
                        'name' => $order->customer_name
                    ],
                    'full_price' => $order->full_price,
                    'count' => $order->count,
                    'created_at' => $order->created_at->format('Y M d    -   h:m A'),
                ];
            }),
            'meta' => $this->pagination
        ];
    }
}
