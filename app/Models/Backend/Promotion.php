<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    public $guarded = [];
    public $timestamps = true;

    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }

    public function scopeFilter($query, $params)
    {
        $orderColumn = 'created_at';
        $order = 'desc';

        $query->when((!empty($params['beginDate']) && !empty($params['endDate'])), function ($q) use ($params) {
            return $q->whereRaw('UNIX_TIMESTAMP(created_at) BETWEEN ? AND ? ', [$params['beginDate'], $params['endDate']]);
        });

        if (!empty($params['orderType']) && !empty($params['order'])) {
            $order = $params['order'];

            switch ($params['orderType']) {
                case 'newest':
                    $orderColumn = 'created_at';
                    break;
                case 'productsCount':
                    $orderColumn = 'products_count';
            }
        }

        return $query->orderBy($orderColumn, $order);
    }

    static function attachProducts($request) {
        $promotionProducts = [];

        collect($request->products)->eachSpread(function($product) use(&$promotionProducts) {
            $promotionProducts[$product->id] = [
                'end_date' => $product->endDate
            ];
        });

        self::find($request->id)->sync($promotionProducts);
    }
}
