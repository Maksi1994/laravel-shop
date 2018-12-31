<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Order extends Model
{
    public $timestamps = true;
    public $guarded = [];

    public function products() {
        return $this->belongsToMany(Product::class);
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}
