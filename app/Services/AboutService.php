<?php

namespace App\Services;

use App\Models\About;
use App\Models\Interest;
use App\Models\EducProfBackground;
use App\Models\LicAndCert;
use App\Models\MegawideWorkExperience;
use App\Models\PrevWorkExperience;
use App\Models\TechnicalProficiency;
use App\Models\LanguageProficiency;
use Illuminate\Support\Facades\DB;

class AboutService
{
	/**
	 * Create or update About with all nested resources
	 */
	public function upsertAbout(array $data, ?int $userId = null): About
	{
		return DB::transaction(function () use ($data, $userId) {
			$about = $this->upsertAboutRoot($data, $userId);

			if (isset($data['interests'])) {
				$this->syncInterests($about, $data['interests'], $userId);
			}

			if (isset($data['educ_prof_backgrounds'])) {
				$this->syncEducProfBackgrounds($about, $data['educ_prof_backgrounds'], $userId);
			}

			if (isset($data['megawide_work_experiences'])) {
				$this->syncMegawideWorkExperiences($about, $data['megawide_work_experiences'], $userId);
			}

			if (isset($data['prev_work_exp'])) {
				$this->syncPrevWorkExperiences($about, $data['prev_work_exp'], $userId);
			}

			if (isset($data['technical_proficiencies'])) {
				$this->syncTechnicalProficiencies($about, $data['technical_proficiencies'], $userId);
			}

			if (isset($data['language_proficiencies'])) {
				$this->syncLanguageProficiencies($about, $data['language_proficiencies'], $userId);
			}

			return $about->fresh();
		});
	}

	/**
	 * Create or update the About root record
	 */
	private function upsertAboutRoot(array $data, ?int $userId): About
	{
		$about = About::where('org_structure_id', $data['org_structure_id'])->first();
		$isUpdate = $about !== null;
		$oldAbout = $isUpdate ? $about->toArray() : null;

		if (!$about) {
			$about = new About();
			$about->org_structure_id = $data['org_structure_id'];
		}

		$about->birthdate = $data['birthdate'] ?? null;
		$about->marital_status = $data['marital_status'] ?? null;
		$about->save();

		auditLog('About', $isUpdate ? 'edit' : 'create', $oldAbout, $about->toArray(), $userId);

		return $about;
	}

	/**
	 * Sync interests for an About record
	 */
	private function syncInterests(About $about, array $interests, ?int $userId): void
	{
		$ids = [];
		foreach ($interests as $item) {
			if (isset($item['id'])) {
				$model = Interest::where('id', $item['id'])->where('a_about_id', $about->id)->first();
				if ($model) {
					$old = $model->toArray();
					$model->interest = $item['interest'];
					$model->save();
					auditLog('Interest', 'edit', $old, $model->toArray(), $userId);
					$ids[] = $model->id;
				}
			} else {
				$model = new Interest(['interest' => $item['interest']]);
				$model->a_about_id = $about->id;
				$model->save();
				auditLog('Interest', 'create', null, $model->toArray(), $userId);
				$ids[] = $model->id;
			}
		}
		Interest::where('a_about_id', $about->id)->whereNotIn('id', $ids)->delete();
	}

	/**
	 * Sync educational/professional backgrounds with nested licenses and certifications
	 */
	private function syncEducProfBackgrounds(About $about, array $backgrounds, ?int $userId): void
	{
		$bgIds = [];
		foreach ($backgrounds as $bg) {
			if (isset($bg['id'])) {
				$model = EducProfBackground::where('id', $bg['id'])->where('a_about_id', $about->id)->first();
				if ($model) {
					$old = $model->toArray();
					$model->fill([
						'education_level' => $bg['education_level'] ?? null,
						'school' => $bg['school'] ?? null,
						'course' => $bg['course'] ?? null,
						'start_date' => $bg['start_date'] ?? null,
						'end_date' => $bg['end_date'] ?? null,
						'honors' => $bg['honors'] ?? null,
					]);
					$model->save();
					auditLog('EducProfBackground', 'edit', $old, $model->toArray(), $userId);
				}
			} else {
				$model = new EducProfBackground([
					'education_level' => $bg['education_level'] ?? null,
					'school' => $bg['school'] ?? null,
					'course' => $bg['course'] ?? null,
					'start_date' => $bg['start_date'] ?? null,
					'end_date' => $bg['end_date'] ?? null,
					'honors' => $bg['honors'] ?? null,
				]);
				$model->a_about_id = $about->id;
				$model->save();
				auditLog('EducProfBackground', 'create', null, $model->toArray(), $userId);
			}
			$bgIds[] = $model->id;

			// Sync nested licenses and certifications
			if (isset($bg['lic_and_certs']) && is_array($bg['lic_and_certs'])) {
				$this->syncLicAndCerts($model, $bg['lic_and_certs'], $userId);
			}
		}
		EducProfBackground::where('a_about_id', $about->id)->whereNotIn('id', $bgIds)->delete();
	}

	/**
	 * Sync licenses and certifications for an education background
	 */
	private function syncLicAndCerts(EducProfBackground $background, array $licAndCerts, ?int $userId): void
	{
		$licIds = [];
		foreach ($licAndCerts as $lc) {
			if (isset($lc['id'])) {
				$lic = LicAndCert::where('id', $lc['id'])->where('a_educ_prof_background_id', $background->id)->first();
				if ($lic) {
					$oldLic = $lic->toArray();
					$lic->lic_and_cert = $lc['lic_and_cert'];
					$lic->save();
					auditLog('LicAndCert', 'edit', $oldLic, $lic->toArray(), $userId);
					$licIds[] = $lic->id;
				}
			} else {
				$lic = new LicAndCert(['lic_and_cert' => $lc['lic_and_cert']]);
				$lic->a_educ_prof_background_id = $background->id;
				$lic->save();
				auditLog('LicAndCert', 'create', null, $lic->toArray(), $userId);
				$licIds[] = $lic->id;
			}
		}
		LicAndCert::where('a_educ_prof_background_id', $background->id)->whereNotIn('id', $licIds)->delete();
	}

	/**
	 * Sync Megawide work experiences
	 */
	private function syncMegawideWorkExperiences(About $about, array $experiences, ?int $userId): void
	{
		$ids = [];
		foreach ($experiences as $mw) {
			if (isset($mw['id'])) {
				$model = MegawideWorkExperience::where('id', $mw['id'])->where('a_about_id', $about->id)->first();
				if ($model) {
					$old = $model->toArray();
					$model->position = $mw['position'];
					$model->department = $mw['department'] ?? null;
					$model->rank = $mw['rank'] ?? null;
					$model->start_date = $mw['start_date'] ?? null;
					$model->save();
					auditLog('MegawideWorkExperience', 'edit', $old, $model->toArray(), $userId);
					$ids[] = $model->id;
				}
			} else {
				$model = new MegawideWorkExperience([
					'position' => $mw['position'],
					'department' => $mw['department'] ?? null,
					'rank' => $mw['rank'] ?? null,
					'start_date' => $mw['start_date'] ?? null,
				]);
				$model->a_about_id = $about->id;
				$model->save();
				auditLog('MegawideWorkExperience', 'create', null, $model->toArray(), $userId);
				$ids[] = $model->id;
			}
		}
		MegawideWorkExperience::where('a_about_id', $about->id)->whereNotIn('id', $ids)->delete();
	}

	/**
	 * Sync previous work experiences
	 */
	private function syncPrevWorkExperiences(About $about, array $experiences, ?int $userId): void
	{
		$ids = [];
		foreach ($experiences as $pw) {
			if (isset($pw['id'])) {
				$model = PrevWorkExperience::where('id', $pw['id'])->where('a_about_id', $about->id)->first();
				if ($model) {
					$old = $model->toArray();
					$model->fill([
						'position' => $pw['position'] ?? $pw['title'] ?? null,
						'megawide_position_equivalent' => $pw['megawide_position_equivalent'] ?? $pw['megawide_position_equivalents'] ?? null,
						'department' => $pw['department'] ?? $pw['department_or_field'] ?? null,
						'company' => $pw['company'] ?? $pw['organization'] ?? null,
						'rank' => $pw['rank'] ?? $pw['rank_level'] ?? null,
						'functions_jd' => $pw['functions_jd'] ?? $pw['description'] ?? null,
						'start_date' => $pw['start_date'] ?? null,
						'end_date' => $pw['end_date'] ?? null,
					]);
					$model->save();
					auditLog('PrevWorkExperience', 'edit', $old, $model->toArray(), $userId);
					$ids[] = $model->id;
				}
			} else {
				$model = new PrevWorkExperience([
					'position' => $pw['position'] ?? $pw['title'] ?? null,
					'megawide_position_equivalent' => $pw['megawide_position_equivalent'] ?? $pw['megawide_position_equivalents'] ?? null,
					'department' => $pw['department'] ?? $pw['department_or_field'] ?? null,
					'company' => $pw['company'] ?? $pw['organization'] ?? null,
					'rank' => $pw['rank'] ?? $pw['rank_level'] ?? null,
					'functions_jd' => $pw['functions_jd'] ?? $pw['description'] ?? null,
					'start_date' => $pw['start_date'] ?? null,
					'end_date' => $pw['end_date'] ?? null,
				]);
				$model->a_about_id = $about->id;
				$model->save();
				auditLog('PrevWorkExperience', 'create', null, $model->toArray(), $userId);
				$ids[] = $model->id;
			}
		}
		PrevWorkExperience::where('a_about_id', $about->id)->whereNotIn('id', $ids)->delete();
	}

	/**
	 * Sync technical proficiencies
	 */
	private function syncTechnicalProficiencies(About $about, array $proficiencies, ?int $userId): void
	{
		$ids = [];
		foreach ($proficiencies as $tp) {
			if (isset($tp['id'])) {
				$model = TechnicalProficiency::where('id', $tp['id'])->where('a_about_id', $about->id)->first();
				if ($model) {
					$old = $model->toArray();
					$model->skills = $tp['skills'];
					$model->proficiency = $tp['proficiency'] ?? null;
					$model->save();
					auditLog('TechnicalProficiency', 'edit', $old, $model->toArray(), $userId);
					$ids[] = $model->id;
				}
			} else {
				$model = new TechnicalProficiency([
					'skills' => $tp['skills'],
					'proficiency' => $tp['proficiency'] ?? null,
				]);
				$model->a_about_id = $about->id;
				$model->save();
				auditLog('TechnicalProficiency', 'create', null, $model->toArray(), $userId);
				$ids[] = $model->id;
			}
		}
		TechnicalProficiency::where('a_about_id', $about->id)->whereNotIn('id', $ids)->delete();
	}

	/**
	 * Sync language proficiencies
	 */
	private function syncLanguageProficiencies(About $about, array $proficiencies, ?int $userId): void
	{
		$ids = [];
		foreach ($proficiencies as $lp) {
			if (isset($lp['id'])) {
				$model = LanguageProficiency::where('id', $lp['id'])->where('a_about_id', $about->id)->first();
				if ($model) {
					$old = $model->toArray();
					$model->language = $lp['language'];
					$model->written = (bool) ($lp['written'] ?? false);
					$model->w_prof = $lp['w_prof'] ?? null;
					$model->spoken = (bool) ($lp['spoken'] ?? false);
					$model->s_prof = $lp['s_prof'] ?? null;
					$model->save();
					auditLog('LanguageProficiency', 'edit', $old, $model->toArray(), $userId);
					$ids[] = $model->id;
				}
			} else {
				$model = new LanguageProficiency([
					'language' => $lp['language'],
					'written' => (bool) ($lp['written'] ?? false),
					'w_prof' => $lp['w_prof'] ?? null,
					'spoken' => (bool) ($lp['spoken'] ?? false),
					's_prof' => $lp['s_prof'] ?? null,
				]);
				$model->a_about_id = $about->id;
				$model->save();
				auditLog('LanguageProficiency', 'create', null, $model->toArray(), $userId);
				$ids[] = $model->id;
			}
		}
		LanguageProficiency::where('a_about_id', $about->id)->whereNotIn('id', $ids)->delete();
	}

	/**
	 * Format About data for API response
	 */
	public function formatAboutResponse(About $about): array
	{
		return [
			'id' => $about->id,
			'org_structure_id' => $about->orgStructure->only([
				'id', 'is_active', 'firstname', 'lastname', 'nickname', 'name',
				'email', 'position_title', 'reporting', 'pid', 'emp_no', 'level',
				'department', 'business_unit', 'company', 'image',
				'created_at', 'updated_at', 'deleted_at'
			]),
			'birthdate' => $about->birthdate,
			'marital_status' => $about->marital_status,
			'functions' => $about->functions_from_job_descriptions->map(fn($func) => [
				'id' => $func->id,
				'name' => $func->name ?? null,
			])->toArray(),
			'interests' => $this->formatInterests($about->interests),
			'educ_prof_backgrounds' => $this->formatEducProfBackgrounds($about->educProfBackgrounds),
			'megawide_work_experiences' => $this->formatMegawideWorkExperiences($about->megawideWorkExperiences),
			'prev_work_exp' => $this->formatPrevWorkExperiences($about->prevWorkExperiences),
			'technical_proficiencies' => $this->formatTechnicalProficiencies($about->technicalProficiencies),
			'language_proficiencies' => $this->formatLanguageProficiencies($about->languageProficiencies),
		];
	}

	/**
	 * Format About data for edit form
	 */
	public function formatAboutForEdit(About $about): array
	{
		return [
			'id' => $about->id,
			'org_structure_id' => $about->org_structure_id,
			'birthdate' => $about->birthdate,
			'marital_status' => $about->marital_status,
			'interests' => $this->formatInterests($about->interests),
			'educ_prof_backgrounds' => $this->formatEducProfBackgrounds($about->educProfBackgrounds),
			'megawide_work_experiences' => $this->formatMegawideWorkExperiences($about->megawideWorkExperiences),
			'prev_work_exp' => $this->formatPrevWorkExperiences($about->prevWorkExperiences),
			'technical_proficiencies' => $this->formatTechnicalProficiencies($about->technicalProficiencies),
			'language_proficiencies' => $this->formatLanguageProficiencies($about->languageProficiencies),
		];
	}

	private function formatInterests($interests): array
	{
		return $interests->map(fn($i) => [
			'id' => $i->id,
			'interest' => $i->interest,
		])->values()->toArray();
	}

	private function formatEducProfBackgrounds($backgrounds): array
	{
		return $backgrounds->map(function ($bg) {
			return [
				'id' => $bg->id,
				'education_level' => $bg->education_level,
				'school' => $bg->school,
				'course' => $bg->course,
				'start_date' => $bg->start_date,
				'end_date' => $bg->end_date,
				'honors' => $bg->honors,
				'lic_and_certs' => $bg->licAndCerts->map(fn($lc) => [
					'id' => $lc->id,
					'lic_and_cert' => $lc->lic_and_cert,
				])->values()->toArray(),
			];
		})->values()->toArray();
	}

	private function formatMegawideWorkExperiences($experiences): array
	{
		return $experiences->map(fn($mw) => [
			'id' => $mw->id,
			'position' => $mw->position,
			'department' => $mw->department,
			'rank' => $mw->rank,
			'start_date' => $mw->start_date,
		])->values()->toArray();
	}

	private function formatPrevWorkExperiences($experiences): array
	{
		return $experiences->map(fn($pw) => [
			'id' => $pw->id,
			'position' => $pw->position,
			'megawide_position_equivalent' => $pw->megawide_position_equivalent,
			'department' => $pw->department,
			'company' => $pw->company,
			'rank' => $pw->rank,
			'functions_jd' => $pw->functions_jd,
			'start_date' => $pw->start_date,
			'end_date' => $pw->end_date,
		])->values()->toArray();
	}

	private function formatTechnicalProficiencies($proficiencies): array
	{
		return $proficiencies->map(fn($tp) => [
			'id' => $tp->id,
			'skills' => $tp->skills,
			'proficiency' => $tp->proficiency,
		])->values()->toArray();
	}

	private function formatLanguageProficiencies($proficiencies): array
	{
		return $proficiencies->map(fn($lp) => [
			'id' => $lp->id,
			'language' => $lp->language,
			'written' => (bool) $lp->written,
			'w_prof' => $lp->w_prof,
			'spoken' => (bool) $lp->spoken,
			's_prof' => $lp->s_prof,
		])->values()->toArray();
	}
}
