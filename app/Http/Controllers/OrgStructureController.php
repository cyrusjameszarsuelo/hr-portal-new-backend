<?php

namespace App\Http\Controllers;

use App\Models\OrgStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class OrgStructureController extends Controller
{
    public function index()
    {
        $orgStructure = OrgStructure::all();

        return response()->json($orgStructure);
    }

    public function store($pid)
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

        $orgStructure->fill($validatedData);

        // Save the updated org structure
        $orgStructure->save();

        return response()->json(['message' => 'Organization structure updated successfully', 'data' => $validatedData]);
    }

    public function destroy($id)
    {
        $orgStructure = OrgStructure::find($id);

        if (!$orgStructure) {
            return response()->json(['message' => 'Organization structure not found'], 404);
        }

        $orgStructure->delete();

        return response()->json(['message' => 'Organization structure deleted successfully']);
    }

    public function getHeadCount()
    {

        $position_title_order = [
            'Executive',
            'Manager',
            'Rank & File',
            'Supervisor / Officer'
        ];
        // Return department and business unit headcounts. Use explicit select with
        // COUNT to avoid ONLY_FULL_GROUP_BY SQL errors on MySQL strict modes.
        $headCount = OrgStructure::select('department', 'business_unit')
            ->selectRaw('COUNT(*) as headcount')
            ->selectRaw('SUM(CASE WHEN firstname = "Employee" THEN 1 ELSE 0 END) as vacant')
            ->selectRaw('COUNT(*) - SUM(CASE WHEN firstname = "Employee" THEN 1 ELSE 0 END) as filled')
            ->where('name', '!=', 'OCEO')
            ->orderByRaw('FIELD(level, ?, ?, ?, ?)', $position_title_order)
            ->groupBy('department', 'business_unit')
            ->get();

        // Overall totals across all departments/business units
        $totals = OrgStructure::selectRaw('COUNT(*) as headcount')
            ->selectRaw('SUM(CASE WHEN firstname = "Employee" THEN 1 ELSE 0 END) as vacant')
            ->selectRaw('COUNT(*) - SUM(CASE WHEN firstname = "Employee" THEN 1 ELSE 0 END) as filled')
            ->first();

        return response()->json([
            'data' => $headCount,
            'totals' => $totals,
        ]);
    }

    public function getCountPerPosition()
    {

        $level_order = [
            'Executive',
            'Manager',
            'Supervisor / Officer',
            'Rank & File',
        ];

        $countPerPosition = OrgStructure::select('department', 'business_unit', 'level')
            ->selectRaw('COUNT(*) as headcount')
            ->selectRaw('SUM(CASE WHEN firstname = "Employee" THEN 1 ELSE 0 END) as vacant')
            ->selectRaw('COUNT(*) - SUM(CASE WHEN firstname = "Employee" THEN 1 ELSE 0 END) as filled')
            ->where('name', '!=', 'OCEO')
            ->groupBy('department', 'business_unit', 'level')
            // Order groups by department, business_unit and then by custom level order
            ->orderBy('department')
            ->orderBy('business_unit')
            ->orderByRaw('FIELD(level, ?, ?, ?, ?)', $level_order)
            ->get();

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

            return response()->json(['message' => 'Image uploaded successfully', 'image_path' => $orgStructure->image]);
        }

        return response()->json(['message' => 'No image file provided'], 400);
    }
}
