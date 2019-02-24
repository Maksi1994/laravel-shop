<?php

namespace App\Http\Resources\Backend\User;

use App\Traits\CollectionPaginationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
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
            'result' => $this->collection->map(function ($user) {
                return [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'created_at' => $user->created_at,
                    'orders_count' => $user->orders_count,
                    'sum_all_orders' => $user->sum_all_orders,
                    'is_blocked' => (boolean)$user->is_blocked
                ];
            }),
            'meta' => $this->pagination
        ];
    }
}
