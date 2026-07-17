<?php

namespace Database\Seeders;

use App\Models\HomeSetting;
use Illuminate\Database\Seeder;

class HomeSettingSeeder extends Seeder
{
    public function run(): void
    {
        HomeSetting::firstOrCreate(
            ['id' => 1],
            [
                'hero_badge_text' => 'Industry-Leading Software Solutions',
                'hero_headline' => 'We Build Software',
                'hero_headline_highlight' => 'That Matters',
                'hero_subheadline' => 'Enterprise-grade applications, AI-powered platforms, and digital infrastructure built to scale with your ambitions.',
                'hero_cta_primary_text' => 'Start Your Project',
                'hero_cta_primary_url' => '/contact',
                'hero_cta_secondary_text' => 'View Our Work',
                'hero_cta_secondary_url' => '/portfolio',

                'trusted_by_label' => 'Trusted by innovative companies & partners',

                'services_section_title' => 'Enterprise-Grade Solutions',
                'services_section_subtitle' => 'Discover our comprehensive suite of software development services designed for modern businesses.',
                'services_cta_text' => 'View All Services',
                'services_cta_url' => '/services',

                'products_section_title' => 'Our Flagship Products',
                'products_section_subtitle' => 'Powerful, ready-to-deploy platforms built to accelerate your business operations and growth.',
                'products_cta_text' => 'Explore All Products',
                'products_cta_url' => '/products',

                'portfolio_section_title' => 'Featured Work',
                'portfolio_section_subtitle' => 'Real solutions, measurable results. Explore the work we\'re most proud of.',
                'portfolio_cta_text' => 'View All Projects',
                'portfolio_cta_url' => '/portfolio',

                'process_section_title' => 'How We Work',
                'process_section_subtitle' => 'Our battle-tested process ensures every project is delivered on time, within budget, and beyond expectations.',

                'stats_section_title' => 'By the Numbers',
                'stats_section_subtitle' => 'Metrics that define our track record and commitment to excellence.',

                'testimonials_section_title' => 'Client Success Stories',
                'testimonials_section_subtitle' => 'Don\'t just take our word for it — hear from the teams we\'ve helped transform.',

                'cta_banner_title' => 'Ready to Build Something Extraordinary?',
                'cta_banner_subtitle' => 'Let\'s discuss how CleMwa Developers can transform your vision into a high-performance digital solution.',
                'cta_banner_primary_text' => 'Start Your Project',
                'cta_banner_primary_url' => '/contact',
                'cta_banner_secondary_text' => 'Schedule a Consultation',
                'cta_banner_secondary_url' => '/contact',
            ]
        );
    }
}
