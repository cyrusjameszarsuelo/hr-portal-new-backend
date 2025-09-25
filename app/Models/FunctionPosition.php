<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FunctionPosition extends Model
{

    use SoftDeletes;
    
    public function subfunctionPositions()
    {
        return $this->hasMany(SubfunctionPosition::class);
    }
}
