<footer class="bg-[#050507] pt-24 pb-12 border-t border-white/5 relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Top Section: Newsletter & Call to Action -->
        <div class="glass p-8 md:p-12 rounded-sm border border-white/10 mb-20 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-64 bg-sky-500/10 rounded-full blur-[80px] pointer-events-none"></div>
            <div class="relative z-10 md:w-1/2">
                <h3 class="text-2xl font-bold text-white mb-2">Subscribe to our Newsletter</h3>
                <p class="text-slate-400">Get the latest insights on software engineering, AI, and industry trends directly to your inbox.</p>
            </div>
            <div class="relative z-10 w-full md:w-1/2 max-w-md">
                <form class="flex gap-2" x-data="{}">
                    <input type="email" placeholder="Enter your email address" class="w-full bg-[#0B0B0F] border border-white/10 rounded-sm px-4 py-3 text-white focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" required>
                    <button type="button" @click.prevent="$dispatch('show-dialog', { title: 'Newsletter', message: 'Newsletter subscription is coming soon! Stay tuned.', type: 'info' })" class="px-6 py-3 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-sm transition-all whitespace-nowrap shadow-[0_0_15px_rgba(14,165,233,0.3)]">Subscribe</button>
                </form>
                <p class="text-[10px] text-slate-500 mt-2">By subscribing, you agree to our Privacy Policy and consent to receive updates from our company.</p>
            </div>
        </div>

        <!-- Main Footer Links -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 mb-16">
            
            <!-- Brand & Apps -->
            <div class="lg:col-span-4">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-sm bg-gradient-to-br from-sky-400 to-indigo-500 flex items-center justify-center text-white font-bold text-xl shadow-lg">C</div>
                    <span class="text-2xl font-bold text-white tracking-tight">CleMwa<span class="text-sky-400">Devs</span></span>
                </div>
                <p class="text-slate-400 mb-8 leading-relaxed">Premium software engineering for innovative enterprises. We build scalable, secure, and beautiful digital products.</p>
                
                <!-- App Store Badges -->
                <div class="mb-8 space-y-3">
                    <p class="text-sm font-bold text-white uppercase tracking-wider mb-2">Get our Apps</p>
                    <div class="flex flex-wrap gap-3">
                        <!-- Apple App Store Badge -->
                        <a href="https://apps.apple.com/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-3 py-2 bg-white hover:bg-slate-200 text-black rounded-sm transition-colors border border-transparent">
                            <svg class="w-6 h-6" viewBox="0 0 384 512" fill="currentColor"><path d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z"/></svg>
                            <div class="flex flex-col items-start leading-none">
                                <span class="text-[10px] font-semibold">Download on the</span>
                                <span class="text-sm font-bold">App Store</span>
                            </div>
                        </a>
                        <!-- Google Play Badge -->
                        <a href="https://play.google.com/store/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-3 py-2 bg-black text-white border border-white/20 hover:bg-white/10 rounded-sm transition-colors">
                            <svg class="w-6 h-6 text-emerald-400" viewBox="0 0 512 512" fill="currentColor"><path d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l256.6-256L47 0zm425.2 225.6l-58.9-34.1-65.7 64.5 65.7 64.5 60.1-34.1c18-14.3 18-46.5-1.2-60.8zM104.6 499l280.8-161.2-60.1-60.1L104.6 499z"/></svg>
                            <div class="flex flex-col items-start leading-none">
                                <span class="text-[10px] font-semibold">GET IT ON</span>
                                <span class="text-sm font-bold">Google Play</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="flex gap-3">
                    <a href="#" class="w-10 h-10 rounded-sm bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition-colors" aria-label="Twitter">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-sm bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition-colors" aria-label="LinkedIn">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-sm bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition-colors" aria-label="GitHub">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Services -->
            <div class="lg:col-span-3">
                <h4 class="text-white font-bold mb-6 tracking-wide">Services</h4>
                <ul class="space-y-4">
                    @foreach($footerServices as $service)
                    <li><a href="/services/{{ $service->slug }}" wire:navigate class="text-slate-400 hover:text-{{ $service->color_theme }}-400 transition-colors inline-flex items-center group">
                        <span class="group-hover:translate-x-1 transition-transform">{{ $service->title }}</span>
                    </a></li>
                    @endforeach
                    <li><a href="/services" wire:navigate class="text-sky-400 font-semibold hover:text-sky-300 transition-colors inline-flex items-center group mt-2">
                        View All Services <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a></li>
                </ul>
            </div>

            <!-- Products -->
            <div class="lg:col-span-3">
                <h4 class="text-white font-bold mb-6 tracking-wide">Products</h4>
                <ul class="space-y-4">
                    @foreach($footerProducts as $product)
                    <li><a href="{{ $product->details_link ?? '#' }}" class="text-slate-400 hover:text-{{ $product->theme_color }}-400 transition-colors inline-flex items-center group">
                        <span class="group-hover:translate-x-1 transition-transform">{{ $product->title }}</span>
                    </a></li>
                    @endforeach
                    <li><a href="/products" class="text-sky-400 font-semibold hover:text-sky-300 transition-colors inline-flex items-center group mt-2">
                        Explore Portfolio <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a></li>
                </ul>
            </div>

            <!-- Company -->
            <div class="lg:col-span-2">
                <h4 class="text-white font-bold mb-6 tracking-wide">Company</h4>
                <ul class="space-y-4">
                    <li><a href="/about" wire:navigate class="text-slate-400 hover:text-white transition-colors">About Us</a></li>
                    <li><a href="/careers" wire:navigate class="text-slate-400 hover:text-white transition-colors">Careers @if($isHiring)<span class="ml-2 px-2 py-0.5 rounded-sm bg-sky-500/20 text-sky-400 text-[10px] uppercase font-bold tracking-wider">Hiring</span>@endif</a></li>
                    <li><a href="/blog" wire:navigate class="text-slate-400 hover:text-white transition-colors">Blog</a></li>
                    <li><a href="/contact" wire:navigate class="text-slate-400 hover:text-white transition-colors">Contact</a></li>
                </ul>
            </div>
            
        </div>

        <!-- Bottom Bar: Copyright & Legal -->
        <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2 text-slate-500 text-sm">
                <p>&copy; {{ date('Y') }} CleMwa Developers. All rights reserved.</p>
            </div>
            
            <div class="flex flex-wrap justify-center gap-6 text-sm">
                <a href="/privacy-policy" class="text-slate-500 hover:text-slate-300 transition-colors">Privacy Policy</a>
                <a href="/terms-of-service" class="text-slate-500 hover:text-slate-300 transition-colors">Terms of Service</a>
                <a href="/cookie-policy" class="text-slate-500 hover:text-slate-300 transition-colors">Cookie Policy</a>
                <button @click.prevent="$dispatch('open-cookie-preferences')" class="text-slate-500 hover:text-slate-300 transition-colors cursor-pointer">Cookie Preferences</button>
                <a href="/security" class="text-slate-500 hover:text-slate-300 transition-colors flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Security
                </a>
            </div>
        </div>
    </div>
</footer>
