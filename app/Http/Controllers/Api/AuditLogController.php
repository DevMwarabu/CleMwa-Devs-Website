<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Display a paginated, filterable listing of audit log entries.
     */
    public function index(Request $request)
    {
        $query = AuditLog::query()->latest('created_at');

        if ($request->filled('action')) {
            $query->where('action', $request->string('action'));
        }

        if ($request->filled('resource')) {
            $query->where('resource', $request->string('resource'));
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->string('user_id'));
        }

        if ($request->filled('result')) {
            $query->where('result', $request->string('result'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date('date_to'));
        }

        return response()->json($query->paginate($request->integer('per_page', 25)));
    }

    /**
     * Display a single audit log entry.
     */
    public function show(AuditLog $auditLog)
    {
        return response()->json($auditLog);
    }
}
