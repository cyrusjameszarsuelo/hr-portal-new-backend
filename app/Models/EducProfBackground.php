<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducProfBackground extends Model
{
    use SoftDeletes;
    protected $table = 'a_educ_prof_backgrounds';

    protected $fillable = [
        'about_id',
        'education_level',
        'school_attended',
        'degree_program_course',
        'academic_achievements',
        'year_started',
        'year_ended',
        'is_current',
    ];

    protected $casts = [
        'is_current' => 'boolean',
    ];

    public function about()
    {
        return $this->belongsTo(About::class, 'about_id');
    }
}
