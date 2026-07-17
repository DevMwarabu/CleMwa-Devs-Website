<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\PortfolioSetting;

class PortfolioDummySeeder extends Seeder
{
    public function run(): void
    {
        // Portfolio Settings
        PortfolioSetting::updateOrCreate(['id' => 1], [
            'hero_title'      => 'Building Digital<br><span class="text-sky-500">Excellence</span>',
            'hero_subtitle'   => 'Discover how CleMwa Developers transforms ideas into secure, scalable, and innovative digital solutions that help businesses grow and succeed.',
            'cta_heading'     => 'Ready to Build Your<br><span class="text-sky-500">Next Success Story?</span>',
            'cta_description' => 'Whether you\'re a startup, enterprise, or government institution, CleMwa Developers is ready to transform your vision into a high-performing digital solution.',
            'seo_title'       => 'Our Portfolio - CleMwa Developers',
            'seo_description' => 'Explore the CleMwa Developers portfolio of successful projects including web apps, mobile apps, ERPs, and custom software.',
        ]);

        // Dummy Projects
        $projects = [
            [
                'title'               => 'MagdaPOS Cloud System',
                'slug'                => 'magdapos-cloud-system',
                'subtitle'            => 'A complete cloud POS for retail and hospitality.',
                'short_description'   => 'A full-stack POS system using Laravel and Flutter, featuring real-time syncing, offline support, and multi-branch management.',
                'description'         => '<p>MagdaPOS is an advanced Point of Sale system designed specifically for the rigorous demands of modern retail and hospitality environments. It allows businesses to manage sales, inventory, and employees across multiple locations with ease.</p>',
                'challenge'           => '<p>The client was struggling with legacy on-premise systems that could not sync data across their 12 branches in real-time, leading to inventory discrepancies and delayed reporting.</p>',
                'solution'            => '<p>We architected a cloud-first solution using Laravel for the robust backend API and administrative dashboard, paired with a high-performance Flutter mobile application for the checkout terminals. The system leverages Redis for real-time order broadcasting and offline-first capabilities to ensure uninterrupted service.</p>',
                'results'             => '<p>Since deployment, MagdaPOS has processed over 2,000 orders daily with 99.9% uptime, effectively eliminating inventory sync issues and reducing checkout times by 30%.</p>',
                'features_delivered'  => [
                    ['feature' => 'Offline-first Mobile Checkout'],
                    ['feature' => 'Real-time Inventory Sync'],
                    ['feature' => 'Multi-branch Management'],
                    ['feature' => 'Role-based Access Control'],
                    ['feature' => 'Advanced Analytics Dashboard'],
                ],
                'technologies'        => ['Laravel', 'Flutter', 'React', 'PostgreSQL', 'Redis', 'Docker'],
                'stats'               => [
                    ['label' => 'Daily Orders', 'value' => '2,000+'],
                    ['label' => 'Branches', 'value' => '12'],
                    ['label' => 'Uptime', 'value' => '99.9%'],
                ],
                'client_name'         => 'MagdaPOS Ltd',
                'industry'            => 'Retail & Hospitality',
                'project_type'        => 'ERP System',
                'status'              => 'completed',
                'completion_year'     => '2025',
                'is_featured'         => true,
                'testimonial_name'    => 'John Doe',
                'testimonial_role'    => 'Operations Director',
                'testimonial_company' => 'MagdaPOS Ltd',
                'testimonial_quote'   => 'CleMwa Developers delivered a system that completely transformed how we do business. The offline capability alone saved us countless hours of frustration.',
                'testimonial_rating'  => 5,
                'delay'               => 1,
            ],
            [
                'title'               => 'EduTrack ERP',
                'slug'                => 'edutrack-erp',
                'subtitle'            => 'Comprehensive school management platform.',
                'short_description'   => 'A centralized ERP unifying student records, HR, and finance across multiple school campuses.',
                'description'         => '<p>EduTrack ERP is a comprehensive management system designed for multi-campus educational institutions. It handles everything from student enrollment and grading to staff payroll and parent communications.</p>',
                'challenge'           => '<p>The institution was using disparate systems for grading, accounting, and HR, making it nearly impossible for administrators to get a holistic view of the organization\'s performance.</p>',
                'solution'            => '<p>We developed a unified platform utilizing Laravel and Vue.js, featuring distinct portals for administrators, teachers, students, and parents. The system includes automated fee invoicing and a secure messaging center.</p>',
                'results'             => '<p>EduTrack reduced administrative overhead by 60% and improved fee collection rates by 35% within the first academic year.</p>',
                'features_delivered'  => [
                    ['feature' => 'Student Information System'],
                    ['feature' => 'Automated Fee Management'],
                    ['feature' => 'HR & Payroll Module'],
                    ['feature' => 'Parent & Student Portals'],
                ],
                'technologies'        => ['Laravel', 'Vue.js', 'MySQL', 'AWS'],
                'stats'               => [
                    ['label' => 'Active Students', 'value' => '5,000+'],
                    ['label' => 'Campuses', 'value' => '5'],
                    ['label' => 'Admin Time Saved', 'value' => '60%'],
                ],
                'client_name'         => 'Confidential',
                'industry'            => 'Education',
                'project_type'        => 'ERP System',
                'status'              => 'completed',
                'completion_year'     => '2024',
                'is_featured'         => true,
                'delay'               => 2,
            ],
            [
                'title'               => 'HealthConnect Patient Portal',
                'slug'                => 'healthconnect-patient-portal',
                'subtitle'            => 'Secure telemedicine and appointment booking.',
                'short_description'   => 'A HIPAA-compliant web and mobile app for booking appointments, viewing records, and telehealth consultations.',
                'description'         => '<p>HealthConnect empowers patients to take control of their healthcare journey through a secure, easy-to-use digital platform.</p>',
                'challenge'           => '<p>The clinic network needed a modern way to reduce phone traffic for appointments while securely providing patients access to their test results.</p>',
                'solution'            => '<p>We built a React Native mobile application and a React web portal, backed by a highly secure Node.js backend. We integrated third-party APIs for secure video conferencing and EHR syncing.</p>',
                'results'             => '<p>The portal adopted by 70% of the patient base within 6 months, reducing call center volume by 45%.</p>',
                'features_delivered'  => [
                    ['feature' => 'Secure Video Consultations'],
                    ['feature' => 'Real-time Appointment Booking'],
                    ['feature' => 'Encrypted Medical Records'],
                    ['feature' => 'Push Notifications'],
                ],
                'technologies'        => ['React Native', 'React', 'Node.js', 'PostgreSQL', 'WebRTC'],
                'stats'               => [
                    ['label' => 'User Adoption', 'value' => '70%'],
                    ['label' => 'Call Volume Drop', 'value' => '45%'],
                ],
                'client_name'         => 'Confidential',
                'industry'            => 'Healthcare',
                'project_type'        => 'Mobile App',
                'status'              => 'completed',
                'completion_year'     => '2023',
                'is_featured'         => false,
                'delay'               => 3,
            ],
            [
                'title'               => 'FinFlow Analytics Dashboard',
                'slug'                => 'finflow-analytics-dashboard',
                'subtitle'            => 'Real-time financial data visualization.',
                'short_description'   => 'An AI-powered dashboard aggregating data from multiple financial APIs to provide actionable investment insights.',
                'description'         => '<p>FinFlow aggregates massive amounts of market data and uses machine learning models to identify trends and anomalies.</p>',
                'challenge'           => '<p>Analysts were spending hours manually exporting data from various platforms into Excel to generate daily reports.</p>',
                'solution'            => '<p>We created a Python backend for heavy data processing and a React frontend for ultra-fast, interactive charts and dashboards.</p>',
                'results'             => '<p>Automated 95% of the daily reporting workload, allowing analysts to focus on strategy rather than data entry.</p>',
                'features_delivered'  => [
                    ['feature' => 'Real-time Data Aggregation'],
                    ['feature' => 'Interactive Charting'],
                    ['feature' => 'Automated PDF Reporting'],
                    ['feature' => 'Anomaly Detection Alerts'],
                ],
                'technologies'        => ['Python', 'FastAPI', 'React', 'D3.js', 'AWS'],
                'stats'               => [
                    ['label' => 'Reporting Automated', 'value' => '95%'],
                    ['label' => 'Data Sources', 'value' => '15+'],
                ],
                'client_name'         => 'Confidential',
                'industry'            => 'Finance',
                'project_type'        => 'Web Application',
                'status'              => 'ongoing',
                'completion_year'     => '2026',
                'is_featured'         => true,
                'delay'               => 4,
            ]
        ];

        foreach ($projects as $proj) {
            Project::updateOrCreate(['slug' => $proj['slug']], $proj);
        }
    }
}
