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
        'business_unit',
        'company',
        'department',
        'email',
        'emp_no',
        'firstname',
        'lastname',
        'level',
        'nickname',
        'position_title',
        'name',
        'reporting',
        'pid',
        'user_id',
        'is_active',
        'image',
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
}
