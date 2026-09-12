<?php

namespace App\Http\Middleware;

use App\Models\Server;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Mirrors EnsureUserPrincipal for the agent-facing side: a User's session
 * token must never be usable against agent-only routes either.
 */
class EnsureServerPrincipal
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() instanceof Server) {
            abort(403, 'This endpoint requires an agent token.');
        }

        return $next($request);
    }
}
