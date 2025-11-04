<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrevWorkExperience extends Model
{
    use SoftDeletes;

    protected $table = 'a_prev_work_experiences';

    protected $fillable = [
    'a_about_id',
    'position',
    'megawide_position_equivalent',
    'department',
    'company',
    'rank',
    'functions_jd',
    'start_date',
    'end_date',
    ];

    public function about()
    {
        return $this->belongsTo(About::class, 'a_about_id');
    }
}
