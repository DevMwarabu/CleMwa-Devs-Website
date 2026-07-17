<x-layouts.app>
    <x-slot name="title">{{ $settings->seo_title ?? 'Our Portfolio - CleMwa Developers' }}</x-slot>
    <x-slot name="meta_description">{{ $settings->seo_description ?? 'Discover how CleMwa Developers transforms ideas into secure, scalable, and innovative digital solutions that help businesses grow and succeed.' }}</x-slot>

    {{-- ===================== HERO ===================== --}}
    <section class="relative pt-32 pb-24 lg:pt-44 lg:pb-32 overflow-hidden bg-[#05050A]">
        <div class="absolute inset-0 bg-grid-slate-400/[0.05] bg-[bottom_1px_center] [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
        <div class="absolute inset-y-0 right-0 w-1/2 bg-gradient-to-l from-sky-500/10 to-transparent blur-3xl rounded-full"></div>
        <div class="absolute bottom-0 left-1/4 w-1/3 h-1/2 bg-indigo-500/5 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-4 relative z-10 text-center max-w-4xl">
            {{-- Breadcrumb --}}
            <nav class="flex justify-center mb-8 text-sm text-slate-400" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/" class="hover:text-white transition-colors">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-slate-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 md:ml-2 text-white">Portfolio</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-sky-500/30 bg-sky-500/10 text-sky-400 text-xs font-semibold tracking-widest uppercase mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-sky-400 animate-pulse"></span>
                Our Work
            </div>

            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                {!! $settings->hero_title ?? 'Building Digital<br><span class="text-sky-500">Excellence</span>' !!}
            </h1>

            <p class="text-lg md:text-xl text-slate-400 leading-relaxed mb-10 mx-auto max-w-2xl">
                {{ $settings->hero_subtitle ?? 'Discover how CleMwa Developers transforms ideas into secure, scalable, and innovative digital solutions that help businesses grow and succeed.' }}
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="/quote" class="px-8 py-4 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-sm transition-all shadow-[0_0_20px_rgba(14,165,233,0.3)]">
                    Start Your Project
                </a>
                <a href="/contact" class="px-8 py-4 bg-transparent border border-white/20 hover:border-white/40 text-white font-bold rounded-sm transition-all group flex items-center justify-center gap-2">
                    Contact Us
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ===================== OVERVIEW STATS ===================== --}}
    <section class="py-16 bg-[#0B0B0F] border-t border-white/5">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                @foreach([
                    [$projects->count() . '+', 'Completed Projects'],
                    [$industries->count() . '+', 'Industries Served'],
                    [$technologies->count() . '+', 'Technologies Mastered'],
                    ['Global', 'Reach']
                ] as [$val,$lbl])
                <div>
                    <div class="text-3xl md:text-4xl font-extrabold text-white mb-1">{{ $val }}</div>
                    <div class="text-sm text-slate-400">{{ $lbl }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== FEATURED PROJECTS ===================== --}}
    @if($featuredProjects->count() > 0)
    <section class="py-24 bg-[#05050A] border-t border-white/5 relative overflow-hidden">
        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1/3 aspect-square bg-sky-500/5 rounded-full blur-3xl"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Highlight Reel</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">Featured Projects</h3>
                <p class="text-lg text-slate-400">A selection of our most impactful and innovative work across various industries.</p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                @foreach($featuredProjects as $project)
                <a href="/projects/{{ $project->slug }}" class="group block relative rounded-md overflow-hidden bg-[#0B0B0F] border border-white/10 hover:border-sky-500/30 transition-all shadow-2xl">
                    <div class="relative aspect-[4/3] overflow-hidden bg-slate-900">
                        @if($project->image_url)
                            <img src="{{ Str::startsWith($project->image_url, 'http') ? $project->image_url : Storage::url($project->image_url) }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                        
                        {{-- Badges --}}
                        <div class="absolute top-6 left-6 flex flex-wrap gap-2">
                            @if($project->industry)
                            <span class="px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-white text-xs font-semibold tracking-wide border border-white/20 uppercase">
                                {{ $project->industry }}
                            </span>
                            @endif
                            @if($project->completion_year)
                            <span class="px-3 py-1 rounded-full bg-sky-500/20 backdrop-blur-md text-sky-300 text-xs font-semibold tracking-wide border border-sky-500/20">
                                {{ $project->completion_year }}
                            </span>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="absolute bottom-6 left-6 right-6">
                            <h4 class="text-2xl md:text-3xl font-bold text-white mb-2 group-hover:text-sky-400 transition-colors">{{ $project->title }}</h4>
                            @if($project->short_description)
                                <p class="text-slate-300 text-sm md:text-base line-clamp-2 mb-4">{{ $project->short_description }}</p>
                            @endif
                            
                            @if($project->technologies && count($project->technologies) > 0)
                            <div class="flex flex-wrap gap-2 mt-auto">
                                @foreach(array_slice($project->technologies, 0, 4) as $tech)
                                <span class="px-2 py-1 rounded bg-black/40 text-slate-300 text-xs font-medium border border-white/10">{{ $tech }}</span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== FULL PORTFOLIO GRID ===================== --}}
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5" x-data="{ activeFilter: 'all', filterType: 'category' }">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-8">
                <div class="max-w-2xl">
                    <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">All Projects</h2>
                    <h3 class="text-3xl md:text-5xl font-bold text-white mb-4">Complete Portfolio</h3>
                    <p class="text-lg text-slate-400">Explore our diverse range of successful deliveries.</p>
                </div>

                {{-- Filter Controls --}}
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex items-center gap-2 p-1 bg-black/30 rounded-sm border border-white/5">
                        <button @click="filterType = 'category'; activeFilter = 'all'" :class="filterType === 'category' ? 'bg-[#1a1a24] text-white shadow-sm' : 'text-slate-400 hover:text-white'" class="px-4 py-2 text-sm font-medium rounded-md transition-all">Type</button>
                        <button @click="filterType = 'industry'; activeFilter = 'all'" :class="filterType === 'industry' ? 'bg-[#1a1a24] text-white shadow-sm' : 'text-slate-400 hover:text-white'" class="px-4 py-2 text-sm font-medium rounded-md transition-all">Industry</button>
                    </div>
                </div>
            </div>

            {{-- Dynamic Filter Badges --}}
            <div class="flex flex-wrap gap-2 mb-10 min-h-[40px]">
                <button @click="activeFilter = 'all'"
                    :class="activeFilter === 'all' ? 'bg-sky-500 text-white border-sky-500' : 'bg-transparent text-slate-400 border-white/10 hover:border-sky-500/50 hover:text-white'"
                    class="px-4 py-1.5 rounded-full border text-xs font-semibold transition-all">
                    All
                </button>
                
                {{-- Categories --}}
                @foreach($categories as $category)
                <button x-show="filterType === 'category'" @click="activeFilter = '{{ Str::slug($category) }}'"
                    :class="activeFilter === '{{ Str::slug($category) }}' ? 'bg-sky-500 text-white border-sky-500' : 'bg-transparent text-slate-400 border-white/10 hover:border-sky-500/50 hover:text-white'"
                    class="px-4 py-1.5 rounded-full border text-xs font-semibold transition-all">
                    {{ $category }}
                </button>
                @endforeach

                {{-- Industries --}}
                @foreach($industries as $industry)
                <button x-show="filterType === 'industry'" @click="activeFilter = '{{ Str::slug($industry) }}'"
                    :class="activeFilter === '{{ Str::slug($industry) }}' ? 'bg-sky-500 text-white border-sky-500' : 'bg-transparent text-slate-400 border-white/10 hover:border-sky-500/50 hover:text-white'"
                    class="px-4 py-1.5 rounded-full border text-xs font-semibold transition-all">
                    {{ $industry }}
                </button>
                @endforeach
            </div>

            {{-- Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $project)
                <div x-show="activeFilter === 'all' || 
                            (filterType === 'category' && activeFilter === '{{ Str::slug($project->project_type) }}') || 
                            (filterType === 'industry' && activeFilter === '{{ Str::slug($project->industry) }}')"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="group">
                    <a href="/projects/{{ $project->slug }}" class="flex flex-col h-full group">
                        @if($project->image_url)
                        <div class="aspect-video overflow-hidden rounded-md bg-slate-900 relative mb-5">
                            <img src="{{ Str::startsWith($project->image_url, 'http') ? $project->image_url : Storage::url($project->image_url) }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                            @if($project->status === 'ongoing')
                            <div class="absolute top-4 right-4 px-2 py-1 bg-amber-500/90 text-black text-[10px] font-black uppercase tracking-wider rounded">Ongoing</div>
                            @endif
                        </div>
                        @endif
                        <div class="flex flex-col flex-grow">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">{{ $project->project_type }}</span>
                                <span class="text-xs text-slate-500 font-medium">{{ $project->completion_year }}</span>
                            </div>
                            <h4 class="text-xl font-bold text-white mb-2 group-hover:text-sky-400 transition-colors">{{ $project->title }}</h4>
                            <p class="text-sm text-slate-400 line-clamp-2">{{ $project->short_description ?? Str::limit(strip_tags($project->description ?? ''), 100) }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== TECHNOLOGIES ===================== --}}
    @if($technologies->count() > 0)
    <section class="py-24 bg-[#05050A] border-t border-white/5">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Tech Arsenal</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">Technologies We Master</h3>
                <p class="text-lg text-slate-400">We leverage the best tools in the industry to build robust, scalable, and secure applications.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-6 md:gap-10 pt-4 max-w-5xl mx-auto">
                @foreach($technologies as $tech)
                <div class="flex flex-col items-center gap-3 group">
                    <div class="w-20 h-20 rounded-md bg-[#0B0B0F] border border-white/5 flex items-center justify-center group-hover:border-sky-500/50 group-hover:-translate-y-1 transition-all shadow-lg">
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
                <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Domain Expertise</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">Industries We Empower</h3>
                <p class="text-lg text-slate-400">Our deep domain knowledge allows us to craft targeted solutions for various sectors.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-4 max-w-4xl mx-auto">
                @foreach($industries as $industry)
                <div class="px-6 py-3 rounded-full bg-[#05050A] border border-white/5 text-slate-300 font-semibold text-sm hover:border-sky-500/30 hover:text-white transition-colors cursor-default">
                    {{ $industry }}
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
                {!! $settings->cta_heading ?? 'Ready to Build Your<br><span class="text-sky-500">Next Success Story?</span>' !!}
            </h2>
            <p class="text-xl text-slate-400 mb-12 max-w-2xl mx-auto leading-relaxed">
                {{ $settings->cta_description ?? "Whether you're a startup, enterprise, or government institution, CleMwa Developers is ready to transform your vision into a high-performing digital solution." }}
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/quote" class="px-10 py-4 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-sm transition-all shadow-[0_0_30px_rgba(14,165,233,0.4)] text-lg w-full sm:w-auto">
                    Request a Quote
                </a>
                <a href="/contact" class="px-10 py-4 bg-transparent border border-white/20 hover:border-white/40 text-white font-bold rounded-sm transition-all text-lg w-full sm:w-auto">
                    Book Consultation
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>
