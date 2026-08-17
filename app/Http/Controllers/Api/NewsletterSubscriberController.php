<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterSubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::query();

        if ($search = $request->query('q')) {
            $query->where('email', 'like', "%{$search}%");
        }

        $subscribers = $query->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return response()->json($subscribers);
    }

    public function destroy(NewsletterSubscriber $newsletterSubscriber)
    {
        $newsletterSubscriber->delete();
        return response()->json(['message' => 'Subscriber removed successfully.']);
    }
}
