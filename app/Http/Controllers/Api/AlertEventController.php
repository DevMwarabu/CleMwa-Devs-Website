<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AlertEvent;
use Illuminate\Http\Request;

class AlertEventController extends Controller
{
    public function index(Request $request)
    {
        $query = AlertEvent::with(['rule', 'server'])->latest('occurred_at');

        if ($request->filled('server_id')) {
            $query->where('server_id', $request->string('server_id'));
        }

        if ($request->filled('alert_rule_id')) {
            $query->where('alert_rule_id', $request->integer('alert_rule_id'));
        }

        if ($request->filled('to_state')) {
            $query->where('to_state', $request->string('to_state'));
        }

        return response()->json($query->paginate($request->integer('per_page', 25)));
    }
}
