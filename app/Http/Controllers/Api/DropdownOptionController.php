<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DropdownOption;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DropdownOptionController extends Controller
{
    /**
     * Known groups and their human-friendly labels. Any other group value
     * saved via the API will still work — it just won't have a curated
     * label here and the frontend will fall back to a title-cased version.
     */
    public const KNOWN_GROUPS = [
        'project_type' => 'Project Types',
        'project_status' => 'Project Statuses',
        'color_theme' => 'Color Themes',
    ];

    /**
     * List options. Pass ?group=X to scope to one group.
     * Pass ?all=true to include inactive options (used by the Settings page;
     * form dropdowns only ever see active options).
     */
    public function index(Request $request)
    {
        $query = DropdownOption::query()->orderBy('sort_order')->orderBy('label');

        if ($group = $request->query('group')) {
            $query->where('group', $group);
        }

        if (! $request->boolean('all')) {
            $query->where('is_active', true);
        }

        return response()->json($query->get());
    }

    /**
     * List distinct groups present in the table, merged with the known
     * groups list so the Settings page can show empty groups too.
     */
    public function groups()
    {
        $existing = DropdownOption::query()->distinct()->pluck('group');

        $groups = collect(self::KNOWN_GROUPS)
            ->map(fn ($label, $key) => ['key' => $key, 'label' => $label])
            ->values();

        foreach ($existing as $key) {
            if (! isset(self::KNOWN_GROUPS[$key])) {
                $groups->push(['key' => $key, 'label' => Str::headline($key)]);
            }
        }

        return response()->json($groups);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'group' => 'required|string|max:100',
            'value' => 'required|string|max:100',
            'label' => 'nullable|string|max:150',
            'color' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['label'] = $validated['label'] ?? $validated['value'];
        $validated['sort_order'] = $validated['sort_order']
            ?? (DropdownOption::where('group', $validated['group'])->max('sort_order') + 1);

        $option = DropdownOption::create($validated);

        return response()->json($option, 201);
    }

    public function update(Request $request, DropdownOption $dropdownOption)
    {
        $validated = $request->validate([
            'value' => 'sometimes|string|max:100',
            'label' => 'sometimes|string|max:150',
            'color' => 'nullable|string|max:50',
            'sort_order' => 'sometimes|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        $dropdownOption->update($validated);

        return response()->json($dropdownOption);
    }

    public function destroy(DropdownOption $dropdownOption)
    {
        $dropdownOption->delete();

        return response()->json(['message' => 'Option deleted successfully.']);
    }

    /**
     * Persist a new ordering for a group in one request.
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'group' => 'required|string',
            'ids' => 'required|array',
            'ids.*' => 'required|string',
        ]);

        foreach ($validated['ids'] as $index => $id) {
            DropdownOption::where('id', $id)
                ->where('group', $validated['group'])
                ->update(['sort_order' => $index]);
        }

        return response()->json(['message' => 'Order updated.']);
    }
}
