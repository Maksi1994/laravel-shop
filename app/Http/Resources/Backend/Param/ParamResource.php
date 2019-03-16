<?php

namespace App\Http\Resources\Backend\Param;

use App\Http\Resources\Backend\Value\ValueResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ParamResource extends JsonResource
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
           'values' => ValueResource::collection($this->whenLoaded('values')),
       ];
    }
}
