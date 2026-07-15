<x-layouts.app>
    <x-slot name="title">Portfolio | CleMwa Developers</x-slot>

    <!-- Header -->
    <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto text-center relative z-10">
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 gsap-reveal">Our Portfolio</h1>
        <p class="text-xl text-slate-300 max-w-3xl mx-auto gsap-reveal">Explore our successfully delivered projects spanning across various industries and technologies.</p>
    </section>

    <!-- Projects Grid -->
    <section class="pb-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto relative z-10" x-data="{ filter: 'all' }">
        
        <!-- Filters -->
        <div class="flex flex-wrap justify-center gap-4 mb-12 gsap-reveal">
            @foreach(['all', 'web', 'mobile', 'ai'] as $cat)
                <button @click="filter = '{{ $cat }}'" 
                        :class="filter === '{{ $cat }}' ? 'bg-accent-500 text-white' : 'glass-light text-slate-300 hover:text-white'" 
                        class="px-6 py-2 rounded-full font-medium transition-all capitalize">
                    {{ $cat }}
                </button>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @php
                $projects = [
                    ['title' => 'GovTech Portal', 'cat' => 'web', 'img' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
                    ['title' => 'HealthCare AI', 'cat' => 'ai', 'img' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
                    ['title' => 'FinTech App', 'cat' => 'mobile', 'img' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
                    ['title' => 'E-Commerce Platform', 'cat' => 'web', 'img' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
                ];
            @endphp

            @foreach($projects as $index => $project)
                <div x-show="filter === 'all' || filter === '{{ $project['cat'] }}'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="group relative overflow-hidden rounded-3xl glass gsap-reveal">
                    
                    <img src="{{ $project['img'] }}" alt="{{ $project['title'] }}" class="w-full h-80 object-cover opacity-60 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-500 via-primary-500/50 to-transparent flex flex-col justify-end p-8">
                        <span class="text-accent2-500 font-bold uppercase tracking-wider text-sm mb-2">{{ $project['cat'] }}</span>
                        <h3 class="text-2xl font-bold text-white mb-2">{{ $project['title'] }}</h3>
                        <a href="#" class="inline-flex items-center text-white hover:text-accent2-500 transition-colors">
                            View Case Study <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-layouts.app>
