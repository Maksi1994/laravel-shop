<?php

namespace App\Http\Resources\Backend\Order;

use App\Traits\CollectionPaginationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    use CollectionPaginationTrait;

    public $collects = 'App\Http\Resources\Backend\Order\OrderResource';

    public function __construct($resource)
    {
        $this->makePagination($resource);
        parent::__construct($resource->getCollection());
    }


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
          'meta' => $this->pagination
        ];
    }
}
