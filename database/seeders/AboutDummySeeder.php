<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TeamMember;
use App\Models\CoreValue;
use App\Models\TimelineEvent;
use App\Models\Statistic;
use App\Models\Technology;
use App\Models\Industry;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\OfficeLocation;

class AboutDummySeeder extends Seeder
{
    public function run()
    {
        // Core Values
        CoreValue::create([
            'title' => 'Innovation First',
            'description' => 'We are constantly pushing the boundaries of what is possible with modern technology.',
            'icon' => 'fa-solid fa-lightbulb',
            'order_column' => 1,
        ]);
        CoreValue::create([
            'title' => 'Uncompromising Quality',
            'description' => 'We deliver robust, scalable, and secure software that stands the test of time.',
            'icon' => 'fa-solid fa-gem',
            'order_column' => 2,
        ]);

        // Statistics
        Statistic::create(['value' => '10+', 'label' => 'Years Experience', 'delay' => 100]);
        Statistic::create(['value' => '200+', 'label' => 'Projects Delivered', 'delay' => 200]);
        Statistic::create(['value' => '50+', 'label' => 'Team Members', 'delay' => 300]);
        Statistic::create(['value' => '99%', 'label' => 'Client Satisfaction', 'delay' => 400]);

        // Team
        TeamMember::create([
            'name' => 'Jane Doe',
            'position' => 'Chief Technology Officer',
            'biography' => 'Jane has over 15 years of experience leading engineering teams and designing scalable architectures.',
            'order_column' => 1,
        ]);
        TeamMember::create([
            'name' => 'John Smith',
            'position' => 'Lead Developer',
            'biography' => 'John specializes in full-stack development with a passion for robust backend systems and beautiful UIs.',
            'order_column' => 2,
        ]);

        // Timeline
        TimelineEvent::create([
            'date' => '2015',
            'title' => 'The Beginning',
            'description' => 'CleMwa Developers was founded with a small team of passionate engineers.',
            'order_column' => 1,
        ]);
        TimelineEvent::create([
            'date' => '2020',
            'title' => 'Global Expansion',
            'description' => 'We opened our first international office and expanded our client base across three continents.',
            'order_column' => 2,
        ]);

        // Technologies
        Technology::create(['name' => 'Laravel', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-plain.svg', 'delay' => 100]);
        Technology::create(['name' => 'React', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg', 'delay' => 200]);
        Technology::create(['name' => 'Vue.js', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vuejs/vuejs-original.svg', 'delay' => 300]);
        Technology::create(['name' => 'Docker', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/docker/docker-original.svg', 'delay' => 400]);

        // Industries
        Industry::create([
            'name' => 'Healthcare',
            'description' => 'Secure and compliant software solutions for modern healthcare providers.',
            'icon' => 'fa-solid fa-heart-pulse',
        ]);
        Industry::create([
            'name' => 'Finance',
            'description' => 'Fintech platforms with robust security and high-frequency transaction processing.',
            'icon' => 'fa-solid fa-building-columns',
        ]);

        // Testimonials
        Testimonial::create([
            'quote' => 'CleMwa Developers transformed our business with their incredible software solution. Highly recommended!',
            'client_name' => 'Sarah Johnson',
            'client_role' => 'CEO, TechStart Inc.',
            'delay' => 100,
        ]);

        // Offices
        OfficeLocation::create([
            'name' => 'Global Headquarters',
            'address' => '123 Innovation Drive, Tech City',
            'phone' => '+1 (555) 123-4567',
            'email' => 'contact@clemwadevs.com',
            'order_column' => 1,
        ]);

        // FAQs
        Faq::create([
            'question' => 'Do you provide ongoing support?',
            'answer' => 'Yes! We provide comprehensive maintenance and support packages for all our custom software solutions.',
            'order_column' => 1,
        ]);
    }
}
