<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use SoftDeletes;

    protected $table = 'a_skills';

    protected $fillable = [
        'a_about_id',
        'skill',
    ];

    public function about()
    {
        return $this->belongsTo(About::class, 'a_about_id');
    }
}
