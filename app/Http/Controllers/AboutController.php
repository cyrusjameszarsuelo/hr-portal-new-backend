<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\About;
use App\Models\OrgStructure;
use App\Services\AboutService;

class AboutController extends Controller
{
	protected AboutService $aboutService;

	public function __construct(AboutService $aboutService)
	{
		$this->aboutService = $aboutService;
	}
	/**
	 * Fetch About Us data by org_structure_id (profileId)
	 */
	public function showByProfileId(string $id)
	{
		$org = OrgStructure::find($id);
		if (!$org) {
			return response()->json(['message' => 'Org structure not found'], 404);
		}

		$about = About::with([
			'orgStructure.jobProfile.jobDescriptions.subfunctionPosition.functionPosition',
			'interests',
			'educProfBackgrounds.licAndCerts',
			'megawideWorkExperiences',
			'prevWorkExperiences',
			'technicalProficiencies',
			'languageProficiencies',
		])->where('org_structure_id', $id)->first();

		if (!$about) {
			return response()->json([
				'org_structure_id' => $org->only([
					'id',
					'is_active',
					'firstname',
					'lastname',
					'nickname',
					'name',
					'email',
					'position_title',
					'reporting',
					'pid',
					'emp_no',
					'level',
					'department',
					'business_unit',
					'company',
					'image',
					'created_at',
					'updated_at',
					'deleted_at'
				]),
				'birthdate' => null,
				'marital_status' => null,
				'functions' => [],
				'interests' => [],
				'educ_prof_backgrounds' => [],
				'megawide_work_experiences' => [],
				'prev_work_exp' => [],
				'technical_proficiencies' => [],
				'language_proficiencies' => [],
			]);
		}

		return response()->json($this->aboutService->formatAboutResponse($about));
	}

	/**
	 * Create or update About Us data with nested children for an org structure.
	 */
	public function upsert(Request $request)
	{
		$validated = $request->validate([
			'org_structure_id' => 'required|exists:org_structures,id',
			'birthdate' => 'nullable|date',
			'marital_status' => 'nullable|string',

			'interests' => 'sometimes|array',
			'interests.*.id' => 'sometimes|exists:a_interests,id',
			'interests.*.interest' => 'required|string',
			'educ_prof_backgrounds' => 'sometimes|array',
			'educ_prof_backgrounds.*.id' => 'sometimes|exists:a_educ_prof_backgrounds,id',
			'educ_prof_backgrounds.*.education_level' => 'nullable|in:primary,secondary,tertiary,vocational,undergraduate,bachelors,masters,doctorate',
			'educ_prof_backgrounds.*.school' => 'nullable|string',
			'educ_prof_backgrounds.*.course' => 'nullable|string',
			'educ_prof_backgrounds.*.start_date' => 'nullable|date',
			'educ_prof_backgrounds.*.end_date' => 'nullable|date',
			'educ_prof_backgrounds.*.honors' => 'nullable|string',
			'educ_prof_backgrounds.*.lic_and_certs' => 'sometimes|array',
			'educ_prof_backgrounds.*.lic_and_certs.*.id' => 'sometimes|exists:a_lic_and_certs,id',
			'educ_prof_backgrounds.*.lic_and_certs.*.lic_and_cert' => 'required|string',
			'megawide_work_experiences' => 'sometimes|array',
			'megawide_work_experiences.*.id' => 'sometimes|exists:a_megawide_work_experiences,id',
			'megawide_work_experiences.*.position' => 'required|string',
			'megawide_work_experiences.*.department' => 'nullable|string',
			'megawide_work_experiences.*.rank' => 'nullable|string',
			'megawide_work_experiences.*.start_date' => 'nullable|date',

		'prev_work_exp' => 'sometimes|array',
		'prev_work_exp.*.id' => 'sometimes|exists:a_prev_work_experiences,id',
		'prev_work_exp.*.position' => 'required|string',
		'prev_work_exp.*.megawide_position_equivalent' => 'nullable|string',
		'prev_work_exp.*.department' => 'nullable|string',
		'prev_work_exp.*.company' => 'nullable|string',
		'prev_work_exp.*.rank' => 'nullable|string',
		'prev_work_exp.*.functions_jd' => 'nullable|string',
		'prev_work_exp.*.start_date' => 'nullable|date',
		'prev_work_exp.*.end_date' => 'nullable|date',

		'technical_proficiencies' => 'sometimes|array',
			'technical_proficiencies.*.id' => 'sometimes|exists:a_technical_proficiencies,id',
			'technical_proficiencies.*.skills' => 'required|string',
			'technical_proficiencies.*.proficiency' => 'nullable|string',

			'language_proficiencies' => 'sometimes|array',
			'language_proficiencies.*.id' => 'sometimes|exists:a_language_proficiencies,id',
			'language_proficiencies.*.language' => 'required|string',
			'language_proficiencies.*.written' => 'nullable|boolean',
			'language_proficiencies.*.w_prof' => 'nullable|string',
			'language_proficiencies.*.spoken' => 'nullable|boolean',
			'language_proficiencies.*.s_prof' => 'nullable|string',

			'user_id' => 'sometimes|integer',
		]);

		$existingAbout = About::where('org_structure_id', $validated['org_structure_id'])->exists();
		$about = $this->aboutService->upsertAbout($validated, $request->input('user_id'));

		return response()->json([
			'message' => $existingAbout ? 'About updated successfully' : 'About created successfully',
			'data' => $this->showByProfileId($about->org_structure_id)->getData(true)
		], $existingAbout ? 200 : 201);
	}

	public function edit(string $id)
	{
		$org = OrgStructure::find($id);
		if (!$org) {
			return response()->json(['message' => 'Org structure not found'], 404);
		}

		$about = About::with([
			'interests',
			'educProfBackgrounds.licAndCerts',
			'megawideWorkExperiences',
			'prevWorkExperiences',
			'technicalProficiencies',
			'languageProficiencies',
		])->where('org_structure_id', $id)->first();

		if (!$about) {
			return response()->json([
				'about' => [
					'org_structure_id' => (int) $id,
					'birthdate' => null,
					'marital_status' => null,
					'interests' => [],
					'educ_prof_backgrounds' => [],
					'megawide_work_experiences' => [],
					'prev_work_exp' => [],
					'technical_proficiencies' => [],
					'language_proficiencies' => [],
				]
			]);
		}

		return response()->json([
			'about' => $this->aboutService->formatAboutForEdit($about),
		]);
	}
}
