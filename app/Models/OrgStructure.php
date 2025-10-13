<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrgStructure extends Model
{

    use SoftDeletes;

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
        'is_active',
        'image',
    ];
}
