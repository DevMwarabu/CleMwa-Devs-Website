<x-layouts.app>
    <x-slot name="title">{{ $settings->seo_title ?? 'Our Products - CleMwa Developers' }}</x-slot>
    <x-slot name="meta_description">{{ $settings->seo_description ?? 'Explore CleMwa Developers software products — ERP systems, POS solutions, school management, HR platforms and more.' }}</x-slot>

    {{-- ===================== HERO ===================== --}}
    <section class="relative pt-32 pb-24 lg:pt-44 lg:pb-32 overflow-hidden bg-[#05050A]">
        <div class="absolute inset-0 bg-grid-slate-400/[0.05] bg-[bottom_1px_center] [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
        <div class="absolute inset-y-0 right-0 w-1/2 bg-gradient-to-l from-indigo-500/10 to-transparent blur-3xl rounded-full"></div>
        <div class="absolute bottom-0 left-1/4 w-1/3 h-1/2 bg-sky-500/5 rounded-full blur-3xl"></div>

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
                            <span class="ml-1 md:ml-2 text-white">Products</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-indigo-500/30 bg-indigo-500/10 text-indigo-400 text-xs font-semibold tracking-widest uppercase mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                Software Products
            </div>

            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                {!! $settings->hero_title ?? 'Powerful Software<br><span class="text-indigo-400">For Every Business</span>' !!}
            </h1>

            <p class="text-lg md:text-xl text-slate-400 leading-relaxed mb-10 mx-auto max-w-2xl">
                {{ $settings->hero_subtitle ?? 'Powerful software products built to automate businesses, improve productivity, and accelerate digital transformation.' }}
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="/contact" class="px-8 py-4 bg-indigo-500 hover:bg-indigo-400 text-white font-bold rounded-sm transition-all shadow-[0_0_20px_rgba(99,102,241,0.3)]">
                    Request Demo
                </a>
                <a href="/contact" class="px-8 py-4 bg-transparent border border-white/20 hover:border-white/40 text-white font-bold rounded-sm transition-all">
                    Contact Sales
                </a>
            </div>
        </div>
    </section>

    {{-- ===================== FEATURED PRODUCTS ===================== --}}
    @if($featuredProducts->count() > 0)
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold tracking-widest text-indigo-400 uppercase mb-3">Flagship Products</h2>
                <h3 class="text-3xl md:text-5xl font-bold text-white mb-6">Featured Solutions</h3>
                <p class="text-lg text-slate-400">Our most powerful and widely-deployed enterprise software systems.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredProducts as $product)
                <a href="/products/{{ $product->slug }}" class="group flex flex-col rounded-sm bg-[#05050A] border border-white/5 hover:border-indigo-500/30 transition-all overflow-hidden">
                    {{-- Cover Image --}}
                    <div class="aspect-[16/9] relative overflow-hidden bg-slate-900">
                        @if($product->cover_image_url)
                            <img src="{{ Str::startsWith($product->cover_image_url, 'http') ? $product->cover_image_url : Storage::url($product->cover_image_url) }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-indigo-900/30 to-slate-900 flex items-center justify-center">
                                <span class="text-4xl font-black text-white/20">{{ strtoupper(substr($product->title, 0, 2)) }}</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        @if($product->logo_url)
                        <div class="absolute bottom-4 left-4 w-12 h-12 rounded-sm bg-white flex items-center justify-center shadow-lg overflow-hidden">
                            <img src="{{ Str::startsWith($product->logo_url, 'http') ? $product->logo_url : Storage::url($product->logo_url) }}" alt="{{ $product->title }} logo" class="w-10 h-10 object-contain">
                        </div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-semibold text-indigo-400 uppercase tracking-wider">{{ $product->category }}</span>
                            @if($product->version)
                            <span class="text-xs text-slate-500 font-mono">v{{ $product->version }}</span>
                            @endif
                        </div>

                        <h4 class="text-xl font-bold text-white mb-2 group-hover:text-indigo-400 transition-colors">{{ $product->title }}</h4>
                        <p class="text-sm text-slate-400 line-clamp-2 mb-5 flex-grow">{{ $product->short_description }}</p>

                        {{-- Platforms --}}
                        @if($product->platforms && count($product->platforms) > 0)
                        <div class="flex flex-wrap gap-1.5 mb-5">
                            @foreach(array_slice($product->platforms, 0, 4) as $platform)
                            <span class="px-2 py-1 rounded text-[10px] font-semibold bg-white/5 text-slate-400 border border-white/5 uppercase tracking-wide">{{ $platform }}</span>
                            @endforeach
                        </div>
                        @endif

                        <div class="flex items-center gap-2 text-indigo-400 font-semibold text-sm mt-auto group-hover:gap-4 transition-all">
                            Learn More
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== ALL PRODUCTS GRID ===================== --}}
    <section class="py-24 bg-[#05050A] border-t border-white/5" x-data="{ activeFilter: 'all', search: '' }">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-8">
                <div class="max-w-2xl">
                    <h2 class="text-xs font-bold tracking-widest text-indigo-400 uppercase mb-3">Full Catalog</h2>
                    <h3 class="text-3xl md:text-5xl font-bold text-white mb-4">All Products</h3>
                    <p class="text-lg text-slate-400">Find the right solution for your business needs.</p>
                </div>

                {{-- Search --}}
                <div class="relative w-full md:w-80">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input x-model="search" type="text" placeholder="Search products…" class="w-full pl-10 pr-4 py-3 bg-[#0B0B0F] border border-white/10 rounded-sm text-white text-sm placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition-colors">
                </div>
            </div>

            {{-- Category Filters --}}
            <div class="flex flex-wrap gap-2 mb-10">
                <button @click="activeFilter = 'all'"
                    :class="activeFilter === 'all' ? 'bg-indigo-500 text-white border-indigo-500' : 'bg-transparent text-slate-400 border-white/10 hover:border-indigo-500/50 hover:text-white'"
                    class="px-4 py-1.5 rounded-full border text-xs font-semibold transition-all">All</button>
                @foreach($categories as $cat)
                <button @click="activeFilter = '{{ Str::slug($cat) }}'"
                    :class="activeFilter === '{{ Str::slug($cat) }}' ? 'bg-indigo-500 text-white border-indigo-500' : 'bg-transparent text-slate-400 border-white/10 hover:border-indigo-500/50 hover:text-white'"
                    class="px-4 py-1.5 rounded-full border text-xs font-semibold transition-all">{{ $cat }}</button>
                @endforeach
            </div>

            {{-- Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                <div x-show="(activeFilter === 'all' || activeFilter === '{{ Str::slug($product->category) }}') && (search === '' || '{{ strtolower($product->title . ' ' . $product->short_description . ' ' . $product->category) }}'.includes(search.toLowerCase()))"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100">
                    <a href="/products/{{ $product->slug }}" class="group flex flex-col h-full">
                        {{-- Logo + Cover --}}
                        <div class="aspect-[4/3] relative overflow-hidden rounded-sm bg-slate-900 mb-4">
                            @if($product->cover_image_url)
                                <img src="{{ Str::startsWith($product->cover_image_url, 'http') ? $product->cover_image_url : Storage::url($product->cover_image_url) }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-indigo-900/40 to-slate-900 flex items-center justify-center">
                                    <span class="text-3xl font-black text-white/20">{{ strtoupper(substr($product->title, 0, 2)) }}</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            @if($product->logo_url)
                            <div class="absolute bottom-3 left-3 w-9 h-9 rounded bg-white shadow overflow-hidden flex items-center justify-center">
                                <img src="{{ Str::startsWith($product->logo_url, 'http') ? $product->logo_url : Storage::url($product->logo_url) }}" alt="{{ $product->title }}" class="w-7 h-7 object-contain">
                            </div>
                            @endif
                        </div>

                        {{-- Meta --}}
                        <div class="flex flex-col flex-grow">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">{{ $product->category }}</span>
                                @if($product->version)
                                <span class="text-[10px] text-slate-500 font-mono">v{{ $product->version }}</span>
                                @endif
                            </div>
                            <h4 class="text-base font-bold text-white mb-1 group-hover:text-indigo-400 transition-colors">{{ $product->title }}</h4>
                            <p class="text-xs text-slate-400 line-clamp-2">{{ $product->short_description }}</p>

                            {{-- Rating --}}
                            @if($product->rating)
                            <div class="flex items-center gap-1 mt-3">
                                @for($i = 1; $i <= 5; $i++)
                                <svg class="w-3 h-3 {{ $i <= $product->rating ? 'text-amber-400' : 'text-slate-700' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                                <span class="text-[10px] text-slate-400 font-medium ml-1">{{ $product->rating }}</span>
                            </div>
                            @endif
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== CTA ===================== --}}
    <section class="py-28 bg-gradient-to-br from-indigo-900/40 via-[#05050A] to-sky-900/20 border-t border-white/5 relative overflow-hidden">
        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-2/3 aspect-square bg-indigo-500/5 rounded-full blur-3xl"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-indigo-500/30 bg-indigo-500/10 text-indigo-400 text-xs font-semibold tracking-widest uppercase mb-8">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                Get Started Today
            </div>
            <h2 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                {!! $settings->cta_heading ?? 'Ready to Transform<br><span class="text-indigo-400">Your Business?</span>' !!}
            </h2>
            <p class="text-xl text-slate-400 mb-12 max-w-2xl mx-auto leading-relaxed">
                {{ $settings->cta_description ?? 'Get a personalised demo of any of our products and see how CleMwa Developers can help you solve real business challenges.' }}
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/contact" class="px-10 py-4 bg-indigo-500 hover:bg-indigo-400 text-white font-bold rounded-sm transition-all shadow-[0_0_30px_rgba(99,102,241,0.4)] text-lg w-full sm:w-auto">
                    Request Demo
                </a>
                <a href="/contact" class="px-10 py-4 bg-transparent border border-white/20 hover:border-white/40 text-white font-bold rounded-sm transition-all text-lg w-full sm:w-auto">
                    Contact Sales
                </a>
                <a href="/quote" class="px-10 py-4 bg-transparent border border-white/20 hover:border-indigo-500/40 text-white font-bold rounded-sm transition-all text-lg w-full sm:w-auto">
                    Get Started
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>
