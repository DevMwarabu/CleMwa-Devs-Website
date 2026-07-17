<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceSetting;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\CaseStudy;

class ServicesDummySeeder extends Seeder
{
    public function run(): void
    {
        // Service Settings
        ServiceSetting::updateOrCreate(['id' => 1], [
            'hero_title'      => 'Services Built<br><span class="text-sky-500">for Impact</span>',
            'hero_subtitle'   => 'Innovative software solutions designed to help businesses grow, automate operations, and achieve digital transformation through secure, scalable, and modern technologies.',
            'overview_text'   => '<p>At CleMwa Developers, we combine technical mastery with deep business insight to deliver software solutions that truly move the needle. From elegant web applications to enterprise-grade ERP systems, every line of code we write is optimized for performance, security, and long-term maintainability.</p><p>We take a consultative approach — understanding your challenges first, then architecting solutions that address the root cause, not just the symptoms.</p>',
            'cta_heading'     => 'Ready to Transform<br><span class="text-sky-500">Your Business?</span>',
            'cta_description' => 'Partner with CleMwa Developers to build secure, scalable, and innovative digital solutions tailored to your business needs.',
            'seo_title'       => 'Our Services - CleMwa Developers',
            'seo_description' => 'Explore CleMwa Developers full range of software services including web development, mobile apps, ERP systems, AI solutions, and cloud infrastructure.',
        ]);

        // Service Categories
        $categories = [
            ['name' => 'Software Development', 'slug' => 'software-development', 'icon' => 'fa-solid fa-code', 'order_column' => 1],
            ['name' => 'Web Development',       'slug' => 'web-development',       'icon' => 'fa-solid fa-globe', 'order_column' => 2],
            ['name' => 'Mobile Development',    'slug' => 'mobile-development',    'icon' => 'fa-solid fa-mobile-alt', 'order_column' => 3],
            ['name' => 'AI & Automation',       'slug' => 'ai-automation',         'icon' => 'fa-solid fa-robot', 'order_column' => 4],
            ['name' => 'ERP Solutions',         'slug' => 'erp-solutions',         'icon' => 'fa-solid fa-sitemap', 'order_column' => 5],
            ['name' => 'Cloud & DevOps',        'slug' => 'cloud-devops',          'icon' => 'fa-solid fa-cloud', 'order_column' => 6],
            ['name' => 'Cybersecurity',         'slug' => 'cybersecurity',         'icon' => 'fa-solid fa-shield-alt', 'order_column' => 7],
            ['name' => 'UI/UX Design',          'slug' => 'ui-ux-design',          'icon' => 'fa-solid fa-pencil-ruler', 'order_column' => 8],
        ];

        foreach ($categories as $cat) {
            ServiceCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $catMap = ServiceCategory::pluck('id', 'slug');

        // Services
        $services = [
            [
                'slug'                => 'custom-software-development',
                'title'               => 'Custom Software Development',
                'service_category_id' => $catMap['software-development'],
                'short_description'   => 'Tailor-made software solutions engineered to solve your unique business challenges and scale with your growth.',
                'detailed_description'=> '<p>We design and build bespoke software from scratch, ensuring every feature aligns perfectly with your workflow and objectives. Our agile process ensures you are involved at every stage.</p>',
                'key_features'        => ['Requirements Analysis', 'Scalable Architecture', 'Test-Driven Development', 'CI/CD Pipelines', 'Post-Launch Support', 'Documentation'],
                'business_benefits'   => ['Eliminate manual, repetitive processes', 'Gain a competitive technological edge', 'Reduce operational costs over time', 'Full ownership of your intellectual property'],
                'typical_timeline'    => '8–24 Weeks',
                'starting_price'      => 'From $5,000',
                'is_featured'         => true,
                'icon_svg'            => '<svg class="w-6 h-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>',
                'delay'               => 1,
            ],
            [
                'slug'                => 'mobile-app-development',
                'title'               => 'Mobile App Development',
                'service_category_id' => $catMap['mobile-development'],
                'short_description'   => 'Beautiful, high-performance Android, iOS, and cross-platform Flutter applications that users love.',
                'detailed_description'=> '<p>We build mobile applications that combine intuitive design with robust engineering. From consumer apps to enterprise-grade tools, our Flutter expertise allows us to deliver a single codebase that works flawlessly across all platforms.</p>',
                'key_features'        => ['Cross-Platform Flutter', 'Native Android & iOS', 'Offline-First Architecture', 'Push Notifications', 'Biometric Authentication', 'App Store Deployment'],
                'business_benefits'   => ['Reach customers on every device', 'Reduce development costs with one codebase', 'Faster time-to-market', 'Enhanced customer engagement'],
                'typical_timeline'    => '6–16 Weeks',
                'starting_price'      => 'From $8,000',
                'is_featured'         => true,
                'icon_svg'            => '<svg class="w-6 h-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>',
                'delay'               => 2,
            ],
            [
                'slug'                => 'erp-development',
                'title'               => 'ERP Systems',
                'service_category_id' => $catMap['erp-solutions'],
                'short_description'   => 'Comprehensive ERP solutions for schools, hospitals, HR, finance, procurement, and inventory management.',
                'detailed_description'=> '<p>Our ERP solutions are built to unify your business operations into a single, coherent system. From school management to hospital information systems, we have built production-ready platforms trusted by real organizations.</p>',
                'key_features'        => ['Multi-module Architecture', 'Role-Based Access Control', 'Reporting & Analytics', 'Multi-Branch Support', 'API Integration', 'Custom Workflows'],
                'business_benefits'   => ['Eliminate data silos across departments', 'Real-time business insights', 'Streamline compliance and reporting', 'Scale from 10 to 10,000+ users'],
                'typical_timeline'    => 'Custom — 12+ Weeks',
                'starting_price'      => 'From $15,000',
                'is_featured'         => true,
                'icon_svg'            => '<svg class="w-6 h-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>',
                'delay'               => 3,
            ],
            [
                'slug'                => 'ai-solutions',
                'title'               => 'AI & Automation',
                'service_category_id' => $catMap['ai-automation'],
                'short_description'   => 'AI assistants, chatbots, OCR, ML models, and intelligent workflow automation to accelerate your business.',
                'detailed_description'=> '<p>We build practical AI solutions that solve real business problems — not AI for the sake of AI. From intelligent document processing to predictive analytics dashboards, we integrate AI seamlessly into your existing workflows.</p>',
                'key_features'        => ['AI Chatbots & Assistants', 'OCR Document Processing', 'Predictive Analytics', 'Workflow Automation', 'Machine Learning Models', 'NLP Solutions'],
                'business_benefits'   => ['Automate repetitive cognitive tasks', 'Unlock insights from unstructured data', 'Reduce human error', 'Scale operations without scaling headcount'],
                'typical_timeline'    => '4–12 Weeks',
                'starting_price'      => 'From $6,000',
                'is_featured'         => true,
                'icon_svg'            => '<svg class="w-6 h-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-2"/></svg>',
                'delay'               => 4,
            ],
            [
                'slug'                => 'web-development',
                'title'               => 'Web Development',
                'service_category_id' => $catMap['web-development'],
                'short_description'   => 'Corporate websites, SaaS platforms, e-commerce, CMS solutions, and progressive web applications.',
                'key_features'        => ['Responsive Design', 'SEO Optimized', 'CMS Integration', 'E-Commerce', 'PWA Support', 'Performance Optimized'],
                'business_benefits'   => ['24/7 digital presence', 'Convert visitors to customers', 'Full content management control'],
                'typical_timeline'    => '2–8 Weeks',
                'starting_price'      => 'From $1,500',
                'is_featured'         => false,
                'icon_svg'            => '<svg class="w-6 h-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>',
                'delay'               => 5,
            ],
            [
                'slug'                => 'cloud-devops',
                'title'               => 'Cloud & DevOps',
                'service_category_id' => $catMap['cloud-devops'],
                'short_description'   => 'Cloud migration, AWS/Azure deployments, Docker, Kubernetes, CI/CD pipelines and infrastructure automation.',
                'key_features'        => ['Cloud Migration', 'AWS & Azure', 'Docker & Kubernetes', 'CI/CD Pipelines', 'Monitoring & Logging', 'Disaster Recovery'],
                'business_benefits'   => ['Reduce infrastructure costs', 'Improve application reliability', 'Accelerate deployment cycles'],
                'typical_timeline'    => '3–8 Weeks',
                'starting_price'      => 'From $3,000',
                'is_featured'         => false,
                'icon_svg'            => '<svg class="w-6 h-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>',
                'delay'               => 6,
            ],
            [
                'slug'                => 'cybersecurity',
                'title'               => 'Cybersecurity',
                'service_category_id' => $catMap['cybersecurity'],
                'short_description'   => 'Security assessments, penetration testing, vulnerability scanning, and secure development lifecycle implementation.',
                'key_features'        => ['Penetration Testing', 'Security Audits', 'Vulnerability Scanning', 'API Security', 'Authentication Systems', 'Compliance Review'],
                'business_benefits'   => ['Protect customer data and reputation', 'Meet compliance requirements', 'Identify vulnerabilities before attackers do'],
                'typical_timeline'    => '2–4 Weeks',
                'starting_price'      => 'From $2,000',
                'is_featured'         => false,
                'icon_svg'            => '<svg class="w-6 h-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
                'delay'               => 7,
            ],
            [
                'slug'                => 'ui-ux-design',
                'title'               => 'UI/UX Design',
                'service_category_id' => $catMap['ui-ux-design'],
                'short_description'   => 'Product design, wireframes, interactive prototypes, design systems, and user experience research.',
                'key_features'        => ['User Research', 'Wireframing', 'Interactive Prototypes', 'Design Systems', 'Usability Testing', 'Branding'],
                'business_benefits'   => ['Increase user adoption and retention', 'Reduce support costs with intuitive UX', 'Build a strong brand identity'],
                'typical_timeline'    => '2–6 Weeks',
                'starting_price'      => 'From $1,200',
                'is_featured'         => false,
                'icon_svg'            => '<svg class="w-6 h-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>',
                'delay'               => 8,
            ],
        ];

        foreach ($services as $svc) {
            Service::updateOrCreate(['slug' => $svc['slug']], $svc);
        }

        // Case Studies
        $caseStudies = [
            [
                'project_name'   => 'MagdaPOS — Cloud Restaurant & Retail POS',
                'slug'           => 'magdapos',
                'industry'       => 'Retail & Hospitality',
                'client_name'    => 'MagdaPOS Ltd',
                'challenge'      => 'The client needed a multi-branch, cloud-based POS system that could operate offline, sync in real-time, and integrate with a mobile worker app for order taking.',
                'solution'       => 'We built a full-stack POS system using Laravel, Inertia.js + React, and a dedicated Flutter mobile app. The system features real-time order syncing, inventory management, advanced reporting, and role-based access control.',
                'technologies'   => ['Laravel', 'React', 'Flutter', 'PostgreSQL', 'Redis', 'Docker'],
                'project_outcome'=> 'Deployed to 12+ branches across 3 cities, processing 2,000+ orders per day with 99.9% uptime.',
                'is_featured'    => true,
                'order_column'   => 1,
            ],
            [
                'project_name'   => 'School Management ERP',
                'slug'           => 'school-erp',
                'industry'       => 'Education',
                'client_name'    => 'Confidential',
                'challenge'      => 'A private school network needed to unify student records, fee management, staff payroll, and parent communication across 5 campuses.',
                'solution'       => 'Developed a multi-campus ERP with modules for admissions, academics, finance, HR, library, and a mobile parent portal.',
                'technologies'   => ['Laravel', 'Vue.js', 'MySQL', 'AWS', 'Flutter'],
                'project_outcome'=> 'Reduced administrative workload by 60% and improved fee collection rates by 35%.',
                'is_featured'    => true,
                'order_column'   => 2,
            ],
            [
                'project_name'   => 'AI Document Processing Platform',
                'slug'           => 'ai-ocr-platform',
                'industry'       => 'Finance & Insurance',
                'client_name'    => 'Confidential',
                'challenge'      => 'Manual processing of thousands of scanned insurance claim documents per week was causing delays and errors.',
                'solution'       => 'Built an OCR + NLP pipeline using Python and integrated it into a Laravel-based workflow management system, extracting structured data automatically.',
                'technologies'   => ['Python', 'Laravel', 'PostgreSQL', 'AWS Textract', 'Docker'],
                'project_outcome'=> 'Reduced document processing time from 3 days to under 4 hours, with 94% extraction accuracy.',
                'is_featured'    => true,
                'order_column'   => 3,
            ],
        ];

        foreach ($caseStudies as $cs) {
            CaseStudy::updateOrCreate(['slug' => $cs['slug']], $cs);
        }
    }
}
