<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $table = 'a_abouts';

    protected $fillable = [
        'org_structure_id',
        'employee_id',
        'nickname',
        'birth_date',
        'gender',
        'civil_status',
        'phone_number',
        'blood_type',
        'emergency_contact_name',
        'relationship_to_employee',
        'emergency_contact_number',
        'citizenship',
        'birth_place',
        'highest_educational_attainment',
        'current_address_street',
        'current_address_city',
        'current_address_region',
        'current_address_zip_code',
        'permanent_address_street',
        'permanent_address_city',
        'permanent_address_region',
        'permanent_address_zip_code',
    ];

    public function orgStructure()
    {
        return $this->belongsTo(OrgStructure::class, 'org_structure_id');
    }

    public function interests()
    {
        return $this->hasMany(Interest::class, 'a_about_id');
    }

    public function skills()
    {
        return $this->hasMany(Skill::class, 'a_about_id');
    }

    public function educProfBackgrounds()
    {
        return $this->hasMany(EducProfBackground::class, 'a_about_id');
    }

    public function licAndCerts()
    {
        return $this->hasMany(LicAndCert::class, 'a_about_id');
    }

    public function megawideWorkExperience()
    {
        return $this->hasOne(MegawideWorkExperience::class, 'a_about_id');
    }

    public function prevWorkExperiences()
    {
        return $this->hasMany(PrevWorkExperience::class, 'a_about_id');
    }

    public function technicalProficiencies()
    {
        return $this->hasMany(TechnicalProficiency::class, 'a_about_id');
    }

    public function languageProficiencies()
    {
        return $this->hasMany(LanguageProficiency::class, 'a_about_id');
    }

    /**
     * Get the primary function position through the relationship chain
     * About -> OrgStructure -> JobProfile -> JobDescriptions (first) -> SubfunctionPosition -> FunctionPosition
     */
    public function getFunctionAttribute()
    {
        $jobProfile = $this->orgStructure?->jobProfile;
        
        if (!$jobProfile) {
            return null;
        }

        // Get the first job description's function
        $firstJobDescription = $jobProfile->jobDescriptions->first();
        
        return $firstJobDescription
            ?->subfunctionPosition
            ?->functionPosition;
    }

    /**
     * Helper to get all unique functions from job descriptions
     * About -> OrgStructure -> JobProfile -> JobDescriptions -> SubfunctionPositions -> FunctionPositions
     */
    public function getFunctionsFromJobDescriptionsAttribute()
    {
        if (!$this->orgStructure?->jobProfile) {
            return collect([]);
        }

        return $this->orgStructure->jobProfile
            ->jobDescriptions
            ->map(fn($jd) => $jd->subfunctionPosition?->functionPosition)
            ->filter()
            ->unique('id')
            ->values();
    }
}
