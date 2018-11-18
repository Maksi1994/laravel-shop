<?php

namespace App\Models\Backend\Product;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = true;
    public $fillable = ['name', 'image', 'category_id'];

    public function products() {
        $this->hasMany(Product::class);
    }
}
