<?php

namespace App\Models\Backend\Param;

use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    protected $fillable = ['name', 'param_id'];
    public $timestamps = true;

    public function param() {
        return $this->belongsTo(Param::class);
    }
}
