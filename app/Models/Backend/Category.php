<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = true;
    public $fillable = ['name', 'image', 'category_id'];

    public function products() {
        return $this->hasMany(Product::class);
    }
}
