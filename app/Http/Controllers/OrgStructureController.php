<?php

namespace App\Http\Controllers;

use App\Models\OrgStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class OrgStructureController extends Controller
{
    public function index()
    {
        $orgStructure = OrgStructure::with(['department', 'sbu', 'level', 'positionTitle'])->get();

        $orgStructureResponse = $orgStructure->map(function ($item) {
            return [
                'id' => $item->id,
                'is_active' => $item->is_active,
                'firstname' => $item->firstname,
                'lastname' => $item->lastname,
                'nickname' => $item->nickname,
                'name' => $item->name,
                'email' => $item->email,
                'position' => $item->positionTitle->position ?? null,
                'reporting' => $item->reporting,
                'emp_no' => $item->emp_no,
                'level' => $item->level ? $item->level->level : null,
                'department' => $item->department ? $item->department->department : null,
                'sbu' => $item->sbu ? $item->sbu->sbu : null,
                'dept_head' => $item->dept_head,
                'is_admin' => $item->is_admin,
                'company' => $item->company,
                'image' => $item->image,
                'pid' => $item->pid,
                'user_id' => $item->user_id,
            ];
        });

        return response()->json($orgStructureResponse);
    }

    public function store(Request $request, $pid)
    {
        $newEntry = OrgStructure::create([
            'is_active' => true,
            'firstname' => 'New',
            'lastname' => 'Entry',
            'nickname' => '',
            'name' => 'New Entry',
            'email' => '',
            'position_title' => 'Vacant',
            'reporting' => 'N/A',
            'pid' => $pid,
            'emp_no' => '',
            'level' => 'N/A',
            'department' => 'N/A',
            'company' => 'N/A',
            'business_unit' => 'N/A',
            'image' => '',
        ]);

        auditLog('OrgStructure', 'create', null, $newEntry->toArray(), $request['user_id']);

        return response()->json(['message' => 'New organization structure entry added', 'data' => $newEntry]);
    }

    public function update(Request $request)
    {

        // Validate incoming request data
        $validatedData = $request->validate([
            'id' => 'required|exists:org_structures,id',
            'name' => 'sometimes|string|max:255',
            'parent_id' => 'sometimes|nullable|exists:org_structures,id',
            'is_active' => 'sometimes|boolean',
            'business_unit' => 'sometimes|string|max:255',
            'company' => 'sometimes|string|max:255',
            'department' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255|nullable',
            'emp_no' => 'sometimes|string|max:50|nullable',
            'firstname' => 'sometimes|string|max:100',
            'lastname' => 'sometimes|string|max:100',
            'level' => 'sometimes|string|max:50',
            'nickname' => 'sometimes|string|max:100',
            'position_title' => 'sometimes|string|max:255',
            'pid' => 'sometimes|nullable|exists:org_structures,id',
        ]);

        // Find the org structure entry by ID
        $orgStructure = OrgStructure::find($validatedData['id']);

        $oldOrgStructure = $orgStructure->toArray();

        $orgStructure->fill($validatedData);

        // Save the updated org structure
        $orgStructure->save();

        auditLog('OrgStructure', 'edit', $oldOrgStructure, $orgStructure->toArray(), $request['user_id']);

        return response()->json(['message' => 'Organization structure updated successfully', 'data' => $validatedData]);
    }

    public function destroy(Request $request, $id)
    {
        $orgStructure = OrgStructure::find($id);

        if (!$orgStructure) {
            return response()->json(['message' => 'Organization structure not found'], 404);
        }

        $oldOrgStructure = $orgStructure->toArray();

        $orgStructure->delete();

        auditLog('OrgStructure', 'delete', $oldOrgStructure, null, $request['user_id']);

        return response()->json(['message' => 'Organization structure deleted successfully']);
    }

    public function getHeadCount()
    {

        $position_title_order = [
            1,
            3,
            5,
            6
        ];
        // include an aggregate for level_id (min) so we can ORDER the grouped rows
        // while staying compatible with ONLY_FULL_GROUP_BY
        // Use Eloquent + collections to compute grouped results and include related names.
        $all = OrgStructure::with(['department', 'sbu', 'level'])
            ->where('name', '!=', 'OCEO')
            ->get();

        // Group by department_id + sbu_id for headCount
        $groups = $all->groupBy(function ($item) {
            return ($item->department_id ?? '0') . '|' . ($item->sbu_id ?? '0');
        });

        $headCount = $groups->map(function ($group) use ($position_title_order) {
            $head = $group->count();
            $vacant = $group->filter(function ($g) {
                return trim((string) ($g->firstname ?? '')) === 'Employee';
            })->count();
            $minLevel = $group->pluck('level_id')->filter()->min();

            $first = $group->first();

            $levelName = null;
            if ($minLevel) {
                $match = $group->firstWhere('level_id', $minLevel);
                $levelName = ($match && $match->level) ? $match->level->level : null;
            }

            return [
                // 'department_id' => $first->department_id,
                // 'sbu_id' => $first->sbu_id,
                'headcount' => $head,
                'vacant' => $vacant,
                'filled' => $head - $vacant,
                'min_level' => $minLevel,
                'department' => $first->department?->department ?? null,
                'sbu' => $first->sbu?->sbu ?? null,
                'level' => $levelName,
            ];
        })->values()
            ->sortBy(function ($row) use ($position_title_order) {
                $idx = array_search($row['min_level'], $position_title_order, true);
                return $idx === false ? PHP_INT_MAX : $idx;
            })->values();

        $totals = [
            'headcount' => $all->count(),
            'vacant' => $all->filter(function ($g) {
                return trim((string) ($g->firstname ?? '')) === 'Employee';
            })->count(),
            'filled' => $all->count() - $all->filter(function ($g) {
                return trim((string) ($g->firstname ?? '')) === 'Employee';
            })->count(),
        ];

        return response()->json([
            'data' => $headCount,
            'totals' => $totals,
        ]);


    }

    public function getCountPerPosition()
    {

        $level_order = [
            1,
            3,
            5,
            6
        ];

        // Use Eloquent collections + relationships to compute counts per (department, sbu, level)
        $all = OrgStructure::with(['department', 'sbu', 'level'])
            ->where('name', '!=', 'OCEO')
            ->get();

        $groups = $all->groupBy(function ($item) {
            return ($item->department_id ?? '0') . '|' . ($item->sbu_id ?? '0') . '|' . ($item->level_id ?? '0');
        });

        $countPerPosition = $groups->map(function ($group) use ($level_order) {
            $first = $group->first();
            $head = $group->count();
            $vacant = $group->filter(function ($g) {
                return trim((string) ($g->firstname ?? '')) === 'Employee';
            })->count();
            return [
                // 'department_id' => $first->department_id,
                // 'sbu_id' => $first->sbu_id,
                'level_id' => $first->level_id,
                'headcount' => $head,
                'vacant' => $vacant,
                'filled' => $head - $vacant,
                'department' => $first->department?->department ?? null,
                'sbu' => $first->sbu?->sbu ?? null,
                'level' => $first->level?->level ?? null,
            ];
        })->values()
            ->sortBy([['department', 'asc'], ['sbu', 'asc']])
            ->sortBy(function ($row) use ($level_order) {
                $idx = array_search($row['level_id'], $level_order, true);
                return $idx === false ? PHP_INT_MAX : $idx;
            })->values();

        return response()->json([
            'data' => $countPerPosition,
        ]);
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:org_structures,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        $orgStructure = OrgStructure::find($request->id);
        if (!$orgStructure) {
            return response()->json(['message' => 'Organization structure not found'], 404);
        }

        $oldOrgStructure = $orgStructure->toArray();

        // Handle the file upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;

            $storedPath = $file->storeAs('org-structure', $filename, 'public');

            if ($orgStructure->image) {
                $existing = $orgStructure->image;
                $existing = preg_replace('#^/storage/#', '', $existing);
                if (str_starts_with($existing, 'org-structure')) {
                    try {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($existing);
                    } catch (\Exception $e) {
                    }
                }
            }

            // Save DB path as 'org-structure/filename.ext'
            $orgStructure->image = $storedPath;
            $orgStructure->save();

            auditLog('OrgStructure', 'edit', $oldOrgStructure, $orgStructure->toArray(), $request['user_id']);

            return response()->json(['message' => 'Image uploaded successfully', 'image_path' => $orgStructure->image]);
        }

        return response()->json(['message' => 'No image file provided'], 400);
    }

    public function userProfile(string $email)
    {
        $orgStructure = OrgStructure::where('email', $email)->first();

        return response()->json($orgStructure);
    }

    public function teamMembers(string $id)
    {
        $user = OrgStructure::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $teamMembers = OrgStructure::where('pid', $user->id)
            ->where('id', '!=', 2)
            ->get();

        return response()->json($teamMembers);
    }

    public function indirectReporting(string $id)
    {
        // get all users who indirectly report to the user with the given id
        $user = OrgStructure::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Get all indirect reports recursively
        $indirectReports = $this->getIndirectReports($user->id);

        return response()->json($indirectReports);
    }

    /**
     * Recursively get all indirect reports for a given user
     */
    private function getIndirectReports($userId, $excludeFirstLevel = true)
    {
        $allReports = collect();

        // Get direct reports (children)
        $directReports = OrgStructure::where('pid', $userId)
            ->where('id', '!=', 2) // Exclude specific ID if needed
            ->get();

        foreach ($directReports as $report) {
            // Skip adding direct reports on first level
            if (!$excludeFirstLevel) {
                $allReports->push($report);
            }

            // Recursively get their reports (indirect) - always include these
            $indirectReports = $this->getIndirectReports($report->id, false);
            $allReports = $allReports->merge($indirectReports);
        }

        return $allReports;
    }
}
