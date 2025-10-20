<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditTrail;
use App\Models\User;

use Illuminate\Support\Facades\Log;

class AuditLogController extends Controller
{
    public function getAuditLogs(string $id) {
        // Fetch audit trails for module FunctionParameter and filter where new_data->id == $id
        $records = AuditTrail::where('module', 'FunctionParameter')
            ->orderBy('created_at', 'desc')
            ->get()
            ->filter(function ($row) use ($id) {
                if (!$row->new_data) return false;
                $data = json_decode($row->new_data, true);
                if (!is_array($data)) return false;
                // compare numeric ids reliably
                return isset($data['id']) && intval($data['id']) === intval($id);
            })->values();

        // map to include only user.name when user_id matches
        $payload = $records->map(function ($row) {
            $arr = $row->toArray();
            $user = null;
            if (!empty($row->user_id)) {
                $u = User::select('name')->find($row->user_id);
                if ($u) {
                    $user = ['name' => $u->name];
                }
            }
            $arr['user'] = $user;
            return $arr;
        });

        return response()->json($payload);
    }
}
