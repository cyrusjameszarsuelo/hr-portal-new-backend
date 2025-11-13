<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\About;
use App\Models\OrgStructure;
use App\Models\Interest;
use App\Models\Skill;
use App\Models\EducProfBackground;
use App\Models\LicAndCert;
use App\Models\MegawideWorkExperience;
use App\Models\MegawidePreviousAssignment;
use App\Models\PrevWorkExperience;
use App\Models\TechnicalProficiency;
use App\Models\LanguageProficiency;
use App\Models\SubfunctionPosition;

class AboutController extends Controller
{
	/**
	 * Edit data payload for frontend, shaped for the React form.
	 * Accepts org_structure_id and returns { about: { ... } } with nested arrays.
	 */
	public function edit(string $id)
	{
		$org = OrgStructure::find($id);
		if (!$org) {
			return response()->json(['message' => 'Org structure not found'], 404);
		}

		$about = About::with([
			'interests',
			'skills',
			'educProfBackgrounds',
			'licAndCerts',
			'megawideWorkExperience.subfunctionPositions',
			'megawideWorkExperience.previousAssignments',
			'prevWorkExperiences',
			'technicalProficiencies',
			'languageProficiencies',
		])->where('org_structure_id', $id)->first();

		if (!$about) {
			// Return an empty shell so the frontend can render a blank form for creation
			return response()->json(['about' => (object)[]]);
		}

		$aboutArr = [
			// Personal Information
			'org_structure_id' => $about->org_structure_id,
			'employee_id' => $about->employee_id,
			'nickname' => $about->nickname,
			'birth_date' => $about->birth_date,
			'gender' => $about->gender,
			'civil_status' => $about->civil_status,
			'phone_number' => $about->phone_number,
			'blood_type' => $about->blood_type,

			// Emergency Contact
			'emergency_contact_name' => $about->emergency_contact_name,
			'relationship_to_employee' => $about->relationship_to_employee,
			'emergency_contact_number' => $about->emergency_contact_number,

			// Citizenship & Birth Place
			'citizenship' => $about->citizenship,
			'birth_place' => $about->birth_place,

			// Current Address
			'current_address_street' => $about->current_address_street,
			'current_address_city' => $about->current_address_city,
			'current_address_region' => $about->current_address_region,
			'current_address_zip_code' => $about->current_address_zip_code,

			// Permanent Address
			'permanent_address_street' => $about->permanent_address_street,
			'permanent_address_city' => $about->permanent_address_city,
			'permanent_address_region' => $about->permanent_address_region,
			'permanent_address_zip_code' => $about->permanent_address_zip_code,
		];

		// Arrays
		$aboutArr['interests'] = $about->interests->map(function ($i) {
			return [
				'id' => $i->id,
				'interest' => $i->interest,
			];
		})->values();

		$aboutArr['skills'] = $about->skills->map(function ($s) {
			return [
				'id' => $s->id,
				'skill' => $s->skill,
			];
		})->values();

		$aboutArr['educational_backgrounds'] = $about->educProfBackgrounds->map(function ($e) {
			return [
				'id' => $e->id,
				'education_level' => $e->education_level,
				'school_attended' => $e->school_attended,
				'degree_program_course' => $e->degree_program_course,
				'academic_achievements' => $e->academic_achievements,
				'year_started' => $e->year_started,
				'year_ended' => $e->year_ended,
				'is_current' => (bool) $e->is_current,
			];
		})->values();

		$aboutArr['licenses_certifications'] = $about->licAndCerts->map(function ($l) {
			return [
				'id' => $l->id,
				'license_certification_name' => $l->license_certification_name,
				'issuing_organization' => $l->issuing_organization,
				'license_certification_number' => $l->license_certification_number,
				'date_issued' => $l->date_issued,
				'date_of_expiration' => $l->date_of_expiration,
				'non_expiring' => (bool) $l->non_expiring,
			];
		})->values();

		// Megawide Work Experience
		$mwe = $about->megawideWorkExperience;
		if ($mwe) {
			$aboutArr['megawide_work_experience'] = [
				'job_title' => $mwe->job_title,
				'department' => $mwe->department,
				'unit' => $mwe->unit,
				'job_level' => $mwe->job_level,
				'employment_status' => $mwe->employment_status,
				'current_role_start_date' => $mwe->current_role_start_date,
				'current_role_end_date' => $mwe->current_role_end_date,
				'is_current' => (bool) $mwe->is_current,
				// Return array as-is of objects with ids for frontend select
				'functions' => $mwe->subfunctionPositions->map(function ($f) {
					return ['id' => $f->id];
				})->values(),
				'previous_assignments' => $mwe->previousAssignments->map(function ($a) {
					return [
						'id' => $a->id,
						'sbu' => $a->sbu,
						'worked_in_megawide' => (bool) ($a->worked_in_megawide ?? true),
						'previous_department' => $a->previous_department,
						'previous_job_title' => $a->previous_job_title,
						'previous_role_start_date' => $a->previous_role_start_date,
						'end_of_assignment' => $a->end_of_assignment,
					];
				})->values(),
			];
		} else {
			$aboutArr['megawide_work_experience'] = [
				'job_title' => '',
				'department' => '',
				'unit' => '',
				'job_level' => '',
				'employment_status' => '',
				'current_role_start_date' => '',
				'current_role_end_date' => '',
				'is_current' => false,
				'functions' => [],
				'previous_assignments' => [],
			];
		}

	$aboutArr['previous_work_experiences'] = $about->prevWorkExperiences->map(function ($w) {
		return [
			'id' => $w->id,
			'company' => $w->company,
			'job_title' => $w->job_title,
			'job_level' => $w->job_level,
			'start_date' => $w->start_date,
			'end_date' => $w->end_date,
		];
	})->values();		$aboutArr['technical_proficiencies'] = $about->technicalProficiencies->map(function ($t) {
			return [
				'id' => $t->id,
				'skills' => $t->skills,
				'proficiency' => $t->proficiency,
			];
		})->values();

		$aboutArr['language_proficiencies'] = $about->languageProficiencies->map(function ($l) {
			return [
				'id' => $l->id,
				'language' => $l->language,
				'written' => (bool) $l->written,
				'w_prof' => $l->w_prof,
				'spoken' => (bool) $l->spoken,
				's_prof' => $l->s_prof,
			];
		})->values();

		return response()->json(['about' => $aboutArr]);
	}

	/**
	 * Fetch About data by org_structure_id with relations.
	 */
	public function showByProfileId(string $id)
	{
		$org = OrgStructure::find($id);
		if (!$org) {
			return response()->json(['message' => 'Org structure not found'], 404);
		}

		$about = About::with([
			'interests',
			'skills',
			'educProfBackgrounds',
			'licAndCerts',
			'megawideWorkExperience.subfunctionPositions',
			'megawideWorkExperience.previousAssignments',
			'prevWorkExperiences',
			'technicalProficiencies',
			'languageProficiencies',
		])->where('org_structure_id', $id)->first();

		// if (!$about) {
		// 	return response()->json([
		// 		'message' => 'About not found for org structure',
		// 		'org_structure_id' => (int) $id,
		// 	], 404);
		// }

		return response()->json($about);
	}

	/**
	 * Upsert About and all nested relations based on the provided payload.
	 */
	public function upsert(Request $request)
	{
		$data = $request->all();

		$request->validate([
			'org_structure_id' => 'required|exists:org_structures,id',

			// About basics
			'employee_id' => 'nullable|string',
			'nickname' => 'nullable|string',
			'birth_date' => 'nullable|date',
			'gender' => 'nullable|string',
			'civil_status' => 'nullable|string',
			'phone_number' => 'nullable|string',
			'blood_type' => 'nullable|string',
			'emergency_contact_name' => 'nullable|string',
			'relationship_to_employee' => 'nullable|string',
			'emergency_contact_number' => 'nullable|string',
			'citizenship' => 'nullable|string',
			'birth_place' => 'nullable|string',
			'current_address_street' => 'nullable|string',
			'current_address_city' => 'nullable|string',
			'current_address_region' => 'nullable|string',
			'current_address_zip_code' => 'nullable|string',
			'permanent_address_street' => 'nullable|string',
			'permanent_address_city' => 'nullable|string',
			'permanent_address_region' => 'nullable|string',
			'permanent_address_zip_code' => 'nullable|string',

			// Arrays
			'interests' => 'sometimes|array',
			'skills' => 'sometimes|array',
			'educational_backgrounds' => 'sometimes|array',
			'licenses_certifications' => 'sometimes|array',
			'megawide_work_experience' => 'sometimes|array',
			'previous_work_experiences' => 'sometimes|array',
			'technical_proficiencies' => 'sometimes|array',
			'language_proficiencies' => 'sometimes|array',
		]);

		return DB::transaction(function () use ($data) {
			// Upsert About
			$about = About::updateOrCreate(
				['org_structure_id' => $data['org_structure_id']],
				collect($data)->only([
					'org_structure_id',
					'employee_id', 'nickname', 'birth_date', 'gender', 'civil_status',
					'phone_number', 'blood_type',
					'emergency_contact_name', 'relationship_to_employee', 'emergency_contact_number',
					'citizenship', 'birth_place',
					'current_address_street', 'current_address_city', 'current_address_region', 'current_address_zip_code',
					'permanent_address_street', 'permanent_address_city', 'permanent_address_region', 'permanent_address_zip_code',
				])->toArray()
			);

			// Interests (hasMany simple)
			if (isset($data['interests'])) {
				$this->syncHasMany($about, 'interests', $data['interests'], ['interest']);
			}

			// Skills (hasMany simple)
			if (isset($data['skills'])) {
				$this->syncHasMany($about, 'skills', $data['skills'], ['skill']);
			}

			// Educational Backgrounds
			if (isset($data['educational_backgrounds'])) {
				$this->syncHasMany($about, 'educProfBackgrounds', $data['educational_backgrounds'], [
					'education_level', 'school_attended', 'degree_program_course',
					'academic_achievements', 'year_started', 'year_ended', 'is_current'
				]);
			}

			// Licenses & Certifications (belongs to About directly)
			if (isset($data['licenses_certifications'])) {
				$this->syncHasMany($about, 'licAndCerts', $data['licenses_certifications'], [
					'license_certification_name', 'issuing_organization',
					'license_certification_number', 'date_issued', 'date_of_expiration', 'non_expiring'
				]);
			}

			// Megawide Work Experience (hasOne parent)
			if (isset($data['megawide_work_experience'])) {
				$mwePayload = collect($data['megawide_work_experience'])->only([
					'job_title','department','unit','job_level','employment_status',
					'current_role_start_date','current_role_end_date','is_current'
				])->toArray();

				$mwe = MegawideWorkExperience::updateOrCreate(
					['a_about_id' => $about->id],
					array_merge(['a_about_id' => $about->id], $mwePayload)
				);

				// Sync subfunction positions pivot
				if (isset($data['megawide_work_experience']['functions'])) {
					$ids = collect($data['megawide_work_experience']['functions'])
						->pluck('id')
						->filter()
						->values()
						->all();
					$mwe->subfunctionPositions()->sync($ids);
				}

				// Sync previous assignments
				if (isset($data['megawide_work_experience']['previous_assignments'])) {
					$this->syncHasManyDirect(
						MegawidePreviousAssignment::class,
						'megawide_work_experience_id',
						$mwe->id,
						$data['megawide_work_experience']['previous_assignments'],
						['sbu','worked_in_megawide','previous_department','previous_job_title','previous_role_start_date','end_of_assignment']
					);
				}
			}

		// Previous Work Experiences (outside Megawide)
		if (isset($data['previous_work_experiences'])) {
			$this->syncHasManyDirect(
				PrevWorkExperience::class,
				'a_about_id',
				$about->id,
				$data['previous_work_experiences'],
				['company','job_title','job_level','start_date','end_date']
			);
		}			// Technical Proficiencies
			if (isset($data['technical_proficiencies'])) {
				$this->syncHasMany($about, 'technicalProficiencies', $data['technical_proficiencies'], ['skills','proficiency']);
			}

			// Language Proficiencies
			if (isset($data['language_proficiencies'])) {
				$this->syncHasMany($about, 'languageProficiencies', $data['language_proficiencies'], ['language','written','w_prof','spoken','s_prof']);
			}

			return response()->json(['message' => 'About upserted successfully', 'id' => $about->id]);
		});
	}

	/**
	 * Helper: sync hasMany relation on About using local relation name.
	 * Replaces existing rows with provided set (upsert + delete missing).
	 */
	private function syncHasMany(About $about, string $relationName, array $items, array $columns)
	{
		$relation = $about->{$relationName}();
		$existingIds = $relation->pluck('id')->all();

		$keptIds = [];
		foreach ($items as $item) {
			$payload = collect($item)->only($columns)->toArray();
			if (isset($item['id'])) {
				$model = $relation->getRelated()::where('id', $item['id'])->where($relation->getForeignKeyName(), $about->id)->first();
				if ($model) {
					$model->update($payload);
					$keptIds[] = $model->id;
					continue;
				}
			}
			$new = $relation->create($payload);
			$keptIds[] = $new->id;
		}

		// delete missing
		$toDelete = array_diff($existingIds, $keptIds);
		if (!empty($toDelete)) {
			$relation->whereIn('id', $toDelete)->delete();
		}
	}

	/**
	 * Helper: sync hasMany for models not directly related by About relation (direct class + FK name).
	 */
	private function syncHasManyDirect(string $modelClass, string $fkName, int $fkValue, array $items, array $columns)
	{
		$existingIds = $modelClass::where($fkName, $fkValue)->pluck('id')->all();
		$keptIds = [];
		foreach ($items as $item) {
			$payload = collect($item)->only($columns)->toArray();
			$payload[$fkName] = $fkValue;
			if (isset($item['id'])) {
				$model = $modelClass::where('id', $item['id'])->where($fkName, $fkValue)->first();
				if ($model) {
					$model->update($payload);
					$keptIds[] = $model->id;
					continue;
				}
			}
			$new = $modelClass::create($payload);
			$keptIds[] = $new->id;
		}
		$toDelete = array_diff($existingIds, $keptIds);
		if (!empty($toDelete)) {
			$modelClass::whereIn('id', $toDelete)->delete();
		}
	}
}
