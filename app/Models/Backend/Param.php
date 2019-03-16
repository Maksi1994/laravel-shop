<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;


class Param extends Model
{
    public $guarded = [];
    public $timestamps = true;

    public function values()
    {
        return $this->hasMany(Value::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'param_product_value', 'product_id', 'id');
    }

    public function scopeGetList($query, $request)
    {
        $order = $request->get('order') ?? 'desc';

        switch ($request->get('filter')) {
            case 'popularity':
                return $query->withCount('products')->orderBy('products_count', $order);
            case 'values_count':
                return $query->withCount('values')->orderBy('values_count', $order);
        }
    }

    public function attachProducts($query, $request)
    {
        $promotionProducts = [];

        collect($params['products'])->eachSpread(function($product) use(&$promotionProducts) {
            $promotionProducts[$product->id] = [
                'end_date' => $product->endDate
            ];
        });
    }

    public function attachValues($query, $request)
    {

    }

    public function scopeGetOne($query)
    {
        return $query->with(['products', 'products.category', 'value']);
    }

    public function getProductsValues($query, $request)
    {
        return $query->with(['product.paramValues'])->find($request->id);
    }
}
