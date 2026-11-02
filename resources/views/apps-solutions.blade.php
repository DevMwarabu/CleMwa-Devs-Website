<x-layouts.app>
    <x-slot name="title">Projects &amp; Solutions - CleMwa Developers</x-slot>
    <x-slot name="meta_description">Explore selected digital projects designed and developed by CleMwa Developers for clients and partners.</x-slot>

    <section class="image-hero image-hero--apps relative overflow-hidden bg-white pt-12 pb-16 md:pt-20 md:pb-20">
        <div class="pointer-events-none absolute -right-24 -top-24 h-80 w-80 rounded-full bg-accent-500/5 blur-3xl"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav class="mb-8 text-sm text-slate-500" aria-label="Breadcrumb">
                <ol class="flex items-center justify-center gap-2">
                    <li><a href="/" class="hover:text-accent-600">Home</a></li>
                    <li aria-hidden="true">/</li>
                    <li class="font-medium text-slate-900" aria-current="page">Projects</li>
                </ol>
            </nav>

            <div class="mx-auto max-w-3xl text-center">
                <span class="inline-flex items-center gap-2 rounded-full border border-accent-500/20 bg-accent-500/5 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-accent-600">
                    <span class="h-2 w-2 rounded-full bg-accent-500"></span>
                    Selected work
                </span>
                <h1 class="mt-6 text-4xl font-bold tracking-tight text-slate-900 md:text-6xl">Projects &amp; solutions</h1>
                <p class="mx-auto mt-5 max-w-2xl text-lg leading-relaxed text-slate-500">
                    A selection of digital products and systems our team has designed and developed for clients and partners, alongside solutions developed by CleMwa.
                </p>
            </div>
        </div>
    </section>

    <section class="border-y border-slate-200 bg-slate-50 py-16 md:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if($solutions->isNotEmpty())
                <div class="mb-10 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-accent-600">Selected work</p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-900 md:text-3xl">Apps and systems we've built</h2>
                    </div>
                    <p class="text-sm text-slate-500">{{ $solutions->count() }} {{ Str::plural('project', $solutions->count()) }}</p>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($solutions as $solution)
                        <article class="group flex h-full flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition-all hover:-translate-y-1 hover:shadow-xl">
                            <div class="relative aspect-[16/10] overflow-hidden bg-white">
                                @if($solution->image_url)
                                    <img
                                        src="{{ Str::startsWith($solution->image_url, 'http') ? $solution->image_url : Storage::url($solution->image_url) }}"
                                        alt="{{ $solution->title }}"
                                        class="h-full w-full object-contain p-4"
                                        loading="lazy"
                                        decoding="async"
                                    >
                                @else
                                    <div class="flex h-full items-center justify-center text-5xl font-bold tracking-tight text-accent-500/30">
                                        {{ strtoupper(substr($solution->title, 0, 2)) }}
                                    </div>
                                @endif
                                <span class="absolute left-4 top-4 rounded-full border border-white/70 bg-white/90 px-3 py-1 text-xs font-semibold {{ $solution->is_live ? 'text-emerald-700' : 'text-amber-700' }}">
                                    {{ $solution->is_live ? 'Live project' : 'In development' }}
                                </span>
                            </div>

                            <div class="flex flex-1 flex-col p-6">
                                <h2 class="text-xl font-bold text-slate-900">{{ $solution->title }}</h2>
                                <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-500">{{ $solution->description }}</p>

                                @if(!empty($solution->links))
                                    <div class="mt-5 flex flex-wrap gap-2">
                                        @foreach($solution->links as $link)
                                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 transition-colors hover:border-accent-500/40 hover:text-accent-600">
                                                {{ $link['label'] }}
                                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17 17 7M7 7h10v10"/></svg>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="mt-6 flex flex-wrap gap-3 border-t border-slate-100 pt-5">
                                    @if($solution->demo_link)
                                        <a href="{{ $solution->demo_link }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 rounded-full bg-accent-500 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-accent-600">
                                            {{ $solution->is_live ? 'View live project' : 'Request a walkthrough' }}
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17 17 7M7 7h10v10"/></svg>
                                        </a>
                                    @else
                                        <a href="/contact" class="inline-flex items-center justify-center rounded-full bg-accent-500 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-accent-600">Discuss a similar project</a>
                                    @endif
                                    @if($solution->details_link)
                                        <a href="{{ $solution->details_link }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition-colors hover:border-slate-300 hover:bg-slate-50">Project details</a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="mx-auto max-w-xl rounded-3xl border border-slate-200 bg-white px-6 py-14 text-center shadow-sm">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-accent-500/10 text-accent-600">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5v-9ZM12 12l8-4.5M12 12v9m0-9L4 7.5m4-2.25 8 4.5"/></svg>
                    </div>
                    <h2 class="mt-5 text-2xl font-bold text-slate-900">More projects are on the way</h2>
                    <p class="mt-3 text-slate-500">We’re preparing more examples of work delivered for our clients and partners.</p>
                    <a href="/contact" class="mt-6 inline-flex rounded-full bg-accent-500 px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-accent-600">Talk to our team</a>
                </div>
            @endif
        </div>
    </section>

    <section class="bg-white py-16 md:py-20">
        <div class="mx-auto flex max-w-5xl flex-col items-center justify-between gap-6 rounded-3xl border border-slate-200 bg-gradient-to-br from-blue-50/70 to-violet-50/70 px-6 py-10 text-center sm:px-10 md:flex-row md:text-left">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-accent-600">Have a challenge?</p>
                <h2 class="mt-2 text-2xl font-bold text-slate-900">Let's find the right solution for you.</h2>
            </div>
            <a href="/contact" class="inline-flex shrink-0 items-center gap-2 rounded-full bg-accent-500 px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-accent-600">
                Get in touch
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17 17 7M7 7h10v10"/></svg>
            </a>
        </div>
    </section>
</x-layouts.app>
