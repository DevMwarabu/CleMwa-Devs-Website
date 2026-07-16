<x-layouts.app>
    @viteReactRefresh
    @vite('resources/js/hero.tsx')
    <div id="react-hero-background" class="w-full"></div>

    <!-- Trusted By Section -->
    <section class="py-12 relative z-10 bg-[#0B0B0F] border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm font-semibold text-slate-500 uppercase tracking-widest mb-8">Trusted by innovative companies & partners</p>
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-50">
                @foreach($partners as $partner)
                <div class="text-xl font-bold text-white flex items-center gap-2 hover:opacity-100 transition-opacity cursor-default">
                    <svg class="w-8 h-8 text-{{ $partner->color_theme }}-500" fill="currentColor" viewBox="0 0 24 24">
                        {!! $partner->logo_svg !!}
                    </svg> 
                    {{ $partner->name }}
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-24 relative z-10 bg-[#0B0B0F]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 gsap-reveal">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Enterprise-Grade Solutions</h2>
                <p class="text-lg text-slate-400">Discover our comprehensive suite of software development services designed for modern businesses.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $service)
                <div class="glass p-8 rounded-3xl hover:-translate-y-2 hover:bg-white/5 transition-all duration-300 group gsap-reveal border border-white/10 backdrop-blur-md" style="transition-delay: {{ $service->delay }}ms;">
                    <div class="w-14 h-14 rounded-2xl bg-{{ $service->color_theme }}-500/20 text-{{ $service->color_theme }}-500 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            {!! $service->icon_svg !!}
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">{{ $service->title }}</h3>
                    <p class="text-slate-400 mb-6 line-clamp-3">{{ $service->description }}</p>
                    <a href="/services/{{ $service->slug }}" wire:navigate class="inline-flex items-center text-{{ $service->color_theme }}-400 font-medium hover:text-{{ $service->color_theme }}-300 transition-colors">
                        Learn more <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>
                @endforeach
            </div>
            
            <div class="mt-16 text-center gsap-reveal">
                <a href="/services" class="inline-flex items-center justify-center px-8 py-4 border border-white/20 hover:bg-white/10 backdrop-blur-md rounded-full text-white font-medium transition-all shadow-[0_0_20px_rgba(255,255,255,0.05)] hover:shadow-[0_0_30px_rgba(255,255,255,0.1)]">
                    View All Services
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Solutions Section -->
    <section class="py-24 relative z-10 bg-[#0B0B0F] border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 gsap-reveal">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Our Flagship Products</h2>
                <p class="text-lg text-slate-400">Powerful, ready-to-deploy platforms built to accelerate your business operations and growth.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($products as $product)
                <div class="glass p-8 md:p-12 rounded-[2.5rem] hover:-translate-y-2 hover:bg-white/5 transition-all duration-300 group gsap-reveal border border-white/10 backdrop-blur-md relative overflow-hidden flex flex-col md:flex-row items-center gap-8">
                    <div class="absolute inset-0 bg-gradient-to-br from-{{ $product->theme_color }}-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="w-full md:w-1/2 relative z-10">
                        @if($product->is_live)
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-{{ $product->theme_color }}-500/20 text-{{ $product->theme_color }}-400 text-xs font-bold uppercase tracking-widest mb-4">
                            <span class="w-2 h-2 rounded-full bg-{{ $product->theme_color }}-500 animate-pulse"></span> Live Product
                        </div>
                        @endif
                        <h3 class="text-3xl font-bold text-white mb-4">{{ $product->title }}</h3>
                        <p class="text-slate-400 mb-8">{{ $product->description }}</p>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ $product->demo_link ?? '#' }}" class="px-6 py-3 bg-{{ $product->theme_color }}-500 hover:bg-{{ $product->theme_color }}-600 text-white rounded-full font-medium transition-colors shadow-lg shadow-{{ $product->theme_color }}-500/25">Book Demo</a>
                            <a href="{{ $product->details_link ?? '#' }}" class="px-6 py-3 border border-white/20 hover:bg-white/10 text-white rounded-full font-medium transition-colors">Learn More</a>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 relative z-10">
                        <img src="{{ $product->image_url }}" alt="{{ $product->title }} Interface" class="rounded-2xl border border-white/10 shadow-2xl group-hover:scale-105 transition-transform duration-500">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-24 relative z-10 bg-[#0B0B0F] border-t border-white/5 overflow-hidden">
        <!-- Background decorative elements -->
        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-violet-500/10 blur-[120px] rounded-full pointer-events-none transform translate-x-1/3 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-sky-500/10 blur-[100px] rounded-full pointer-events-none transform -translate-x-1/3 translate-y-1/3"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="gsap-reveal">
                    <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Why Partner With Us?</h2>
                    <p class="text-xl text-slate-400 mb-10 leading-relaxed">We don't just write code; we build scalable digital businesses. Our engineering culture is obsessed with performance, security, and exceptional user experiences.</p>
                    
                    <ul class="space-y-8">
                        @foreach($features as $feature)
                        <li class="flex gap-4 items-start">
                            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-{{ $feature->theme_color }}-500/20 text-{{ $feature->theme_color }}-400 flex items-center justify-center">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    {!! $feature->icon_svg !!}
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-2xl font-bold text-white mb-2">{{ $feature->title }}</h4>
                                <p class="text-slate-400 leading-relaxed">{{ $feature->description }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="relative gsap-reveal hidden lg:block">
                    <!-- Tech grid visual representation -->
                    <div class="grid grid-cols-2 gap-6">
                        <div class="glass p-8 rounded-[2rem] border border-white/10 flex flex-col items-center justify-center text-center gap-4 hover:bg-white/5 transition-colors shadow-2xl">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-plain.svg" alt="Laravel" class="w-20 h-20 opacity-90 drop-shadow-lg">
                            <span class="text-white font-medium text-lg">Laravel Core</span>
                        </div>
                        <div class="glass p-8 rounded-[2rem] border border-white/10 flex flex-col items-center justify-center text-center gap-4 hover:bg-white/5 transition-colors translate-y-0 lg:translate-y-8 shadow-2xl">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/flutter/flutter-original.svg" alt="Flutter" class="w-20 h-20 opacity-90 drop-shadow-lg">
                            <span class="text-white font-medium text-lg">Cross-Platform</span>
                        </div>
                        <div class="glass p-8 rounded-[2rem] border border-white/10 flex flex-col items-center justify-center text-center gap-4 hover:bg-white/5 transition-colors shadow-2xl">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg" alt="React" class="w-20 h-20 opacity-90 drop-shadow-lg">
                            <span class="text-white font-medium text-lg">Dynamic UIs</span>
                        </div>
                        <div class="glass p-8 rounded-[2rem] border border-white/10 flex flex-col items-center justify-center text-center gap-4 hover:bg-white/5 transition-colors translate-y-0 lg:translate-y-8 shadow-2xl">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/amazonwebservices/amazonwebservices-original-wordmark.svg" alt="AWS" class="w-20 h-20 opacity-90 invert drop-shadow-lg">
                            <span class="text-white font-medium text-lg">Cloud Native</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Projects Section -->
    <section class="py-20 relative z-10 bg-[#0B0B0F] border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 gsap-reveal">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Featured Work</h2>
                <p class="text-lg text-slate-400">A glimpse into our recent portfolio of digital products and enterprise solutions.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($projects as $project)
                <div class="glass overflow-hidden rounded-2xl hover:-translate-y-2 hover:bg-white/5 transition-all duration-300 group gsap-reveal border border-white/10 backdrop-blur-md" style="transition-delay: {{ $project->delay }}ms;">
                    <div class="h-40 w-full bg-gradient-to-br from-{{ $project->color_theme }}-500/20 to-{{ $project->color_theme == 'sky' ? 'indigo' : ($project->color_theme == 'violet' ? 'fuchsia' : ($project->color_theme == 'emerald' ? 'teal' : 'red')) }}-600/20 relative overflow-hidden flex items-center justify-center">
                        <div class="absolute inset-0 bg-[url('{{ $project->image_url }}')] bg-cover bg-center opacity-40 mix-blend-overlay group-hover:scale-110 transition-transform duration-700"></div>
                        <h4 class="text-xl font-bold text-white z-10 drop-shadow-lg opacity-80 group-hover:opacity-100 transition-opacity">{{ $project->subtitle }}</h4>
                    </div>
                    <div class="p-6 flex flex-col h-[calc(100%-10rem)]">
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if($project->tags)
                                @foreach($project->tags as $tag)
                                <span class="px-2.5 py-1 rounded-md bg-{{ $project->color_theme }}-500/10 text-{{ $project->color_theme }}-400 text-[10px] font-semibold tracking-wide border border-{{ $project->color_theme }}-500/20 uppercase">{{ $tag }}</span>
                                @endforeach
                            @endif
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2 leading-tight">{{ $project->title }}</h3>
                        <p class="text-sm text-slate-400 mb-5 line-clamp-3 flex-grow">{{ $project->description }}</p>
                        <div class="flex items-center justify-between mt-auto">
                            <a href="/projects/{{ $project->id }}" class="inline-flex items-center text-sm text-white font-medium group-hover:text-{{ $project->color_theme }}-400 transition-colors">
                                View Study <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                            </a>
                            @if($project->requires_quote)
                            <a href="/quote?project={{ Str::slug($project->subtitle) }}" class="inline-flex items-center px-3 py-1.5 bg-{{ $project->color_theme }}-500/10 text-{{ $project->color_theme }}-400 hover:bg-{{ $project->color_theme }}-500/20 border border-{{ $project->color_theme }}-500/20 rounded-full text-[10px] font-bold uppercase tracking-wider transition-colors">Request Quote</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-16 text-center gsap-reveal">
                <a href="/projects" class="inline-flex items-center justify-center px-8 py-4 border border-white/20 hover:bg-white/10 backdrop-blur-md rounded-full text-white font-medium transition-all shadow-[0_0_20px_rgba(255,255,255,0.05)] hover:shadow-[0_0_30px_rgba(255,255,255,0.1)]">
                    View Complete Portfolio
                </a>
            </div>
        </div>
    </section>
    <!-- Development Process Section -->
    <section class="py-24 relative z-10 bg-[#0B0B0F] border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20 gsap-reveal">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Our Development Process</h2>
                <p class="text-lg text-slate-400">A transparent, agile, and results-driven approach from concept to launch.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 relative">
                <!-- Connecting Line (Desktop) -->
                <div class="hidden lg:block absolute top-12 left-12 right-12 h-0.5 bg-gradient-to-r from-transparent via-white/20 to-transparent -z-10"></div>
                
                @foreach($processSteps as $step)
                <div class="flex flex-col items-center text-center gsap-reveal group" style="transition-delay: {{ $step->delay }}ms;">
                    <div class="w-24 h-24 rounded-full glass border border-white/10 flex items-center justify-center mb-6 text-white group-hover:scale-110 group-hover:bg-{{ $step->theme_color }}-500/20 group-hover:border-{{ $step->theme_color }}-500/50 group-hover:text-{{ $step->theme_color }}-400 transition-all duration-300 shadow-xl">
                        <span class="text-3xl font-bold">0{{ $step->step_number }}</span>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-2">{{ $step->title }}</h4>
                    <p class="text-sm text-slate-400">{{ $step->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Technology Stack Section -->
    <section class="py-24 relative z-10 bg-[#0B0B0F] border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 gsap-reveal">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Technologies We Master</h2>
                <p class="text-lg text-slate-400">We use the most modern and scalable tech stack to build robust enterprise applications.</p>
            </div>

            <div class="flex flex-wrap justify-center items-center gap-4 md:gap-6 gsap-reveal max-w-5xl mx-auto">
                @foreach($technologies as $tech)
                <div class="glass px-6 md:px-8 py-4 md:py-5 rounded-full border border-white/10 flex items-center gap-3 hover:bg-white/5 transition-colors cursor-default hover:scale-105 duration-300" style="transition-delay: {{ $tech->delay }}ms;">
                    @if($tech->icon_url)
                        <img src="{{ $tech->icon_url }}" alt="{{ $tech->name }}" class="w-8 h-8 {{ $tech->name == 'AWS' ? 'invert w-10 h-10' : '' }}">
                    @else
                        {!! $tech->icon_svg !!}
                    @endif
                    @if($tech->name != 'AWS')
                    <span class="text-white font-bold tracking-wide">{{ $tech->name }}</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Statistics Section -->
    <section class="py-24 relative z-10 bg-gradient-to-b from-[#0B0B0F] to-[#050507]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($statistics as $stat)
                <div class="glass p-8 rounded-3xl border border-white/10 text-center gsap-reveal" style="transition-delay: {{ $stat->delay }}ms;">
                    <div class="text-4xl md:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-{{ $stat->theme_color }}-400 to-{{ $stat->theme_color == 'sky' ? 'indigo' : ($stat->theme_color == 'violet' ? 'fuchsia' : ($stat->theme_color == 'emerald' ? 'teal' : 'red')) }}-500 mb-2">{{ $stat->value }}</div>
                    <p class="text-slate-400 font-medium tracking-wide uppercase text-sm">{{ $stat->label }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-24 relative z-10 bg-[#050507] border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 gsap-reveal">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Client Success Stories</h2>
                <p class="text-lg text-slate-400">Don't just take our word for it. Here's what our partners say about working with us.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="glass p-8 rounded-3xl border border-white/10 gsap-reveal">
                    <div class="flex items-center gap-1 mb-6 text-yellow-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-slate-300 mb-8 italic leading-relaxed">"CleMwa Developers delivered an exceptional FinTech dashboard. Their attention to detail and robust architecture scaled perfectly as our user base exploded."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=150" alt="Client">
                        </div>
                        <div>
                            <h4 class="text-white font-bold">John Davis</h4>
                            <p class="text-sm text-sky-400">CTO, TechCorp</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="glass p-8 rounded-3xl border border-white/10 gsap-reveal" style="transition-delay: 100ms;">
                    <div class="flex items-center gap-1 mb-6 text-yellow-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-slate-300 mb-8 italic leading-relaxed">"The team completely transformed our retail operations with the MagdaPOS implementation. We saw a 40% increase in efficiency across all our physical stores."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&q=80&w=150" alt="Client">
                        </div>
                        <div>
                            <h4 class="text-white font-bold">Sarah Jenkins</h4>
                            <p class="text-sm text-violet-400">CEO, Luxe Retail</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="glass p-8 rounded-3xl border border-white/10 gsap-reveal" style="transition-delay: 200ms;">
                    <div class="flex items-center gap-1 mb-6 text-yellow-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-slate-300 mb-8 italic leading-relaxed">"Their expertise in AI integration gave us a massive competitive advantage. They don't just write code; they understand the business goals."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=150" alt="Client">
                        </div>
                        <div>
                            <h4 class="text-white font-bold">Marcus Johnson</h4>
                            <p class="text-sm text-emerald-400">Founder, InnovateX</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-32 relative z-10 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-sky-600 to-violet-600 opacity-20"></div>
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&q=80&w=2000')] bg-cover bg-center mix-blend-overlay opacity-30"></div>
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center gsap-reveal">
            <h2 class="text-4xl md:text-6xl font-bold text-white mb-8 drop-shadow-lg">Let's Build Your Next Great Solution</h2>
            <p class="text-xl text-slate-200 mb-12 max-w-3xl mx-auto">Ready to transform your business with enterprise-grade software? Our engineering team is ready to tackle your most complex challenges.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="/quote" class="px-10 py-5 bg-white text-[#0B0B0F] hover:bg-slate-200 rounded-full font-bold text-lg transition-colors shadow-2xl">Request a Quote</a>
                <a href="/contact" class="px-10 py-5 border-2 border-white/30 hover:bg-white/10 text-white rounded-full font-bold text-lg transition-colors backdrop-blur-sm">Book Consultation</a>
            </div>
        </div>
    </section>

</x-layouts.app>
