<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_published', true)
            ->orderByDesc('published_at')
            ->get();

        $categories = $posts->pluck('category')->filter()->unique()->values();

        return view('blog', compact('posts', 'categories'));
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->where('is_published', true)->firstOrFail();

        $relatedPosts = Post::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->when($post->category, fn ($query) => $query->where('category', $post->category))
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('blog-details', compact('post', 'relatedPosts'));
    }
}
