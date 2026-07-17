<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ContactSetting;
use App\Models\OfficeLocation;
use App\Models\Faq;
use App\Models\Lead;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $settings = ContactSetting::first();
        $offices = OfficeLocation::orderBy('order_column')->get();
        // Assuming we're fetching FAQs categorized for Contact, or just all FAQs if small.
        $faqs = Faq::where('category', 'Contact')->orWhereNull('category')->orderBy('order_column')->get();
        $prefillSubject = $request->query('subject');

        return view('contact', compact('settings', 'offices', 'faqs', 'prefillSubject'));
    }

    public function store(Request $request)
    {
        // Honeypot: bots fill hidden fields humans never see.
        if ($request->filled('honeypot_field')) {
            return response()->json(['message' => 'Thanks! We\'ll be in touch shortly.']);
        }

        $data = $request->validate([
            'type' => 'required|in:inquiry,consultation',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'service' => 'nullable|string|max:255',
            'budget' => 'nullable|string|max:255',
            'preferred_date' => 'nullable|date',
            'preferred_time' => 'nullable|string|max:50',
            'meeting_type' => 'nullable|string|max:100',
            'message' => 'required|string',
        ]);

        $messageParts = [];
        if (!empty($data['service'])) {
            $messageParts[] = 'Service interested in: '.$data['service'];
        }
        if (!empty($data['budget'])) {
            $messageParts[] = 'Budget range: '.$data['budget'];
        }
        if (!empty($data['preferred_date']) || !empty($data['preferred_time'])) {
            $messageParts[] = 'Preferred time: '.trim(($data['preferred_date'] ?? '').' '.($data['preferred_time'] ?? ''));
        }
        if (!empty($data['meeting_type'])) {
            $messageParts[] = 'Meeting type: '.$data['meeting_type'];
        }
        $messageParts[] = $data['message'];

        Lead::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'company' => $data['company'] ?? null,
            'type' => $data['type'],
            'subject' => $data['type'] === 'consultation' ? 'Consultation Request' : ($data['service'] ?? 'Project Inquiry'),
            'message' => implode("\n", $messageParts),
            'source' => 'Contact Page',
            'status' => 'new',
        ]);

        return response()->json([
            'message' => $data['type'] === 'consultation'
                ? 'Thanks! We\'ve received your consultation request and will confirm a time shortly.'
                : 'Thanks! Your message has been sent. Our team will get back to you soon.',
        ]);
    }
}
