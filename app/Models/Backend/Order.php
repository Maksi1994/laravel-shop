<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Carbon;

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

    public function scopeFilter($query, $params)
    {
        $orderColumn = 'orders.created_at';
        $order = 'desc';

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
}
