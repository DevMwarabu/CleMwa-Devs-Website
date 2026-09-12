<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Server;
use App\Support\AuditLogger;
use App\Support\MetricRangeQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Server::with('metric')->latest()->get());
    }

    /**
     * Store a newly created resource in storage. Issues a one-time agent
     * token — this is the only response that will ever contain it.
     */
    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $server = Server::create($validated);
        $token = $server->createToken('agent', ['agent:heartbeat'])->plainTextToken;

        AuditLogger::log('server.created', 'Server', $server->id, [], $server->toArray());

        return response()->json(['server' => $server, 'token' => $token], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Server $server)
    {
        return response()->json($server->load('metric'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Server $server)
    {
        $validated = $this->validated($request, $server);
        $before = $server->toArray();

        $server->update($validated);

        AuditLogger::log('server.updated', 'Server', $server->id, $before, $server->fresh()->toArray());

        return response()->json($server->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Server $server)
    {
        $server->tokens()->delete();
        $before = $server->toArray();
        $server->delete();

        AuditLogger::log('server.deleted', 'Server', $before['id'], $before, []);

        return response()->json(null, 204);
    }

    /**
     * Revoke the server's current agent token(s) and issue a new one.
     */
    public function rotateToken(Server $server)
    {
        $server->tokens()->delete();
        $token = $server->createToken('agent', ['agent:heartbeat'])->plainTextToken;

        AuditLogger::log('server.token_rotated', 'Server', $server->id);

        return response()->json(['token' => $token]);
    }

    /**
     * Historical CPU/memory/disk trend for a server. Short ranges (1h/6h)
     * return raw points (capped at the most recent 500, chronological
     * order); long ranges (24h/7d) return one "last observed" point per
     * bucket (hour/day) via a DB-level DISTINCT ON, not a full row dump —
     * this only ever computes the three scalar metrics actually charted
     * (cpu.usage_percent, memory used %, root-filesystem used %). A fully
     * generic arbitrary-metric query engine is deferred until dashboard
     * panels need one.
     */
    public function metricsHistory(Request $request, Server $server)
    {
        $range = MetricRangeQuery::resolve($request->query('range'));
        $config = MetricRangeQuery::config($range);
        $since = MetricRangeQuery::since($range);

        if ($config['bucket'] === null) {
            $rows = DB::table('server_metric_history')
                ->where('server_id', $server->id)
                ->where('collected_at', '>=', $since)
                ->orderByDesc('collected_at')
                ->limit(500)
                ->get(['cpu', 'memory', 'disk', 'collected_at'])
                ->reverse()
                ->values();
        } else {
            // "Last observed row per bucket" via a window function rather
            // than Postgres's DISTINCT ON — this app runs Postgres in
            // production but SQLite in tests, and ROW_NUMBER() is portable
            // to both, where DISTINCT ON only exists in Postgres.
            $bucketExpr = MetricRangeQuery::bucketExpr('collected_at', $config['bucket']);
            $rows = collect(DB::select(
                "select bucket, cpu, memory, disk, collected_at from (
                    select {$bucketExpr} as bucket, cpu, memory, disk, collected_at,
                           row_number() over (partition by {$bucketExpr} order by collected_at desc) as rn
                    from server_metric_history
                    where server_id = ? and collected_at >= ?
                 ) ranked
                 where rn = 1
                 order by bucket",
                [$server->id, $since]
            ));
        }

        $points = $rows->map(function ($row) {
            return array_merge(
                ['collected_at' => Carbon::parse($row->collected_at)->toIso8601String()],
                MetricRangeQuery::extractPercentages($row->cpu, $row->memory, $row->disk)
            );
        });

        return response()->json(['range' => $range, 'points' => $points]);
    }

    private function validated(Request $request, ?Server $server = null): array
    {
        return $request->validate([
            'name' => $server ? 'sometimes|string|max:255' : 'required|string|max:255',
            'hostname' => 'nullable|string|max:255',
            'ip_address' => 'nullable|string|max:100',
            'public_ip' => 'nullable|string|max:100',
            'private_ip' => 'nullable|string|max:100',
            'os' => 'nullable|string|max:100',
            'os_version' => 'nullable|string|max:100',
            'kernel_version' => 'nullable|string|max:100',
            'architecture' => 'nullable|string|max:50',
            'cpu_cores' => 'nullable|integer|min:1',
            'ram_mb' => 'nullable|integer|min:1',
            'storage_gb' => 'nullable|integer|min:1',
            'environment' => 'nullable|string|in:production,staging,development',
            'role' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:100',
            'critical_services' => 'nullable|array',
            'critical_services.*' => 'string|max:100',
        ]);
    }
}
