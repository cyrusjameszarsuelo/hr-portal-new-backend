<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubfunctionPosition extends Model
{

    use SoftDeletes;

    public function functionPosition()
    {
        return $this->belongsTo(FunctionPosition::class);
    }

    public function subfunctionDescriptions()
    {
        return $this->hasMany(SubfunctionDescription::class);
    }

    public function jobProfileKras()
    {
        return $this->hasMany(JobProfileKra::class);
    }
}
