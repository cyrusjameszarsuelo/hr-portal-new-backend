<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LanguageProficiency extends Model
{
    use SoftDeletes;

    protected $table = 'a_language_proficiencies';

    protected $fillable = [
        'a_about_id',
        'language',
        'written',
        'w_prof',
        'spoken',
        's_prof',
    ];

    protected $casts = [
        'written' => 'boolean',
        'spoken' => 'boolean',
    ];

    public function about()
    {
        return $this->belongsTo(About::class, 'a_about_id');
    }
}
