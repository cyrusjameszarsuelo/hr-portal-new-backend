<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditTrail;
use App\Models\User;

use Illuminate\Support\Facades\Log;

class AuditLogController extends Controller
{
    public function getAuditLogs(Request $request) {
        // parse pagination params, provide sensible defaults
        $page = (int) $request->query('page', 1);
        $perPage = (int) $request->query('per_page', 20);

        // build query: module LIKE %Function%
        $query = AuditTrail::query()
            ->where('module', 'like', '%Function%')
            ->with('user')
            ->orderBy('created_at', 'desc');

        // use manual pagination so we respect page & per_page from query string
        $results = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json($results);
    }
}
