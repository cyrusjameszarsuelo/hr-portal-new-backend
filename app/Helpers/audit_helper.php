<?php

use App\Models\AuditTrail;
use Illuminate\Support\Facades\Auth;

if (!function_exists('auditLog')) {
    function auditLog($module, $action, $oldData = null, $newData = null, $user_id = null)
    {
        AuditTrail::create([
            'module' => $module,
            'user_id' => $user_id,
            'old_data' => $oldData ? json_encode($oldData) : null,
            'new_data' => $newData ? json_encode($newData) : null,
            'action' => $action,
        ]);
    }
}