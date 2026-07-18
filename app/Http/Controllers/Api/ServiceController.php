<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->query('featured') === 'true') {
            $query->where('is_featured', true);
        }

        $services = $query->select(
            'id', 'title', 'slug', 'short_description', 'color_theme',
            'image_url', 'is_featured', 'starting_price', 'typical_timeline',
            'service_category_id', 'created_at'
        )
        ->orderBy('created_at', 'desc')
        ->paginate(15)
        ->withQueryString();

        return response()->json($services);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'                => 'required|string|max:255',
            'slug'                 => 'nullable|string|unique:services,slug|max:255',
            'description'          => 'nullable|string',
            'content'              => 'nullable|string',
            'short_description'    => 'nullable|string',
            'detailed_description' => 'nullable|string',
            'icon_svg'             => 'nullable|string',
            'color_theme'          => 'nullable|string|max:50',
            'delay'                => 'nullable|integer',
            'image_url'            => 'nullable|string|max:500',
            'key_features'         => 'nullable|array',
            'business_benefits'    => 'nullable|array',
            'typical_timeline'     => 'nullable|string|max:100',
            'starting_price'       => 'nullable|string|max:100',
            'is_featured'          => 'boolean',
            'service_category_id'  => 'nullable|integer|exists:service_categories,id',
            'seo_title'            => 'nullable|string|max:255',
            'seo_description'      => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        }

        $service = Service::create($validated);
        return response()->json($service, 201);
    }

    public function show(Service $service)
    {
        return response()->json($service);
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title'                => 'required|string|max:255',
            'slug'                 => "nullable|string|unique:services,slug,{$service->id}|max:255",
            'description'          => 'nullable|string',
            'content'              => 'nullable|string',
            'short_description'    => 'nullable|string',
            'detailed_description' => 'nullable|string',
            'icon_svg'             => 'nullable|string',
            'color_theme'          => 'nullable|string|max:50',
            'delay'                => 'nullable|integer',
            'image_url'            => 'nullable|string|max:500',
            'key_features'         => 'nullable|array',
            'business_benefits'    => 'nullable|array',
            'typical_timeline'     => 'nullable|string|max:100',
            'starting_price'       => 'nullable|string|max:100',
            'is_featured'          => 'boolean',
            'service_category_id'  => 'nullable|integer|exists:service_categories,id',
            'seo_title'            => 'nullable|string|max:255',
            'seo_description'      => 'nullable|string',
        ]);

        $service->update($validated);
        return response()->json($service);
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json(['message' => 'Service deleted successfully.']);
    }
}
