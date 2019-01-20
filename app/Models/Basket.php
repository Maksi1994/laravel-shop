<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{

    public function products() {
        return $this->belongsToMany(Product::class, 'basket_product', 'basket_id', 'product_id');
    }

    public function customer() {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }
}
