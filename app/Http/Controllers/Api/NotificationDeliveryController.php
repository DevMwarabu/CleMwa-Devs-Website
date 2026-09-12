<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NotificationDelivery;
use Illuminate\Http\Request;

class NotificationDeliveryController extends Controller
{
    public function index(Request $request)
    {
        $query = NotificationDelivery::with('server')->latest('attempted_at');

        if ($request->filled('server_id')) {
            $query->where('server_id', $request->string('server_id'));
        }

        if ($request->filled('channel')) {
            $query->where('channel', $request->string('channel'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        return response()->json($query->paginate($request->integer('per_page', 25)));
    }
}
