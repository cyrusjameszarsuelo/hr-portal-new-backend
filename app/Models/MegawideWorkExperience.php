<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MegawideWorkExperience extends Model
{
    protected $table = 'a_megawide_work_experiences';

    public $timestamps = false; // table does not have created_at/updated_at

    protected $fillable = [
        'about_id',
        'position_title_id',
        'department_id',
        'sbu_id',
        'level_id',
        'employment_status',
        'current_role_start_date',
        'current_role_end_date',
        'is_current',
    ];

    protected $casts = [
        'current_role_start_date' => 'date',
        'current_role_end_date' => 'date',
        'is_current' => 'boolean',
    ];

    public function about()
    {
        return $this->belongsTo(About::class, 'about_id');
    }

    public function previousAssignments()
    {
        return $this->hasMany(MegawidePreviousAssignment::class, 'megawide_work_experience_id');
    }

    public function subfunctionPositions()
    {
        return $this->belongsToMany(SubfunctionPosition::class, 'a_megawide_work_experience_function', 'megawide_work_experience_id', 'subfunction_position_id')->withTimestamps();
    }
}
