<x-layouts.app>
    <x-slot:title>
        {{ $project->title }} - CleMwa Developers
    </x-slot:title>

    <div class="relative pt-32 pb-20 min-h-screen bg-[#050507]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <a href="/" wire:navigate class="inline-flex items-center text-slate-400 hover:text-{{ $project->color_theme }}-400 transition-colors mb-8 group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Home
            </a>

            <!-- Header Content -->
            <div class="flex flex-col lg:flex-row gap-12 mb-16 items-center">
                <!-- Left Text -->
                <div class="lg:w-1/2 relative z-10">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-{{ $project->color_theme }}-500/10 border border-{{ $project->color_theme }}-500/20 text-{{ $project->color_theme }}-400 text-sm font-bold uppercase tracking-widest mb-6">
                        Case Study
                    </div>
                    <h1 class="text-5xl md:text-6xl font-black text-white mb-4 tracking-tight leading-tight">{{ $project->title }}</h1>
                    <h2 class="text-2xl font-semibold text-slate-300 mb-6">{{ $project->subtitle }}</h2>
                    <p class="text-xl text-slate-400 leading-relaxed mb-8">{!! $project->description !!}</p>
                    
                    <div class="flex flex-wrap gap-2 mb-8">
                        @if($project->tags)
                            @foreach($project->tags as $tag)
                            <span class="px-3 py-1.5 rounded-md bg-{{ $project->color_theme }}-500/10 text-{{ $project->color_theme }}-400 text-xs font-bold tracking-widest border border-{{ $project->color_theme }}-500/20 uppercase">{{ $tag }}</span>
                            @endforeach
                        @endif
                    </div>

                    @if($project->requires_quote)
                    <a href="/quote?project={{ Str::slug($project->subtitle) }}" class="inline-flex items-center justify-center px-8 py-4 bg-{{ $project->color_theme }}-500 hover:bg-{{ $project->color_theme }}-400 text-white font-bold rounded-full transition-all shadow-[0_0_20px_rgba(255,255,255,0.1)] hover:shadow-[0_0_30px_rgba(255,255,255,0.2)] hover:scale-105">
                        Request a Quote for Similar Project
                    </a>
                    @endif
                </div>
                <!-- Right Image -->
                <div class="lg:w-1/2 relative w-full">
                    <div class="absolute -inset-4 bg-{{ $project->color_theme }}-500/20 rounded-[2.5rem] blur-[80px]"></div>
                    <div class="relative rounded-[2.5rem] overflow-hidden border border-white/10 shadow-2xl glass">
                        @if($project->image_url)
                            <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-full h-[400px] object-cover opacity-80 hover:opacity-100 hover:scale-105 transition-all duration-700 mix-blend-overlay">
                        @else
                            <div class="w-full h-[400px] bg-gradient-to-br from-{{ $project->color_theme }}-500/20 to-transparent flex items-center justify-center">
                                <span class="text-white opacity-50">No image available</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- More details grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="glass p-8 rounded-3xl border border-white/10 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-{{ $project->color_theme }}-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <h4 class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">Client Industry</h4>
                        <p class="text-white text-lg font-semibold">{{ $project->industry ?? Str::title(explode(' ', $project->subtitle)[0]) . ' & Tech' }}</p>
                    </div>
                </div>
                
                <div class="glass p-8 rounded-3xl border border-white/10 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-{{ $project->color_theme }}-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <h4 class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">Project Type</h4>
                        <p class="text-white text-lg font-semibold">{{ $project->project_type ?? 'Custom Development' }}</p>
                    </div>
                </div>
                
                <div class="glass p-8 rounded-3xl border border-white/10 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-{{ $project->color_theme }}-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <h4 class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">Core Tech Stack</h4>
                        <p class="text-white text-lg font-semibold">{{ $project->tags ? implode(', ', $project->tags) : 'Multiple Technologies' }}</p>
                    </div>
                </div>
            </div>

            <!-- Deep Dive Content -->
            @if($project->content || $project->challenge || $project->solution || $project->results)
            <div class="glass p-10 md:p-16 rounded-[2.5rem] border border-white/10 relative z-10 bg-[#0B0B0F]/80 backdrop-blur-xl mb-16">
                
                @if($project->content)
                <div class="prose prose-invert prose-lg max-w-none 
                    prose-headings:text-white prose-headings:font-bold prose-headings:tracking-tight 
                    prose-p:text-slate-400 prose-p:leading-relaxed mb-12">
                    {!! $project->content !!}
                </div>
                @endif

                @if($project->challenge || $project->solution || $project->results)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @if($project->challenge)
                    <div class="border-t border-white/10 pt-8">
                        <div class="inline-flex items-center gap-2 text-rose-400 mb-4 font-bold uppercase tracking-widest text-sm">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            The Challenge
                        </div>
                        <div class="text-slate-400 leading-relaxed">{!! $project->challenge !!}</div>
                    </div>
                    @endif

                    @if($project->solution)
                    <div class="border-t border-white/10 pt-8">
                        <div class="inline-flex items-center gap-2 text-sky-400 mb-4 font-bold uppercase tracking-widest text-sm">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Our Solution
                        </div>
                        <div class="text-slate-400 leading-relaxed">{!! $project->solution !!}</div>
                    </div>
                    @endif

                    @if($project->results)
                    <div class="border-t border-white/10 pt-8">
                        <div class="inline-flex items-center gap-2 text-emerald-400 mb-4 font-bold uppercase tracking-widest text-sm">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            The Results
                        </div>
                        <div class="text-slate-400 leading-relaxed">{!! $project->results !!}</div>
                    </div>
                    @endif
                </div>
                @endif

            </div>
            @endif
            
            <!-- Call to Action -->
            <div class="mt-16 text-center glass p-12 rounded-[2rem] border border-white/10 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-{{ $project->color_theme }}-500/10 to-transparent"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold text-white mb-4">Want to build something similar?</h2>
                    <p class="text-slate-400 mb-8 max-w-xl mx-auto">Let's discuss how we can bring your vision to life using our battle-tested processes and technology.</p>
                    <a href="/quote?project={{ Str::slug($project->subtitle) }}" class="inline-flex items-center justify-center px-8 py-4 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold rounded-full transition-all hover:scale-105">
                        Start a Conversation
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
