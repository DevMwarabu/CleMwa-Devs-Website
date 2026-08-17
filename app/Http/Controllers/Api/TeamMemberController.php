<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index()
    {
        return response()->json(
            TeamMember::orderBy('order_column')->get()
        );
    }

    private function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'biography' => 'nullable|string',
            'experience_years' => 'nullable|integer',
            'expertise' => 'nullable|array',
            'social_links' => 'nullable|array',
            'photo_url' => 'nullable|string|max:500',
            'order_column' => 'nullable|integer',
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $member = TeamMember::create($validated);
        return response()->json($member, 201);
    }

    public function show(TeamMember $teamMember)
    {
        return response()->json($teamMember);
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $validated = $request->validate($this->rules());
        $teamMember->update($validated);
        return response()->json($teamMember);
    }

    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();
        return response()->json(['message' => 'Team member deleted successfully.']);
    }
}
