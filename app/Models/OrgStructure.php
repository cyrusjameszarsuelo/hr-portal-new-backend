<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrgStructure extends Model
{

    use SoftDeletes;

    protected static function booted()
    {
        static::deleting(function ($orgNode) {
            if (!$orgNode->isForceDeleting()) {
                $orgNode->children()->update(['pid' => null]);
            }
        });
    }

    protected $fillable = [
        'is_active',
        'firstname',
        'lastname',
        'nickname',
        'name',
        'email',
        'position_title_id',
        'reporting',
        'emp_no',
        'level_id',
        'department_id',
        'sbu_id',
        'dept_head',
        'is_admin',
        'company',
        'image',
        'pid',
        'user_id'
    ];

    public function parent()
    {
        return $this->belongsTo(OrgStructure::class, 'pid');
    }

    public function children()
    {
        return $this->hasMany(OrgStructure::class, 'pid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jobProfile()
    {
        return $this->hasOne(JobProfile::class, 'org_structure_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function positionTitle()
    {
        return $this->belongsTo(PositionTitle::class, 'position_title_id');
    }

    public function sbu()
    {
        return $this->belongsTo(SBU::class, 'sbu_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }
}
