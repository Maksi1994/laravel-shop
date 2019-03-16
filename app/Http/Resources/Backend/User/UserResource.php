<?php

namespace App\Http\Resources\Backend\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'orders_count' => $this->orders_count,
            'sum_all_orders' => $this->sum_all_orders,
            'created_at' => $this->created_at->format('Y M d    -   h:m A'),
            'is_blocked' => (boolean)$this->is_blocked
        ];
    }
}
