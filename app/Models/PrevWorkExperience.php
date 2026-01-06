<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrevWorkExperience extends Model
{
    use SoftDeletes;

    protected $table = 'a_prev_work_experiences';

    protected $fillable = [
        'about_id',
        'company',
        'job_title',
        'job_level',
        'start_date',
        'end_date',
    ];

    public function about()
    {
        return $this->belongsTo(About::class, 'about_id');
    }
}
