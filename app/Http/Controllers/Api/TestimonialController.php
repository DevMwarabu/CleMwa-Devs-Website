<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $query = Testimonial::query();

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('client_role', 'like', "%{$search}%")
                  ->orWhere('quote', 'like', "%{$search}%");
            });
        }

        if ($request->has('approved')) {
            $query->where('is_approved', $request->query('approved') === 'true');
        }

        $testimonials = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return response()->json($testimonials);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name'      => 'required|string|max:255',
            'client_role'      => 'required|string|max:255',
            'quote'            => 'required|string',
            'client_image_url' => 'nullable|string|max:500',
            'delay'            => 'nullable|integer',
            'is_approved'      => 'boolean',
        ]);

        $testimonial = Testimonial::create($validated);
        return response()->json($testimonial, 201);
    }

    public function show(Testimonial $testimonial)
    {
        return response()->json($testimonial);
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'client_name'      => 'required|string|max:255',
            'client_role'      => 'required|string|max:255',
            'quote'            => 'required|string',
            'client_image_url' => 'nullable|string|max:500',
            'delay'            => 'nullable|integer',
            'is_approved'      => 'boolean',
        ]);

        $testimonial->update($validated);
        return response()->json($testimonial);
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return response()->json(['message' => 'Testimonial deleted successfully.']);
    }
}
