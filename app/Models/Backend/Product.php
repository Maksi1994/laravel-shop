<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = true;
    public $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class)->withTimestamps();
    }

    public function scopeList($query, $params)
    {
        $orderColumn = 'products.created_at';
        $order = 'desc';

        $query = $query->selectRaw('
        ANY_VALUE(products.id) as id,
        COUNT(order_product.order_id) as sum_boughts,
        ANY_VALUE(products.price) as price,
        ANY_VALUE(products.image) as image,
        ANY_VALUE(products.name) as name,
        ANY_VALUE(products.created_at) as created_at,
        ANY_VALUE(categories.id) as category_id,
        ANY_VALUE(categories.name) as category_name
        ')->leftJoin('order_product', 'order_product.product_id', '=', 'products.id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->groupBy(['products.id']);

        if (!empty($params['categoryId']) && empty($params['categoryId'])) {
            $query = $query->where('products.category_id', $params['categoryId']);
        }

        if (!empty($params['minPrice']) && !empty($params['maxPrice'])) {
            $query = $query->whereBetween('products.price', [$params['minPrice'], $params['maxPrice']]);
        }

        if (!empty($params['orderType']) && !empty($params['order'])) {
            $order = $params['order'];

            switch ($params['orderType']) {
                case 'price':
                    $orderColumn = 'products.price';
                    break;
                case 'popularity':
                    $orderColumn = 'sum_boughts';
            }
        }

        return $query->orderBy($orderColumn, $order);
    }

    public function scopeGetOne($query, $params)
    {
        return $query->selectRaw('
        ANY_VALUE(products.id) as id,
        COUNT(order_product.count) as sum_boughts,
        ANY_VALUE(products.price) as price,
        ANY_VALUE(products.image) as image,
        ANY_VALUE(products.name) as name,
        ANY_VALUE(products.created_at) as created_at,
        ANY_VALUE(products.category_id) as category_id,
        ANY_VALUE(categories.name) as category_name
        ')->leftJoin('order_product', 'order_product.product_id', '=', 'products.id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->groupBY(['products.id'])
            ->find($params['id']);
    }

    public function scopePriceRange($query)
    {
        return $query->selectRaw('MAX(products.price) as max_price, MIN(products.price) as min_price')->first();
    }
}
