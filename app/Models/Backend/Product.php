<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = true;
    public $fillable = [
        'name',
        'price',
        'category_id',
        'image'
    ];

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

        if (!empty($params['categoryId']) && is_numeric($params['categoryId'])) {
            $query = $query->where('products.category_id', $params['categoryId']);
        }

        if (!empty($params['minPrice']) && !empty($params['maxPrice'])) {
            $query = $query->whereBetween('products.price', [$params['minPrice'], $params['maxPrice']]);

        }

        if (is_numeric($params['orderType']) && is_numeric($params['order'])) {
            $orderColumn = '';

            switch ($params['orderType']) {
                case 'newst':
                    $orderColumn = 'products.created_at';
                    break;
                case 'price':
                    $orderColumn = 'products.price';
                    break;
                case 'popularity':
                    $orderColumn = 'sum_boughts';
            }

            $query = $query->orderBy($orderColumn, $params['order'] ?? 'desc');
        }

        return $query;
    }
}
