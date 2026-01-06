<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TableController extends Controller
{
    // Keep an allowlist to avoid arbitrary table access
    protected array $allowed = [
        'users',
        'timesheets',
        // add other syncable tables here
    ];

    // GET /api/tables
    public function index()
    {
        $result = [];
        foreach ($this->allowed as $t) {
            try {
                $updated = DB::table($t)->max('updated_at');
            } catch (\Throwable $e) {
                Log::warning("Unable to fetch updated_at for table {$t}: {$e->getMessage()}");
                $updated = null;
            }
            $result[] = [
                'name' => $t,
                'updated_at' => $updated,
            ];
        }
        return response()->json($result);
    }

    // GET /api/tables/{table}/rows?since=timestamp
    public function rows(string $table, Request $request)
    {
        if (!in_array($table, $this->allowed)) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $since = $request->query('since');
        $query = DB::table($table);

        if ($since) {
            // If numeric, attempt to interpret as unix timestamp (ms or s)
            if (is_numeric($since)) {
                $s = (string) $since;
                // treat >=13 digits as milliseconds
                if (strlen($s) >= 13) {
                    $dt = date('Y-m-d H:i:s', (int) ($since / 1000));
                } else {
                    $dt = date('Y-m-d H:i:s', (int) $since);
                }
                $query->where('updated_at', '>', $dt);
            } else {
                // assume ISO/datetime string
                $query->where('updated_at', '>', $since);
            }
        }

        try {
            $rows = $query->get();
            return response()->json($rows);
        } catch (\Throwable $e) {
            Log::error('Fetch rows failed', ['table' => $table, 'error' => $e->getMessage()]);
            return response()->json(['message' => 'Fetch failed', 'error' => $e->getMessage()], 500);
        }
    }

    // POST /api/tables/{table}/rows
    // Body example: { "action": "upsert", "data": { ... } }
    public function store(string $table, Request $request)
    {
        if (!in_array($table, $this->allowed)) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $payload = $request->validate([
            'action' => 'required|string|in:upsert,delete,create',
            'data' => 'required|array',
        ]);

        $action = $payload['action'];
        $data = $payload['data'];

        DB::beginTransaction();
        try {
            if ($action === 'delete') {
                if (empty($data['id'])) {
                    return response()->json(['message' => 'Missing id for delete'], 400);
                }
                DB::table($table)->where('id', $data['id'])->delete();
                DB::commit();
                return response()->json(['ok' => true]);
            }

            // for create/upsert: set server-authoritative updated_at
            $data['updated_at'] = now();

            if (!empty($data['id'])) {
                DB::table($table)->updateOrInsert(['id' => $data['id']], $data);
                DB::commit();
                return response()->json(['ok' => true, 'id' => $data['id']]);
            } else {
                $id = DB::table($table)->insertGetId($data);
                DB::commit();
                return response()->json(['ok' => true, 'id' => $id]);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Sync failed', ['table' => $table, 'error' => $e->getMessage()]);
            return response()->json(['message' => 'Sync failed', 'error' => $e->getMessage()], 500);
        }
    }
}
