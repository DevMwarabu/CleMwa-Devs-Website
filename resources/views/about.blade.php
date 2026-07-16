<x-layouts.app>
    <x-slot name="title">{{ $settings->hero_title ?? 'About Us - CleMwa Developers' }}</x-slot>
    <x-slot name="meta_description">{{ Str::limit(strip_tags($settings->overview ?? ''), 160) }}</x-slot>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden bg-[#05050A]">
        <div class="absolute inset-0 bg-[url('/img/grid.svg')] bg-center [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))] opacity-10"></div>
        <div class="absolute inset-y-0 right-0 w-1/2 bg-gradient-to-l from-sky-500/10 to-transparent blur-3xl rounded-full"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl">
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
                                <span class="ml-1 md:ml-2 text-white">About Us</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-4xl md:text-5xl lg:text-7xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                    {{ $settings->hero_title ?? 'About CleMwa Developers' }}
                </h1>
                
                <p class="text-lg md:text-xl text-slate-400 leading-relaxed mb-10 max-w-2xl">
                    {{ $settings->hero_description ?? 'Building innovative software solutions that empower businesses, organizations, and governments through modern technology, secure architecture, and exceptional user experiences.' }}
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/quote" class="px-8 py-4 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-sm transition-all text-center shadow-[0_0_20px_rgba(14,165,233,0.3)]">
                        Start Your Project
                    </a>
                    <a href="/contact" class="px-8 py-4 bg-transparent border border-white/20 hover:border-white/40 text-white font-bold rounded-sm transition-all text-center group flex items-center justify-center gap-2">
                        Contact Us
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Company Overview & Story -->
    <section class="py-20 bg-[#0B0B0F] border-t border-white/5 relative">
        <div class="container mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                <div>
                    <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Company Overview</h2>
                    <h3 class="text-3xl md:text-4xl font-bold text-white mb-6">Who We Are</h3>
                    <div class="prose prose-invert prose-lg text-slate-400 max-w-none">
                        <p>{{ $settings->overview ?? 'We are a premier software engineering firm committed to delivering high-quality digital solutions.' }}</p>
                    </div>
                </div>
                <div>
                    <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Our Story</h2>
                    <h3 class="text-3xl md:text-4xl font-bold text-white mb-6">How It Started</h3>
                    <div class="prose prose-invert prose-lg text-slate-400 max-w-none">
                        <p>{{ $settings->our_story ?? 'Founded with a vision to transform the digital landscape, we have grown from a small team to a global technology partner.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-24 bg-[#05050A] relative">
        <div class="container mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="p-10 md:p-12 rounded-2xl bg-gradient-to-br from-sky-900/20 to-[#0B0B0F] border border-sky-500/10 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-24 h-24 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
                        <span class="w-8 h-8 rounded bg-sky-500/20 flex items-center justify-center text-sky-500">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </span>
                        Our Mission
                    </h3>
                    <p class="text-xl text-slate-300 leading-relaxed relative z-10">
                        "{{ $settings->mission ?? 'To empower businesses through innovative, secure, scalable, and intelligent software solutions that create measurable value.' }}"
                    </p>
                </div>
                
                <div class="p-10 md:p-12 rounded-2xl bg-gradient-to-br from-[#0B0B0F] to-indigo-900/20 border border-indigo-500/10 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-24 h-24 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
                        <span class="w-8 h-8 rounded bg-indigo-500/20 flex items-center justify-center text-indigo-500">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </span>
                        Our Vision
                    </h3>
                    <p class="text-xl text-slate-300 leading-relaxed relative z-10">
                        "{{ $settings->vision ?? 'To become a globally recognized software engineering company delivering world-class digital solutions that transform industries and improve lives.' }}"
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    @if($coreValues->count() > 0)
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5 relative">
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Our Principles</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">Core Values</h3>
                <p class="text-lg text-slate-400">The fundamental beliefs that guide our behavior, decision-making, and how we interact with our clients and each other.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($coreValues as $value)
                <div class="p-8 rounded-xl bg-[#12121A] border border-white/5 hover:border-sky-500/30 transition-all group">
                    <div class="w-12 h-12 rounded-lg bg-white/5 flex items-center justify-center text-sky-500 mb-6 group-hover:scale-110 group-hover:bg-sky-500/10 transition-all">
                        @if($value->icon)
                            <i class="{{ $value->icon }} text-xl"></i>
                        @else
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        @endif
                    </div>
                    <h4 class="text-xl font-bold text-white mb-3">{{ $value->title }}</h4>
                    <p class="text-slate-400 leading-relaxed">{{ $value->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Statistics -->
    @if($statistics->count() > 0)
    <section class="py-20 bg-sky-600 relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.05] bg-[bottom_1px_center]"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                @foreach($statistics as $stat)
                <div>
                    <div class="text-4xl md:text-5xl font-extrabold text-white mb-2">{{ $stat->value }}{{ $stat->suffix }}</div>
                    <div class="text-sky-100 font-medium uppercase tracking-wider text-sm">{{ $stat->label }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Team Section -->
    @if($teamMembers->count() > 0)
    <section class="py-24 bg-[#05050A] border-t border-white/5">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Our People</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">Meet The Team</h3>
                <p class="text-lg text-slate-400">The brilliant minds behind our innovative solutions.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($teamMembers as $member)
                <div class="group relative rounded-2xl bg-[#0B0B0F] border border-white/5 overflow-hidden hover:border-sky-500/30 transition-all">
                    <div class="aspect-square overflow-hidden bg-[#12121A]">
                        @if($member->photo_url)
                            <img src="{{ Storage::url($member->photo_url) }}" alt="{{ $member->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-700">
                                <svg class="w-20 h-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold text-white mb-1">{{ $member->name }}</h4>
                        <p class="text-sky-500 text-sm font-medium mb-4">{{ $member->position }}</p>
                        @if($member->biography)
                            <p class="text-slate-400 text-sm mb-4 line-clamp-3">{{ $member->biography }}</p>
                        @endif
                        
                        @if($member->social_links)
                        <div class="flex items-center gap-3 mt-4 pt-4 border-t border-white/5">
                            @foreach($member->social_links as $link)
                                <a href="{{ $link['url'] ?? '#' }}" target="_blank" rel="noopener noreferrer" class="text-slate-500 hover:text-white transition-colors">
                                    <i class="{{ $link['icon'] ?? 'fa-solid fa-link' }}"></i>
                                </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Timeline / Our Journey -->
    @if($timelineEvents->count() > 0)
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="text-center mb-16">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Our Journey</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">Company Timeline</h3>
            </div>
            
            <div class="relative border-l border-white/10 ml-3 md:ml-6 space-y-12 pb-4">
                @foreach($timelineEvents as $event)
                <div class="relative pl-8 md:pl-12">
                    <div class="absolute w-6 h-6 bg-[#0B0B0F] border-2 border-sky-500 rounded-full -left-[13px] top-1"></div>
                    <div class="text-sky-500 font-bold mb-2">{{ $event->date }}</div>
                    <h4 class="text-2xl font-bold text-white mb-3">{{ $event->title }}</h4>
                    <p class="text-slate-400 leading-relaxed max-w-3xl">{{ $event->description }}</p>
                    @if($event->image_url)
                        <img src="{{ Storage::url($event->image_url) }}" alt="{{ $event->title }}" class="mt-6 rounded-xl border border-white/10 max-w-md w-full" loading="lazy">
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Technologies -->
    @if($technologies->count() > 0)
    <section class="py-24 bg-[#05050A] border-t border-white/5 relative overflow-hidden">
        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1/3 aspect-square bg-sky-500/5 rounded-full blur-3xl"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Our Stack</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">Technologies We Use</h3>
                <p class="text-lg text-slate-400">We leverage modern, enterprise-grade technologies to build scalable and secure solutions.</p>
            </div>
            
            <div class="flex flex-wrap justify-center gap-6 md:gap-10">
                @foreach($technologies as $tech)
                <div class="flex flex-col items-center gap-3 group">
                    <div class="w-20 h-20 rounded-2xl bg-[#0B0B0F] border border-white/5 flex items-center justify-center group-hover:border-sky-500/50 group-hover:-translate-y-1 transition-all shadow-lg">
                        @if($tech->icon_url)
                            <img src="{{ Storage::url($tech->icon_url) }}" alt="{{ $tech->name }}" class="w-10 h-10 object-contain filter grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100 transition-all" loading="lazy">
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

    <!-- Industries Served -->
    @if($industries->count() > 0)
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Our Reach</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">Industries We Serve</h3>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($industries as $industry)
                <div class="p-6 rounded-xl bg-[#12121A] border border-white/5 hover:bg-[#1a1a24] hover:border-white/10 transition-all group">
                    <div class="w-10 h-10 rounded bg-white/5 flex items-center justify-center text-sky-500 mb-4 group-hover:scale-110 transition-transform">
                        <i class="{{ $industry->icon ?? 'fa-solid fa-building' }}"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2">{{ $industry->name }}</h4>
                    <p class="text-sm text-slate-400 leading-relaxed">{{ $industry->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Testimonials -->
    @if($testimonials->count() > 0)
    <section class="py-24 bg-[#05050A] border-t border-white/5 overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Client Success</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">What Our Clients Say</h3>
            </div>
            
            <div class="flex overflow-x-auto gap-6 pb-8 snap-x snap-mandatory scrollbar-hide" style="-ms-overflow-style: none; scrollbar-width: none;">
                @foreach($testimonials as $testimonial)
                <div class="snap-center shrink-0 w-full md:w-[400px] p-8 rounded-2xl bg-[#0B0B0F] border border-white/5 flex flex-col justify-between">
                    <div>
                        <div class="flex text-sky-500 mb-4 text-sm">
                            @for($i=0; $i<5; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </div>
                        <p class="text-slate-300 italic mb-8 relative z-10">"{{ $testimonial->quote }}"</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-slate-800 overflow-hidden shrink-0">
                            @if($testimonial->image_url)
                                <img src="{{ Storage::url($testimonial->image_url) }}" alt="{{ $testimonial->author_name }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div>
                            <h5 class="text-white font-bold text-sm">{{ $testimonial->author_name }}</h5>
                            <p class="text-sky-500 text-xs">{{ $testimonial->author_title }}{{ $testimonial->company ? ', ' . $testimonial->company : '' }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Certifications & Awards -->
    @if($certifications->count() > 0 || $awards->count() > 0)
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <!-- Certifications -->
                @if($certifications->count() > 0)
                <div>
                    <h3 class="text-2xl font-bold text-white mb-8 flex items-center gap-3">
                        <i class="fa-solid fa-certificate text-sky-500"></i> Certifications & Standards
                    </h3>
                    <div class="space-y-6">
                        @foreach($certifications as $cert)
                        <div class="p-6 rounded-xl bg-[#12121A] border border-white/5">
                            <h4 class="text-lg font-bold text-white mb-2">{{ $cert->title }}</h4>
                            <p class="text-sm text-slate-400">{{ $cert->description }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Awards -->
                @if($awards->count() > 0)
                <div>
                    <h3 class="text-2xl font-bold text-white mb-8 flex items-center gap-3">
                        <i class="fa-solid fa-trophy text-sky-500"></i> Awards & Recognition
                    </h3>
                    <div class="space-y-6">
                        @foreach($awards as $award)
                        <div class="p-6 rounded-xl bg-[#12121A] border border-white/5 flex gap-6 items-start">
                            <div class="font-bold text-sky-500 shrink-0">{{ $award->year }}</div>
                            <div>
                                <h4 class="text-lg font-bold text-white mb-2">{{ $award->name }}</h4>
                                <p class="text-sm text-slate-400">{{ $award->description }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    <!-- Office Locations -->
    @if($officeLocations->count() > 0)
    <section class="py-24 bg-[#05050A] border-t border-white/5">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Global Presence</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">Our Offices</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($officeLocations as $office)
                <div class="p-8 rounded-2xl bg-[#0B0B0F] border border-white/5">
                    <h4 class="text-2xl font-bold text-white mb-6">{{ $office->name }}</h4>
                    <div class="space-y-4 text-slate-300">
                        <div class="flex gap-4">
                            <i class="fa-solid fa-location-dot text-sky-500 mt-1"></i>
                            <span>{{ $office->address }}</span>
                        </div>
                        @if($office->phone)
                        <div class="flex gap-4">
                            <i class="fa-solid fa-phone text-sky-500 mt-1"></i>
                            <span>{{ $office->phone }}</span>
                        </div>
                        @endif
                        @if($office->email)
                        <div class="flex gap-4">
                            <i class="fa-solid fa-envelope text-sky-500 mt-1"></i>
                            <span>{{ $office->email }}</span>
                        </div>
                        @endif
                        @if($office->office_hours)
                        <div class="flex gap-4">
                            <i class="fa-solid fa-clock text-sky-500 mt-1"></i>
                            <span>{{ $office->office_hours }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- FAQs -->
    @if($faqs->count() > 0)
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5">
        <div class="container mx-auto px-4 max-w-3xl">
            <div class="text-center mb-16">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Learn More</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">Frequently Asked Questions</h3>
            </div>
            
            <div class="space-y-4" x-data="{ active: null }">
                @foreach($faqs as $index => $faq)
                <div class="border border-white/5 rounded-lg bg-[#12121A] overflow-hidden">
                    <button @click="active === {{ $index }} ? active = null : active = {{ $index }}" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                        <span class="font-bold text-white pr-4">{{ $faq->question }}</span>
                        <svg class="w-5 h-5 text-sky-500 transform transition-transform duration-300" :class="active === {{ $index }} ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="active === {{ $index }}" x-collapse>
                        <div class="p-6 pt-0 text-slate-400 leading-relaxed border-t border-white/5 mt-2">
                            {{ $faq->answer }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="py-24 bg-sky-600 relative overflow-hidden text-center">
        <div class="absolute inset-0 bg-[url('/img/grid.svg')] bg-center [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))] opacity-20"></div>
        <div class="container mx-auto px-4 relative z-10 max-w-4xl">
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 leading-tight">
                {{ $settings->cta_heading ?? "Let's Build Something Amazing Together" }}
            </h2>
            <p class="text-xl text-sky-100 mb-10 leading-relaxed">
                {{ $settings->cta_description ?? "Whether you're a startup, enterprise, government institution, or growing business, we're ready to help you transform your ideas into reliable digital solutions." }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/quote" class="px-8 py-4 bg-white hover:bg-slate-100 text-sky-600 font-bold rounded-sm transition-all shadow-lg text-lg">
                    Request a Quote
                </a>
                <a href="/contact" class="px-8 py-4 bg-transparent border border-white/30 hover:border-white text-white font-bold rounded-sm transition-all text-lg">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>
