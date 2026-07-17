<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductSetting;

class ProductDummySeeder extends Seeder
{
    public function run(): void
    {
        ProductSetting::updateOrCreate(['id' => 1], [
            'hero_title'      => 'Powerful Software<br><span class="text-indigo-400">For Every Business</span>',
            'hero_subtitle'   => 'Powerful software products built to automate businesses, improve productivity, and accelerate digital transformation.',
            'cta_heading'     => 'Ready to Transform<br><span class="text-indigo-400">Your Business?</span>',
            'cta_description' => 'Get a personalised demo of any of our products and see how CleMwa Developers can help you solve real business challenges.',
            'seo_title'       => 'Software Products - CleMwa Developers',
            'seo_description' => 'Explore CleMwa Developers\' portfolio of enterprise software products including POS, ERP, school management, HR and more.',
        ]);

        $products = [
            [
                'title'             => 'MagdaPOS',
                'slug'              => 'magdapos',
                'category'          => 'POS Systems',
                'short_description' => 'A cloud-first, offline-capable Point of Sale system built for retail, hospitality, and multi-branch businesses.',
                'version'           => '3.2',
                'rating'            => 4.9,
                'is_featured'       => true,
                'platforms'         => ['Web', 'Android', 'iOS'],
                'overview'          => '<p>MagdaPOS is the definitive cloud-based Point of Sale solution for businesses that demand reliability, speed, and intelligence. Whether you run a single restaurant or a chain of 50 retail branches, MagdaPOS scales effortlessly to meet your needs.</p><p class="mt-4">Built on Laravel and Flutter, MagdaPOS delivers a best-in-class experience on mobile and web, with powerful real-time reporting and an intuitive dashboard that managers actually enjoy using.</p>',
                'features'          => [
                    ['name' => 'Offline-First', 'icon' => 'fa-solid fa-wifi-slash', 'description' => 'Continues operating seamlessly during internet outages with full sync on reconnection.'],
                    ['name' => 'Multi-Branch', 'icon' => 'fa-solid fa-code-branch', 'description' => 'Centrally manage all your branches from a single admin dashboard.'],
                    ['name' => 'Real-Time Reports', 'icon' => 'fa-solid fa-chart-line', 'description' => 'Up-to-the-minute sales, inventory and employee performance reporting.'],
                    ['name' => 'Mobile Access', 'icon' => 'fa-solid fa-mobile', 'description' => 'Native Android and iOS apps for checkout terminals and managers.'],
                    ['name' => 'Inventory Management', 'icon' => 'fa-solid fa-boxes-stacked', 'description' => 'Full stock control with low-stock alerts and automated purchase orders.'],
                    ['name' => 'Role-Based Access', 'icon' => 'fa-solid fa-shield', 'description' => 'Granular permissions for cashiers, managers, and owners.'],
                ],
                'modules'           => [
                    ['module' => 'Sales & Checkout'],
                    ['module' => 'Inventory & Stock Control'],
                    ['module' => 'Kitchen Display System'],
                    ['module' => 'HR & Payroll'],
                    ['module' => 'CRM & Loyalty'],
                    ['module' => 'Accounting & Finance'],
                ],
                'integrations'      => [
                    ['name' => 'M-Pesa'],
                    ['name' => 'Stripe'],
                    ['name' => 'WhatsApp'],
                    ['name' => 'Twilio'],
                ],
                'pricing_tiers'     => [
                    ['plan' => 'Starter', 'price' => 'KES 3,500/mo', 'features' => ['1 Branch', '3 Terminals', 'Basic Reports', 'Email Support']],
                    ['plan' => 'Professional', 'price' => 'KES 8,500/mo', 'features' => ['5 Branches', 'Unlimited Terminals', 'Advanced Analytics', 'Priority Support', 'API Access']],
                    ['plan' => 'Enterprise', 'price' => 'Custom', 'features' => ['Unlimited Branches', 'Dedicated Server', 'Custom Integrations', 'Onsite Training', 'SLA Guarantee']],
                ],
                'stats'             => [
                    ['label' => 'Daily Orders', 'value' => '20,000+'],
                    ['label' => 'Active Branches', 'value' => '150+'],
                    ['label' => 'Uptime', 'value' => '99.9%'],
                ],
                'faqs'              => [
                    ['question' => 'Does MagdaPOS work offline?', 'answer' => 'Yes. MagdaPOS is built offline-first. All transactions are stored locally and synced to the cloud when connectivity is restored.'],
                    ['question' => 'Can I manage multiple branches?', 'answer' => 'Absolutely. MagdaPOS supports unlimited branches in the Enterprise plan with centralised reporting and management.'],
                    ['question' => 'Which payment methods are supported?', 'answer' => 'MagdaPOS supports cash, card, M-Pesa, Airtel Money, and Stripe out of the box. Custom payment gateways can be integrated.'],
                ],
                'testimonials'      => [
                    ['name' => 'Sarah M.', 'role' => 'Operations Manager', 'company' => 'Nairobi Kitchen Co.', 'quote' => 'MagdaPOS transformed our multi-branch operations. The offline mode alone saved us during network outages.', 'rating' => 5],
                ],
                'documentation'     => [
                    ['title' => 'User Guide', 'url' => '#'],
                    ['title' => 'API Documentation', 'url' => '#'],
                    ['title' => 'Installation Guide', 'url' => '#'],
                ],
                'seo_title'         => 'MagdaPOS - Cloud POS System | CleMwa Developers',
                'seo_description'   => 'MagdaPOS is a cloud-first, offline-capable Point of Sale system for retail and hospitality businesses. Multi-branch, mobile-ready.',
                'delay'             => 1,
            ],
            [
                'title'             => 'EduCore ERP',
                'slug'              => 'educore-erp',
                'category'          => 'School Management',
                'short_description' => 'Comprehensive school ERP unifying student records, HR, finance, and parent communication for multi-campus institutions.',
                'version'           => '2.1',
                'rating'            => 4.8,
                'is_featured'       => true,
                'platforms'         => ['Web', 'Android', 'iOS'],
                'overview'          => '<p>EduCore ERP is a comprehensive, modular school management system designed for the rigorous demands of modern educational institutions. From enrollment and grading to payroll and procurement, EduCore gives your entire institution a single source of truth.</p>',
                'features'          => [
                    ['name' => 'Student Information', 'icon' => 'fa-solid fa-graduation-cap', 'description' => 'Full student lifecycle management from application to alumni.'],
                    ['name' => 'Parent Portal', 'icon' => 'fa-solid fa-users', 'description' => 'Real-time access to grades, attendance, and fee statements for parents.'],
                    ['name' => 'Automated Fees', 'icon' => 'fa-solid fa-file-invoice', 'description' => 'Automated fee invoicing, payment tracking, and reminders via SMS.'],
                    ['name' => 'HR & Payroll', 'icon' => 'fa-solid fa-money-bill-wave', 'description' => 'Complete staff management and payroll processing.'],
                ],
                'pricing_tiers'     => [
                    ['plan' => 'Basic', 'price' => 'KES 5,000/mo', 'features' => ['500 Students', 'Core Modules', 'Email Support']],
                    ['plan' => 'Standard', 'price' => 'KES 12,000/mo', 'features' => ['2,000 Students', 'All Modules', 'Parent Portal', 'Priority Support']],
                    ['plan' => 'Enterprise', 'price' => 'Custom', 'features' => ['Unlimited Students', 'Multi-campus', 'Custom Integrations', 'Dedicated Support']],
                ],
                'stats'             => [
                    ['label' => 'Active Students', 'value' => '50,000+'],
                    ['label' => 'Institutions', 'value' => '30+'],
                    ['label' => 'Countries', 'value' => '4'],
                ],
                'faqs'              => [
                    ['question' => 'Can parents access student information?', 'answer' => 'Yes. EduCore includes a dedicated parent portal accessible via mobile app and web.'],
                ],
                'seo_title'         => 'EduCore ERP - School Management System | CleMwa Developers',
                'seo_description'   => 'EduCore ERP is a comprehensive school management platform for multi-campus institutions.',
                'delay'             => 2,
            ],
            [
                'title'             => 'SmartHR',
                'slug'              => 'smarthr',
                'category'          => 'HR & Payroll',
                'short_description' => 'Modern HR and payroll management platform with leave tracking, contracts, appraisals, and statutory compliance.',
                'version'           => '1.5',
                'rating'            => 4.7,
                'is_featured'       => true,
                'platforms'         => ['Web', 'Android'],
                'overview'          => '<p>SmartHR simplifies every aspect of human resource management, from hiring to retirement. Automate payroll, manage leave, conduct appraisals, and ensure full statutory compliance all from one intuitive platform.</p>',
                'features'          => [
                    ['name' => 'Payroll Automation', 'icon' => 'fa-solid fa-money-check', 'description' => 'Automated gross to net payroll with PAYE, NHIF, and NSSF compliance.'],
                    ['name' => 'Leave Management', 'icon' => 'fa-solid fa-calendar-days', 'description' => 'Self-service leave applications with approval workflows.'],
                    ['name' => 'Performance Appraisals', 'icon' => 'fa-solid fa-star', 'description' => 'Configurable KPI-based performance review cycles.'],
                    ['name' => 'Recruitment', 'icon' => 'fa-solid fa-magnifying-glass-dollar', 'description' => 'Applicant tracking and onboarding pipeline.'],
                ],
                'pricing_tiers'     => [
                    ['plan' => 'Starter', 'price' => 'KES 2,500/mo', 'features' => ['50 Employees', 'Core HR', 'Payroll']],
                    ['plan' => 'Professional', 'price' => 'KES 6,000/mo', 'features' => ['200 Employees', 'All Features', 'API Access', 'Priority Support']],
                    ['plan' => 'Enterprise', 'price' => 'Custom', 'features' => ['Unlimited Employees', 'Custom Integrations', 'Dedicated Support']],
                ],
                'stats'             => [
                    ['label' => 'Employees Managed', 'value' => '10,000+'],
                    ['label' => 'Businesses', 'value' => '80+'],
                ],
                'faqs'              => [
                    ['question' => 'Does SmartHR handle Kenyan statutory deductions?', 'answer' => 'Yes. SmartHR is pre-configured for PAYE, NHIF, NSSF, HELB, and housing levy. Rates are updated automatically with every Finance Act.'],
                ],
                'seo_title'         => 'SmartHR - HR & Payroll Management | CleMwa Developers',
                'seo_description'   => 'SmartHR is a modern HR and payroll platform with leave, contracts, appraisals, and full Kenyan statutory compliance.',
                'delay'             => 3,
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
