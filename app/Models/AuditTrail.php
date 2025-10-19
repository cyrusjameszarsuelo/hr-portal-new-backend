<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    protected $fillable = [
        'module',
        'user_id',
        'old_data',
        'new_data',
        'action',
    ];
}
