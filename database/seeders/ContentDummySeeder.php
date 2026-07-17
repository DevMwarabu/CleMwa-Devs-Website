<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\JobListing;

class ContentDummySeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Why We Chose Laravel and Filament for Enterprise CMS Builds',
                'slug' => 'laravel-filament-enterprise-cms',
                'excerpt' => 'A look at how we build fast, maintainable admin experiences for our clients using Laravel and Filament.',
                'content' => '<p>When building content-managed platforms for our clients, we consistently reach for Laravel paired with Filament. The combination gives us a battle-tested backend framework and a rapid, form-driven admin UI without reinventing the wheel on every project.</p><p>In this post we walk through the architectural decisions that make this stack a strong default for enterprise CMS work: resource-based CRUD, relationship management, and a consistent design language across every admin panel we ship.</p>',
                'category' => 'Engineering',
                'tags' => ['laravel', 'filament', 'cms'],
                'author_name' => 'CleMwa Engineering',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Designing Secure Multi-Tenant Systems for Government Clients',
                'slug' => 'secure-multi-tenant-government-systems',
                'excerpt' => 'Lessons learned building compliant, secure platforms for public sector organizations.',
                'content' => '<p>Government and public sector engagements come with a different bar for security and auditability. We share the patterns we rely on for access control, data isolation, and compliance reporting.</p>',
                'category' => 'Security',
                'tags' => ['security', 'government', 'compliance'],
                'author_name' => 'CleMwa Engineering',
                'is_published' => true,
                'published_at' => now()->subDays(20),
            ],
            [
                'title' => 'CleMwa Developers Expands Into Enterprise ERP Solutions',
                'slug' => 'clemwa-expands-erp-solutions',
                'excerpt' => 'Announcing our new dedicated practice for ERP and POS systems.',
                'content' => '<p>We are excited to announce a dedicated practice focused on ERP and POS systems for growing businesses across the region.</p>',
                'category' => 'Company News',
                'tags' => ['announcement', 'erp'],
                'author_name' => 'CleMwa Team',
                'is_published' => true,
                'published_at' => now()->subDays(45),
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(['slug' => $post['slug']], $post);
        }

        $jobs = [
            [
                'title' => 'Senior Backend Engineer (Laravel)',
                'slug' => 'senior-backend-engineer-laravel',
                'department' => 'Engineering',
                'location' => 'Remote',
                'employment_type' => 'Full-time',
                'description' => '<p>We are looking for a Senior Backend Engineer with deep Laravel experience to help build and scale our client platforms.</p>',
                'requirements' => ['5+ years PHP/Laravel experience', 'Strong SQL and database design skills', 'Experience with REST API design'],
                'responsibilities' => "Design and build backend services for client projects.\nMentor junior engineers and review code.\nCollaborate with product and design on requirements.",
                'salary_range' => 'Competitive, based on experience',
                'is_active' => true,
                'posted_at' => now()->subDays(3),
            ],
            [
                'title' => 'Product Designer (UI/UX)',
                'slug' => 'product-designer-ui-ux',
                'department' => 'Design',
                'location' => 'Nairobi, Kenya',
                'employment_type' => 'Full-time',
                'description' => '<p>Join our design team to craft intuitive, accessible interfaces for enterprise and government software.</p>',
                'requirements' => ['Portfolio demonstrating product design work', 'Proficiency in Figma', 'Experience designing for the web'],
                'responsibilities' => "Design user flows and high-fidelity interfaces.\nPartner with engineering on implementation.\nConduct usability reviews.",
                'salary_range' => null,
                'is_active' => true,
                'posted_at' => now()->subDays(10),
            ],
            [
                'title' => 'DevOps Engineer',
                'slug' => 'devops-engineer',
                'department' => 'Engineering',
                'location' => 'Remote',
                'employment_type' => 'Contract',
                'description' => '<p>Help us build and maintain reliable cloud infrastructure for client-facing production systems.</p>',
                'requirements' => ['Experience with CI/CD pipelines', 'Familiarity with containerization (Docker)', 'Cloud infrastructure experience (AWS/GCP)'],
                'responsibilities' => "Maintain deployment pipelines.\nMonitor production infrastructure.\nImprove reliability and observability.",
                'salary_range' => null,
                'is_active' => true,
                'posted_at' => now()->subDays(1),
            ],
        ];

        foreach ($jobs as $job) {
            JobListing::updateOrCreate(['slug' => $job['slug']], $job);
        }
    }
}
