<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'department',
        'sbu_id',
    ];

    public function orgStructures()
    {
        return $this->hasMany(OrgStructure::class, 'department_id');
    }

    public function sbu()
    {
        return $this->belongsTo(SBU::class, 'sbu_id');
    }
}
