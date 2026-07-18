<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->has('published')) {
            $query->where('is_published', $request->query('published') === 'true');
        }

        $posts = $query->select(
            'id', 'title', 'slug', 'excerpt', 'featured_image',
            'category', 'author_name', 'is_published', 'published_at', 'created_at'
        )
        ->orderBy('created_at', 'desc')
        ->paginate(15)
        ->withQueryString();

        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'slug'           => 'nullable|string|unique:posts,slug|max:255',
            'excerpt'        => 'nullable|string',
            'content'        => 'nullable|string',
            'featured_image' => 'nullable|string|max:500',
            'category'       => 'nullable|string|max:255',
            'tags'           => 'nullable|array',
            'author_name'    => 'nullable|string|max:255',
            'author_avatar'  => 'nullable|string|max:500',
            'is_published'   => 'boolean',
            'published_at'   => 'nullable|date',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        }

        if (isset($validated['is_published']) && $validated['is_published']) {
            $validated['published_at'] = $validated['published_at'] ?? now();
        } else {
            $validated['published_at'] = null;
        }

        $post = Post::create($validated);
        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return response()->json($post);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'slug'           => "nullable|string|unique:posts,slug,{$post->id}|max:255",
            'excerpt'        => 'nullable|string',
            'content'        => 'nullable|string',
            'featured_image' => 'nullable|string|max:500',
            'category'       => 'nullable|string|max:255',
            'tags'           => 'nullable|array',
            'author_name'    => 'nullable|string|max:255',
            'author_avatar'  => 'nullable|string|max:500',
            'is_published'   => 'boolean',
            'published_at'   => 'nullable|date',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        }

        if (isset($validated['is_published'])) {
            if ($validated['is_published'] && !$post->is_published) {
                $validated['published_at'] = now();
            } elseif (!$validated['is_published']) {
                $validated['published_at'] = null;
            }
        }

        $post->update($validated);
        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully.']);
    }
}
