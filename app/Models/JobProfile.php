<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobProfile extends Model
{
    use SoftDeletes;
    
    protected $table = 'jp_profiles';
    
    public function jobDescriptions()
    {
        return $this->hasMany(JobDescription::class);
    }

    public function jobSpecifications()
    {
        return $this->hasOne(JobSpecification::class);
    }

    public function levelsOfAuthority()
    {
        return $this->hasOne(LevelOfAuthority::class);
    }

    public function reportingRelationships()
    {
        return $this->hasOne(ReportingRelationship::class);
    }

    public function jobPerformanceStandards()
    {
        return $this->hasMany(JobPerformanceStandard::class);
    }

    public function subfunctionPosition()
    {
        return $this->belongsTo(SubfunctionPosition::class);
    }

    public function reportingTo()
    {
        return $this->belongsTo(OrgStructure::class, 'reporting_to', 'id');
    }
}
