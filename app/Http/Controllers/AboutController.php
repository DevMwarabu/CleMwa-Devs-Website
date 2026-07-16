<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeamMember;
use App\Models\CoreValue;
use App\Models\TimelineEvent;
use App\Models\Industry;
use App\Models\Certification;
use App\Models\Award;
use App\Models\OfficeLocation;
use App\Models\Faq;
use App\Models\AboutSetting;
use App\Models\Statistic;
use App\Models\Partner;
use App\Models\Technology;
use App\Models\Testimonial;

class AboutController extends Controller
{
    public function index()
    {
        $settings = AboutSetting::first() ?? new AboutSetting([
            'hero_title' => 'About CleMwa Developers',
            'hero_description' => 'Building innovative software solutions that empower businesses, organizations, and governments through modern technology, secure architecture, and exceptional user experiences.',
            'overview' => 'We are a premier software engineering firm committed to delivering high-quality digital solutions.',
            'our_story' => 'Founded with a vision to transform the digital landscape, we have grown from a small team to a global technology partner.',
            'mission' => 'To empower businesses through innovative, secure, scalable, and intelligent software solutions that create measurable value.',
            'vision' => 'To become a globally recognized software engineering company delivering world-class digital solutions that transform industries and improve lives.',
            'development_philosophy' => 'We follow agile methodologies, ensuring transparency, collaboration, and continuous delivery.',
            'culture_description' => 'At CleMwa Developers, we foster an environment of continuous learning, innovation, and mutual respect.',
            'careers_preview' => 'Join us and work on exciting projects that make a real difference.',
            'cta_heading' => 'Let\'s Build Something Amazing Together',
            'cta_description' => 'Whether you\'re a startup, enterprise, government institution, or growing business, we\'re ready to help you transform your ideas into reliable digital solutions.'
        ]);

        return view('about', [
            'settings' => $settings,
            'teamMembers' => TeamMember::orderBy('order_column')->get(),
            'coreValues' => CoreValue::orderBy('order_column')->get(),
            'timelineEvents' => TimelineEvent::orderBy('order_column')->get(),
            'industries' => Industry::orderBy('order_column')->get(),
            'certifications' => Certification::orderBy('order_column')->get(),
            'awards' => Award::orderBy('order_column')->get(),
            'officeLocations' => OfficeLocation::orderBy('order_column')->get(),
            'faqs' => Faq::orderBy('order_column')->get(),
            'statistics' => Statistic::orderBy('delay')->get(),
            'partners' => Partner::all(),
            'technologies' => Technology::orderBy('delay')->get(),
            'testimonials' => Testimonial::orderBy('delay')->get(),
        ]);
    }
}
