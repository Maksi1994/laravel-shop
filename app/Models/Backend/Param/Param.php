<?php

namespace App\Models\Backend\Param;

use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    protected $fillable = ['name'];
    public $timestamps = true;

    public function values()
    {
        return $this->hasMany(Value::class);
    }
}
