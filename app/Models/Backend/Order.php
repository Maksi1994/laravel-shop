<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    public $timestamps = true;
    public $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('count', 'price');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeList($query, $params)
    {
        $orderColumn = 'orders.created_at';
        $order = 'desc';

        $query = $query->selectRaw('
             orders.id as id,
             orders.created_at as created_at,
             SUM(order_product.count) as count,
             SUM(order_product.count * order_product.price) as full_price,
             CONCAT(users.first_name, " ", users.last_name)  as customer_name,
             users.id as customer_id
             ')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->groupBy('orders.id');

        if (!empty($params['maxPrice']) && !empty($params['maxPrice'])) {
            $query = $query->havingRaw('SUM(order_product.count * order_product.price) BETWEEN ? AND ?', [$params['minPrice'], $params['maxPrice']]);
        }

        if (!empty($params['beginDate']) && !empty($params['endDate'])) {
            $query = $query->whereRaw('UNIX_TIMESTAMP(orders.created_at) BETWEEN ? AND ? ', [$params['beginDate'], $params['endDate']]);
        }

        if (!empty($params['orderType']) && !empty($params['order'])) {
            $order = $params['order'];

            switch ($params['orderType']) {
                case 'price':
                    $orderColumn = 'full_price';
                    break;
                default:
                    $orderColumn = 'orders.created_at';
            }
        }

        return $query->orderBy($orderColumn, $order);
    }

    public function scopePriceRange($query) {
        return $query->selectRaw('SUM(order_product.count * order_product.price) as max_price')
            ->join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->groupBy('orders.id')
            ->orderBy('max_price', 'desc')
            ->first();
    }

    public function scopeGetOne($query, $params) {
        return $query->selectRaw('
             ANY_VALUE(orders.id) as order_id,
             ANY_VALUE(orders.created_at) as created_at,
             ANY_VALUE(products.id) as id,
             ANY_VALUE(order_product.name) as name,
             ANY_VALUE(categories.name) as category_name,
             ANY_VALUE(categories.id) as categories_id,
             ANY_VALUE(products.image) as image,
             SUM(order_product.count) as count,
             ANY_VALUE(order_product.price) as price_for_one,
             SUM(order_product.count * order_product.price) as full_price,
             ANY_VALUE(CONCAT(users.first_name, " ", users.last_name))  as customer_name,
             ANY_VALUE(users.id) as customer_id
             ')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->leftJoin('products', 'order_product.product_id', '=', 'products.id')
            ->leftJoin('categories', 'categories.id' , '=', 'products.category_id')
            ->groupBy(DB::raw(' order_product.product_id with ROLLUP'))
            ->where('order_id', $params['id'])
            ->get();
    }

    public function scopeAttachProducts($query, $params) {
        $orderDataForSaving = [];

        collect($params['products'])->eachSpread(function ($product) use (&$orderDataForSaving) {
            $orderDataForSaving[$product['product_id']] = [
                'count' => $product['count']
            ];
        });

        $query::find($params['order-id'])->products()->sync($orderDataForSaving);
    }
}
