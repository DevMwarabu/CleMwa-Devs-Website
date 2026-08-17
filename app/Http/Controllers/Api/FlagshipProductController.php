<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FlagshipProduct;
use Illuminate\Http\Request;

class FlagshipProductController extends Controller
{
    public function index(Request $request)
    {
        $query = FlagshipProduct::query();

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'image_url'     => 'nullable|string|max:500',
            'theme_color'   => 'nullable|string|max:50',
            'is_live'       => 'boolean',
            'demo_link'     => 'nullable|string|max:500',
            'details_link'  => 'nullable|string|max:500',
        ]);

        $product = FlagshipProduct::create($validated);
        return response()->json($product, 201);
    }

    public function show(FlagshipProduct $flagshipProduct)
    {
        return response()->json($flagshipProduct);
    }

    public function update(Request $request, FlagshipProduct $flagshipProduct)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'image_url'     => 'nullable|string|max:500',
            'theme_color'   => 'nullable|string|max:50',
            'is_live'       => 'boolean',
            'demo_link'     => 'nullable|string|max:500',
            'details_link'  => 'nullable|string|max:500',
        ]);

        $flagshipProduct->update($validated);
        return response()->json($flagshipProduct);
    }

    public function destroy(FlagshipProduct $flagshipProduct)
    {
        $flagshipProduct->delete();
        return response()->json(['message' => 'Product deleted successfully.']);
    }
}
