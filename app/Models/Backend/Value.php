<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    public $guarded = [];
    public $timestamps = true;

    public function param() {
        return $this->belongsTo(Param::class);
    }
}
