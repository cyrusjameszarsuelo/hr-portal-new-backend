<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportingRelationship extends Model
{
    use SoftDeletes;
    
    protected $table = 'jp_reporting_relationships';
}
