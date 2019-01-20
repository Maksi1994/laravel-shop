<?php

namespace App\Http\Resources\Backend\Category;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\Backend\Product\ProductResource';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'result' => $this->collection,
        ];
    }
}
