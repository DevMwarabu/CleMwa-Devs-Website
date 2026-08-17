<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserPresence;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    /**
     * Users are considered "online" if they've sent a heartbeat within
     * this many seconds. The admin SPA pings every 20s, so 60s gives
     * a couple of missed beats of tolerance before someone drops off
     * the list.
     */
    private const ONLINE_WINDOW_SECONDS = 60;

    public function heartbeat(Request $request)
    {
        $validated = $request->validate([
            'page_path' => 'nullable|string|max:500',
            'page_label' => 'nullable|string|max:150',
        ]);

        $presence = UserPresence::updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'page_path' => $validated['page_path'] ?? null,
                'page_label' => $validated['page_label'] ?? null,
                'last_seen_at' => now(),
            ]
        );

        return response()->json($presence);
    }

    public function index(Request $request)
    {
        $online = UserPresence::with('user:id,name,email')
            ->where('last_seen_at', '>=', now()->subSeconds(self::ONLINE_WINDOW_SECONDS))
            ->get()
            ->map(fn ($p) => [
                'user_id' => $p->user_id,
                'name' => $p->user?->name,
                'email' => $p->user?->email,
                'page_path' => $p->page_path,
                'page_label' => $p->page_label,
                'last_seen_at' => $p->last_seen_at,
                'is_self' => $p->user_id === $request->user()->id,
            ]);

        return response()->json($online);
    }
}
