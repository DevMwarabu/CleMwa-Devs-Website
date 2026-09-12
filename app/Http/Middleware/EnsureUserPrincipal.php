<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sanctum's personal_access_tokens table is polymorphic — since Server also
 * authenticates via HasApiTokens, an agent token would otherwise pass
 * auth:sanctum on every admin route with no further check. This confines
 * the main admin API to real User principals only.
 */
class EnsureUserPrincipal
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() instanceof User) {
            abort(403, 'This endpoint requires a user session.');
        }

        return $next($request);
    }
}
