<header class="fixed top-0 w-full z-50 glass transition-all duration-300" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-accent-500 to-accent2-500 flex items-center justify-center text-white font-bold text-xl group-hover:shadow-[0_0_20px_rgba(56,189,248,0.5)] transition-all">
                        C
                    </div>
                    <span class="font-heading font-bold text-xl text-white tracking-tight">CleMwa<span class="text-slate-400">Devs</span></span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <nav class="hidden md:flex space-x-8">
                @php
                    $links = [
                        ['name' => 'Home', 'url' => '/'],
                        ['name' => 'About', 'url' => '/about'],
                        ['name' => 'Services', 'url' => '/services'],
                        ['name' => 'Portfolio', 'url' => '/portfolio'],
                        ['name' => 'Products', 'url' => '/products'],
                        ['name' => 'Contact', 'url' => '/contact'],
                    ];
                @endphp
                @foreach($links as $link)
                    <a href="{{ $link['url'] }}" class="text-slate-300 hover:text-white hover:text-glow transition-all text-sm font-medium">
                        {{ $link['name'] }}
                    </a>
                @endforeach
            </nav>

            <!-- CTA & Client Portal -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="/client-portal" class="text-slate-300 hover:text-white text-sm font-medium transition-colors">Client Portal</a>
                <a href="/request-quote" class="bg-white text-primary-500 hover:bg-slate-200 px-5 py-2.5 rounded-full text-sm font-bold transition-all shadow-lg hover:shadow-xl hover:scale-105 active:scale-95">
                    Request Quote
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-300 hover:text-white focus:outline-none">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden glass border-t border-slate-800/50" style="display: none;">
        <div class="px-4 pt-2 pb-6 space-y-1">
            @foreach($links as $link)
                <a href="{{ $link['url'] }}" class="block px-3 py-3 rounded-md text-base font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                    {{ $link['name'] }}
                </a>
            @endforeach
            <div class="pt-4 flex flex-col gap-3">
                <a href="/client-portal" class="block text-center px-3 py-3 rounded-md text-base font-medium text-slate-300 border border-slate-700 hover:bg-slate-800/50">
                    Client Portal
                </a>
                <a href="/request-quote" class="block text-center px-3 py-3 rounded-full text-base font-bold text-primary-500 bg-white hover:bg-slate-200 shadow-lg">
                    Request Quote
                </a>
            </div>
        </div>
    </div>
</header>
