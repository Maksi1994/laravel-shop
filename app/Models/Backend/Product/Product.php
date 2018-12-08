<?php

namespace App\Models\Backend\Product;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = true;
    public $fillable = ['name', 'image', 'category_id'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function promotions() {
        return $this->belongsToMany(Promotion::class);
    }
}
