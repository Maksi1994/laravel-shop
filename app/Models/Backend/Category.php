<?php

namespace App\Models\Backend;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = true;
    public $guarded = [];

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function parent() {
        return $this->belongsTo(static::class);
    }

    public static function getCategories(Request $request) {

    }

}
