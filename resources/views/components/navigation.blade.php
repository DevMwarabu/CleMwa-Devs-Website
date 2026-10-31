<header class="fixed inset-x-0 top-3 z-50 px-4" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto relative">
        <div class="flex items-center justify-between h-[4.25rem] px-4 sm:px-6 rounded-full border border-slate-200 bg-white/90 backdrop-blur-xl shadow-sm">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="flex items-center gap-2">
                    <img src="/favicon.svg" alt="CleMwa Developers" class="w-9 h-9 rounded-sm">
                    <span class="font-heading font-bold text-xl text-slate-900 tracking-tight">CleMwa<span class="text-slate-400">Devs</span></span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <nav class="hidden lg:flex space-x-8">
                @php
                    $links = [
                        ['name' => 'Home', 'url' => '/'],
                        ['name' => 'About', 'url' => '/about'],
                        ['name' => 'Services', 'url' => '/services'],
                        ['name' => 'Portfolio', 'url' => '/portfolio'],
                        ['name' => 'Apps & Solutions', 'url' => '/apps-solutions'],
                        ['name' => 'Contact', 'url' => '/contact'],
                    ];
                @endphp
                @foreach($links as $link)
                    <a href="{{ $link['url'] }}" class="text-slate-600 hover:text-accent-600 transition-colors text-sm font-medium">
                        {{ $link['name'] }}
                    </a>
                @endforeach
            </nav>

            <!-- CTA -->
            <div class="hidden lg:flex items-center space-x-4">
                <a href="/quote" class="bg-accent-500 text-white hover:bg-accent-600 px-5 py-2.5 rounded-full text-sm font-semibold transition-colors">
                    Request Quote
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-600 hover:text-slate-900 focus:outline-none">
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
         class="absolute top-full left-0 right-0 mt-3 lg:hidden bg-white border border-slate-200 rounded-2xl shadow-xl" style="display: none;">
        <div class="p-4 space-y-1">
            @foreach($links as $link)
                <a href="{{ $link['url'] }}" class="block px-3 py-3 rounded-md text-base font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                    {{ $link['name'] }}
                </a>
            @endforeach
            <div class="pt-4 flex flex-col gap-3">
                <a href="/quote" class="block text-center px-3 py-3 rounded-full text-base font-semibold text-white bg-accent-500 hover:bg-accent-600">
                    Request Quote
                </a>
            </div>
        </div>
    </div>
</header>
