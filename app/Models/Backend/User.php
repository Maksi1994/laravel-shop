<?php

namespace App\Models\Backend;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $fillable = ['id', 'first_name', 'last_name', 'email', 'is_blocked'];
    public $timestamps = true;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role()->where('name', 'admin')->exists();
    }

    public function orders()
    {
        return $this->belongsTo(Order::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeList($query, $params)
    {
        $orderColumn = 'created_at';
        $order = 'desc';

        $query = $query->selectRaw('
        users.id,
        users.first_name,
        users.last_name,
        users.created_at,
        COUNT(orders.id) as orders_count,
        SUM(order_product.price * order_product.count) as sum_all_orders,
        users.is_blocked,
        users.created_at
        ')->leftJoin('orders', 'orders.user_id', '=', 'users.id')
            ->leftJoin('order_product', 'order_product.order_id', 'orders.id')
            ->groupBy('users.id');


        $query->when((!empty($params['has_orders'])), function ($q) use ($params) {
            return $q->havingRaw('COUNT(orders.id) > 0');
        });

        if (!empty($params['orderType']) && !empty($params['order'])) {
            $order = $params['order'];

            switch ($params['orderType']) {
                case 'orders_count':
                    $orderColumn = 'orders_count';
                    break;
                case 'sum_all_orders':
                    $orderColumn = 'sum_all_orders';
            }
        }


        return $query->orderBy($orderColumn, $order);
    }

    public function scopeGetOne($query, $params)
    {
        return $query->selectRaw('
        users.id,
        users.first_name,
        users.last_name,
        users.created_at,
        COUNT(orders.id) as orders_count,
        SUM(order_product.price * order_product.count) as sum_all_orders,
        users.is_blocked,
         users.created_at
        ')->leftJoin('orders', 'orders.user_id', '=', 'users.id')
            ->leftJoin('order_product', 'order_product.order_id', 'orders.id')
            ->groupBy('users.id')
            ->where('users.id', $params['id'])
            ->get()
            ->first();
    }

}
