<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    public $fillable = ['name', 'image'];
    public $timestamps = true;

    public function products() {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
