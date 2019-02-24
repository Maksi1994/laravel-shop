<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class PromotionType extends Model
{
    protected $guarded = [];
    public $timestamps = true;

    public function promotions() {
        return $this->belongsToMany(Promotion::class,'product_promotion', 'promotion_d', 'id');
    }
}
