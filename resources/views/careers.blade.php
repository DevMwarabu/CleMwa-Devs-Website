<x-layouts.app>
    <x-slot name="title">Careers - CleMwa Developers</x-slot>
    <x-slot name="meta_description">Join CleMwa Developers and work on software that powers businesses, organizations, and governments.</x-slot>

    {{-- ===================== HERO ===================== --}}
    <section class="relative pt-32 pb-24 lg:pt-44 lg:pb-32 overflow-hidden bg-[#05050A]">
        <div class="absolute inset-0 bg-grid-slate-400/[0.05] bg-[bottom_1px_center] [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
        <div class="absolute inset-y-0 right-0 w-1/2 bg-gradient-to-l from-sky-500/10 to-transparent blur-3xl rounded-full"></div>

        <div class="container mx-auto px-4 relative z-10 text-center max-w-4xl">
            <nav class="flex justify-center mb-8 text-sm text-slate-400" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/" class="hover:text-white transition-colors">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-slate-500" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                            <span class="ml-1 md:ml-2 text-white">Careers</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-sky-500/30 bg-sky-500/10 text-sky-400 text-xs font-semibold tracking-widest uppercase mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-sky-400 animate-pulse"></span>
                Join Our Team
            </div>

            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                Build Your Career <span class="text-sky-500">With Us</span>
            </h1>

            <p class="text-lg md:text-xl text-slate-400 leading-relaxed mb-10 mx-auto max-w-2xl">
                We're looking for talented people who want to work on software that makes a real difference for businesses, organizations, and governments.
            </p>
        </div>
    </section>

    {{-- ===================== OPEN ROLES ===================== --}}
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5" x-data="{ activeDept: 'all' }">
        <div class="container mx-auto px-4 max-w-5xl">
            @if($departments->count() > 0)
            <div class="flex flex-wrap gap-2 mb-12 justify-center">
                <button @click="activeDept = 'all'"
                    :class="activeDept === 'all' ? 'bg-sky-500 text-white border-sky-500' : 'bg-transparent text-slate-400 border-white/10 hover:border-sky-500/50 hover:text-white'"
                    class="px-4 py-1.5 rounded-full border text-xs font-semibold transition-all">
                    All Departments
                </button>
                @foreach($departments as $department)
                <button @click="activeDept = '{{ Str::slug($department) }}'"
                    :class="activeDept === '{{ Str::slug($department) }}' ? 'bg-sky-500 text-white border-sky-500' : 'bg-transparent text-slate-400 border-white/10 hover:border-sky-500/50 hover:text-white'"
                    class="px-4 py-1.5 rounded-full border text-xs font-semibold transition-all">
                    {{ $department }}
                </button>
                @endforeach
            </div>
            @endif

            @if($jobs->count() > 0)
            <div class="space-y-4">
                @foreach($jobs as $job)
                <div x-show="activeDept === 'all' || activeDept === '{{ Str::slug($job->department ?? '') }}'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100">
                    <a href="/careers/{{ $job->slug }}" class="group flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 rounded-md bg-[#05050A] border border-white/5 hover:border-sky-500/30 transition-all">
                        <div>
                            <h3 class="text-lg font-bold text-white mb-2 group-hover:text-sky-400 transition-colors">{{ $job->title }}</h3>
                            <div class="flex flex-wrap gap-3 text-sm text-slate-400">
                                @if($job->department)
                                <span class="inline-flex items-center gap-1.5"><i class="fa-solid fa-building text-sky-500"></i>{{ $job->department }}</span>
                                @endif
                                @if($job->location)
                                <span class="inline-flex items-center gap-1.5"><i class="fa-solid fa-location-dot text-sky-500"></i>{{ $job->location }}</span>
                                @endif
                                @if($job->employment_type)
                                <span class="inline-flex items-center gap-1.5"><i class="fa-solid fa-briefcase text-sky-500"></i>{{ $job->employment_type }}</span>
                                @endif
                            </div>
                        </div>
                        <span class="shrink-0 px-6 py-3 bg-sky-500/10 group-hover:bg-sky-500 text-sky-400 group-hover:text-white font-bold text-sm rounded-sm border border-sky-500/20 transition-all text-center">
                            View Role
                        </span>
                    </a>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-20">
                <i class="fa-solid fa-briefcase text-5xl text-slate-700 mb-6"></i>
                <h3 class="text-2xl font-bold text-white mb-2">No open roles right now</h3>
                <p class="text-slate-400 mb-8">We're not hiring at the moment, but we're always glad to hear from talented people.</p>
                <a href="/contact?subject=General+Application" class="inline-block px-8 py-4 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-sm transition-all shadow-[0_0_20px_rgba(14,165,233,0.3)]">
                    Send a General Application
                </a>
            </div>
            @endif
        </div>
    </section>
</x-layouts.app>
