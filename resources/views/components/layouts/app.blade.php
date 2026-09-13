<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.gtag-head')
        @include('partials.gtm-head')

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>{{ $title ?? 'CleMwa Developers - Engineering Digital Excellence' }}</title>
        <meta name="description" content="We build secure, scalable and intelligent software solutions that transform businesses.">

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="/favicon.svg">
        <link rel="alternate icon" href="/favicon.ico">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <!-- Fonts Preconnect -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        
        <!-- Livewire Styles -->
        @livewireStyles
        
        <!-- Vite Assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- GSAP Core & Plugins -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
        
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
    </head>
    <body class="bg-white text-slate-900 font-sans antialiased selection:bg-accent-500 selection:text-white min-h-screen flex flex-col relative overflow-x-hidden">
        @include('partials.gtm-body')

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
