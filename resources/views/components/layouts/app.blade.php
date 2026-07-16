<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>{{ $title ?? 'CleMwa Developers - Engineering Digital Excellence' }}</title>
        <meta name="description" content="We build secure, scalable and intelligent software solutions that transform businesses.">
        
        <!-- Fonts Preconnect -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        
        <!-- Livewire Styles -->
        @livewireStyles
        
        <!-- Vite Assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- GSAP Core & Plugins -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
        
        <!-- Theme Initialization -->
        <script>
            if (localStorage.getItem('theme') === 'light') {
                document.documentElement.classList.remove('dark');
            }
        </script>
        
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="bg-primary-500 text-white font-sans antialiased selection:bg-accent-500 selection:text-white min-h-screen flex flex-col relative overflow-x-hidden">
        
        <!-- Aurora Background -->
        <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
            <div class="absolute -top-[30%] -left-[10%] w-[70%] h-[70%] rounded-sm bg-accent-500/20 blur-[120px] animate-aurora"></div>
            <div class="absolute -bottom-[20%] -right-[10%] w-[60%] h-[60%] rounded-sm bg-accent2-500/20 blur-[120px] animate-aurora" style="animation-delay: -5s;"></div>
        </div>

        <x-navigation />
        
        <main class="flex-grow pt-24">
            {{ $slot }}
        </main>
        
        <x-footer />
        <div class="no-print">
            <x-floating-actions />
        </div>

        <x-custom-dialog />
        <x-cookie-consent />
        
        <!-- Livewire Scripts -->
        @livewireScripts
        
        <!-- Global GSAP Initializer -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                gsap.registerPlugin(ScrollTrigger);
                
                // Example Global Scroll Animation
                const revealElements = document.querySelectorAll('.gsap-reveal');
                revealElements.forEach((el) => {
                    gsap.fromTo(el, 
                        { y: 50, opacity: 0 },
                        { 
                            y: 0, 
                            opacity: 1, 
                            duration: 0.8, 
                            ease: "power3.out",
                            scrollTrigger: {
                                trigger: el,
                                start: "top 85%",
                            }
                        }
                    );
                });
            });
        </script>
    </body>
</html>
