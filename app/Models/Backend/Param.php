<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;


class Param extends Model
{
    public $guarded = [];
    public $timestamps = true;

    public function values()
    {
        return $this->hasMany(Value::class);
    }
}
