<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LevelOfAuthority extends Model
{
    use SoftDeletes;
    
    protected $table = 'jp_level_of_authorities';
}
