<x-layouts.app>
    <x-slot:title>
        {{ $service->title }} - CleMwa Developers
    </x-slot:title>

    <div class="relative pt-32 pb-20 min-h-screen bg-[#050507]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <a href="/" wire:navigate class="inline-flex items-center text-slate-400 hover:text-{{ $service->color_theme }}-400 transition-colors mb-8 group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Services
            </a>

            <!-- Header Split Layout -->
            <div class="flex flex-col lg:flex-row gap-12 mb-16 items-center">
                <!-- Left Text -->
                <div class="lg:w-1/2 relative z-10">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-{{ $service->color_theme }}-500/10 border border-{{ $service->color_theme }}-500/20 text-{{ $service->color_theme }}-400 text-sm font-bold uppercase tracking-widest mb-6">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            {!! $service->icon_svg !!}
                        </svg>
                        Enterprise Service
                    </div>
                    <h1 class="text-5xl md:text-6xl font-black text-white mb-6 tracking-tight leading-tight">{{ $service->title }}</h1>
                    <p class="text-xl text-slate-300 leading-relaxed mb-8">{{ $service->description }}</p>
                    <a href="/quote?service={{ $service->slug }}" class="inline-flex items-center justify-center px-8 py-4 bg-{{ $service->color_theme }}-500 hover:bg-{{ $service->color_theme }}-400 text-white font-bold rounded-full transition-all shadow-[0_0_20px_rgba(255,255,255,0.1)] hover:shadow-[0_0_30px_rgba(255,255,255,0.2)] hover:scale-105">
                        Get Started
                    </a>
                </div>
                <!-- Right Image -->
                <div class="lg:w-1/2 relative">
                    <div class="absolute -inset-4 bg-{{ $service->color_theme }}-500/20 rounded-[2.5rem] blur-[80px]"></div>
                    <div class="relative rounded-[2.5rem] overflow-hidden border border-white/10 shadow-2xl glass">
                        @if($service->image_url)
                            <img src="{{ $service->image_url }}" alt="{{ $service->title }}" class="w-full h-[400px] object-cover opacity-80 hover:opacity-100 hover:scale-105 transition-all duration-700 mix-blend-overlay">
                        @else
                            <div class="w-full h-[400px] bg-gradient-to-br from-{{ $service->color_theme }}-500/20 to-transparent flex items-center justify-center">
                                <svg class="w-32 h-32 text-{{ $service->color_theme }}-500/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    {!! $service->icon_svg !!}
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="glass p-10 md:p-16 rounded-[2.5rem] border border-white/10 prose prose-invert prose-lg max-w-none shadow-2xl relative z-10 bg-[#0B0B0F]/80 backdrop-blur-xl
                prose-headings:text-white prose-headings:font-bold prose-headings:tracking-tight 
                prose-p:text-slate-400 prose-p:leading-relaxed 
                prose-a:text-{{ $service->color_theme }}-400 prose-a:no-underline hover:prose-a:text-{{ $service->color_theme }}-300 
                prose-li:text-slate-400 prose-ul:list-disc prose-ul:pl-6">
                {!! $service->content !!}
            </div>

            <!-- Call to Action -->
            <div class="mt-16 text-center glass p-12 rounded-[2rem] border border-white/10 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-{{ $service->color_theme }}-500/10 to-transparent"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold text-white mb-4">Ready to get started?</h2>
                    <p class="text-slate-400 mb-8 max-w-xl mx-auto">Let's build something extraordinary together. Our team of experts is ready to discuss your next big project.</p>
                    <a href="/quote?service={{ $service->slug }}" class="inline-flex items-center justify-center px-8 py-4 bg-{{ $service->color_theme }}-500 hover:bg-{{ $service->color_theme }}-400 text-white font-bold rounded-full transition-all shadow-[0_0_20px_rgba(255,255,255,0.1)] hover:shadow-[0_0_30px_rgba(255,255,255,0.2)] hover:scale-105">
                        Request a Quote
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
