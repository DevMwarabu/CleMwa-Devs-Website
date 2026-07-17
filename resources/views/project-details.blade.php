<x-layouts.app>
    <x-slot name="title">{{ $project->seo_title ?? $project->title . ' - CleMwa Developers Portfolio' }}</x-slot>
    <x-slot name="meta_description">{{ $project->seo_description ?? Str::limit(strip_tags($project->short_description ?? $project->description ?? ''), 160) }}</x-slot>

    {{-- ===================== HERO ===================== --}}
    <section class="relative pt-32 pb-20 lg:pt-44 lg:pb-28 overflow-hidden bg-[#05050A]">
        <div class="absolute inset-0 bg-grid-slate-400/[0.05] bg-[bottom_1px_center] [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
        <div class="absolute inset-y-0 right-0 w-1/2 bg-gradient-to-l from-sky-500/10 to-transparent blur-3xl rounded-full"></div>

        <div class="container mx-auto px-4 relative z-10">
            {{-- Breadcrumb --}}
            <nav class="flex mb-12 text-sm text-slate-400" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 flex-wrap gap-y-1">
                    <li class="inline-flex items-center">
                        <a href="/" class="hover:text-white transition-colors">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-slate-600" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                            <a href="/portfolio" class="hover:text-white transition-colors">Portfolio</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-slate-600" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                            <span class="text-white">{{ $project->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        @if($project->project_type)
                        <div class="px-4 py-2 rounded-full border border-sky-500/30 bg-sky-500/10 text-sky-400 text-xs font-semibold tracking-widest uppercase">
                            {{ $project->project_type }}
                        </div>
                        @endif
                        @if($project->industry)
                        <div class="px-4 py-2 rounded-full border border-white/10 bg-white/5 text-slate-300 text-xs font-semibold tracking-widest uppercase">
                            {{ $project->industry }}
                        </div>
                        @endif
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                        {{ $project->title }}
                    </h1>

                    @if($project->subtitle || $project->short_description)
                    <p class="text-lg md:text-xl text-slate-400 leading-relaxed mb-10">
                        {{ $project->subtitle ?? $project->short_description }}
                    </p>
                    @endif

                    @if($project->live_url)
                    <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-8 py-4 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-sm transition-all shadow-[0_0_20px_rgba(14,165,233,0.3)]">
                        View Live Project
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                    @endif
                </div>

                <div class="relative">
                    @if($project->image_url)
                    <div class="rounded-md overflow-hidden border border-white/10 shadow-2xl bg-slate-900 aspect-[4/3]">
                        <img src="{{ Str::startsWith($project->image_url, 'http') ? $project->image_url : Storage::url($project->image_url) }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                    </div>
                    @else
                    <div class="w-full aspect-[4/3] rounded-md bg-[#0B0B0F] border border-white/5 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-sky-500/10 to-indigo-500/5"></div>
                        <svg class="w-16 h-16 text-slate-700 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    @endif

                    @if($project->client_logo_url)
                    <div class="absolute -bottom-6 -left-6 p-4 rounded-sm bg-white shadow-xl max-w-[150px]">
                        <img src="{{ Str::startsWith($project->client_logo_url, 'http') ? $project->client_logo_url : Storage::url($project->client_logo_url) }}" alt="{{ $project->client_name }}" class="w-full h-auto object-contain">
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== OVERVIEW BAR ===================== --}}
    <section class="py-10 bg-[#0B0B0F] border-t border-white/5">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                @if($project->client_name)
                <div>
                    <div class="text-xs font-bold tracking-widest text-slate-500 uppercase mb-1">Client</div>
                    <div class="text-lg font-semibold text-white">{{ $project->client_name }}</div>
                </div>
                @endif
                @if($project->completion_year)
                <div>
                    <div class="text-xs font-bold tracking-widest text-slate-500 uppercase mb-1">Delivered</div>
                    <div class="text-lg font-semibold text-white">{{ $project->completion_year }}</div>
                </div>
                @endif
                @if($project->industry)
                <div>
                    <div class="text-xs font-bold tracking-widest text-slate-500 uppercase mb-1">Industry</div>
                    <div class="text-lg font-semibold text-white">{{ $project->industry }}</div>
                </div>
                @endif
                @if($project->project_type)
                <div>
                    <div class="text-xs font-bold tracking-widest text-slate-500 uppercase mb-1">Service</div>
                    <div class="text-lg font-semibold text-white">{{ $project->project_type }}</div>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ===================== CONTENT BODY ===================== --}}
    <div class="py-24 bg-[#05050A]">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">

                {{-- Main content column --}}
                <div class="lg:col-span-2 space-y-16">

                    {{-- Description --}}
                    @if($project->description)
                    <div>
                        <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Overview</h2>
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-6">About the Project</h3>
                        <div class="prose prose-invert prose-lg text-slate-400 max-w-none">
                            {!! $project->description !!}
                        </div>
                    </div>
                    @endif

                    {{-- Challenge & Solution --}}
                    @if($project->challenge || $project->solution)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @if($project->challenge)
                        <div class="p-8 rounded-md bg-[#0B0B0F] border border-white/5">
                            <h2 class="text-xs font-bold tracking-widest text-red-400 uppercase mb-3">The Problem</h2>
                            <h3 class="text-2xl font-bold text-white mb-4">The Challenge</h3>
                            <div class="prose prose-invert text-slate-400">
                                {!! $project->challenge !!}
                            </div>
                        </div>
                        @endif

                        @if($project->solution)
                        <div class="p-8 rounded-md bg-gradient-to-br from-sky-900/20 to-[#0B0B0F] border border-sky-500/10">
                            <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Our Approach</h2>
                            <h3 class="text-2xl font-bold text-white mb-4">The Solution</h3>
                            <div class="prose prose-invert text-slate-400">
                                {!! $project->solution !!}
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    {{-- Features Delivered --}}
                    @if($project->features_delivered && count($project->features_delivered) > 0)
                    <div>
                        <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Capabilities</h2>
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-8">Features Delivered</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($project->features_delivered as $feature)
                            @if(is_array($feature) && isset($feature['feature']))
                                <div class="flex items-start gap-4 p-5 rounded-sm bg-[#0B0B0F] border border-white/5">
                                    <div class="w-8 h-8 rounded-sm bg-sky-500/10 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-4 h-4 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="text-slate-300 font-medium leading-snug">{{ $feature['feature'] }}</span>
                                </div>
                            @elseif(is_string($feature))
                                <div class="flex items-start gap-4 p-5 rounded-sm bg-[#0B0B0F] border border-white/5">
                                    <div class="w-8 h-8 rounded-sm bg-sky-500/10 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-4 h-4 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="text-slate-300 font-medium leading-snug">{{ $feature }}</span>
                                </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Gallery --}}
                    @if($project->gallery && count($project->gallery) > 0)
                    <div>
                        <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Visuals</h2>
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-8">Project Gallery</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach($project->gallery as $img)
                            <div class="rounded-sm overflow-hidden border border-white/10 bg-slate-900 aspect-video group relative">
                                <img src="{{ Str::startsWith($img, 'http') ? $img : Storage::url($img) }}" alt="Gallery Image" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors pointer-events-none"></div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Results --}}
                    @if($project->results)
                    <div>
                        <h2 class="text-xs font-bold tracking-widest text-green-400 uppercase mb-3">Outcome</h2>
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-6">Business Results</h3>
                        <div class="prose prose-invert prose-lg text-slate-400 max-w-none">
                            {!! $project->results !!}
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="space-y-8">
                    {{-- Stats --}}
                    @if($project->stats && count($project->stats) > 0)
                    <div class="rounded-md bg-gradient-to-br from-sky-900/20 to-[#0B0B0F] border border-sky-500/10 p-8">
                        <h3 class="text-lg font-bold text-white mb-6">Project Impact</h3>
                        <div class="space-y-6">
                            @foreach($project->stats as $stat)
                            <div>
                                <div class="text-3xl font-extrabold text-white mb-1">{{ $stat['value'] ?? '' }}</div>
                                <div class="text-sm font-semibold tracking-wide text-sky-400 uppercase">{{ $stat['label'] ?? '' }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Technologies --}}
                    @if($project->technologies && count($project->technologies) > 0)
                    <div class="rounded-md bg-[#0B0B0F] border border-white/5 p-8">
                        <h3 class="text-lg font-bold text-white mb-6">Technologies Used</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($project->technologies as $tech)
                            <span class="px-3 py-1.5 rounded bg-[#05050A] text-slate-300 text-xs font-medium border border-white/5">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Client Testimonial --}}
                    @if($project->testimonial_quote)
                    <div class="rounded-md bg-[#0B0B0F] border border-white/5 p-8 relative overflow-hidden">
                        <svg class="absolute top-4 right-4 w-16 h-16 text-white/5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                        
                        <div class="relative z-10">
                            @if($project->testimonial_rating)
                            <div class="flex text-amber-400 mb-4 text-sm">
                                @for($i = 0; $i < $project->testimonial_rating; $i++)
                                <i class="fa-solid fa-star"></i>
                                @endfor
                            </div>
                            @endif
                            <p class="text-slate-300 italic leading-relaxed mb-6">"{{ $project->testimonial_quote }}"</p>
                            <div class="flex items-center gap-4">
                                @if($project->testimonial_photo_url)
                                <img src="{{ Str::startsWith($project->testimonial_photo_url, 'http') ? $project->testimonial_photo_url : Storage::url($project->testimonial_photo_url) }}" alt="{{ $project->testimonial_name }}" class="w-12 h-12 rounded-full object-cover">
                                @endif
                                <div>
                                    <div class="font-bold text-white text-sm">{{ $project->testimonial_name }}</div>
                                    <div class="text-sky-500 text-xs font-medium">{{ $project->testimonial_role }}</div>
                                    <div class="text-slate-500 text-xs">{{ $project->testimonial_company }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== RELATED PROJECTS ===================== --}}
    @if($relatedProjects->count() > 0)
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-4">Related Projects</h2>
                <p class="text-lg text-slate-400">Explore more of our work in the {{ $project->project_type }} space.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedProjects as $related)
                <a href="/projects/{{ $related->slug }}" class="group flex flex-col h-full">
                    @if($related->image_url)
                    <div class="aspect-video overflow-hidden rounded-md bg-slate-900 relative mb-4">
                        <img src="{{ Str::startsWith($related->image_url, 'http') ? $related->image_url : Storage::url($related->image_url) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                    </div>
                    @endif
                    <div class="flex flex-col flex-grow">
                        <h4 class="text-xl font-bold text-white mb-2 group-hover:text-sky-400 transition-colors">{{ $related->title }}</h4>
                        <p class="text-sm text-slate-400 line-clamp-2">{{ $related->short_description ?? Str::limit(strip_tags($related->description ?? ''), 100) }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== CTA ===================== --}}
    <section class="py-28 bg-gradient-to-br from-sky-900/40 via-[#05050A] to-indigo-900/20 border-t border-white/5 relative overflow-hidden">
        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-2/3 aspect-square bg-sky-500/5 rounded-full blur-3xl"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-6">Ready to build something<br><span class="text-sky-500">amazing together?</span></h2>
            <p class="text-xl text-slate-400 mb-10 max-w-2xl mx-auto">Let's discuss how we can help you achieve your business goals with custom software.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/quote" class="px-10 py-4 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-sm transition-all shadow-[0_0_30px_rgba(14,165,233,0.4)] text-lg w-full sm:w-auto">
                    Start Your Project
                </a>
                <a href="/contact" class="px-10 py-4 border border-white/20 hover:border-white/40 text-white font-bold rounded-sm transition-all text-lg w-full sm:w-auto">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>
