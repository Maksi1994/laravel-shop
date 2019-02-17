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

    public function scopeFilter($query, $params)
    {
        $orderColumn = 'products.created_at';
        $order = 'desc';

        if (!empty($params['categoryId']) && empty($params['categoryId'])) {
            $query = $query->where('products.category_id', $params['categoryId']);
        }

        if (!empty($params['minPrice']) && !empty($params['maxPrice'])) {
            $query = $query->whereBetween('products.price', [$params['minPrice'], $params['maxPrice']]);
        }

        if (!empty($params['orderType']) && !empty($params['order'])) {
            $order = $params['order'];

            switch ($params['orderType']) {
                case 'newest':
                    $orderColumn = 'products.created_at';
                    break;
                case 'price':
                    $orderColumn = 'products.price';
                    break;
                case 'popularity':
                    $orderColumn = 'sum_boughts';
            }
        }

        return $query->orderBy($orderColumn, $order);
    }
}
