<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducProfBackground extends Model
{
    use SoftDeletes;
    protected $table = 'a_educ_prof_backgrounds';

    protected $fillable = [
        'a_about_id',
        'education_level',
        'school',
        'course',
        'start_date',
        'end_date',
        'honors',
    ];

    public function about()
    {
        return $this->belongsTo(About::class, 'a_about_id');
    }

    public function licAndCerts()
    {
        return $this->hasMany(LicAndCert::class, 'a_educ_prof_background_id');
    }
}
