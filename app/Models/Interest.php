<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interest extends Model
{
    use SoftDeletes;

    protected $table = 'a_interests';

    protected $fillable = [
        'about_id',
        'interest',
    ];

    public function about()
    {
        return $this->belongsTo(About::class, 'about_id');
    }
}
