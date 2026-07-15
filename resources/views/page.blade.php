<x-layouts.app>
    <x-slot name="title">{{ $page->title }} | CleMwa Developers</x-slot>
    <x-slot name="meta_description">{{ $page->meta_description }}</x-slot>

    <!-- Header -->
    <section class="pt-32 pb-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto text-center relative z-10">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 gsap-reveal">{{ $page->title }}</h1>
    </section>

    <!-- Dynamic Content -->
    <section class="pb-24 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto relative z-10">
        <div class="glass p-8 md:p-12 rounded-3xl gsap-reveal prose prose-invert prose-lg max-w-none prose-a:text-accent-500 hover:prose-a:text-accent2-500">
            {!! $page->content !!}
        </div>
    </section>
</x-layouts.app>
