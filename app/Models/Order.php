<?php

namespace App\Models;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Order extends Model
{
    public $timestamps = true;
    public $guarded = [];

    public function products() {
        return $this->belongsToMany(Product::class)->withPivot(['price', 'name']);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
