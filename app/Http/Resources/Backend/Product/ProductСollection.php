<?php

namespace App\Http\Resources\Backend\Product;

use App\Traits\CollectionPaginationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductСollection extends ResourceCollection
{

    use CollectionPaginationTrait;

    public $collects = 'App\Http\Resources\Backend\Product\ProductResource';

    public function __construct($resource)
    {
        $this->makePagination($resource);
        parent::__construct($resource->getCollection());
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'result' => $this->collection,
            'meta' => $this->pagination
        ];
    }
}
