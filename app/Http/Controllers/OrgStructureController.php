<?php

namespace App\Http\Controllers;

use App\Models\OrgStructure;
use Illuminate\Http\Request;

class OrgStructureController extends Controller
{
    public function index()
    {
        $orgStructure = OrgStructure::where('is_active', true)
            ->get();

        return response()->json($orgStructure);
    }
}
