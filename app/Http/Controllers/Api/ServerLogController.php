<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Server;
use App\Models\ServerLog;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ServerLogController extends Controller
{
    public function index(Request $request, Server $server)
    {
        $query = $this->filtered($request, $server);

        return response()->json($query->paginate($request->integer('per_page', 50)));
    }

    public function export(Request $request, Server $server): StreamedResponse
    {
        $rows = $this->filtered($request, $server)->limit(10000)->get();

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['logged_at', 'source', 'level', 'message']);
            foreach ($rows as $row) {
                fputcsv($out, [$row->logged_at->toIso8601String(), $row->source, $row->level, $row->message]);
            }
            fclose($out);
        }, "server-{$server->id}-logs.csv", ['Content-Type' => 'text/csv']);
    }

    private function filtered(Request $request, Server $server)
    {
        $query = ServerLog::where('server_id', $server->id)->latest('logged_at');

        if ($request->filled('search')) {
            // LOWER()+LIKE rather than Postgres-only ILIKE — this app runs
            // Postgres in production but SQLite in tests (see the Phase
            // 4/5 driver-portability lesson: don't assume one engine).
            $query->whereRaw('LOWER(message) LIKE ?', ['%'.strtolower((string) $request->string('search')).'%']);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->string('level'));
        }

        if ($request->filled('source')) {
            $query->where('source', $request->string('source'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('logged_at', '>=', $request->date('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('logged_at', '<=', $request->date('date_to'));
        }

        return $query;
    }
}
