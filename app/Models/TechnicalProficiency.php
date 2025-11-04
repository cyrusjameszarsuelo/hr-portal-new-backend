<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechnicalProficiency extends Model
{
    use SoftDeletes;

    protected $table = 'a_technical_proficiencies';

    protected $fillable = [
        'a_about_id',
        'skills',
        'proficiency',
    ];

    public function about()
    {
        return $this->belongsTo(About::class, 'a_about_id');
    }
}
