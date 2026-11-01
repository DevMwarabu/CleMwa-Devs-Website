<x-layouts.app>
    <div class="home-concept">
    <!-- Hero -->
    <section class="home-hero relative overflow-hidden bg-white py-14 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-4xl text-center">
                <span class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-1.5 text-xs font-semibold text-emerald-900">
                    <span class="h-2 w-2 rounded-full bg-emerald-700"></span>
                    Software that moves business forward
                </span>
                <h1 class="mx-auto mt-6 max-w-4xl text-5xl font-medium leading-[1.05] tracking-tight text-slate-900 md:text-7xl">
                    Driving growth through <span class="text-accent-500">smart technology.</span>
                </h1>
                <p class="mx-auto mt-5 max-w-2xl text-lg leading-relaxed text-slate-500 md:text-xl">
                    We design and develop thoughtful digital solutions that help ambitious businesses work better, grow faster, and reach what's next.
                </p>
                <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                    <a href="/quote" class="inline-flex items-center justify-center gap-2 rounded-full bg-accent-500 px-7 py-3.5 font-semibold text-white transition-colors hover:bg-accent-600">
                        Get a free consultation
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17 17 7M7 7h10v10"/></svg>
                    </a>
                    <a href="/portfolio" class="inline-flex items-center justify-center rounded-full border border-slate-300 px-7 py-3.5 font-semibold text-slate-900 transition-colors hover:bg-slate-50">
                        Explore our work
                    </a>
                </div>

                @if($featuredProject)
                    <a href="/projects/{{ $featuredProject->slug }}" class="mt-6 inline-flex items-center gap-2 text-sm text-slate-500 transition-colors hover:text-accent-500">
                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-900">Featured work</span>
                        {{ $featuredProject->title }}
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
                    </a>
                @endif
            </div>

            @php($heroImage = $featuredProject?->image_url)
            <div class="relative mx-auto mt-12 max-w-6xl px-3 sm:mt-16 sm:px-8">
                <div class="home-hero__art relative aspect-[2/1] overflow-hidden rounded-3xl border border-slate-200 sm:rounded-[2rem]">
                    @if($heroImage)
                        <img src="{{ Str::startsWith($heroImage, 'http') ? $heroImage : Storage::url($heroImage) }}" alt="{{ $featuredProject?->title ?? 'CleMwa digital solutions' }}" class="h-full w-full object-cover">
                    @else
                        <div class="absolute inset-0 grid grid-cols-3 items-center justify-items-center overflow-hidden px-8">
                            <div class="h-32 w-32 rotate-[-12deg] rounded-[2rem] bg-accent-500/90 shadow-2xl sm:h-56 sm:w-56"></div>
                            <div class="relative flex h-40 w-40 items-center justify-center rounded-full border-[20px] border-accent2-500 bg-white/70 sm:h-72 sm:w-72 sm:border-[32px]">
                                <span class="text-4xl font-semibold text-accent-500 sm:text-7xl">C</span>
                            </div>
                            <div class="h-28 w-28 rotate-[12deg] rounded-full bg-accent2-400 shadow-xl sm:h-48 sm:w-48"></div>
                        </div>
                    @endif
                </div>
                @if($statistics->isNotEmpty())
                    <div class="absolute -left-1 top-8 max-w-40 rounded-2xl bg-accent-500 p-4 text-white shadow-xl sm:-left-2 sm:top-12 sm:max-w-48 sm:p-5">
                        <p class="text-xs font-medium text-white/75">{{ $statistics->first()->label }}</p>
                        <p class="mt-1 text-3xl font-semibold sm:text-4xl">{{ $statistics->first()->value }}</p>
                    </div>
                @endif
                @if($statistics->count() > 1)
                    <div class="absolute -bottom-3 right-0 max-w-40 rounded-2xl bg-accent-500 p-4 text-white shadow-xl sm:-right-2 sm:max-w-48 sm:p-5">
                        <p class="text-xs font-medium text-white/75">{{ $statistics->get(1)->label }}</p>
                        <p class="mt-1 text-3xl font-semibold sm:text-4xl">{{ $statistics->get(1)->value }}</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Trusted By Section -->
    @if($partners->isNotEmpty())
    <section class="home-trusted py-12 bg-white border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm font-semibold text-slate-400 uppercase tracking-widest mb-8">Trusted by innovative companies & partners</p>
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16">
                @foreach($partners as $partner)
                <div class="text-lg font-bold text-slate-500 flex items-center gap-2">
                    <svg class="w-7 h-7 text-{{ $partner->color_theme }}-500" fill="currentColor" viewBox="0 0 24 24">
                        {!! $partner->logo_svg !!}
                    </svg>
                    {{ $partner->name }}
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Services Section -->
    <section class="home-services py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Services designed to move you forward</h2>
                <p class="text-lg text-slate-500">A comprehensive suite of software development services designed for modern businesses.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $service)
                <div class="home-card p-8 rounded-xl border border-slate-200 hover:border-slate-300 hover:shadow-md transition-all">
                    <div class="w-14 h-14 rounded-lg bg-{{ $service->color_theme }}-500/10 text-{{ $service->color_theme }}-600 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            {!! $service->icon_svg !!}
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $service->title }}</h3>
                    <p class="text-slate-500 mb-6 line-clamp-3">{{ $service->description }}</p>
                    <a href="/services/{{ $service->slug }}" wire:navigate class="inline-flex items-center text-accent-600 font-medium hover:text-accent-700 transition-colors">
                        Learn more <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="mt-16 text-center">
                <a href="/services" class="inline-flex items-center justify-center px-8 py-4 border border-slate-300 hover:bg-slate-50 rounded-md text-slate-900 font-medium transition-colors">
                    View All Services
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="home-about py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-6">Why Partner With Us?</h2>
                    <p class="text-lg text-slate-500 mb-10 leading-relaxed">We don't just write code; we build scalable digital businesses. Our engineering culture is obsessed with performance, security, and exceptional user experiences.</p>

                    <ul class="space-y-8">
                        @foreach($features as $feature)
                        <li class="flex gap-4 items-start">
                            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-{{ $feature->theme_color }}-500/10 text-{{ $feature->theme_color }}-600 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    {!! $feature->icon_svg !!}
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-900 mb-1">{{ $feature->title }}</h4>
                                <p class="text-slate-500 leading-relaxed">{{ $feature->description }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="hidden lg:block">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="p-8 rounded-xl border border-slate-200 flex flex-col items-center justify-center text-center gap-4">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-plain.svg" alt="Laravel" class="w-16 h-16">
                            <span class="text-slate-900 font-medium">Laravel Core</span>
                        </div>
                        <div class="p-8 rounded-xl border border-slate-200 flex flex-col items-center justify-center text-center gap-4">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/flutter/flutter-original.svg" alt="Flutter" class="w-16 h-16">
                            <span class="text-slate-900 font-medium">Cross-Platform</span>
                        </div>
                        <div class="p-8 rounded-xl border border-slate-200 flex flex-col items-center justify-center text-center gap-4">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg" alt="React" class="w-16 h-16">
                            <span class="text-slate-900 font-medium">Dynamic UIs</span>
                        </div>
                        <div class="p-8 rounded-xl border border-slate-200 flex flex-col items-center justify-center text-center gap-4">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/amazonwebservices/amazonwebservices-original-wordmark.svg" alt="AWS" class="w-16 h-16">
                            <span class="text-slate-900 font-medium">Cloud Native</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Work Section -->
    <section class="home-work py-24 bg-slate-50 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Featured Work</h2>
                <p class="text-lg text-slate-500">A glimpse into recent work and the difference it makes.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($projects as $project)
                <div class="home-card bg-white overflow-hidden rounded-xl border border-slate-200 hover:shadow-md transition-shadow flex flex-col">
                    <div class="h-40 w-full bg-slate-100 relative overflow-hidden flex items-center justify-center">
                        @if($project->image_url)
                        <div class="absolute inset-0 bg-[url('{{ $project->image_url }}')] bg-cover bg-center"></div>
                        @else
                        <span class="text-slate-400 font-medium">{{ $project->subtitle }}</span>
                        @endif
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if($project->tags)
                                @foreach($project->tags as $tag)
                                <span class="px-2.5 py-1 rounded-full bg-{{ $project->color_theme }}-500/10 text-{{ $project->color_theme }}-600 text-[10px] font-semibold tracking-wide uppercase">{{ $tag }}</span>
                                @endforeach
                            @endif
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2 leading-tight">{{ $project->title }}</h3>
                        <p class="text-sm text-slate-500 mb-5 line-clamp-3 flex-1">{{ $project->short_description ?: Str::limit(strip_tags((string) $project->description), 140) }}</p>
                        <div class="flex items-center justify-between mt-auto">
                            <a href="/projects/{{ $project->slug }}" class="inline-flex items-center text-sm text-slate-900 font-medium hover:text-accent-600 transition-colors">
                                View Study <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                            </a>
                            @if($project->requires_quote)
                            <a href="/quote?project={{ Str::slug($project->subtitle) }}" class="inline-flex items-center px-3 py-1.5 bg-{{ $project->color_theme }}-500/10 text-{{ $project->color_theme }}-600 hover:bg-{{ $project->color_theme }}-500/20 rounded-full text-[10px] font-bold uppercase tracking-wider transition-colors">Request Quote</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-16 text-center">
                <a href="/portfolio" class="inline-flex items-center justify-center px-8 py-4 border border-slate-300 hover:bg-white rounded-md text-slate-900 font-medium transition-colors">
                    View Complete Portfolio
                </a>
            </div>
        </div>
    </section>

    <!-- Development Process Section -->
    <section class="home-process py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-20">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Our Development Process</h2>
                <p class="text-lg text-slate-500">A transparent, agile, and results-driven approach from concept to launch.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 relative">
                <div class="hidden lg:block absolute top-10 left-12 right-12 h-px bg-slate-200 -z-10"></div>

                @foreach($processSteps as $step)
                <div class="home-card flex flex-col items-center text-center rounded-2xl bg-white p-5">
                    <div class="w-20 h-20 rounded-full bg-white border border-slate-200 flex items-center justify-center mb-6 text-slate-900">
                        <span class="text-2xl font-bold">0{{ $step->step_number }}</span>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 mb-2">{{ $step->title }}</h4>
                    <p class="text-sm text-slate-500">{{ $step->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Technology Stack Section -->
    <section class="home-tech py-24 bg-slate-50 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Technologies We Master</h2>
                <p class="text-lg text-slate-500">A modern, scalable tech stack for robust enterprise applications.</p>
            </div>

            <div class="flex flex-wrap justify-center items-center gap-4 max-w-5xl mx-auto">
                @foreach($technologies as $tech)
                <div class="home-card bg-white px-6 py-4 rounded-lg border border-slate-200 flex items-center gap-3">
                    @if($tech->icon_url)
                        <img src="{{ $tech->icon_url }}" alt="{{ $tech->name }}" class="w-7 h-7">
                    @else
                        {!! $tech->icon_svg !!}
                    @endif
                    <span class="text-slate-900 font-semibold">{{ $tech->name }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="home-testimonials py-24 bg-slate-50 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Client Success Stories</h2>
                <p class="text-lg text-slate-500">Don't just take our word for it. Here's what our partners say about working with us.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($testimonials as $testimonial)
                <div class="home-card bg-white p-8 rounded-xl border border-slate-200">
                    <div class="flex items-center gap-1 mb-6 text-yellow-500">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-slate-600 mb-8 italic leading-relaxed">"{{ $testimonial->quote }}"</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center overflow-hidden">
                            @if($testimonial->client_image_url)
                                <img src="{{ $testimonial->client_image_url }}" alt="{{ $testimonial->client_name }}">
                            @else
                                <span class="text-slate-500 font-bold">{{ substr($testimonial->client_name, 0, 1) }}</span>
                            @endif
                        </div>
                        <div>
                            <h4 class="text-slate-900 font-bold">{{ $testimonial->client_name }}</h4>
                            <p class="text-sm text-slate-500">{{ $testimonial->client_role }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="home-cta py-24 bg-accent-500">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Ready to build something better?</h2>
            <p class="text-lg text-white/90 mb-10 max-w-2xl mx-auto">Tell us what you are working on. We will help you find the right next step.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="/quote" class="px-8 py-4 bg-white text-accent-600 hover:bg-slate-100 rounded-md font-semibold transition-colors">Request a Quote</a>
                <a href="/contact" class="px-8 py-4 border border-white/40 hover:bg-white/10 text-white rounded-md font-semibold transition-colors">Book Consultation</a>
            </div>
        </div>
    </section>

    </div>
</x-layouts.app>
