<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use SoftDeletes;

    protected $table = 'a_skills';

    protected $fillable = [
        'about_id',
        'skill',
    ];

    public function about()
    {
        return $this->belongsTo(About::class, 'about_id');
    }
}
