<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    /**
     * Logs a lightweight, privacy-conscious page view for the Weekly
     * Traffic dashboard widget: no raw IP is stored, only a salted hash
     * used solely to de-duplicate a visitor within the same day.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->isMethod('GET') && $response->getStatusCode() < 400 && ! $request->ajax()) {
            $today = now()->toDateString();

            PageView::create([
                'path' => substr($request->path(), 0, 500),
                'visitor_hash' => hash('sha256', $request->ip().$request->userAgent().$today),
                'visited_on' => $today,
            ]);
        }

        return $response;
    }
}
