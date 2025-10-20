<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubfunctionDescription extends Model
{
    use SoftDeletes;

    public function functionParameters()
    {
        // A subfunction description can have multiple function parameters.
        // Return a hasMany relationship so callers can access all parameters.
        return $this->hasMany(FunctionParameter::class);
    }
}
