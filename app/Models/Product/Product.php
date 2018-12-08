<?php
namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    public function category() { 
        return $this->belongsTo(Category::class);
    }
} 
