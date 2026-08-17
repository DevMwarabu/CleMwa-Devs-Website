<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        // Honeypot: bots fill hidden fields humans never see.
        if ($request->filled('honeypot_field')) {
            return response()->json(['message' => 'Thanks for subscribing!']);
        }

        $data = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $existing = NewsletterSubscriber::where('email', $data['email'])->first();

        if ($existing) {
            if (! $existing->is_active) {
                $existing->update(['is_active' => true]);
            }
        } else {
            NewsletterSubscriber::create([
                'email' => $data['email'],
                'source' => 'Footer',
            ]);
        }

        return response()->json([
            'message' => 'You\'re subscribed! Thanks for joining our newsletter.',
        ]);
    }
}
