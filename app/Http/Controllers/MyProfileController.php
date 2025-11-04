<?php

namespace App\Http\Controllers;

use App\Models\JobDescription;
use App\Models\JobPerformanceStandard;
use App\Models\JobProfile;
use App\Models\JobSpecification;
use App\Models\LevelOfAuthority;
use App\Models\OrgStructure;
use App\Models\ProfileKra;
use App\Models\ReportingRelationship;
use App\Models\SubfunctionPosition;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MyProfileController extends Controller
{

    /**
     * Return edit payload for a given OrgStructure ID in the requested shape
     */
    public function editData(string $id)
    {
        $org = OrgStructure::with([
            'jobProfile',
            'jobProfile.jobDescriptions.subfunctionPosition',
            'jobProfile.jobDescriptions.profileKras',
            'jobProfile.jobPerformanceStandards',
            'jobProfile.jobSpecifications',
            'jobProfile.reportingRelationships',
            'jobProfile.levelsOfAuthority',
        ])->find($id);

        if (!$org) {
            return response()->json(['message' => 'Org structure not found'], 404);
        }

        $jp = $org->jobProfile;

        // Job descriptions with nested profile_kra and subfunction
        $jobDescriptions = [];
        if ($jp && $jp->jobDescriptions) {
            $jobDescriptions = $jp->jobDescriptions->map(function ($jd) {
                $subfunction = null;
                if ($jd->subfunctionPosition) {
                    $subfunction = [
                        'id' => $jd->subfunctionPosition->id,
                        'name' => $jd->subfunctionPosition->name,
                    ];
                }
                return [
                    'id' => $jd->id,
                    'kra' => $jd->kra,
                    'description' => $jd->description,
                    'subfunction' => $subfunction,
                    'profile_kra' => ($jd->profileKras ? $jd->profileKras->map(function ($pk) {
                        return [
                            'id' => $pk->id,
                            'kra_description' => $pk->kra_description,
                            'description' => $pk->deliverables,
                        ];
                    })->values()->toArray() : []),
                ];
            })->values()->toArray();
        }

        // Job performance standards
        $jps = [];
        if ($jp && $jp->jobPerformanceStandards) {
            $jps = $jp->jobPerformanceStandards->map(function ($std) {
                $vals = $std->values;
                if (is_string($vals)) {
                    $decoded = json_decode($vals, true);
                    $vals = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : (strlen($vals) ? [$vals] : []);
                } elseif (!is_array($vals)) {
                    $vals = [];
                }
                return [
                    'id' => $std->id,
                    'name' => $std->name,
                    'values' => array_values($vals),
                ];
            })->values()->toArray();
        }

        // Reporting relationships (raw object)
        $rr = null;
        if ($jp && $jp->reportingRelationships) {
            $rr = [
                'primary' => $jp->reportingRelationships->primary,
                'secondary' => $jp->reportingRelationships->secondary,
                'tertiary' => $jp->reportingRelationships->tertiary,
            ];
        }

        // Levels of authority (snake_case keys)
        $loa = null;
        if ($jp && $jp->levelsOfAuthority) {
            $loa = [
                'line_authority' => $jp->levelsOfAuthority->line_authority,
                'staff_authority' => $jp->levelsOfAuthority->staff_authority,
            ];
        }

        // Job specifications (snake_case keys)
        $js = null;
        if ($jp && $jp->jobSpecifications) {
            $js = [
                'educational_background' => $this->firstOrString($jp->jobSpecifications->educational_background),
                'license_requirement' => $this->firstOrString($jp->jobSpecifications->license_requirement),
                'work_experience' => $this->firstOrString($jp->jobSpecifications->work_experience),
            ];
        }

        $result = [
            'position_title' => $org->position_title,
            'department' => $org->department,
            'reporting' => $org->reporting,
            'job_profile' => [
                'job_purpose' => $jp?->job_purpose,
                'job_descriptions' => $jobDescriptions,
                'job_performance_standards' => $jps,
                'reporting_relationships' => $rr,
                'levels_of_authority' => $loa,
                'job_specifications' => $js,
            ],
        ];

        return response()->json($result);
    }

    // Helper: when a column may store JSON array or a plain string, return the string (first value)
    private function firstOrString($value)
    {
        if ($value === null || $value === '')
            return '';
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return count($decoded) ? (string) $decoded[0] : '';
            }
            return $value;
        }
        if (is_array($value)) {
            return count($value) ? (string) $value[0] : '';
        }
        return (string) $value;
    }

    public function show(string $id)
    {
        $orgStructure = OrgStructure::with([
            'jobProfile',
            'jobProfile.reportingTo',
            'jobProfile.jobDescriptions',
            'jobProfile.jobDescriptions.jobProfileKra',
            'jobProfile.jobDescriptions.subfunctionPosition',
            'jobProfile.jobDescriptions.profileKras',
            'jobProfile.jobPerformanceStandards',
            'jobProfile.jobSpecifications',
            'jobProfile.reportingRelationships',
            'jobProfile.levelsOfAuthority',
            'jobProfile.subfunctionPosition',
        ])->find($id);

        // Convert to array for manipulation
        $orgStructureArray = $orgStructure ? $orgStructure->toArray() : null;

        if ($orgStructureArray && isset($orgStructureArray['job_profile'])) {
            // Transform jobPerformanceStandards if they exist
            if (isset($orgStructureArray['job_profile']['job_performance_standards'])) {
                $formattedStandards = [
                    'title' => 'Job Performance Standards',
                    'items' => collect($orgStructureArray['job_profile']['job_performance_standards'])->map(function ($standard) {
                        return [
                            'name' => ucfirst($standard['name']), // Capitalize first letter
                            'values' => json_decode($standard['values'], true) // Decode JSON string to array
                        ];
                    })->toArray()
                ];
                $orgStructureArray['job_profile']['job_performance_standards'] = $formattedStandards;
            }

            // Transform jobSpecifications if they exist
            if (isset($orgStructureArray['job_profile']['job_specifications'])) {
                $specs = $orgStructureArray['job_profile']['job_specifications'];

                $formattedSpecifications = [
                    'title' => 'Job Specifications',
                    'items' => [
                        [
                            'name' => 'Educational Background',
                            'values' => $this->parseSpecificationValue($specs['educational_background'] ?? '')
                        ],
                        [
                            'name' => 'License Requirement',
                            'values' => $this->parseSpecificationValue($specs['license_requirement'] ?? '')
                        ],
                        [
                            'name' => 'Years of Work Experience',
                            'values' => $this->parseSpecificationValue($specs['work_experience'] ?? '')
                        ],
                    ]
                ];
                $orgStructureArray['job_profile']['job_specifications'] = $formattedSpecifications;
            }

            // Transform levelsOfAuthority if they exist
            if (isset($orgStructureArray['job_profile']['levels_of_authority'])) {
                $levels = $orgStructureArray['job_profile']['levels_of_authority'];

                $formattedLevels = [
                    'title' => 'Levels of Authority',
                    'items' => [
                        [
                            'name' => 'Line Authority',
                            'values' => $this->parseSpecificationValue($levels['line_authority'] ?? '')
                        ],
                        [
                            'name' => 'Staff Authority',
                            'values' => $this->parseSpecificationValue($levels['staff_authority'] ?? '')
                        ],
                    ]
                ];
                $orgStructureArray['job_profile']['levels_of_authority'] = $formattedLevels;
            }

            // Transform reportingRelationships if they exist
            if (isset($orgStructureArray['job_profile']['reporting_relationships'])) {
                $relations = $orgStructureArray['job_profile']['reporting_relationships'];

                $formattedRelationships = [
                    'title' => 'Reporting Relationships',
                    'items' => [
                        [
                            'name' => 'Primary / Direct Reporting Relationship',
                            'values' => $this->parseSpecificationValue($relations['primary'] ?? '')
                        ],
                        [
                            'name' => 'Functional Reporting Relationship',
                            'values' => $this->parseSpecificationValue($relations['secondary'] ?? '')
                        ],
                        [
                            'name' => 'Administrative Reporting Relationship',
                            'values' => $this->parseSpecificationValue($relations['tertiary'] ?? '')
                        ],
                    ]
                ];
                $orgStructureArray['job_profile']['reporting_relationships'] = $formattedRelationships;
            }
        }

        return response()->json($orgStructureArray);
    }

    /**
     * Parse specification value - handles both JSON array strings and plain strings
     */
    private function parseSpecificationValue($value)
    {
        if (empty($value)) {
            return [];
        }

        // Try to decode as JSON first
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        // If not JSON, return as single-item array
        return [$value];
    }

    public function store(Request $request)
    {
        $request->validate([
            'org_structure_id' => 'required|exists:org_structures,id',
            'job_purpose' => 'required|string',
            // job_performance_standards array with optional IDs for updates
            'job_performance_standards' => 'sometimes|array',
            'job_performance_standards.*.id' => 'sometimes|exists:job_performance_standards,id',
            'job_performance_standards.*.name' => 'required|string',
            'job_performance_standards.*.values' => 'required|array',
            'job_performance_standards.*.values.*' => 'string',
            // reporting_relationships object
            'reporting_relationships' => 'sometimes|array',
            'reporting_relationships.primary' => 'sometimes|string',
            'reporting_relationships.secondary' => 'sometimes|string',
            'reporting_relationships.tertiary' => 'sometimes|string',
            // levels_of_authority object
            'levels_of_authority' => 'sometimes|array',
            'levels_of_authority.line_authority' => 'sometimes|nullable|string',
            'levels_of_authority.staff_authority' => 'sometimes|nullable|string',
            // job_specifications object
            'job_specifications' => 'sometimes|array',
            'job_specifications.educational_background' => 'sometimes|nullable|string',
            'job_specifications.license_requirement' => 'sometimes|nullable|string',
            'job_specifications.work_experience' => 'sometimes|nullable|string',
            // job_descriptions array with nested subfunction and profile_kra
            'job_descriptions' => 'sometimes|array',
            'job_descriptions.*.id' => 'sometimes|exists:job_descriptions,id',
            'job_descriptions.*.kra' => 'required|exists:job_profile_kras,id',
            'job_descriptions.*.description' => 'required|string',
            'job_descriptions.*.subfunction' => 'nullable|array',
            'job_descriptions.*.subfunction.id' => 'required_with:job_descriptions.*.subfunction|exists:subfunction_positions,id',
            'job_descriptions.*.profile_kra' => 'sometimes|array',
            'job_descriptions.*.profile_kra.*.id' => 'sometimes|exists:jp_description_kras,id',
            'job_descriptions.*.profile_kra.*.kra_description' => 'required|string',
            'job_descriptions.*.profile_kra.*.description' => 'required|string',
        ]);

        $org_structure = OrgStructure::find($request->input('org_structure_id'));

        // Find existing profile or create new
        $job_profile = JobProfile::where('org_structure_id', $request->input('org_structure_id'))->first();
        $isUpdate = $job_profile !== null;
        $oldData = $isUpdate ? $job_profile->toArray() : null;

        if (!$job_profile) {
            $job_profile = new JobProfile();
        }

        $job_profile->org_structure_id = $request->input('org_structure_id');
        $job_profile->reporting_to = $org_structure->id;
        $job_profile->job_purpose = $request->input('job_purpose');
        $job_profile->save();

        // Audit trail
        if ($request->has('user_id')) {
            auditLog('JobProfile', $isUpdate ? 'edit' : 'create', $oldData, $job_profile->toArray(), $request->input('user_id'));
        }

        // Handle job_performance_standards with update-or-create
        if ($request->has('job_performance_standards')) {
            $standards = $request->input('job_performance_standards', []);
            $standardIds = [];

            foreach ($standards as $stdData) {
                if (isset($stdData['id'])) {
                    // Update existing
                    $standard = JobPerformanceStandard::find($stdData['id']);
                    if ($standard && $standard->job_profile_id == $job_profile->id) {
                        $oldStdData = $standard->toArray();
                        $standard->name = $stdData['name'];
                        $standard->values = json_encode(array_values($stdData['values']));
                        $standard->save();
                        $standardIds[] = $standard->id;

                        if ($request->has('user_id')) {
                            auditLog('JobPerformanceStandard', 'edit', $oldStdData, $standard->toArray(), $request->input('user_id'));
                        }
                    }
                } else {
                    // Create new
                    $standard = new JobPerformanceStandard();
                    $standard->job_profile_id = $job_profile->id;
                    $standard->name = $stdData['name'];
                    $standard->values = json_encode(array_values($stdData['values']));
                    $standard->save();
                    $standardIds[] = $standard->id;

                    if ($request->has('user_id')) {
                        auditLog('JobPerformanceStandard', 'create', null, $standard->toArray(), $request->input('user_id'));
                    }
                }
            }

            // Delete orphaned standards
            JobPerformanceStandard::where('job_profile_id', $job_profile->id)
                ->whereNotIn('id', $standardIds)
                ->delete();
        }

        // Handle reporting_relationships (single record)
        if ($request->has('reporting_relationships')) {
            $relationships = $request->input('reporting_relationships');
            $reportingRelationship = ReportingRelationship::where('job_profile_id', $job_profile->id)->first();
            $isRRUpdate = $reportingRelationship !== null;
            $oldRRData = $isRRUpdate ? $reportingRelationship->toArray() : null;

            if (!$reportingRelationship) {
                $reportingRelationship = new ReportingRelationship();
                $reportingRelationship->job_profile_id = $job_profile->id;
            }

            $reportingRelationship->primary = $relationships['primary'] ?? '';
            $reportingRelationship->secondary = $relationships['secondary'] ?? '';
            $reportingRelationship->tertiary = $relationships['tertiary'] ?? '';
            $reportingRelationship->save();

            if ($request->has('user_id')) {
                auditLog('ReportingRelationship', $isRRUpdate ? 'edit' : 'create', $oldRRData, $reportingRelationship->toArray(), $request->input('user_id'));
            }
        }

        // Handle levels_of_authority (single record)
        if ($request->has('levels_of_authority')) {
            $authorities = $request->input('levels_of_authority');
            $levelOfAuthority = LevelOfAuthority::where('job_profile_id', $job_profile->id)->first();
            $isLOAUpdate = $levelOfAuthority !== null;
            $oldLOAData = $isLOAUpdate ? $levelOfAuthority->toArray() : null;

            if (!$levelOfAuthority) {
                $levelOfAuthority = new LevelOfAuthority();
                $levelOfAuthority->job_profile_id = $job_profile->id;
            }

            $levelOfAuthority->line_authority = $authorities['line_authority'] ?? '';
            $levelOfAuthority->staff_authority = $authorities['staff_authority'] ?? '';
            $levelOfAuthority->save();

            if ($request->has('user_id')) {
                auditLog('LevelOfAuthority', $isLOAUpdate ? 'edit' : 'create', $oldLOAData, $levelOfAuthority->toArray(), $request->input('user_id'));
            }
        }

        // Handle job_specifications (single record)
        if ($request->has('job_specifications')) {
            $specifications = $request->input('job_specifications');
            $jobSpecification = JobSpecification::where('job_profile_id', $job_profile->id)->first();
            $isJSUpdate = $jobSpecification !== null;
            $oldJSData = $isJSUpdate ? $jobSpecification->toArray() : null;

            if (!$jobSpecification) {
                $jobSpecification = new JobSpecification();
                $jobSpecification->job_profile_id = $job_profile->id;
            }

            $jobSpecification->educational_background = is_array($specifications['educational_background'] ?? null)
                ? json_encode($specifications['educational_background'])
                : ($specifications['educational_background'] ?? '');

            $jobSpecification->license_requirement = is_array($specifications['license_requirement'] ?? null)
                ? json_encode($specifications['license_requirement'])
                : ($specifications['license_requirement'] ?? '');

            $jobSpecification->work_experience = is_array($specifications['work_experience'] ?? null)
                ? json_encode($specifications['work_experience'])
                : ($specifications['work_experience'] ?? '');

            $jobSpecification->values = '';
            $jobSpecification->save();

            if ($request->has('user_id')) {
                auditLog('JobSpecification', $isJSUpdate ? 'edit' : 'create', $oldJSData, $jobSpecification->toArray(), $request->input('user_id'));
            }
        }

        // Handle job_descriptions with nested profile_kra and subfunction
        if ($request->has('job_descriptions')) {
            $descriptions = $request->input('job_descriptions');
            $descriptionIds = [];

            foreach ($descriptions as $descData) {
                $subfunctionId = isset($descData['subfunction']['id']) ? $descData['subfunction']['id'] : null;
                if (isset($descData['id'])) {
                    // Update existing JobDescription
                    $jobDescription = JobDescription::find($descData['id']);
                    if ($jobDescription && $jobDescription->job_profile_id == $job_profile->id) {
                        $oldJDData = $jobDescription->toArray();
                        $jobDescription->job_profile_kra_id = $descData['kra'];
                        $jobDescription->description = $descData['description'];
                        $jobDescription->subfunction_position_id = $subfunctionId;
                        $jobDescription->save();
                        $descriptionIds[] = $jobDescription->id;

                        if ($request->has('user_id')) {
                            auditLog('JobDescription', 'edit', $oldJDData, $jobDescription->toArray(), $request->input('user_id'));
                        }
                    }
                } else {
                    // Create new JobDescription
                    $jobDescription = new JobDescription();
                    $jobDescription->job_profile_id = $job_profile->id;
                    $jobDescription->job_profile_kra_id = $descData['kra'];
                    $jobDescription->description = $descData['description'];
                    $jobDescription->subfunction_position_id = $subfunctionId;
                    $jobDescription->save();
                    $descriptionIds[] = $jobDescription->id;

                    if ($request->has('user_id')) {
                        auditLog('JobDescription', 'create', null, $jobDescription->toArray(), $request->input('user_id'));
                    }
                }

                // Handle nested profile_kra
                if (isset($descData['profile_kra']) && is_array($descData['profile_kra'])) {
                    $kraIds = [];

                    foreach ($descData['profile_kra'] as $kraData) {
                        if (isset($kraData['id'])) {
                            // Update existing ProfileKra
                            $profileKra = ProfileKra::find($kraData['id']);
                            if ($profileKra && $profileKra->job_description_id == $jobDescription->id) {
                                $oldPKData = $profileKra->toArray();
                                $profileKra->kra_description = $kraData['kra_description'];
                                $profileKra->deliverables = $kraData['description'];
                                $profileKra->save();
                                $kraIds[] = $profileKra->id;

                                if ($request->has('user_id')) {
                                    auditLog('ProfileKra', 'edit', $oldPKData, $profileKra->toArray(), $request->input('user_id'));
                                }
                            }
                        } else {
                            // Create new ProfileKra
                            $profileKra = new ProfileKra();
                            $profileKra->job_description_id = $jobDescription->id;
                            $profileKra->kra_description = $kraData['kra_description'];
                            $profileKra->deliverables = $kraData['description'];
                            $profileKra->save();
                            $kraIds[] = $profileKra->id;

                            if ($request->has('user_id')) {
                                auditLog('ProfileKra', 'create', null, $profileKra->toArray(), $request->input('user_id'));
                            }
                        }
                    }

                    // Delete orphaned ProfileKras
                    ProfileKra::where('job_description_id', $jobDescription->id)
                        ->whereNotIn('id', $kraIds)
                        ->delete();
                }
            }

            // Delete orphaned JobDescriptions
            JobDescription::where('job_profile_id', $job_profile->id)
                ->whereNotIn('id', $descriptionIds)
                ->delete();
        }

        return response()->json([
            'message' => $isUpdate ? 'Job profile updated successfully' : 'Job profile created successfully',
            'data' => [
                'profile' => $job_profile,
            ]
        ], $isUpdate ? 200 : 201);
    }

    public function edit(string $id)
    {
        $org = OrgStructure::with([
            'jobProfile',
            'jobProfile.jobDescriptions',
            'jobProfile.jobDescriptions',
            'jobProfile.jobDescriptions.jobProfileKra',
            'jobProfile.jobDescriptions.profileKras',
            'jobProfile.jobPerformanceStandards',
            'jobProfile.jobSpecifications',
            'jobProfile.reportingRelationships',
            'jobProfile.levelsOfAuthority',
        ])->find($id);

        if (!$org) {
            return response()->json(['message' => 'Org structure not found'], 404);
        }

        $jp = $org->jobProfile;

        // Subfunction info
        $subfunction = null;
        if ($jp && $jp->subfunction_position_id) {
            $sub = SubfunctionPosition::find($jp->subfunction_position_id);
            if ($sub) {
                $subfunction = [
                    'id' => $sub->id,
                    'name' => $sub->name,
                ];
            }
        }

        // Job descriptions with nested profile_kra
        $jobDescriptions = [];
        if ($jp && $jp->jobDescriptions) {
            $jobDescriptions = $jp->jobDescriptions->map(function ($jd) {
                return [
                    'id' => $jd->id,
                    'subfunction' => $jd->subfunctionPosition,
                    'kra' => $jd->jobProfileKra,
                    'description' => $jd->description,
                    'profile_kra' => ($jd->profileKras ? $jd->profileKras->map(function ($pk) {
                        return [
                            'id' => $pk->id,
                            'kra_description' => $pk->kra_description,
                            // DB column is 'deliverables' -> map back to 'description'
                            'description' => $pk->deliverables,
                        ];
                    })->values()->toArray() : []),
                ];
            })->values()->toArray();
        }

        // Job performance standards
        $jps = [];
        if ($jp && $jp->jobPerformanceStandards) {
            $jps = $jp->jobPerformanceStandards->map(function ($std) {
                $vals = $std->values;
                if (is_string($vals)) {
                    $decoded = json_decode($vals, true);
                    $vals = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : (strlen($vals) ? [$vals] : []);
                } elseif (!is_array($vals)) {
                    $vals = [];
                }
                return [
                    'id' => $std->id,
                    'name' => $std->name,
                    'values' => array_values($vals),
                ];
            })->values()->toArray();
        }

        // Reporting relationships (raw object)
        $rr = null;
        if ($jp && $jp->reportingRelationships) {
            $rr = [
                'primary' => $jp->reportingRelationships->primary,
                'secondary' => $jp->reportingRelationships->secondary,
                'tertiary' => $jp->reportingRelationships->tertiary,
            ];
        }

        // Levels of authority (snake_case keys)
        $loa = null;
        if ($jp && $jp->levelsOfAuthority) {
            $loa = [
                'line_authority' => $jp->levelsOfAuthority->line_authority,
                'staff_authority' => $jp->levelsOfAuthority->staff_authority,
            ];
        }

        // Job specifications (snake_case keys)
        $js = null;
        if ($jp && $jp->jobSpecifications) {
            $js = [
                'educational_background' => $this->firstOrString($jp->jobSpecifications->educational_background),
                'license_requirement' => $this->firstOrString($jp->jobSpecifications->license_requirement),
                'work_experience' => $this->firstOrString($jp->jobSpecifications->work_experience),
            ];
        }

        $result = [
            'position_title' => $org->position_title,
            'department' => $org->department,
            'reporting' => $org->reporting,
            'job_profile' => [
                'job_purpose' => $jp?->job_purpose,
                'job_descriptions' => $jobDescriptions,
                'job_performance_standards' => $jps,
                'reporting_relationships' => $rr,
                'levels_of_authority' => $loa,
                'job_specifications' => $js,
            ],
        ];

        return response()->json($result);
    }

    public function exportPdf($id)
    {
        // Fetch the data using the same logic as the show method
        $orgStructure = OrgStructure::with([
            'jobProfile',
            'jobProfile.reportingTo',
            'jobProfile.jobDescriptions',
            'jobProfile.jobDescriptions.profileKras',
            'jobProfile.jobPerformanceStandards',
            'jobProfile.jobSpecifications',
            'jobProfile.reportingRelationships',
            'jobProfile.levelsOfAuthority',
            'jobProfile.subfunctionPosition',
        ])->find($id);

        if (!$orgStructure) {
            return response()->json(['message' => 'Org structure not found'], 404);
        }

        // Convert to array for manipulation
        $orgStructureArray = $orgStructure->toArray();

        if (isset($orgStructureArray['job_profile'])) {
            // Transform jobPerformanceStandards if they exist
            if (isset($orgStructureArray['job_profile']['job_performance_standards'])) {
                $formattedStandards = [
                    'title' => 'Job Performance Standards',
                    'items' => collect($orgStructureArray['job_profile']['job_performance_standards'])->map(function ($standard) {
                        return [
                            'name' => ucfirst($standard['name']),
                            'values' => json_decode($standard['values'], true)
                        ];
                    })->toArray()
                ];
                $orgStructureArray['job_profile']['job_performance_standards'] = $formattedStandards;
            }

            // Transform jobSpecifications if they exist
            if (isset($orgStructureArray['job_profile']['job_specifications'])) {
                $specs = $orgStructureArray['job_profile']['job_specifications'];

                $formattedSpecifications = [
                    'title' => 'Job Specifications',
                    'items' => [
                        [
                            'name' => 'Educational Background',
                            'values' => $this->parseSpecificationValue($specs['educational_background'] ?? '')
                        ],
                        [
                            'name' => 'License Requirement',
                            'values' => $this->parseSpecificationValue($specs['license_requirement'] ?? '')
                        ],
                        [
                            'name' => 'Years of Work Experience',
                            'values' => $this->parseSpecificationValue($specs['work_experience'] ?? '')
                        ],
                    ]
                ];
                $orgStructureArray['job_profile']['job_specifications'] = $formattedSpecifications;
            }

            // Transform levelsOfAuthority if they exist
            if (isset($orgStructureArray['job_profile']['levels_of_authority'])) {
                $levels = $orgStructureArray['job_profile']['levels_of_authority'];

                $formattedLevels = [
                    'title' => 'Levels of Authority',
                    'items' => [
                        [
                            'name' => 'Line Authority',
                            'values' => $this->parseSpecificationValue($levels['line_authority'] ?? '')
                        ],
                        [
                            'name' => 'Staff Authority',
                            'values' => $this->parseSpecificationValue($levels['staff_authority'] ?? '')
                        ],
                    ]
                ];
                $orgStructureArray['job_profile']['levels_of_authority'] = $formattedLevels;
            }

            // Transform reportingRelationships if they exist
            if (isset($orgStructureArray['job_profile']['reporting_relationships'])) {
                $relations = $orgStructureArray['job_profile']['reporting_relationships'];

                $formattedRelationships = [
                    'title' => 'Reporting Relationships',
                    'items' => [
                        [
                            'name' => 'Primary / Direct Reporting Relationship',
                            'values' => $this->parseSpecificationValue($relations['primary'] ?? '')
                        ],
                        [
                            'name' => 'Functional Reporting Relationship',
                            'values' => $this->parseSpecificationValue($relations['secondary'] ?? '')
                        ],
                        [
                            'name' => 'Administrative Reporting Relationship',
                            'values' => $this->parseSpecificationValue($relations['tertiary'] ?? '')
                        ],
                    ]
                ];
                $orgStructureArray['job_profile']['reporting_relationships'] = $formattedRelationships;
            }
        }

        // Generate PDF
        $pdf = Pdf::loadView('pdf.job-profile', ['data' => $orgStructureArray]);

        // Set paper size and orientation
        $pdf->setPaper('a4', 'portrait');

        // Generate filename
        $filename = 'job-profile-' . ($orgStructureArray['position_title'] ?? 'document') . '-' . date('Ymd') . '.pdf';
        $filename = preg_replace('/[^A-Za-z0-9\-_.]/', '_', $filename); // Sanitize filename

        // Return PDF as response with proper headers for download
        return $pdf->download($filename);
    }
}
