<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MegawideWorkExperience extends Model
{
    protected $table = 'a_megawide_work_experiences';

    public $timestamps = false; // table does not have created_at/updated_at

    protected $fillable = [
        'a_about_id',
        'position',
        'department',
        'rank',
        'start_date',
    ];

    public function about()
    {
        return $this->belongsTo(About::class, 'a_about_id');
    }
}
