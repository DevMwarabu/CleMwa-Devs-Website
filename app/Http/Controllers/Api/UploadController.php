<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /**
     * Upload a single image to public storage and return its URL.
     */
    public function image(Request $request)
    {
        $request->validate([
            'image' => 'required|file|image|max:5120', // max 5MB
        ]);

        $file = $request->file('image');
        $folder = 'projects';
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($folder, $filename, 'public');

        $url = Storage::disk('public')->url($path);

        return response()->json([
            'url' => $url,
            'path' => $path,
        ]);
    }
}
