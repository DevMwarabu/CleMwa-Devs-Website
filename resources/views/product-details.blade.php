<x-layouts.app>
    <x-slot name="title">{{ $product->seo_title ?? $product->title . ' - CleMwa Developers' }}</x-slot>
    <x-slot name="meta_description">{{ $product->seo_description ?? Str::limit(strip_tags($product->short_description ?? ''), 160) }}</x-slot>

    {{-- ===================== HERO ===================== --}}
    <section class="relative pt-32 pb-20 lg:pt-44 lg:pb-28 overflow-hidden bg-[#05050A]">
        <div class="absolute inset-0 bg-grid-slate-400/[0.05] bg-[bottom_1px_center] [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
        <div class="absolute inset-y-0 right-0 w-1/2 bg-gradient-to-l from-indigo-500/10 to-transparent blur-3xl"></div>

        {{-- Cover Image Banner --}}
        @if($product->cover_image_url)
        <div class="absolute inset-0 z-0">
            <img src="{{ Str::startsWith($product->cover_image_url, 'http') ? $product->cover_image_url : Storage::url($product->cover_image_url) }}" alt="{{ $product->title }}" class="w-full h-full object-cover opacity-10">
            <div class="absolute inset-0 bg-gradient-to-b from-[#05050A]/80 via-[#05050A]/90 to-[#05050A]"></div>
        </div>
        @endif

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
                            <a href="/products" class="hover:text-white transition-colors">Products</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-slate-600" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                            <span class="text-white">{{ $product->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    {{-- Logo + badges --}}
                    <div class="flex items-center gap-4 mb-8">
                        @if($product->logo_url)
                        <div class="w-16 h-16 rounded-sm bg-white shadow-lg overflow-hidden flex items-center justify-center flex-shrink-0">
                            <img src="{{ Str::startsWith($product->logo_url, 'http') ? $product->logo_url : Storage::url($product->logo_url) }}" alt="{{ $product->title }} logo" class="w-12 h-12 object-contain">
                        </div>
                        @endif
                        <div class="flex flex-wrap gap-2">
                            @if($product->category)
                            <span class="px-3 py-1.5 rounded-full border border-indigo-500/30 bg-indigo-500/10 text-indigo-400 text-xs font-semibold tracking-widest uppercase">{{ $product->category }}</span>
                            @endif
                            @if($product->version)
                            <span class="px-3 py-1.5 rounded-full border border-white/10 bg-white/5 text-slate-300 text-xs font-mono">v{{ $product->version }}</span>
                            @endif
                        </div>
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                        {{ $product->title }}
                    </h1>

                    @if($product->short_description)
                    <p class="text-lg md:text-xl text-slate-400 leading-relaxed mb-8">{{ $product->short_description }}</p>
                    @endif

                    {{-- Rating --}}
                    @if($product->rating)
                    <div class="flex items-center gap-2 mb-8">
                        <div class="flex text-amber-400">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $product->rating ? 'text-amber-400' : 'text-slate-700' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <span class="text-sm text-slate-400 font-medium">{{ number_format($product->rating, 1) }} / 5.0</span>
                    </div>
                    @endif

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="/contact" class="px-8 py-4 bg-indigo-500 hover:bg-indigo-400 text-white font-bold rounded-sm transition-all shadow-[0_0_20px_rgba(99,102,241,0.3)]">
                            Request Demo
                        </a>
                        <a href="/contact" class="px-8 py-4 bg-transparent border border-white/20 hover:border-white/40 text-white font-bold rounded-sm transition-all">
                            Contact Sales
                        </a>
                    </div>
                </div>

                {{-- Cover / Hero Image --}}
                <div>
                    @if($product->cover_image_url)
                    <div class="rounded-sm overflow-hidden border border-white/10 shadow-2xl aspect-[16/10] bg-slate-900">
                        <img src="{{ Str::startsWith($product->cover_image_url, 'http') ? $product->cover_image_url : Storage::url($product->cover_image_url) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== QUICK INFO BAR ===================== --}}
    @if($product->platforms && count($product->platforms) > 0)
    <section class="py-10 bg-[#0B0B0F] border-t border-white/5">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center gap-x-10 gap-y-4">
                <div>
                    <div class="text-xs font-bold tracking-widest text-slate-500 uppercase mb-1">Platforms</div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->platforms as $platform)
                        <span class="px-3 py-1 rounded bg-white/5 text-slate-300 text-xs font-semibold border border-white/5 uppercase tracking-wide">{{ $platform }}</span>
                        @endforeach
                    </div>
                </div>
                @if($product->category)
                <div>
                    <div class="text-xs font-bold tracking-widest text-slate-500 uppercase mb-1">Category</div>
                    <div class="text-base font-semibold text-white">{{ $product->category }}</div>
                </div>
                @endif
                @if($product->version)
                <div>
                    <div class="text-xs font-bold tracking-widest text-slate-500 uppercase mb-1">Version</div>
                    <div class="text-base font-semibold text-white font-mono">v{{ $product->version }}</div>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== MAIN CONTENT ===================== --}}
    <div class="py-24 bg-[#05050A]" x-data="{ activeTab: 'overview' }">
        <div class="container mx-auto px-4">

            {{-- Tab Navigation --}}
            <div class="flex flex-wrap gap-1 mb-16 border-b border-white/5 pb-1">
                @foreach([
                    ['overview', 'Overview'],
                    ['features', 'Features'],
                    ['modules', 'Modules'],
                    ['pricing', 'Pricing'],
                    ['integrations', 'Integrations'],
                    ['screenshots', 'Screenshots'],
                    ['faqs', 'FAQs'],
                    ['docs', 'Documentation'],
                ] as [$key, $label])
                <button @click="activeTab = '{{ $key }}'"
                    :class="activeTab === '{{ $key }}' ? 'text-white border-b-2 border-indigo-500' : 'text-slate-400 hover:text-white border-b-2 border-transparent'"
                    class="px-5 py-3 text-sm font-semibold transition-all -mb-px">
                    {{ $label }}
                </button>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
                <div class="lg:col-span-2">

                    {{-- OVERVIEW --}}
                    <div x-show="activeTab === 'overview'" x-transition>
                        @if($product->overview)
                        <div class="prose prose-invert prose-lg text-slate-400 max-w-none">
                            {!! $product->overview !!}
                        </div>
                        @else
                        <p class="text-slate-500 italic">No overview content has been added yet.</p>
                        @endif
                    </div>

                    {{-- FEATURES --}}
                    <div x-show="activeTab === 'features'" x-transition>
                        @if($product->features && count($product->features) > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            @foreach($product->features as $feature)
                            <div class="flex items-start gap-5 p-5 rounded-sm bg-[#0B0B0F] border border-white/5 hover:border-indigo-500/20 transition-colors">
                                <div class="w-10 h-10 rounded bg-indigo-500/10 flex items-center justify-center shrink-0 mt-0.5">
                                    @if(!empty($feature['icon']))
                                    <i class="{{ $feature['icon'] }} text-indigo-400"></i>
                                    @else
                                    <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-white mb-1">{{ $feature['name'] ?? '' }}</div>
                                    @if(!empty($feature['description']))
                                    <div class="text-sm text-slate-400 leading-relaxed">{{ $feature['description'] }}</div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-slate-500 italic">No features listed yet.</p>
                        @endif
                    </div>

                    {{-- MODULES --}}
                    <div x-show="activeTab === 'modules'" x-transition>
                        @if($product->modules && count($product->modules) > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($product->modules as $module)
                            <div class="flex items-center gap-3 p-4 rounded-sm bg-[#0B0B0F] border border-white/5">
                                <div class="w-2 h-2 rounded-full bg-indigo-500 shrink-0"></div>
                                <span class="text-white font-medium">{{ is_array($module) ? ($module['module'] ?? '') : $module }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-slate-500 italic">No modules listed yet.</p>
                        @endif
                    </div>

                    {{-- PRICING --}}
                    <div x-show="activeTab === 'pricing'" x-transition>
                        @if($product->pricing_tiers && count($product->pricing_tiers) > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            @foreach($product->pricing_tiers as $i => $tier)
                            <div class="flex flex-col rounded-sm {{ $i === 1 ? 'bg-gradient-to-br from-indigo-900/30 to-[#0B0B0F] border-indigo-500/30' : 'bg-[#0B0B0F] border-white/5' }} border p-8 relative overflow-hidden">
                                @if($i === 1)
                                <div class="absolute top-0 left-0 right-0 h-1 bg-indigo-500"></div>
                                <div class="absolute top-4 right-4 text-[10px] font-black text-indigo-400 uppercase tracking-widest bg-indigo-500/10 px-2 py-1 rounded">Popular</div>
                                @endif
                                <div class="text-sm font-bold text-indigo-400 uppercase tracking-widest mb-3">{{ $tier['plan'] ?? '' }}</div>
                                <div class="text-3xl font-extrabold text-white mb-6">{{ $tier['price'] ?? '' }}</div>
                                @if(!empty($tier['features']) && is_array($tier['features']))
                                <ul class="space-y-3 flex-grow mb-8">
                                    @foreach($tier['features'] as $feat)
                                    <li class="flex items-start gap-3 text-sm text-slate-300">
                                        <svg class="w-4 h-4 text-indigo-400 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        {{ $feat }}
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                                <a href="/contact" class="mt-auto block text-center py-3 px-6 {{ $i === 1 ? 'bg-indigo-500 hover:bg-indigo-400' : 'bg-white/5 hover:bg-white/10' }} text-white font-bold rounded-sm transition-all text-sm">
                                    Get Started
                                </a>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-slate-500 italic">Pricing information coming soon. <a href="/contact" class="text-indigo-400 hover:underline">Contact us</a> for a custom quote.</p>
                        @endif
                    </div>

                    {{-- INTEGRATIONS --}}
                    <div x-show="activeTab === 'integrations'" x-transition>
                        @if($product->integrations && count($product->integrations) > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                            @foreach($product->integrations as $integration)
                            <div class="flex flex-col items-center gap-3 p-5 rounded-sm bg-[#0B0B0F] border border-white/5 hover:border-indigo-500/20 transition-colors group">
                                @if(!empty($integration['logo']))
                                <img src="{{ Str::startsWith($integration['logo'], 'http') ? $integration['logo'] : Storage::url($integration['logo']) }}" alt="{{ $integration['name'] }}" class="w-10 h-10 object-contain grayscale group-hover:grayscale-0 transition-all" loading="lazy">
                                @else
                                <div class="w-10 h-10 rounded bg-indigo-500/10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                                </div>
                                @endif
                                <span class="text-sm font-semibold text-slate-400 group-hover:text-white transition-colors text-center">{{ $integration['name'] ?? '' }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-slate-500 italic">No integrations listed yet.</p>
                        @endif
                    </div>

                    {{-- SCREENSHOTS --}}
                    <div x-show="activeTab === 'screenshots'" x-transition>
                        @if(($product->screenshots && count($product->screenshots) > 0) || ($product->gallery && count($product->gallery) > 0))
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach(array_merge($product->screenshots ?? [], $product->gallery ?? []) as $img)
                            <div class="rounded-sm overflow-hidden border border-white/10 aspect-video bg-slate-900">
                                <img src="{{ Str::startsWith($img, 'http') ? $img : Storage::url($img) }}" alt="Screenshot" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" loading="lazy">
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-slate-500 italic">No screenshots uploaded yet.</p>
                        @endif
                    </div>

                    {{-- FAQs --}}
                    <div x-show="activeTab === 'faqs'" x-transition x-data="{ openFaq: null }">
                        @if($product->faqs && count($product->faqs) > 0)
                        <div class="space-y-3">
                            @foreach($product->faqs as $i => $faq)
                            <div class="rounded-sm border {{ $i === 0 ? 'border-indigo-500/20 bg-indigo-500/5' : 'border-white/5 bg-[#0B0B0F]' }} overflow-hidden">
                                <button @click="openFaq = openFaq === {{ $i }} ? null : {{ $i }}" class="w-full flex items-center justify-between p-5 text-left">
                                    <span class="font-semibold text-white pr-8">{{ $faq['question'] ?? '' }}</span>
                                    <svg :class="openFaq === {{ $i }} ? 'rotate-180' : ''" class="w-5 h-5 text-slate-400 shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div x-show="openFaq === {{ $i }}" x-transition class="px-5 pb-5 text-sm text-slate-400 leading-relaxed">
                                    {{ $faq['answer'] ?? '' }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-slate-500 italic">No FAQs yet.</p>
                        @endif
                    </div>

                    {{-- DOCUMENTATION --}}
                    <div x-show="activeTab === 'docs'" x-transition>
                        @if($product->documentation && count($product->documentation) > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($product->documentation as $doc)
                            <a href="{{ $doc['url'] ?? '#' }}" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-5 p-5 rounded-sm bg-[#0B0B0F] border border-white/5 hover:border-indigo-500/30 transition-all">
                                <div class="w-10 h-10 rounded bg-indigo-500/10 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <span class="font-semibold text-slate-300 group-hover:text-white transition-colors">{{ $doc['title'] ?? '' }}</span>
                                <svg class="w-4 h-4 text-slate-600 ml-auto group-hover:text-indigo-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            @endforeach
                        </div>
                        @else
                        <p class="text-slate-500 italic">No documentation available yet.</p>
                        @endif

                        @if($product->changelog)
                        <div class="mt-12">
                            <h3 class="text-xl font-bold text-white mb-6">Changelog</h3>
                            <div class="prose prose-invert text-slate-400 max-w-none">{!! $product->changelog !!}</div>
                        </div>
                        @endif
                    </div>

                </div>

                {{-- ===================== SIDEBAR ===================== --}}
                <div class="space-y-8">

                    {{-- Stats --}}
                    @if($product->stats && count($product->stats) > 0)
                    <div class="rounded-sm bg-gradient-to-br from-indigo-900/20 to-[#0B0B0F] border border-indigo-500/10 p-8">
                        <h3 class="text-lg font-bold text-white mb-6">Product Statistics</h3>
                        <div class="space-y-5">
                            @foreach($product->stats as $stat)
                            <div>
                                <div class="text-3xl font-extrabold text-white mb-1">{{ $stat['value'] ?? '' }}</div>
                                <div class="text-sm font-semibold tracking-wide text-indigo-400 uppercase">{{ $stat['label'] ?? '' }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Testimonials --}}
                    @if($product->testimonials && count($product->testimonials) > 0)
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-white">Customer Reviews</h3>
                        @foreach($product->testimonials as $testimonial)
                        <div class="rounded-sm bg-[#0B0B0F] border border-white/5 p-6 relative overflow-hidden">
                            <svg class="absolute top-3 right-4 w-12 h-12 text-white/5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                            <div class="relative z-10">
                                @if(!empty($testimonial['rating']))
                                <div class="flex text-amber-400 text-xs mb-3">
                                    @for($i = 0; $i < $testimonial['rating']; $i++)<i class="fa-solid fa-star"></i>@endfor
                                </div>
                                @endif
                                <p class="text-sm text-slate-300 italic leading-relaxed mb-4">"{{ $testimonial['quote'] ?? '' }}"</p>
                                <div class="flex items-center gap-3">
                                    @if(!empty($testimonial['photo_url']))
                                    <img src="{{ Str::startsWith($testimonial['photo_url'], 'http') ? $testimonial['photo_url'] : Storage::url($testimonial['photo_url']) }}" alt="{{ $testimonial['name'] }}" class="w-10 h-10 rounded-full object-cover">
                                    @endif
                                    <div>
                                        <div class="text-sm font-bold text-white">{{ $testimonial['name'] ?? '' }}</div>
                                        <div class="text-xs text-indigo-400">{{ $testimonial['role'] ?? '' }} @if(!empty($testimonial['company']))<span class="text-slate-500">· {{ $testimonial['company'] }}</span>@endif</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    {{-- CTA Card --}}
                    <div class="rounded-sm bg-gradient-to-br from-indigo-900/30 to-[#0B0B0F] border border-indigo-500/20 p-8 text-center">
                        <h3 class="text-lg font-bold text-white mb-3">Interested in {{ $product->title }}?</h3>
                        <p class="text-sm text-slate-400 mb-6">Get a personalised demo or speak with our sales team.</p>
                        <a href="/contact" class="block w-full py-3 bg-indigo-500 hover:bg-indigo-400 text-white font-bold rounded-sm transition-all text-sm mb-3">
                            Request Demo
                        </a>
                        <a href="/contact" class="block w-full py-3 border border-white/10 hover:border-white/20 text-white font-bold rounded-sm transition-all text-sm">
                            Contact Sales
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== RELATED PRODUCTS ===================== --}}
    @if($relatedProducts->count() > 0)
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-4">Similar Products</h2>
                <p class="text-lg text-slate-400">Other solutions in the {{ $product->category }} space.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedProducts as $related)
                <a href="/products/{{ $related->slug }}" class="group flex flex-col h-full">
                    <div class="aspect-[16/10] overflow-hidden rounded-sm bg-slate-900 relative mb-4">
                        @if($related->cover_image_url)
                        <img src="{{ Str::startsWith($related->cover_image_url, 'http') ? $related->cover_image_url : Storage::url($related->cover_image_url) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-indigo-900/30 to-slate-900 flex items-center justify-center"><span class="text-3xl font-black text-white/10">{{ strtoupper(substr($related->title, 0, 2)) }}</span></div>
                        @endif
                    </div>
                    <div class="flex flex-col flex-grow">
                        <span class="text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-1">{{ $related->category }}</span>
                        <h4 class="text-xl font-bold text-white mb-2 group-hover:text-indigo-400 transition-colors">{{ $related->title }}</h4>
                        <p class="text-sm text-slate-400 line-clamp-2">{{ $related->short_description }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== CTA ===================== --}}
    <section class="py-28 bg-gradient-to-br from-indigo-900/40 via-[#05050A] to-sky-900/20 border-t border-white/5 relative overflow-hidden">
        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-2/3 aspect-square bg-indigo-500/5 rounded-full blur-3xl"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-6">Ready to get started with<br><span class="text-indigo-400">{{ $product->title }}?</span></h2>
            <p class="text-xl text-slate-400 mb-10 max-w-2xl mx-auto">Book a free demo and see it in action for your business.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/contact" class="px-10 py-4 bg-indigo-500 hover:bg-indigo-400 text-white font-bold rounded-sm transition-all shadow-[0_0_30px_rgba(99,102,241,0.4)] text-lg w-full sm:w-auto">
                    Request Demo
                </a>
                <a href="/contact" class="px-10 py-4 border border-white/20 hover:border-white/40 text-white font-bold rounded-sm transition-all text-lg w-full sm:w-auto">
                    Contact Sales
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>
