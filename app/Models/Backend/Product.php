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

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function promotions() {
        return $this->belongsToMany(Promotion::class)->withTimestamps();
    }

    public function scopeFilter($query, $params) {
        if (!empty($params['categoryId'])  && is_numeric($params['categoryId'])) {
            $query = $query->where('category_id', $params['categoryId']);
        }

        if (!empty($params['priceMin']) && !empty($params['priceMax'])) {
            $query = $query->whereBetween('price', [$params['priceMin'], $params['priceMax']]);
        }

        return $query;
    }
}
