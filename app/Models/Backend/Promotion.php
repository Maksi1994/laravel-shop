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

    public function scopeAttachProducts($query, $params) {
        $promotionProducts = [];

        collect($params['products'])->eachSpread(function($product) use(&$promotionProducts) {
            $promotionProducts[$product->id] = [
                'end_date' => $product->endDate
            ];
        });

        $query::find($params['id'])->sync($promotionProducts);
    }

    public function scopeList($query, $params) {
        $orderColumn = 'created_at';
        $order = 'desc';

        $query = $query->withCount('products');

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

    public function types() {
        return $this->belongsToMany(PromotionType::class,'product_promotion', 'promotion_type_id', 'id');
    }
}
