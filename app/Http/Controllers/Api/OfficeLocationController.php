<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OfficeLocation;
use Illuminate\Http\Request;

class OfficeLocationController extends Controller
{
    public function index()
    {
        return response()->json(
            OfficeLocation::orderBy('order_column')->get()
        );
    }

    private function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'fax' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'office_hours' => 'nullable|string|max:255',
            'working_hours' => 'nullable|string',
            'map_embed_code' => 'nullable|string',
            'order_column' => 'nullable|integer',
            'is_primary' => 'boolean',
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $office = OfficeLocation::create($validated);
        return response()->json($office, 201);
    }

    public function show(OfficeLocation $officeLocation)
    {
        return response()->json($officeLocation);
    }

    public function update(Request $request, OfficeLocation $officeLocation)
    {
        $validated = $request->validate($this->rules());
        $officeLocation->update($validated);
        return response()->json($officeLocation);
    }

    public function destroy(OfficeLocation $officeLocation)
    {
        $officeLocation->delete();
        return response()->json(['message' => 'Office location deleted successfully.']);
    }
}
