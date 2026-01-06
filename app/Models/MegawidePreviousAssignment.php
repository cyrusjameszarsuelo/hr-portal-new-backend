<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MegawidePreviousAssignment extends Model
{
    use SoftDeletes;

    protected $table = 'a_megawide_previous_assignments';

    protected $fillable = [
        'megawide_work_experience_id',
        'sbu_id',
        'worked_in_megawide',
        'previous_department',
        'previous_job_title',
        'previous_role_start_date',
        'end_of_assignment',
    ];

    protected $casts = [
        'worked_in_megawide' => 'boolean',
        'previous_role_start_date' => 'date',
        'end_of_assignment' => 'date',
    ];

    public function megawideWorkExperience()
    {
        return $this->belongsTo(MegawideWorkExperience::class, 'megawide_work_experience_id');
    }
}
