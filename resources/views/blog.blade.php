<x-layouts.app>
    <x-slot name="title">Blog - CleMwa Developers</x-slot>
    <x-slot name="meta_description">Insights, engineering deep-dives, and updates from the CleMwa Developers team.</x-slot>

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
                            <span class="ml-1 md:ml-2 text-white">Blog</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-sky-500/30 bg-sky-500/10 text-sky-400 text-xs font-semibold tracking-widest uppercase mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-sky-400 animate-pulse"></span>
                Insights & Updates
            </div>

            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                From the <span class="text-sky-500">CleMwa</span> Blog
            </h1>

            <p class="text-lg md:text-xl text-slate-400 leading-relaxed mb-10 mx-auto max-w-2xl">
                Engineering deep-dives, product updates, and lessons from building software that matters.
            </p>
        </div>
    </section>

    {{-- ===================== POSTS GRID ===================== --}}
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5" x-data="{ activeCategory: 'all' }">
        <div class="container mx-auto px-4">
            @if($categories->count() > 0)
            <div class="flex flex-wrap gap-2 mb-12 justify-center">
                <button @click="activeCategory = 'all'"
                    :class="activeCategory === 'all' ? 'bg-sky-500 text-white border-sky-500' : 'bg-transparent text-slate-400 border-white/10 hover:border-sky-500/50 hover:text-white'"
                    class="px-4 py-1.5 rounded-full border text-xs font-semibold transition-all">
                    All
                </button>
                @foreach($categories as $category)
                <button @click="activeCategory = '{{ Str::slug($category) }}'"
                    :class="activeCategory === '{{ Str::slug($category) }}' ? 'bg-sky-500 text-white border-sky-500' : 'bg-transparent text-slate-400 border-white/10 hover:border-sky-500/50 hover:text-white'"
                    class="px-4 py-1.5 rounded-full border text-xs font-semibold transition-all">
                    {{ $category }}
                </button>
                @endforeach
            </div>
            @endif

            @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                <div x-show="activeCategory === 'all' || activeCategory === '{{ Str::slug($post->category ?? '') }}'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100">
                    <a href="/blog/{{ $post->slug }}" class="group flex flex-col h-full rounded-md overflow-hidden bg-[#05050A] border border-white/5 hover:border-sky-500/30 transition-all">
                        <div class="aspect-video overflow-hidden bg-slate-900 relative">
                            @if($post->featured_image)
                                <img src="{{ Str::startsWith($post->featured_image, 'http') ? $post->featured_image : Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-sky-500/10 to-indigo-500/5">
                                    <i class="fa-solid fa-newspaper text-4xl text-slate-700"></i>
                                </div>
                            @endif
                            @if($post->category)
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-black/60 backdrop-blur-md text-sky-300 text-xs font-semibold border border-white/10">{{ $post->category }}</span>
                            @endif
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <span class="text-xs text-slate-500 font-medium mb-2">{{ $post->published_at?->format('M d, Y') }}</span>
                            <h3 class="text-lg font-bold text-white mb-2 group-hover:text-sky-400 transition-colors line-clamp-2">{{ $post->title }}</h3>
                            <p class="text-sm text-slate-400 line-clamp-3 mb-4">{{ $post->excerpt ?? Str::limit(strip_tags($post->content ?? ''), 120) }}</p>
                            <div class="mt-auto flex items-center gap-3 pt-4 border-t border-white/5">
                                @if($post->author_avatar)
                                <img src="{{ Str::startsWith($post->author_avatar, 'http') ? $post->author_avatar : Storage::url($post->author_avatar) }}" alt="{{ $post->author_name }}" class="w-8 h-8 rounded-full object-cover">
                                @endif
                                <span class="text-sm text-slate-300 font-medium">{{ $post->author_name ?? 'CleMwa Team' }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-20">
                <i class="fa-solid fa-newspaper text-5xl text-slate-700 mb-6"></i>
                <h3 class="text-2xl font-bold text-white mb-2">No posts yet</h3>
                <p class="text-slate-400">Check back soon for engineering insights and company updates.</p>
            </div>
            @endif
        </div>
    </section>
</x-layouts.app>
