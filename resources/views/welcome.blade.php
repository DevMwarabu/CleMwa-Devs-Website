<x-layouts.app>
    <!-- Hero Section -->
    <section class="relative min-h-[90vh] flex items-center justify-center pt-20 overflow-hidden">
        
        <!-- Floating Elements -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="absolute top-[20%] left-[10%] w-32 h-32 bg-accent-500/10 rounded-2xl border border-white/5 backdrop-blur-3xl animate-pulse" style="animation-duration: 8s;"></div>
            <div class="absolute bottom-[20%] right-[10%] w-48 h-48 bg-accent2-500/10 rounded-full border border-white/5 backdrop-blur-3xl animate-pulse" style="animation-duration: 12s;"></div>
            
            <!-- Code snippet floating -->
            <div class="absolute top-[30%] right-[15%] hidden lg:block gsap-float glass p-4 rounded-xl shadow-2xl rotate-3">
                <pre class="text-xs text-accent2-500 font-mono"><code><span class="text-slate-400">const</span> <span class="text-white">excellence</span> <span class="text-slate-400">=</span> <span class="text-warning">true</span>;
<span class="text-slate-400">if</span> (excellence) {
  buildFuture();
}</code></pre>
            </div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-light mb-8 mx-auto hover:bg-white/20 transition-colors cursor-pointer gsap-reveal">
                <span class="flex h-2 w-2 rounded-full bg-success"></span>
                <span class="text-xs font-bold text-white uppercase tracking-widest">Open for New Projects</span>
            </div>

            <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold tracking-tight text-white mb-8 gsap-reveal leading-tight">
                Engineering <br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent-500 via-accent2-500 to-white">Digital Excellence.</span>
            </h1>

            <p class="mt-4 max-w-2xl text-lg md:text-xl text-slate-300 mx-auto mb-10 gsap-reveal">
                We build secure, scalable and intelligent software solutions that transform businesses and accelerate growth.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 gsap-reveal">
                <a href="/contact" class="w-full sm:w-auto px-8 py-4 bg-white text-primary-500 rounded-full font-bold text-lg hover:bg-slate-200 transition-all hover:scale-105 active:scale-95 shadow-[0_0_40px_rgba(255,255,255,0.3)]">
                    Start Your Project
                </a>
                <a href="/portfolio" class="w-full sm:w-auto px-8 py-4 glass text-white rounded-full font-bold text-lg hover:bg-slate-800/80 transition-all hover:scale-105 active:scale-95">
                    View Portfolio
                </a>
            </div>

            <!-- Stats -->
            <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-white/10 pt-10 gsap-reveal">
                <div class="text-center">
                    <h3 class="text-4xl font-bold text-white mb-2"><span class="counter" data-target="250">0</span>+</h3>
                    <p class="text-sm text-slate-400 font-medium uppercase tracking-wider">Projects Completed</p>
                </div>
                <div class="text-center">
                    <h3 class="text-4xl font-bold text-white mb-2"><span class="counter" data-target="100">0</span>+</h3>
                    <p class="text-sm text-slate-400 font-medium uppercase tracking-wider">Happy Clients</p>
                </div>
                <div class="text-center">
                    <h3 class="text-4xl font-bold text-white mb-2"><span class="counter" data-target="15">0</span>+</h3>
                    <p class="text-sm text-slate-400 font-medium uppercase tracking-wider">Countries Served</p>
                </div>
                <div class="text-center">
                    <h3 class="text-4xl font-bold text-white mb-2"><span class="counter" data-target="10">0</span>+</h3>
                    <p class="text-sm text-slate-400 font-medium uppercase tracking-wider">Years Experience</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-24 relative bg-primary-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20 gsap-reveal">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Enterprise-Grade Solutions</h2>
                <p class="text-lg text-slate-400">Discover our comprehensive suite of software development services designed for modern businesses.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service Card 1 -->
                <div class="glass p-8 rounded-3xl hover:bg-slate-800/80 transition-all duration-300 group gsap-reveal">
                    <div class="w-14 h-14 rounded-2xl bg-accent-500/20 text-accent-500 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Custom Software</h3>
                    <p class="text-slate-400 mb-6 line-clamp-3">Tailor-made software solutions engineered to address your unique business challenges with precision and scalability.</p>
                    <a href="/services" class="inline-flex items-center text-accent2-500 font-medium hover:text-accent-500 transition-colors">
                        Learn more <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>

                <!-- Service Card 2 -->
                <div class="glass p-8 rounded-3xl hover:bg-slate-800/80 transition-all duration-300 group gsap-reveal" style="transition-delay: 100ms;">
                    <div class="w-14 h-14 rounded-2xl bg-accent2-500/20 text-accent2-500 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Mobile Apps</h3>
                    <p class="text-slate-400 mb-6 line-clamp-3">Native and cross-platform mobile applications that deliver exceptional user experiences across iOS and Android.</p>
                    <a href="/services" class="inline-flex items-center text-accent2-500 font-medium hover:text-accent-500 transition-colors">
                        Learn more <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>

                <!-- Service Card 3 -->
                <div class="glass p-8 rounded-3xl hover:bg-slate-800/80 transition-all duration-300 group gsap-reveal" style="transition-delay: 200ms;">
                    <div class="w-14 h-14 rounded-2xl bg-success/20 text-success flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">AI Solutions</h3>
                    <p class="text-slate-400 mb-6 line-clamp-3">Integrate cutting-edge Artificial Intelligence and Machine Learning models to automate workflows and unlock insights.</p>
                    <a href="/services" class="inline-flex items-center text-accent2-500 font-medium hover:text-accent-500 transition-colors">
                        Learn more <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>
            </div>
            
            <div class="mt-16 text-center gsap-reveal">
                <a href="/services" class="inline-flex items-center justify-center px-8 py-4 border border-slate-700 hover:border-slate-500 rounded-full text-white font-medium transition-all">
                    View All Services
                </a>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Floating animation
            gsap.to('.gsap-float', {
                y: -20,
                rotation: -2,
                duration: 3,
                ease: 'sine.inOut',
                yoyo: true,
                repeat: -1
            });

            // Counter animation
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                ScrollTrigger.create({
                    trigger: counter,
                    start: "top 90%",
                    once: true,
                    onEnter: () => {
                        const target = +counter.getAttribute('data-target');
                        gsap.to(counter, {
                            innerHTML: target,
                            duration: 2.5,
                            ease: 'power3.out',
                            snap: { innerHTML: 1 },
                            onUpdate: function() {
                                counter.innerHTML = Math.round(counter.innerHTML);
                            }
                        });
                    }
                });
            });
        });
    </script>
</x-layouts.app>
