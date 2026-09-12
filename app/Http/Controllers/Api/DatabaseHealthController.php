<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DatabaseHealthController extends Controller
{
    /**
     * Real numbers about this app's own Postgres database — not a generic
     * "add any external database" feature (that needs its own credential
     * storage/security model, deliberately out of scope for this pass; see
     * the Phase 9 plan). This is honest self-monitoring, matching §66.
     */
    public function summary()
    {
        if (DB::connection()->getDriverName() !== 'pgsql') {
            return response()->json(['supported' => false, 'message' => 'Database health is only implemented for PostgreSQL.']);
        }

        $dbName = DB::connection()->getDatabaseName();

        $activity = DB::selectOne(
            "select
                count(*) filter (where state = 'active') as active_connections,
                count(*) filter (where state = 'idle') as idle_connections,
                count(*) as total_connections
             from pg_stat_activity
             where datname = ?",
            [$dbName]
        );

        $dbStats = DB::selectOne(
            'select
                xact_commit, xact_rollback, blks_read, blks_hit,
                tup_returned, tup_fetched, tup_inserted, tup_updated, tup_deleted
             from pg_stat_database
             where datname = ?',
            [$dbName]
        );

        $sizeBytes = DB::selectOne('select pg_database_size(?) as size', [$dbName])->size;

        $cacheHitRatio = null;
        if ($dbStats && ($dbStats->blks_hit + $dbStats->blks_read) > 0) {
            $cacheHitRatio = round(100 * $dbStats->blks_hit / ($dbStats->blks_hit + $dbStats->blks_read), 2);
        }

        $locks = DB::selectOne('select count(*) as count from pg_locks where not granted');

        return response()->json([
            'supported' => true,
            'database' => $dbName,
            'size_mb' => round($sizeBytes / (1024 * 1024), 1),
            'active_connections' => (int) $activity->active_connections,
            'idle_connections' => (int) $activity->idle_connections,
            'total_connections' => (int) $activity->total_connections,
            'cache_hit_ratio_percent' => $cacheHitRatio,
            'waiting_locks' => (int) $locks->count,
            'transactions_committed' => (int) ($dbStats->xact_commit ?? 0),
            'transactions_rolled_back' => (int) ($dbStats->xact_rollback ?? 0),
        ]);
    }
}
