<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $leads = Lead::orderBy('created_at', 'desc')->paginate(15);
        return response()->json($leads);
    }

    public function show(Lead $lead)
    {
        return response()->json($lead);
    }

    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'status' => 'nullable|string|in:new,contacted,converted,archived',
            'notes'  => 'nullable|string',
        ]);

        $lead->update($validated);
        return response()->json($lead);
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return response()->json(['message' => 'Lead deleted successfully.']);
    }
}
