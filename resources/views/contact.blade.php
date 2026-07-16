<x-layouts.app>
    <x-slot:title>
        Contact Us - CleMwa Developers
    </x-slot:title>

    <div class="relative pt-32 pb-20 min-h-screen bg-[#050507]">
        <!-- Background glows (kept circular since they are just blurry background effects) -->
        <div class="absolute top-1/4 left-0 w-[500px] h-[500px] bg-sky-500/20 rounded-full blur-[120px] pointer-events-none animate-pulse" style="animation-duration: 4s;"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-violet-500/20 rounded-full blur-[120px] pointer-events-none animate-pulse" style="animation-duration: 6s; animation-delay: 2s;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto mb-16 gsap-reveal">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-sky-500/10 border border-sky-500/20 text-sky-400 text-sm font-bold uppercase tracking-widest mb-6 hover:bg-sky-500/20 transition-colors cursor-default">
                    <svg class="w-4 h-4 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    Get In Touch
                </div>
                <h1 class="text-5xl md:text-7xl font-black text-white mb-6 tracking-tight leading-tight">Let's build the <br><span class="text-sky-400">future together.</span></h1>
                <p class="text-xl text-slate-400 leading-relaxed max-w-2xl mx-auto">
                    Have a project in mind? We'd love to hear about it. Send us a message and our experts will respond as soon as possible.
                </p>
            </div>

            <!-- Contact Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-start max-w-6xl mx-auto">
                
                <!-- Contact Information -->
                <div class="space-y-8">
                    <div class="glass p-8 rounded-md border border-white/10 relative overflow-hidden group hover:scale-[1.02] transition-transform duration-500 gsap-reveal" style="transition-delay: 100ms;">
                        <div class="absolute inset-0 bg-sky-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 flex items-start gap-6">
                            <div class="w-14 h-14 rounded-md bg-sky-500/10 border border-sky-500/20 flex items-center justify-center text-sky-400 shrink-0 group-hover:scale-110 transition-transform duration-500 shadow-[0_0_15px_rgba(14,165,233,0.2)] group-hover:shadow-[0_0_25px_rgba(14,165,233,0.4)]">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white mb-2">Email Us</h3>
                                <p class="text-slate-400 mb-3">Our friendly team is here to help.</p>
                                <a href="mailto:hello@clemwadevs.com" class="text-sky-400 hover:text-sky-300 font-bold tracking-wide transition-colors flex items-center gap-2 group/link">
                                    hello@clemwadevs.com
                                    <svg class="w-4 h-4 opacity-0 -translate-x-2 group-hover/link:opacity-100 group-hover/link:translate-x-0 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="glass p-8 rounded-md border border-white/10 relative overflow-hidden group hover:scale-[1.02] transition-transform duration-500 gsap-reveal" style="transition-delay: 200ms;">
                        <div class="absolute inset-0 bg-violet-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 flex items-start gap-6">
                            <div class="w-14 h-14 rounded-md bg-violet-500/10 border border-violet-500/20 flex items-center justify-center text-violet-400 shrink-0 group-hover:scale-110 transition-transform duration-500 shadow-[0_0_15px_rgba(139,92,246,0.2)] group-hover:shadow-[0_0_25px_rgba(139,92,246,0.4)]">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white mb-2">Visit Us</h3>
                                <p class="text-slate-400 mb-3">Come say hello at our office HQ.</p>
                                <p class="text-violet-400 font-bold tracking-wide">Nairobi, Kenya</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass p-8 rounded-md border border-white/10 relative overflow-hidden group hover:scale-[1.02] transition-transform duration-500 gsap-reveal" style="transition-delay: 300ms;">
                        <div class="absolute inset-0 bg-emerald-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 flex items-start gap-6">
                            <div class="w-14 h-14 rounded-md bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 shrink-0 group-hover:scale-110 transition-transform duration-500 shadow-[0_0_15px_rgba(16,185,129,0.2)] group-hover:shadow-[0_0_25px_rgba(16,185,129,0.4)]">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white mb-2">Call Us</h3>
                                <p class="text-slate-400 mb-3">Mon-Fri from 8am to 5pm.</p>
                                <a href="tel:+254700000000" class="text-emerald-400 hover:text-emerald-300 font-bold tracking-wide transition-colors flex items-center gap-2 group/link">
                                    +254 700 000 000
                                    <svg class="w-4 h-4 opacity-0 -translate-x-2 group-hover/link:opacity-100 group-hover/link:translate-x-0 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="glass p-10 md:p-12 rounded-md border border-white/10 shadow-2xl relative gsap-reveal" style="transition-delay: 400ms;">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-sky-500/20 rounded-full blur-[60px] pointer-events-none"></div>
                    <form action="#" method="POST" class="space-y-6 relative z-10">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2 group">
                                <label for="first_name" class="block text-sm font-bold tracking-wider text-slate-400 uppercase group-focus-within:text-sky-400 transition-colors">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="w-full bg-[#050507]/50 backdrop-blur-sm border border-white/10 rounded-md px-5 py-4 text-white focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all hover:bg-[#050507]" required placeholder="John">
                            </div>
                            <div class="space-y-2 group">
                                <label for="last_name" class="block text-sm font-bold tracking-wider text-slate-400 uppercase group-focus-within:text-sky-400 transition-colors">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="w-full bg-[#050507]/50 backdrop-blur-sm border border-white/10 rounded-md px-5 py-4 text-white focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all hover:bg-[#050507]" required placeholder="Doe">
                            </div>
                        </div>

                        <div class="space-y-2 group">
                            <label for="email" class="block text-sm font-bold tracking-wider text-slate-400 uppercase group-focus-within:text-sky-400 transition-colors">Email Address</label>
                            <input type="email" id="email" name="email" class="w-full bg-[#050507]/50 backdrop-blur-sm border border-white/10 rounded-md px-5 py-4 text-white focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all hover:bg-[#050507]" required placeholder="john@example.com">
                        </div>

                        <div class="space-y-2 group">
                            <label for="subject" class="block text-sm font-bold tracking-wider text-slate-400 uppercase group-focus-within:text-sky-400 transition-colors">Subject</label>
                            <input type="text" id="subject" name="subject" value="{{ request('subject') ? Str::title(str_replace('-', ' ', request('subject'))) : '' }}" class="w-full bg-[#050507]/50 backdrop-blur-sm border border-white/10 rounded-md px-5 py-4 text-white focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all hover:bg-[#050507]" required placeholder="How can we help?">
                        </div>

                        <div class="space-y-2 group">
                            <label for="message" class="block text-sm font-bold tracking-wider text-slate-400 uppercase group-focus-within:text-sky-400 transition-colors">Message</label>
                            <textarea id="message" name="message" rows="5" class="w-full bg-[#050507]/50 backdrop-blur-sm border border-white/10 rounded-md px-5 py-4 text-white focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all hover:bg-[#050507] resize-none" required placeholder="Tell us about your project..."></textarea>
                        </div>

                        <button type="submit" class="w-full py-5 bg-sky-500 hover:bg-sky-400 text-white font-black tracking-widest uppercase rounded-md transition-all shadow-[0_0_20px_rgba(14,165,233,0.2)] hover:shadow-[0_0_40px_rgba(14,165,233,0.4)] hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-3 group">
                            <span>Send Message</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- What Happens Next Section -->
            <div class="mt-32 max-w-6xl mx-auto">
                <div class="text-center mb-16 gsap-reveal">
                    <h2 class="text-3xl md:text-4xl font-black text-white mb-4">What happens next?</h2>
                    <p class="text-slate-400 max-w-2xl mx-auto">We value your time. Here is our streamlined process to get your project moving quickly and efficiently.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                    <!-- Connecting line for desktop -->
                    <div class="hidden md:block absolute top-12 left-[15%] right-[15%] h-0.5 bg-sky-500/20"></div>

                    <!-- Step 1 -->
                    <div class="text-center relative z-10 gsap-reveal" style="transition-delay: 100ms;">
                        <div class="w-24 h-24 mx-auto bg-[#050507] border-4 border-sky-500/20 rounded-md flex items-center justify-center mb-6 shadow-[0_0_30px_rgba(14,165,233,0.1)] relative">
                            <span class="text-3xl font-black text-sky-400">1</span>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Discovery Call</h3>
                        <p class="text-slate-400 leading-relaxed">Within 24 hours, our technical lead will reach out to schedule a brief call to understand your core requirements.</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center relative z-10 gsap-reveal" style="transition-delay: 200ms;">
                        <div class="w-24 h-24 mx-auto bg-[#050507] border-4 border-violet-500/20 rounded-md flex items-center justify-center mb-6 shadow-[0_0_30px_rgba(139,92,246,0.1)] relative">
                            <span class="text-3xl font-black text-violet-400">2</span>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Technical Proposal</h3>
                        <p class="text-slate-400 leading-relaxed">We will draft a comprehensive proposal outlining architecture, timelines, and an accurate project estimate.</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center relative z-10 gsap-reveal" style="transition-delay: 300ms;">
                        <div class="w-24 h-24 mx-auto bg-[#050507] border-4 border-emerald-500/20 rounded-md flex items-center justify-center mb-6 shadow-[0_0_30px_rgba(16,185,129,0.1)] relative">
                            <span class="text-3xl font-black text-emerald-400">3</span>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Project Kickoff</h3>
                        <p class="text-slate-400 leading-relaxed">Once approved, we assemble your dedicated engineering team and begin executing agile development sprints.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="mt-32 max-w-4xl mx-auto mb-20">
                <div class="text-center mb-16 gsap-reveal">
                    <h2 class="text-3xl md:text-4xl font-black text-white mb-4">Frequently Asked Questions</h2>
                    <p class="text-slate-400 max-w-2xl mx-auto">Have a quick question? We might have already answered it below.</p>
                </div>

                <div class="space-y-6">
                    <!-- FAQ 1 -->
                    <div class="glass p-8 rounded-md border border-white/10 gsap-reveal hover:bg-white/5 transition-colors" style="transition-delay: 100ms;">
                        <h3 class="text-xl font-bold text-white mb-3">Do you take on equity-based partnerships?</h3>
                        <p class="text-slate-400 leading-relaxed">Currently, we operate purely on a fee-for-service model to ensure our engineering teams remain completely dedicated and unbiased to your project's success without complicated equity negotiations.</p>
                    </div>
                    
                    <!-- FAQ 2 -->
                    <div class="glass p-8 rounded-md border border-white/10 gsap-reveal hover:bg-white/5 transition-colors" style="transition-delay: 200ms;">
                        <h3 class="text-xl font-bold text-white mb-3">Will I own the source code?</h3>
                        <p class="text-slate-400 leading-relaxed">Absolutely. Upon final payment, all intellectual property, source code, and assets are fully transferred to you. We believe in transparency and complete client ownership.</p>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="glass p-8 rounded-md border border-white/10 gsap-reveal hover:bg-white/5 transition-colors" style="transition-delay: 300ms;">
                        <h3 class="text-xl font-bold text-white mb-3">Do you provide ongoing support after launch?</h3>
                        <p class="text-slate-400 leading-relaxed">Yes. We offer flexible Service Level Agreements (SLAs) ranging from standard monitoring and maintenance to dedicated engineering retainers for continuous feature development.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
