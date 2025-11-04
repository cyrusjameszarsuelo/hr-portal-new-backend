<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileKra extends Model
{
    use SoftDeletes;

    /**
     * Explicit table name to match renamed migration table.
     */
    protected $table = 'jp_description_kras';
}
