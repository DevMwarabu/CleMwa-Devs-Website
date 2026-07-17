<x-layouts.app>
    <x-slot name="title">{{ $service->seo_title ?? $service->title . ' - CleMwa Developers' }}</x-slot>
    <x-slot name="meta_description">{{ $service->seo_description ?? Str::limit(strip_tags($service->short_description ?? $service->description ?? ''), 160) }}</x-slot>

    {{-- ===================== HERO ===================== --}}
    <section class="relative pt-32 pb-20 lg:pt-44 lg:pb-28 overflow-hidden bg-[#05050A]">
        <div class="absolute inset-0 bg-grid-slate-400/[0.05] bg-[bottom_1px_center] [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
        <div class="absolute inset-y-0 right-0 w-1/2 bg-gradient-to-l from-sky-500/10 to-transparent blur-3xl rounded-full"></div>

        <div class="container mx-auto px-4 relative z-10">
            {{-- Breadcrumb --}}
            <nav class="flex mb-8 text-sm text-slate-400" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 flex-wrap gap-y-1">
                    <li class="inline-flex items-center">
                        <a href="/" class="hover:text-white transition-colors">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-slate-600" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                            <a href="/services" class="hover:text-white transition-colors">Services</a>
                        </div>
                    </li>
                    @if($service->category)
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-slate-600" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                            <span class="text-slate-500">{{ $service->category->name }}</span>
                        </div>
                    </li>
                    @endif
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-slate-600" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                            <span class="text-white">{{ $service->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    @if($service->category)
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-sky-500/30 bg-sky-500/10 text-sky-400 text-xs font-semibold tracking-widest uppercase mb-6">
                        {{ $service->category->name }}
                    </div>
                    @endif

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                        {{ $service->title }}
                    </h1>

                    <p class="text-lg md:text-xl text-slate-400 leading-relaxed mb-10">
                        {{ $service->short_description ?? Str::limit(strip_tags($service->description ?? ''), 200) }}
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="/quote" class="px-8 py-4 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-sm transition-all text-center shadow-[0_0_20px_rgba(14,165,233,0.3)]">
                            Request a Quote
                        </a>
                        <a href="/contact" class="px-8 py-4 border border-white/20 hover:border-white/40 text-white font-bold rounded-sm transition-all text-center group flex items-center justify-center gap-2">
                            Book a Consultation
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>

                <div class="relative">
                    @if($service->image_url)
                    <div class="rounded-2xl overflow-hidden border border-white/10">
                        <img src="{{ Str::startsWith($service->image_url, 'http') ? $service->image_url : Storage::url($service->image_url) }}" alt="{{ $service->title }}" class="w-full h-80 object-cover" loading="lazy">
                    </div>
                    @else
                    <div class="w-full h-80 rounded-2xl bg-[#0B0B0F] border border-white/5 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-sky-500/10 to-indigo-500/5"></div>
                        <div class="w-24 h-24 rounded-2xl bg-sky-500/10 border border-sky-500/20 flex items-center justify-center relative z-10">
                            @if($service->icon_svg)
                                {!! $service->icon_svg !!}
                            @else
                                <svg class="w-12 h-12 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- Floating price badge --}}
                    @if($service->starting_price)
                    <div class="absolute -bottom-4 -left-4 px-6 py-4 rounded-2xl bg-[#0B0B0F] border border-sky-500/30 shadow-2xl">
                        <div class="text-xs text-slate-400 mb-1 uppercase tracking-widest font-semibold">Starting From</div>
                        <div class="text-2xl font-extrabold text-white">{{ $service->starting_price }}</div>
                    </div>
                    @endif

                    {{-- Timeline badge --}}
                    @if($service->typical_timeline)
                    <div class="absolute -top-4 -right-4 px-5 py-3 rounded-2xl bg-sky-500/20 border border-sky-500/30 backdrop-blur-sm">
                        <div class="flex items-center gap-2 text-sky-300 font-semibold text-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $service->typical_timeline }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== CONTENT BODY ===================== --}}
    <div class="py-24 bg-[#0B0B0F] border-t border-white/5">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">

                {{-- Main content column --}}
                <div class="lg:col-span-2 space-y-16">

                    {{-- Detailed Description --}}
                    @if($service->detailed_description)
                    <div>
                        <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Overview</h2>
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-6">About This Service</h3>
                        <div class="prose prose-invert prose-lg text-slate-400 max-w-none">
                            {!! $service->detailed_description !!}
                        </div>
                    </div>
                    @endif

                    {{-- Key Features --}}
                    @if($service->key_features && count($service->key_features) > 0)
                    <div>
                        <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Capabilities</h2>
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-8">Key Features</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($service->key_features as $feature)
                            <div class="flex items-start gap-4 p-5 rounded-xl bg-[#05050A] border border-white/5 hover:border-sky-500/30 transition-all group">
                                <div class="w-8 h-8 rounded-lg bg-sky-500/10 border border-sky-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="text-slate-300 font-medium leading-snug group-hover:text-white transition-colors">{{ $feature }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Business Benefits --}}
                    @if($service->business_benefits && count($service->business_benefits) > 0)
                    <div>
                        <h2 class="text-xs font-bold tracking-widest text-sky-500 uppercase mb-3">Value</h2>
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-8">Business Benefits</h3>
                        <div class="space-y-4">
                            @foreach($service->business_benefits as $index => $benefit)
                            <div class="flex items-start gap-5 p-5 rounded-xl bg-[#05050A] border border-white/5 hover:border-sky-500/30 transition-all group">
                                <div class="w-8 h-8 rounded-lg bg-sky-500/10 border border-sky-500/20 flex items-center justify-center shrink-0 mt-0.5 font-bold text-sky-400 text-sm">{{ $index + 1 }}</div>
                                <span class="text-slate-300 font-medium leading-relaxed group-hover:text-white transition-colors">{{ $benefit }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Details Card --}}
                    <div class="rounded-2xl bg-[#05050A] border border-white/5 p-7 space-y-5 sticky top-28">
                        <h3 class="text-lg font-bold text-white">Service Details</h3>
                        <hr class="border-white/5">

                        @if($service->category)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-400">Category</span>
                            <span class="text-sm font-semibold text-white">{{ $service->category->name }}</span>
                        </div>
                        @endif

                        @if($service->typical_timeline)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-400">Typical Timeline</span>
                            <span class="text-sm font-semibold text-white">{{ $service->typical_timeline }}</span>
                        </div>
                        @endif

                        @if($service->starting_price)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-400">Starting Price</span>
                            <span class="text-sm font-bold text-sky-400">{{ $service->starting_price }}</span>
                        </div>
                        @endif

                        <hr class="border-white/5">
                        <a href="/quote" class="block w-full px-6 py-3.5 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-sm transition-all text-center shadow-[0_0_20px_rgba(14,165,233,0.3)]">
                            Request a Quote
                        </a>
                        <a href="/contact" class="block w-full px-6 py-3.5 border border-white/10 hover:border-white/30 text-white font-semibold rounded-sm transition-all text-center">
                            Book a Consultation
                        </a>
                    </div>

                    {{-- Related Services --}}
                    @if($relatedServices->count() > 0)
                    <div class="rounded-2xl bg-[#05050A] border border-white/5 p-7">
                        <h3 class="text-lg font-bold text-white mb-5">Related Services</h3>
                        <div class="space-y-3">
                            @foreach($relatedServices as $related)
                            <a href="/services/{{ $related->slug }}" class="flex items-center gap-4 p-4 rounded-xl hover:bg-white/5 transition-all group border border-transparent hover:border-sky-500/20">
                                <div class="w-10 h-10 rounded-lg bg-sky-500/10 flex items-center justify-center shrink-0">
                                    @if($related->icon_svg)
                                        {!! $related->icon_svg !!}
                                    @else
                                        <svg class="w-5 h-5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-white group-hover:text-sky-400 transition-colors">{{ $related->title }}</h4>
                                    @if($related->typical_timeline)
                                    <span class="text-xs text-slate-500">{{ $related->typical_timeline }}</span>
                                    @endif
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== CTA ===================== --}}
    <section class="py-28 bg-gradient-to-br from-sky-900/40 via-[#05050A] to-indigo-900/20 border-t border-white/5 relative overflow-hidden">
        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-2/3 aspect-square bg-sky-500/5 rounded-full blur-3xl"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-6">Ready to get started with<br><span class="text-sky-500">{{ $service->title }}?</span></h2>
            <p class="text-xl text-slate-400 mb-10 max-w-2xl mx-auto">Let's discuss your project requirements and build something exceptional together.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/quote" class="px-10 py-4 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-sm transition-all shadow-[0_0_30px_rgba(14,165,233,0.4)] text-lg w-full sm:w-auto">
                    Request a Quote
                </a>
                <a href="/contact" class="px-10 py-4 border border-white/20 hover:border-white/40 text-white font-bold rounded-sm transition-all text-lg w-full sm:w-auto">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>
