<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AlertState;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    /**
     * Current alert states (one row per rule x server). Not paginated —
     * this is meant to be a small "what's happening right now" list, not a
     * historical log (that's AlertEventController).
     */
    public function index(Request $request)
    {
        $query = AlertState::with(['rule', 'server']);

        if ($request->filled('state')) {
            $query->where('state', $request->string('state'));
        } else {
            // Default view: only what's actually interesting right now.
            $query->whereIn('state', ['pending', 'firing']);
        }

        $states = $query->get()->map(function (AlertState $state) {
            $data = $state->toArray();
            $data['is_silenced'] = $state->isSilenced();

            return $data;
        });

        return response()->json($states);
    }
}
