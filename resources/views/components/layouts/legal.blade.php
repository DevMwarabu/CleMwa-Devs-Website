<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>{{ $title ?? 'Legal Documents - CleMwa Developers' }}</title>
        <meta name="description" content="{{ $description ?? 'Legal documentation for CleMwa Developers.' }}">
        <link rel="canonical" href="{{ url()->current() }}">
        
        <!-- Open Graph Tags -->
        <meta property="og:title" content="{{ $title ?? 'Legal Documents - CleMwa Developers' }}">
        <meta property="og:description" content="{{ $description ?? 'Legal documentation for CleMwa Developers.' }}">
        <meta property="og:type" content="article">
        <meta property="og:url" content="{{ url()->current() }}">
        
        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $title ?? 'Legal Documents - CleMwa Developers' }}">
        <meta name="twitter:description" content="{{ $description ?? 'Legal documentation for CleMwa Developers.' }}">

        <!-- Fonts Preconnect -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        
        <!-- Livewire Styles -->
        @livewireStyles
        
        <!-- Vite Assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Theme Initialization -->
        <script>
            if (localStorage.getItem('theme') === 'light') {
                document.documentElement.classList.remove('dark');
            }
        </script>
        
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <style>
            @media print {
                .no-print { display: none !important; }
                body { background-color: white !important; color: black !important; }
                .print-text-black { color: black !important; }
                a { color: #2563eb !important; text-decoration: underline !important; }
                h1, h2, h3, h4, h5, h6 { color: black !important; page-break-after: avoid; }
                p, ul, li { color: black !important; page-break-inside: avoid; }
                .highlight-box { border: 1px solid #ccc !important; background: transparent !important; }
                * { filter: none !important; } /* Disable dark mode invert for printing */
            }
        </style>
    </head>
    <body class="bg-[#0f172a] text-slate-300 font-sans antialiased selection:bg-accent-500 selection:text-white min-h-screen flex flex-col"
          x-data="{ scrollProgress: 0, scrolled: false }"
          @scroll.window="
            scrollProgress = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
            scrolled = window.scrollY > 20;
          ">
        
        <!-- Reading Progress Bar -->
        <div class="fixed top-0 left-0 h-1 bg-accent-500 z-[60] transition-all duration-150 ease-out no-print" 
             :style="`width: ${scrollProgress}%`"></div>

        <!-- Minimal Navigation -->
        <header class="fixed top-0 w-full z-50 transition-all duration-300 no-print"
                :class="scrolled ? 'bg-slate-900/95 backdrop-blur-md border-b border-slate-800 shadow-sm' : 'bg-transparent'">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="/" class="flex items-center gap-2 group">
                            <div class="w-8 h-8 rounded-sm bg-gradient-to-tr from-accent-500 to-accent2-500 flex items-center justify-center text-white font-bold text-lg">
                                C
                            </div>
                            <span class="font-heading font-bold text-lg text-white tracking-tight print-text-black">CleMwa<span class="text-slate-400 print-text-black">Devs</span></span>
                        </a>
                    </div>

                    <!-- Right Links -->
                    <nav class="flex items-center space-x-6">
                        <a href="/" class="text-slate-300 hover:text-white text-sm font-medium transition-colors hidden sm:block">Home</a>
                        <a href="/contact" class="text-slate-300 hover:text-white text-sm font-medium transition-colors hidden sm:block">Contact</a>
                        <a href="/" class="flex items-center gap-2 text-accent-500 hover:text-accent-400 text-sm font-semibold transition-colors bg-accent-500/10 hover:bg-accent-500/20 px-4 py-2 rounded-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Website
                        </a>
                    </nav>
                </div>
            </div>
        </header>
        
        <main class="flex-grow pt-24 pb-24 relative">
            {{ $slot }}
        </main>
        
        <!-- Footer -->
        <div class="no-print">
            <x-footer />
        </div>
        
        <!-- Floating Actions -->
        <div class="no-print">
            <x-floating-actions />
        </div>
        
        <!-- Custom Dialog -->
        <x-custom-dialog />
        
        <!-- Cookie Consent -->
        <x-cookie-consent />
        
        @livewireScripts
    </body>
</html>
