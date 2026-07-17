<x-layouts.app>
    <x-slot name="title">{{ $post->title }} | CleMwa Developers Blog</x-slot>
    <x-slot name="meta_description">{{ $post->excerpt ?? Str::limit(strip_tags($post->content ?? ''), 160) }}</x-slot>

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
                            <a href="/blog" class="hover:text-white transition-colors">Blog</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-slate-600" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                            <span class="text-white line-clamp-1">{{ $post->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            @if($post->category)
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-sky-500/30 bg-sky-500/10 text-sky-400 text-xs font-semibold tracking-widest uppercase mb-6">
                {{ $post->category }}
            </div>
            @endif

            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                {{ $post->title }}
            </h1>

            <div class="flex items-center gap-4">
                @if($post->author_avatar)
                <img src="{{ Str::startsWith($post->author_avatar, 'http') ? $post->author_avatar : Storage::url($post->author_avatar) }}" alt="{{ $post->author_name }}" class="w-10 h-10 rounded-full object-cover">
                @endif
                <div>
                    <div class="text-white font-semibold text-sm">{{ $post->author_name ?? 'CleMwa Team' }}</div>
                    <div class="text-slate-500 text-xs">{{ $post->published_at?->format('F d, Y') }}</div>
                </div>
            </div>
        </div>
    </section>

    @if($post->featured_image)
    <section class="px-4 relative z-10 -mt-4 mb-16">
        <div class="container mx-auto max-w-4xl">
            <div class="rounded-2xl overflow-hidden border border-white/10">
                <img src="{{ Str::startsWith($post->featured_image, 'http') ? $post->featured_image : Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-auto object-cover">
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== CONTENT ===================== --}}
    <section class="pb-24 px-4 relative z-10">
        <div class="container mx-auto max-w-4xl">
            <div class="prose prose-invert prose-lg max-w-none prose-a:text-sky-400 hover:prose-a:text-sky-300">
                {!! $post->content !!}
            </div>

            @if($post->tags && count($post->tags) > 0)
            <div class="flex flex-wrap gap-2 mt-12 pt-8 border-t border-white/5">
                @foreach($post->tags as $tag)
                <span class="px-3 py-1 rounded-full bg-[#0B0B0F] border border-white/10 text-slate-400 text-xs font-medium">#{{ $tag }}</span>
                @endforeach
            </div>
            @endif
        </div>
    </section>

    {{-- ===================== RELATED POSTS ===================== --}}
    @if($relatedPosts->count() > 0)
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5">
        <div class="container mx-auto px-4 max-w-6xl">
            <h3 class="text-2xl md:text-3xl font-bold text-white mb-10">More Reading</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedPosts as $related)
                <a href="/blog/{{ $related->slug }}" class="group flex flex-col h-full rounded-md overflow-hidden bg-[#05050A] border border-white/5 hover:border-sky-500/30 transition-all">
                    <div class="aspect-video overflow-hidden bg-slate-900">
                        @if($related->featured_image)
                            <img src="{{ Str::startsWith($related->featured_image, 'http') ? $related->featured_image : Storage::url($related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                        @endif
                    </div>
                    <div class="p-6">
                        <h4 class="text-lg font-bold text-white mb-2 group-hover:text-sky-400 transition-colors line-clamp-2">{{ $related->title }}</h4>
                        <span class="text-xs text-slate-500">{{ $related->published_at?->format('M d, Y') }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</x-layouts.app>
