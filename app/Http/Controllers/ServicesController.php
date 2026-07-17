<?php

namespace App\Http\Controllers;

use App\Models\ServiceSetting;
use App\Models\ServiceCategory;
use App\Models\CaseStudy;
use App\Models\ProcessStep;
use App\Models\Technology;
use App\Models\Industry;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        $settings = ServiceSetting::first();
        $categories = ServiceCategory::with('services')->orderBy('order_column')->get();
        $featuredServices = Service::where('is_featured', true)->orderBy('delay')->get();
        $allServices = Service::with('category')->orderBy('delay')->get();
        $processSteps = ProcessStep::orderBy('step_number')->get();
        $technologies = Technology::orderBy('delay')->get()->unique('name');
        $industries = Industry::orderBy('order_column')->get();
        $testimonials = Testimonial::orderBy('delay')->get();
        $faqs = Faq::orderBy('order_column')->get();
        $caseStudies = CaseStudy::orderBy('order_column')->get();

        return view('services', compact(
            'settings',
            'categories',
            'featuredServices',
            'allServices',
            'processSteps',
            'technologies',
            'industries',
            'testimonials',
            'faqs',
            'caseStudies'
        ));
    }

    public function show(string $slug)
    {
        $service = Service::where('slug', $slug)->with('category')->firstOrFail();
        $relatedServices = Service::where('service_category_id', $service->service_category_id)
            ->where('id', '!=', $service->id)
            ->limit(3)
            ->get();

        return view('service-details', compact('service', 'relatedServices'));
    }
}
