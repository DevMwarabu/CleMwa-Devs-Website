<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProductSetting;

class ProductController extends Controller
{
    public function index()
    {
        $settings = ProductSetting::first();
        $products = Product::orderBy('delay')->get();
        $featuredProducts = Product::where('is_featured', true)->orderBy('delay')->get();
        $categories = $products->pluck('category')->filter()->unique()->values();

        return view('products', compact('settings', 'products', 'featuredProducts', 'categories'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->limit(3)
            ->get();

        return view('product-details', compact('product', 'relatedProducts'));
    }
}

