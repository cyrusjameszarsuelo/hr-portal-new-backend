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
            'email' => 'sometimes|email|max:255',
            'emp_no' => 'sometimes|string|max:50|nullable',
            'firstname' => 'sometimes|string|max:100',
            'lastname' => 'sometimes|string|max:100',
            'level' => 'sometimes|string|max:50',
            'nickname' => 'sometimes|string|max:100',
            'position_title' => 'sometimes|string|max:255',
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
        // Return department and business unit headcounts. Use explicit select with
        // COUNT to avoid ONLY_FULL_GROUP_BY SQL errors on MySQL strict modes.
        $headCount = OrgStructure::select('department', 'business_unit')
            ->selectRaw('COUNT(*) as headcount')
            ->selectRaw('SUM(CASE WHEN firstname = "Employee" THEN 1 ELSE 0 END) as vacant')
            ->selectRaw('COUNT(*) - SUM(CASE WHEN firstname = "Employee" THEN 1 ELSE 0 END) as filled')
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
}
