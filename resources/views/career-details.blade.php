<x-layouts.app>
    <x-slot name="title">{{ $job->title }} | Careers - CleMwa Developers</x-slot>
    <x-slot name="meta_description">{{ Str::limit(strip_tags($job->description ?? ''), 160) }}</x-slot>

    {{-- ===================== HERO ===================== --}}
    <section class="relative pt-32 pb-16 lg:pt-44 overflow-hidden bg-[#05050A]">
        <div class="absolute inset-0 bg-grid-slate-400/[0.05] bg-[bottom_1px_center] [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>

        <div class="container mx-auto px-4 relative z-10 max-w-4xl">
            <nav class="flex mb-8 text-sm text-slate-400" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 flex-wrap gap-y-1">
                    <li class="inline-flex items-center">
                        <a href="/" class="hover:text-white transition-colors">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-slate-600" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                            <a href="/careers" class="hover:text-white transition-colors">Careers</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-slate-600" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                            <span class="text-white line-clamp-1">{{ $job->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            @if($job->department)
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-sky-500/30 bg-sky-500/10 text-sky-400 text-xs font-semibold tracking-widest uppercase mb-6">
                {{ $job->department }}
            </div>
            @endif

            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                {{ $job->title }}
            </h1>

            <div class="flex flex-wrap gap-4 text-sm text-slate-400 mb-10">
                @if($job->location)
                <span class="inline-flex items-center gap-1.5"><i class="fa-solid fa-location-dot text-sky-500"></i>{{ $job->location }}</span>
                @endif
                @if($job->employment_type)
                <span class="inline-flex items-center gap-1.5"><i class="fa-solid fa-briefcase text-sky-500"></i>{{ $job->employment_type }}</span>
                @endif
                @if($job->salary_range)
                <span class="inline-flex items-center gap-1.5"><i class="fa-solid fa-sack-dollar text-sky-500"></i>{{ $job->salary_range }}</span>
                @endif
            </div>

            <a href="/contact?subject={{ urlencode('Application: '.$job->title) }}" class="inline-block px-8 py-4 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-sm transition-all shadow-[0_0_20px_rgba(14,165,233,0.3)]">
                Apply Now
            </a>
        </div>
    </section>

    {{-- ===================== CONTENT ===================== --}}
    <section class="pb-24 px-4 relative z-10">
        <div class="container mx-auto max-w-4xl">
            @if($job->description)
            <div class="prose prose-invert prose-lg max-w-none mb-12">
                {!! $job->description !!}
            </div>
            @endif

            @if($job->requirements && count($job->requirements) > 0)
            <div class="mb-12">
                <h3 class="text-xl font-bold text-white mb-4">Requirements</h3>
                <ul class="space-y-3">
                    @foreach($job->requirements as $requirement)
                    <li class="flex items-start gap-3 text-slate-300">
                        <i class="fa-solid fa-check text-sky-500 mt-1 shrink-0"></i>
                        <span>{{ $requirement }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if($job->responsibilities)
            <div class="mb-12">
                <h3 class="text-xl font-bold text-white mb-4">Responsibilities</h3>
                <div class="prose prose-invert max-w-none text-slate-300">
                    {!! nl2br(e($job->responsibilities)) !!}
                </div>
            </div>
            @endif

            <div class="p-8 rounded-md bg-[#0B0B0F] border border-white/5 text-center">
                <h3 class="text-xl font-bold text-white mb-3">Ready to apply?</h3>
                <p class="text-slate-400 mb-6">Send us your details and we'll get back to you about next steps.</p>
                <a href="/contact?subject={{ urlencode('Application: '.$job->title) }}" class="inline-block px-8 py-4 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-sm transition-all shadow-[0_0_20px_rgba(14,165,233,0.3)]">
                    Apply Now
                </a>
            </div>
        </div>
    </section>

    {{-- ===================== RELATED ROLES ===================== --}}
    @if($relatedJobs->count() > 0)
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5">
        <div class="container mx-auto px-4 max-w-4xl">
            <h3 class="text-2xl md:text-3xl font-bold text-white mb-10">Other Open Roles</h3>
            <div class="space-y-4">
                @foreach($relatedJobs as $related)
                <a href="/careers/{{ $related->slug }}" class="group flex items-center justify-between gap-4 p-6 rounded-md bg-[#05050A] border border-white/5 hover:border-sky-500/30 transition-all">
                    <div>
                        <h4 class="text-lg font-bold text-white group-hover:text-sky-400 transition-colors">{{ $related->title }}</h4>
                        <span class="text-sm text-slate-400">{{ $related->location }}</span>
                    </div>
                    <i class="fa-solid fa-arrow-right text-slate-500 group-hover:text-sky-400 group-hover:translate-x-1 transition-all"></i>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</x-layouts.app>
