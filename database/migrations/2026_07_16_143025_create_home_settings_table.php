<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();

            // ── Hero Section ──────────────────────────────────────────
            $table->string('hero_badge_text')->default('Industry-Leading Software Solutions');
            $table->string('hero_headline')->default('We Build Software');
            $table->string('hero_headline_highlight')->default('That Matters');
            $table->text('hero_subheadline')->default('Enterprise-grade applications, AI-powered platforms, and digital infrastructure built to scale with your ambitions.');
            $table->string('hero_cta_primary_text')->default('Start Your Project');
            $table->string('hero_cta_primary_url')->default('/contact');
            $table->string('hero_cta_secondary_text')->default('View Our Work');
            $table->string('hero_cta_secondary_url')->default('/portfolio');

            // ── Trusted By Section ────────────────────────────────────
            $table->string('trusted_by_label')->default('Trusted by innovative companies & partners');

            // ── Services Section ──────────────────────────────────────
            $table->string('services_section_title')->default('Enterprise-Grade Solutions');
            $table->text('services_section_subtitle')->default('Discover our comprehensive suite of software development services designed for modern businesses.');
            $table->string('services_cta_text')->default('View All Services');
            $table->string('services_cta_url')->default('/services');

            // ── Products Section ──────────────────────────────────────
            $table->string('products_section_title')->default('Our Flagship Products');
            $table->text('products_section_subtitle')->default('Powerful, ready-to-deploy platforms built to accelerate your business operations and growth.');
            $table->string('products_cta_text')->default('Explore All Products');
            $table->string('products_cta_url')->default('/products');

            // ── Portfolio Section ─────────────────────────────────────
            $table->string('portfolio_section_title')->default('Featured Work');
            $table->text('portfolio_section_subtitle')->default('Real solutions, measurable results. Explore the work we\'re most proud of.');
            $table->string('portfolio_cta_text')->default('View All Projects');
            $table->string('portfolio_cta_url')->default('/portfolio');

            // ── Process Section ───────────────────────────────────────
            $table->string('process_section_title')->default('How We Work');
            $table->text('process_section_subtitle')->default('Our battle-tested process ensures every project is delivered on time, within budget, and beyond expectations.');

            // ── Stats Section ─────────────────────────────────────────
            $table->string('stats_section_title')->default('By the Numbers');
            $table->text('stats_section_subtitle')->default('Metrics that define our track record and commitment to excellence.');

            // ── Testimonials Section ──────────────────────────────────
            $table->string('testimonials_section_title')->default('Client Success Stories');
            $table->text('testimonials_section_subtitle')->default('Don\'t just take our word for it — hear from the teams we\'ve helped transform.');

            // ── CTA Banner ────────────────────────────────────────────
            $table->string('cta_banner_title')->default('Ready to Build Something Extraordinary?');
            $table->text('cta_banner_subtitle')->default('Let\'s discuss how CleMwa Developers can transform your vision into a high-performance digital solution.');
            $table->string('cta_banner_primary_text')->default('Start Your Project');
            $table->string('cta_banner_primary_url')->default('/contact');
            $table->string('cta_banner_secondary_text')->default('Schedule a Consultation');
            $table->string('cta_banner_secondary_url')->default('/contact');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_settings');
    }
};
