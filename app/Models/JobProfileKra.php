<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobProfileKra extends Model
{

    public function subfunctionPosition()
    {
        return $this->belongsTo(SubfunctionPosition::class);
    }
}
