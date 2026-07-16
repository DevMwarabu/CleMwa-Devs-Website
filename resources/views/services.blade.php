<x-layouts.app>
    <x-slot name="title">Services | CleMwa Developers</x-slot>

    <!-- Header -->
    <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto text-center relative z-10">
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 gsap-reveal">Our Services</h1>
        <p class="text-xl text-slate-300 max-w-3xl mx-auto gsap-reveal">Comprehensive digital solutions engineered to scale your business. We leverage modern technologies to build secure and robust systems.</p>
    </section>

    <!-- Services Grid -->
    <section class="pb-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $services = [
                    ['title' => 'Custom Software', 'desc' => 'Bespoke enterprise applications tailored to your operational needs.', 'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4'],
                    ['title' => 'Web Development', 'desc' => 'High-performance web apps built with Laravel, React, and Vue.', 'icon' => 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9'],
                    ['title' => 'Mobile Apps', 'desc' => 'Native iOS & Android applications using Flutter and React Native.', 'icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z'],
                    ['title' => 'ERP Development', 'desc' => 'Centralize your business processes with custom ERP solutions.', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                    ['title' => 'AI Solutions', 'desc' => 'Implement machine learning models to automate workflows.', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                    ['title' => 'Cloud & DevOps', 'desc' => 'AWS, Azure, and Docker infrastructure setup and maintenance.', 'icon' => 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z'],
                ];
            @endphp

            @foreach($services as $index => $service)
                <div class="glass p-8 rounded-sm hover:bg-slate-800/80 transition-all duration-300 group gsap-reveal" style="transition-delay: {{ $index * 100 }}ms;">
                    <div class="w-14 h-14 rounded-sm bg-accent2-500/10 text-accent2-500 flex items-center justify-center mb-6 group-hover:bg-accent-500 group-hover:text-white transition-all">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $service['icon'] }}" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">{{ $service['title'] }}</h3>
                    <p class="text-slate-400 mb-6">{{ $service['desc'] }}</p>
                    <a href="/contact" class="text-accent2-500 text-sm font-bold uppercase tracking-wider group-hover:text-white transition-colors flex items-center gap-2">
                        Get Started <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
</x-layouts.app>
