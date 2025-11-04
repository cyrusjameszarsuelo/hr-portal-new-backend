<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobDescription extends Model
{
    use SoftDeletes;
    
    protected $table = 'jp_descriptions';
    
    public function jobProfile()
    {
        return $this->belongsTo(JobProfile::class);
    }

    public function profileKras()
    {
        return $this->hasMany(ProfileKra::class);
    }

    public function subfunctionPosition()
    {
        return $this->belongsTo(\App\Models\SubfunctionPosition::class);
    }

    public function jobProfileKra()
    {
        return $this->belongsTo(JobProfileKra::class);
    }
}
