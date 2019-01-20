<?php

namespace App\Http\Resources\Backend\Promotion;

use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
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
          'name' => $this->name,
          'image' => $this->image,
          'id' => $this->id
        ];
    }
}
