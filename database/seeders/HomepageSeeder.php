<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomepageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Partners
        \App\Models\Partner::truncate();
        \App\Models\Partner::insert([
            ['name' => 'TechCorp', 'logo_svg' => '<path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>', 'color_theme' => 'sky'],
            ['name' => 'InnovateX', 'logo_svg' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>', 'color_theme' => 'violet'],
            ['name' => 'GlobalSys', 'logo_svg' => '<path d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 18a8 8 0 110-16 8 8 0 010 16z"/>', 'color_theme' => 'emerald'],
            ['name' => 'Nexus Group', 'logo_svg' => '<path d="M13 10V3L4 14h7v7l9-11h-7z"/>', 'color_theme' => 'orange'],
            ['name' => 'FutureWeb', 'logo_svg' => '<path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>', 'color_theme' => 'rose'],
        ]);

        // 2. Flagship Products
        \App\Models\FlagshipProduct::truncate();
        \App\Models\FlagshipProduct::insert([
            [
                'title' => 'MagdaPOS',
                'description' => 'An omnichannel Point of Sale and ERP system designed for modern retail. Sync offline sales with cloud analytics in real-time.',
                'image_url' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&q=80&w=800',
                'theme_color' => 'orange',
                'is_live' => true,
                'demo_link' => '#',
                'details_link' => '#'
            ],
            [
                'title' => 'EduTech Core',
                'description' => 'A comprehensive Learning Management System with interactive video streaming, automated grading, and AI insights.',
                'image_url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=800',
                'theme_color' => 'sky',
                'is_live' => true,
                'demo_link' => '#',
                'details_link' => '#'
            ]
        ]);

        // 3. Features
        \App\Models\Feature::truncate();
        \App\Models\Feature::insert([
            [
                'title' => 'Secure by Design',
                'description' => 'Enterprise-grade security protocols, regular audits, and robust data encryption to protect your intellectual property.',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
                'theme_color' => 'emerald',
                'delay' => 0
            ],
            [
                'title' => 'Scalable Architecture',
                'description' => 'Microservices and serverless architectures built to handle millions of requests without breaking a sweat.',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>',
                'theme_color' => 'sky',
                'delay' => 100
            ],
            [
                'title' => 'Fast Delivery',
                'description' => 'Agile methodologies and CI/CD pipelines ensuring rapid, reliable feature rollouts for your users.',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
                'theme_color' => 'violet',
                'delay' => 200
            ]
        ]);

        // 4. Projects
        \App\Models\Project::truncate();
        \App\Models\Project::insert([
            [
                'id' => '7cdfdbee-76f0-479b-b79f-8d32bb0d6d30',
                'title' => 'NextGen Banking Platform',
                'subtitle' => 'FinTech Dashboard',
                'description' => 'A high-performance financial dashboard handling real-time transactions with enterprise-grade security.',
                'content' => '<p>The modern financial landscape requires tools that are not only robust and secure but also highly performant and intuitive. We built the NextGen Banking Platform to bridge the gap between complex financial data and user-friendly interfaces.</p><h3>Architecture & Scale</h3><p>Handling millions of daily transactions, our microservices architecture ensures 99.99% uptime. By leveraging modern caching strategies and asynchronous processing, we reduced transaction latency to under 50ms.</p>',
                'challenge' => 'Legacy systems were struggling to handle peak transaction loads, resulting in slow dashboard load times and poor user experience for institutional clients.',
                'solution' => 'We implemented a fully decoupled React frontend powered by a horizontally scalable Laravel backend API, integrating WebSockets for real-time portfolio updates.',
                'results' => 'Dashboard load times decreased by 400%, and the platform securely processed over $2B in transactions within the first quarter of launch.',
                'client_name' => 'Global Finance Corp',
                'industry' => 'Financial Services',
                'project_type' => 'Enterprise Web Application',
                'image_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=1000',
                'tags' => json_encode(['React', 'Laravel', 'Redis', 'WebSockets']),
                'requires_quote' => true,
                'color_theme' => 'sky',
                'delay' => 0,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'title' => 'Luxe Retail Mobile Experience',
                'subtitle' => 'E-Commerce App',
                'description' => 'An elegant, cross-platform mobile shopping application with seamless checkout and real-time inventory.',
                'content' => '<p>Luxury brands demand luxury digital experiences. We crafted this mobile application to reflect the brand\'s high-end aesthetic while providing a frictionless shopping journey from discovery to checkout.</p><h3>Seamless Omnichannel</h3><p>The app synchronizes in real-time with physical store inventories, allowing customers to reserve items online and try them on in-store, creating a true omnichannel luxury experience.</p>',
                'challenge' => 'The client needed a mobile presence that felt native on both iOS and Android without doubling the development budget and timeline.',
                'solution' => 'We utilized Flutter to build a visually stunning, highly animated cross-platform app, backed by a robust Firebase architecture for real-time inventory synchronization.',
                'results' => 'Mobile conversion rates jumped by 150%, and the app achieved a 4.9-star rating on both the App Store and Google Play.',
                'client_name' => 'Luxe Retail Group',
                'industry' => 'Luxury Retail',
                'project_type' => 'Mobile Application (iOS/Android)',
                'image_url' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?auto=format&fit=crop&q=80&w=1000',
                'tags' => json_encode(['Flutter', 'Firebase', 'Stripe']),
                'requires_quote' => false,
                'color_theme' => 'violet',
                'delay' => 100,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'title' => 'Predictive Intelligence Tool',
                'subtitle' => 'AI Analytics',
                'description' => 'A powerful web-based analytics platform leveraging machine learning to forecast market trends.',
                'content' => '<p>In the age of big data, making sense of vast information streams is a competitive advantage. This AI analytics platform ingests massive datasets and visualizes predictive models in real-time.</p><h3>Machine Learning Pipeline</h3><p>We designed a scalable Python-based data ingestion and processing pipeline that feeds sophisticated predictive models, surfacing actionable insights through an elegant Vue.js dashboard.</p>',
                'challenge' => 'The client\'s data science team had brilliant models, but lacked a scalable way to deploy them and visualize the insights for non-technical stakeholders.',
                'solution' => 'We built a robust Python backend to operationalize their ML models and created an interactive Vue.js dashboard with complex, dynamic charting capabilities.',
                'results' => 'Reduced the time-to-insight from weeks to minutes, allowing the client to secure 3 new enterprise contracts based on the platform\'s capabilities.',
                'client_name' => 'DataSight Analytics',
                'industry' => 'Business Intelligence',
                'project_type' => 'AI/ML Platform & Dashboard',
                'image_url' => 'https://images.unsplash.com/photo-1555949963-aa79dcee57d5?auto=format&fit=crop&q=80&w=1000',
                'tags' => json_encode(['Vue.js', 'Python AI', 'TensorFlow', 'D3.js']),
                'requires_quote' => false,
                'color_theme' => 'emerald',
                'delay' => 200,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'title' => 'Omnichannel Retail POS',
                'subtitle' => 'POS System',
                'description' => 'A unified Point of Sale system streamlining inventory, sales, and employee management across locations.',
                'content' => '<p>Modern retailers need systems that work anywhere, anytime. Our omnichannel POS system handles offline sales, cloud synchronization, and complex multi-location inventory routing.</p><h3>Resilient Architecture</h3><p>Built with offline-first capabilities, the POS system ensures that cashiers can continue processing transactions even during internet outages, syncing automatically once connection is restored.</p>',
                'challenge' => 'The client\'s existing POS system was failing during peak holiday seasons due to server overloads and inconsistent internet connectivity at physical locations.',
                'solution' => 'We engineered an offline-first React Native tablet application integrated with a Node.js cloud backend, featuring advanced conflict resolution for inventory management.',
                'results' => 'Zero downtime during the Black Friday rush, with a 30% reduction in checkout wait times across all 50+ locations.',
                'client_name' => 'RetailTech Solutions',
                'industry' => 'Retail Technology',
                'project_type' => 'POS & ERP System',
                'image_url' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&q=80&w=1000',
                'tags' => json_encode(['React Native', 'Node.js', 'PostgreSQL', 'Offline-First']),
                'requires_quote' => true,
                'color_theme' => 'orange',
                'delay' => 300,
                'created_at' => now(), 'updated_at' => now()
            ]
        ]);

        // 5. Process Steps
        \App\Models\ProcessStep::truncate();
        \App\Models\ProcessStep::insert([
            ['step_number' => 1, 'title' => 'Discover', 'description' => 'Requirement analysis & strategy.', 'theme_color' => 'sky', 'delay' => 0],
            ['step_number' => 2, 'title' => 'Design', 'description' => 'Wireframes & high-fidelity UI.', 'theme_color' => 'violet', 'delay' => 100],
            ['step_number' => 3, 'title' => 'Develop', 'description' => 'Agile sprints & robust coding.', 'theme_color' => 'emerald', 'delay' => 200],
            ['step_number' => 4, 'title' => 'Test', 'description' => 'QA, security & performance testing.', 'theme_color' => 'orange', 'delay' => 300],
            ['step_number' => 5, 'title' => 'Deploy', 'description' => 'CI/CD & cloud infrastructure setup.', 'theme_color' => 'teal', 'delay' => 400],
            ['step_number' => 6, 'title' => 'Support', 'description' => 'Monitoring & ongoing maintenance.', 'theme_color' => 'rose', 'delay' => 500],
        ]);

        // 6. Technologies
        \App\Models\Technology::truncate();
        \App\Models\Technology::insert([
            ['name' => 'Laravel', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-plain.svg', 'delay' => 0],
            ['name' => 'React', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg', 'delay' => 100],
            ['name' => 'Flutter', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/flutter/flutter-original.svg', 'delay' => 200],
            ['name' => 'PostgreSQL', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/postgresql/postgresql-original.svg', 'delay' => 300],
            ['name' => 'Docker', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/docker/docker-original.svg', 'delay' => 400],
            ['name' => 'AWS', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/amazonwebservices/amazonwebservices-original-wordmark.svg', 'delay' => 500],
            ['name' => 'Tailwind', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/tailwindcss/tailwindcss-original.svg', 'delay' => 600],
            ['name' => 'AI & ML', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/python/python-original.svg', 'delay' => 700],
        ]);

        // 7. Statistics
        \App\Models\Statistic::truncate();
        \App\Models\Statistic::insert([
            ['value' => '150+', 'label' => 'Projects Delivered', 'theme_color' => 'sky', 'delay' => 0],
            ['value' => '99%', 'label' => 'Happy Clients', 'theme_color' => 'violet', 'delay' => 100],
            ['value' => '10+', 'label' => 'Years Experience', 'theme_color' => 'emerald', 'delay' => 200],
            ['value' => '25+', 'label' => 'Countries Served', 'theme_color' => 'orange', 'delay' => 300],
        ]);

        // 8. Testimonials
        \App\Models\Testimonial::truncate();
        \App\Models\Testimonial::insert([
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'quote' => 'CleMwa Developers delivered an exceptional FinTech dashboard. Their attention to detail and robust architecture scaled perfectly as our user base exploded.',
                'client_name' => 'John Davis',
                'client_role' => 'CTO, TechCorp',
                'client_image_url' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=150',
                'delay' => 0,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'quote' => 'The team completely transformed our retail operations with the MagdaPOS implementation. We saw a 40% increase in efficiency across all our physical stores.',
                'client_name' => 'Sarah Jenkins',
                'client_role' => 'CEO, Luxe Retail',
                'client_image_url' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&q=80&w=150',
                'delay' => 100,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'quote' => 'Our student engagement doubled after launching EduTech Core. The platform is blazing fast and handles thousands of concurrent video streams flawlessly.',
                'client_name' => 'Dr. Robert Chen',
                'client_role' => 'Director, Global Academy',
                'client_image_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=150',
                'delay' => 200,
                'created_at' => now(), 'updated_at' => now()
            ]
        ]);
    }
}
