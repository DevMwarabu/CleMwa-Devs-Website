<x-layouts.app>
    <x-slot name="title">{{ $settings->seo_title ?? 'Our Services - CleMwa Developers' }}</x-slot>
    <x-slot name="meta_description">{{ $settings->seo_description ?? 'Innovative software solutions designed to help businesses grow, automate operations, and achieve digital transformation through secure, scalable, and modern technologies.' }}</x-slot>

    {{-- ===================== HERO ===================== --}}
    <section class="relative pt-32 pb-24 lg:pt-44 lg:pb-32 overflow-hidden bg-[#05050A]">
        <div class="absolute inset-0 bg-grid-slate-400/[0.05] bg-[bottom_1px_center] [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
        <div class="absolute inset-y-0 right-0 w-1/2 bg-gradient-to-l from-sky-500/10 to-transparent blur-3xl rounded-full"></div>
        <div class="absolute bottom-0 left-1/4 w-1/3 h-1/2 bg-indigo-500/5 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl">
                {{-- Breadcrumb --}}
                <nav class="flex mb-8 text-sm text-slate-400" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="/" class="hover:text-white transition-colors">Home</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 mx-1 text-slate-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="ml-1 md:ml-2 text-white">Services</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-sky-500/30 bg-sky-500/10 text-sky-400 text-xs font-semibold tracking-widest uppercase mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-400 animate-pulse"></span>
                    What We Build
                </div>

                <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                    {!! $settings->hero_title ?? 'Services Built<br><span class="text-sky-500">for Impact</span>' !!}
                </h1>

                <p class="text-lg md:text-xl text-slate-400 leading-relaxed mb-10 max-w-2xl">
                    {{ $settings->hero_subtitle ?? 'Innovative software solutions designed to help businesses grow, automate operations, and achieve digital transformation through secure, scalable, and modern technologies.' }}
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/quote" class="px-8 py-4 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-sm transition-all text-center shadow-[0_0_20px_rgba(14,165,233,0.3)]">
                        Request a Quote
                    </a>
                    <a href="/contact" class="px-8 py-4 bg-transparent border border-white/20 hover:border-white/40 text-white font-bold rounded-sm transition-all text-center group flex items-center justify-center gap-2">
                        Book a Free Consultation
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== OVERVIEW STATS ===================== --}}
    <section class="py-16 bg-[#0B0B0F] border-t border-white/5">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                @foreach([['12+','Years Experience'],['200+','Projects Delivered'],['50+','Expert Engineers'],['98%','Client Satisfaction']] as [$val,$lbl])
                <div>
                    <div class="text-3xl md:text-4xl font-extrabold text-white mb-1">{{ $val }}</div>
                    <div class="text-sm text-slate-400">{{ $lbl }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== SERVICES OVERVIEW ===================== --}}
    @if($settings && $settings->overview_text)
    <section class="py-20 bg-[#05050A] border-t border-white/5">
        <div class="container mx-auto px-4 max-w-4xl text-center">
            <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Our Approach</h2>
            <h3 class="text-3xl md:text-5xl font-bold text-white mb-8">What We Do</h3>
            <div class="prose prose-invert prose-lg text-slate-400 max-w-none">
                {!! $settings->overview_text !!}
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== FEATURED SERVICES ===================== --}}
    @if($featuredServices->count() > 0)
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5 relative overflow-hidden">
        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1/3 aspect-square bg-sky-500/5 rounded-full blur-3xl"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Flagship Offerings</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">Featured Services</h3>
                <p class="text-lg text-slate-400">Our most sought-after solutions, trusted by businesses worldwide.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($featuredServices as $service)
                <a href="/services/{{ $service->slug }}" class="group relative rounded-2xl bg-gradient-to-br from-sky-900/20 to-[#05050A] border border-sky-500/10 hover:border-sky-500/40 p-8 flex flex-col gap-6 transition-all overflow-hidden">
                    <div class="absolute inset-0 bg-sky-500/0 group-hover:bg-sky-500/5 transition-colors"></div>
                    <div class="w-14 h-14 rounded-xl bg-sky-500/10 border border-sky-500/20 flex items-center justify-center shrink-0">
                        @if($service->icon_svg)
                            {!! $service->icon_svg !!}
                        @else
                            <svg class="w-6 h-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-white mb-3 group-hover:text-sky-400 transition-colors">{{ $service->title }}</h4>
                        <p class="text-slate-400 leading-relaxed">{{ $service->short_description ?? Str::limit(strip_tags($service->description ?? ''), 160) }}</p>
                    </div>
                    @if($service->key_features && count($service->key_features) > 0)
                    <ul class="space-y-2 mt-2">
                        @foreach(array_slice($service->key_features, 0, 4) as $feature)
                        <li class="flex items-center gap-2 text-sm text-slate-400">
                            <svg class="w-4 h-4 text-sky-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                    @endif
                    <div class="flex items-center gap-2 text-sky-400 font-semibold text-sm mt-auto group-hover:gap-4 transition-all">
                        Learn More <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== ALL SERVICES BY CATEGORY ===================== --}}
    <section class="py-24 bg-[#05050A] border-t border-white/5" x-data="{ activeCategory: 'all' }">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Full Portfolio</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">All Services</h3>
                <p class="text-lg text-slate-400">From concept to deployment — we cover every layer of modern software development.</p>
            </div>

            {{-- Category Filter Tabs --}}
            @if($categories->count() > 0)
            <div class="flex flex-wrap justify-center gap-3 mb-12">
                <button @click="activeCategory = 'all'"
                    :class="activeCategory === 'all' ? 'bg-sky-500 text-white border-sky-500' : 'bg-transparent text-slate-400 border-white/10 hover:border-sky-500/50 hover:text-white'"
                    class="px-5 py-2 rounded-full border text-sm font-semibold transition-all">
                    All Services
                </button>
                @foreach($categories as $cat)
                <button @click="activeCategory = '{{ $cat->id }}'"
                    :class="activeCategory === '{{ $cat->id }}' ? 'bg-sky-500 text-white border-sky-500' : 'bg-transparent text-slate-400 border-white/10 hover:border-sky-500/50 hover:text-white'"
                    class="px-5 py-2 rounded-full border text-sm font-semibold transition-all">
                    {{ $cat->name }}
                </button>
                @endforeach
            </div>
            @endif

            {{-- Services Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($allServices as $service)
                <div x-show="activeCategory === 'all' || activeCategory === '{{ $service->service_category_id }}'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100">
                    <a href="/services/{{ $service->slug }}" class="group flex flex-col gap-5 p-6 rounded-2xl bg-[#0B0B0F] border border-white/5 hover:border-sky-500/30 transition-all h-full">
                        <div class="w-12 h-12 rounded-xl bg-sky-500/10 border border-sky-500/20 flex items-center justify-center shrink-0">
                            @if($service->icon_svg)
                                {!! $service->icon_svg !!}
                            @else
                                <svg class="w-5 h-5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            @endif
                        </div>
                        <div class="flex flex-col gap-2 flex-grow">
                            <h4 class="text-lg font-bold text-white group-hover:text-sky-400 transition-colors">{{ $service->title }}</h4>
                            <p class="text-sm text-slate-400 leading-relaxed flex-grow">{{ Str::limit($service->short_description ?? strip_tags($service->description ?? 'We provide expert solutions tailored to your business.'), 120) }}</p>
                        </div>
                        @if($service->category)
                        <span class="text-xs text-sky-500/70 font-medium">{{ $service->category->name }}</span>
                        @endif
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== DEVELOPMENT PROCESS ===================== --}}
    @if($processSteps->count() > 0)
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-1/3 aspect-square bg-indigo-500/5 rounded-full blur-3xl"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">How We Work</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">Our Development Process</h3>
                <p class="text-lg text-slate-400">A structured, transparent, and agile approach to delivering software that matters.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($processSteps as $index => $step)
                <div class="relative flex flex-col gap-5 p-7 rounded-2xl bg-[#05050A] border border-white/5 hover:border-sky-500/30 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-sky-500/10 border border-sky-500/20 flex items-center justify-center shrink-0">
                        @if($step->icon_svg)
                            {!! $step->icon_svg !!}
                        @else
                            <span class="text-sky-400 font-bold text-lg">{{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}</span>
                        @endif
                    </div>
                    <div>
                        <div class="text-xs font-bold text-sky-500/60 uppercase tracking-widest mb-2">Step {{ $step->step_number }}</div>
                        <h4 class="text-lg font-bold text-white mb-2 group-hover:text-sky-400 transition-colors">{{ $step->title }}</h4>
                        <p class="text-sm text-slate-400 leading-relaxed">{{ $step->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== TECHNOLOGIES ===================== --}}
    @if($technologies->count() > 0)
    <section class="py-24 bg-[#05050A] border-t border-white/5">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Our Stack</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">Technologies We Use</h3>
                <p class="text-lg text-slate-400">Enterprise-grade technologies that power secure and scalable solutions.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-6 md:gap-10 pt-4">
                @foreach($technologies as $tech)
                <div class="flex flex-col items-center gap-3 group">
                    <div class="w-20 h-20 rounded-2xl bg-[#0B0B0F] border border-white/5 flex items-center justify-center group-hover:border-sky-500/50 group-hover:-translate-y-1 transition-all shadow-lg">
                        @if($tech->icon_url)
                            <img src="{{ Str::startsWith($tech->icon_url, 'http') ? $tech->icon_url : Storage::url($tech->icon_url) }}" alt="{{ $tech->name }}" class="w-10 h-10 object-contain filter grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100 transition-all" loading="lazy">
                        @else
                            <i class="{{ $tech->icon_class ?? 'fa-solid fa-microchip' }} text-2xl text-slate-500 group-hover:text-sky-500 transition-colors"></i>
                        @endif
                    </div>
                    <span class="text-sm font-medium text-slate-400 group-hover:text-white transition-colors">{{ $tech->name }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== INDUSTRIES ===================== --}}
    @if($industries->count() > 0)
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Sectors</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">Industries We Serve</h3>
                <p class="text-lg text-slate-400">Delivering domain-specific software solutions across a wide range of sectors.</p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($industries as $industry)
                <div class="group flex flex-col items-center gap-3 p-6 rounded-2xl bg-[#05050A] border border-white/5 hover:border-sky-500/30 text-center transition-all">
                    <div class="w-12 h-12 rounded-xl bg-sky-500/10 flex items-center justify-center">
                        @if($industry->icon_url)
                            <img src="{{ Str::startsWith($industry->icon_url, 'http') ? $industry->icon_url : Storage::url($industry->icon_url) }}" alt="{{ $industry->name }}" class="w-8 h-8 object-contain" loading="lazy">
                        @else
                            <i class="{{ $industry->icon_class ?? 'fa-solid fa-building' }} text-sky-400 text-xl"></i>
                        @endif
                    </div>
                    <span class="text-sm font-semibold text-slate-300 group-hover:text-white transition-colors">{{ $industry->name }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== WHY CHOOSE US ===================== --}}
    <section class="py-24 bg-[#05050A] border-t border-white/5 relative overflow-hidden">
        <div class="absolute left-1/2 top-0 -translate-x-1/2 w-2/3 aspect-square bg-sky-500/5 rounded-full blur-3xl"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Our Advantage</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">Why Choose CleMwa Developers?</h3>
                <p class="text-lg text-slate-400">Committed to quality, security, and long-term partnerships.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach([
                    ['fa-solid fa-users-cog','Expert Engineers','Seasoned professionals with deep domain knowledge across multiple industries.'],
                    ['fa-solid fa-sync-alt','Agile Methodology','Iterative development with regular releases and transparent progress tracking.'],
                    ['fa-solid fa-shield-alt','Enterprise Security','Security-first architecture with rigorous testing and compliance standards.'],
                    ['fa-solid fa-expand-arrows-alt','Scalable Architecture','Systems that grow with your business without costly rewrites.'],
                    ['fa-solid fa-comments','Transparent Communication','Regular updates, milestone reports, and dedicated project managers.'],
                    ['fa-solid fa-microchip','Modern Technologies','We stay at the forefront of tech to deliver future-proof solutions.'],
                    ['fa-solid fa-headset','Dedicated Support','24/7 technical support and proactive maintenance after launch.'],
                    ['fa-solid fa-clock','On-Time Delivery','We respect deadlines without compromising on quality or scope.'],
                ] as [$icon, $title, $desc])
                <div class="flex flex-col gap-4 p-6 rounded-2xl bg-[#0B0B0F] border border-white/5 hover:border-sky-500/30 transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-sky-500/10 border border-sky-500/20 flex items-center justify-center shrink-0">
                        <i class="{{ $icon }} text-sky-400 text-sm"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-white mb-2 group-hover:text-sky-400 transition-colors">{{ $title }}</h4>
                        <p class="text-sm text-slate-400 leading-relaxed">{{ $desc }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== CASE STUDIES ===================== --}}
    @if($caseStudies->count() > 0)
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Our Work</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">Case Studies</h3>
                <p class="text-lg text-slate-400">Real solutions. Real results. See how we've transformed businesses.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($caseStudies as $study)
                <div class="group rounded-2xl bg-[#05050A] border border-white/5 hover:border-sky-500/30 overflow-hidden transition-all flex flex-col">
                    @if($study->image_url)
                    <div class="aspect-video overflow-hidden">
                        <img src="{{ Str::startsWith($study->image_url, 'http') ? $study->image_url : Storage::url($study->image_url) }}" alt="{{ $study->project_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    </div>
                    @endif
                    <div class="p-7 flex flex-col gap-4 flex-grow">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-sky-500 uppercase tracking-widest">{{ $study->industry }}</span>
                        </div>
                        <h4 class="text-xl font-bold text-white group-hover:text-sky-400 transition-colors">{{ $study->project_name }}</h4>
                        @if($study->solution)
                        <p class="text-sm text-slate-400 leading-relaxed flex-grow">{{ Str::limit($study->solution, 160) }}</p>
                        @endif
                        @if($study->technologies && count($study->technologies) > 0)
                        <div class="flex flex-wrap gap-2 mt-auto">
                            @foreach(array_slice($study->technologies, 0, 4) as $tech)
                            <span class="px-3 py-1 rounded-full bg-sky-500/10 text-sky-400 text-xs font-medium border border-sky-500/20">{{ $tech }}</span>
                            @endforeach
                        </div>
                        @endif
                        @if($study->link)
                        <a href="{{ $study->link }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-sky-400 font-semibold text-sm mt-3 group-hover:gap-4 transition-all">
                            View Case Study <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== TESTIMONIALS ===================== --}}
    @if($testimonials->count() > 0)
    @php
        $bentoClasses = ['sm:col-span-2 lg:row-span-2', 'md:col-span-2', '', ''];
    @endphp
    <section class="py-24 bg-[#05050A] border-t border-white/5 overflow-hidden">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Client Success</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">What Our Clients Say</h3>
                <p class="text-lg text-slate-400">Don't just take our word for it. Here's what our partners say about working with us.</p>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-4 lg:grid-rows-2">
                @foreach($testimonials as $index => $testimonial)
                @php $class = $bentoClasses[$index % 4] ?? ''; @endphp
                <div class="{{ $class }} p-6 md:p-8 rounded-2xl bg-[#0B0B0F] border border-white/5 flex flex-col justify-between group hover:border-sky-500/30 transition-all">
                    <blockquote class="flex flex-col justify-between h-full gap-6">
                        <p class="text-xl font-medium text-slate-300 italic leading-relaxed">"{{ $testimonial->quote }}"</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div class="w-12 h-12 rounded-full bg-slate-800 overflow-hidden shrink-0 border border-white/10">
                                @if($testimonial->client_image_url)
                                    <img src="{{ Str::startsWith($testimonial->client_image_url, 'http') ? $testimonial->client_image_url : Storage::url($testimonial->client_image_url) }}" alt="{{ $testimonial->client_name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400 font-bold uppercase text-sm">{{ substr($testimonial->client_name, 0, 2) }}</div>
                                @endif
                            </div>
                            <div>
                                <cite class="text-sm font-bold text-white not-italic">{{ $testimonial->client_name }}</cite>
                                <span class="block text-sm text-sky-500 font-medium">{{ $testimonial->client_role }}</span>
                            </div>
                        </div>
                    </blockquote>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== FAQs ===================== --}}
    @if($faqs->count() > 0)
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="text-center mb-16">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Questions</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">Frequently Asked Questions</h3>
                <p class="text-lg text-slate-400">Everything you need to know before starting your project with us.</p>
            </div>
            <div class="space-y-4" x-data="{ open: null }">
                @foreach($faqs as $index => $faq)
                <div class="rounded-2xl bg-[#05050A] border border-white/5 hover:border-sky-500/20 transition-all overflow-hidden">
                    <button @click="open === {{ $index }} ? open = null : open = {{ $index }}"
                        class="w-full flex items-center justify-between p-6 text-left group focus:outline-none">
                        <span class="font-semibold text-white group-hover:text-sky-400 transition-colors pr-4">{{ $faq->question }}</span>
                        <svg :class="open === {{ $index }} ? 'rotate-45 text-sky-400' : 'text-slate-500'"
                            class="w-5 h-5 shrink-0 transition-all duration-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </button>
                    <div x-show="open === {{ $index }}" x-collapse class="px-6 pb-6">
                        <p class="text-slate-400 leading-relaxed">{{ $faq->answer }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== CALL TO ACTION ===================== --}}
    <section class="py-28 bg-gradient-to-br from-sky-900/40 via-[#05050A] to-indigo-900/20 border-t border-white/5 relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-slate-400/[0.03] bg-[bottom_1px_center] [mask-image:linear-gradient(180deg,transparent,white,transparent)]"></div>
        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-2/3 aspect-square bg-sky-500/5 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-sky-500/30 bg-sky-500/10 text-sky-400 text-xs font-semibold tracking-widest uppercase mb-8">
                <span class="w-1.5 h-1.5 rounded-full bg-sky-400 animate-pulse"></span>
                Ready to Start?
            </div>
            <h2 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                {!! $settings->cta_heading ?? 'Ready to Transform<br><span class="text-sky-500">Your Business?</span>' !!}
            </h2>
            <p class="text-xl text-slate-400 mb-12 max-w-2xl mx-auto leading-relaxed">
                {{ $settings->cta_description ?? 'Partner with CleMwa Developers to build secure, scalable, and innovative digital solutions tailored to your business needs.' }}
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/quote" class="px-10 py-4 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-sm transition-all shadow-[0_0_30px_rgba(14,165,233,0.4)] text-lg w-full sm:w-auto">
                    Request a Quote
                </a>
                <a href="/contact" class="px-10 py-4 bg-transparent border border-white/20 hover:border-white/40 text-white font-bold rounded-sm transition-all text-lg w-full sm:w-auto">
                    Schedule a Consultation
                </a>
                <a href="/contact" class="px-10 py-4 bg-transparent text-slate-400 hover:text-white font-semibold transition-all text-lg underline underline-offset-4 w-full sm:w-auto">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>
