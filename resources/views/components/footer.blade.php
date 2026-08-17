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
                <form class="flex gap-2" x-data="{
                        submitting: false,
                        async submitNewsletter(event) {
                            this.submitting = true;
                            const form = event.target;
                            const formData = new FormData(form);
                            try {
                                const res = await fetch('/newsletter/subscribe', {
                                    method: 'POST',
                                    headers: { 'Accept': 'application/json' },
                                    body: formData,
                                });
                                const data = await res.json();
                                if (!res.ok) {
                                    const firstError = data.errors ? Object.values(data.errors)[0][0] : (data.message || 'Something went wrong. Please try again.');
                                    this.$dispatch('show-dialog', { title: 'Something went wrong', message: firstError, type: 'error' });
                                } else {
                                    this.$dispatch('show-dialog', { title: 'Subscribed', message: data.message, type: 'success' });
                                    form.reset();
                                }
                            } catch (e) {
                                this.$dispatch('show-dialog', { title: 'Something went wrong', message: 'Please check your connection and try again.', type: 'error' });
                            } finally {
                                this.submitting = false;
                            }
                        }
                    }" @submit.prevent="submitNewsletter($event)">
                    @csrf
                    <input type="email" name="email" placeholder="Enter your email address" class="w-full bg-[#0B0B0F] border border-white/10 rounded-sm px-4 py-3 text-white focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" required>
                    <button type="submit" :disabled="submitting" class="px-6 py-3 bg-sky-500 hover:bg-sky-400 disabled:opacity-60 disabled:cursor-not-allowed text-white font-bold rounded-sm transition-all whitespace-nowrap shadow-[0_0_15px_rgba(14,165,233,0.3)]" x-text="submitting ? 'Subscribing...' : 'Subscribe'"></button>
                </form>
                <p class="text-[10px] text-slate-500 mt-2">By subscribing, you agree to our Privacy Policy and consent to receive updates from our company.</p>
            </div>
        </div>

        <!-- Main Footer Links -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 mb-16">
            
            <!-- Brand & Contact -->
            <div class="lg:col-span-4">
                <div class="flex items-center gap-3 mb-6">
                    <img src="/favicon.svg" alt="CleMwa Developers" class="w-10 h-10 rounded-sm shadow-lg">
                    <div>
                        <span class="text-2xl font-bold text-white tracking-tight">CleMwa<span class="text-sky-400">Devs</span></span>
                        @if(!empty($foundedEvent?->date))
                        <p class="text-[11px] text-slate-500 tracking-wide">Est. {{ $foundedEvent->date }} &middot; Kericho, Kenya</p>
                        @endif
                    </div>
                </div>
                <p class="text-slate-400 mb-8 leading-relaxed">{{ \Illuminate\Support\Str::limit($footerAbout?->overview, 160) ?: 'Premium software engineering for innovative enterprises. We build scalable, secure, and beautiful digital products.' }}</p>

                <!-- Contact Details -->
                @if(isset($footerContact) || isset($footerOffice))
                <div class="mb-8 space-y-3 text-sm">
                    @if(!empty($footerOffice?->address))
                    <div class="flex items-start gap-3 text-slate-400">
                        <i class="fa-solid fa-location-dot mt-1 text-sky-400 shrink-0"></i>
                        <span>{{ $footerOffice->address }}@if($footerOffice->city), {{ $footerOffice->city }}@endif@if($footerOffice->country), {{ $footerOffice->country }}@endif</span>
                    </div>
                    @endif
                    @if(!empty($footerContact?->general_phone))
                    <a href="tel:{{ str_replace(' ', '', $footerContact->general_phone) }}" class="flex items-center gap-3 text-slate-400 hover:text-white transition-colors">
                        <i class="fa-solid fa-phone text-sky-400 shrink-0"></i>
                        <span>{{ $footerContact->general_phone }}</span>
                    </a>
                    @endif
                    @if(!empty($footerContact?->general_email))
                    <a href="mailto:{{ $footerContact->general_email }}" class="flex items-center gap-3 text-slate-400 hover:text-white transition-colors">
                        <i class="fa-solid fa-envelope text-sky-400 shrink-0"></i>
                        <span>{{ $footerContact->general_email }}</span>
                    </a>
                    @endif
                    @if(!empty($footerOffice?->office_hours))
                    <div class="flex items-start gap-3 text-slate-400">
                        <i class="fa-solid fa-clock mt-1 text-sky-400 shrink-0"></i>
                        <span>{{ $footerOffice->office_hours }}</span>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Social Links -->
                <div class="flex flex-wrap gap-3">
                    @if(isset($footerContact) && $footerContact->social_links)
                        @foreach($footerContact->social_links as $social)
                        <a href="{{ $social['url'] ?? '#' }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-sm bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition-colors" aria-label="{{ $social['platform'] ?? '' }}">
                            @if(!empty($social['icon']))
                            <i class="{{ $social['icon'] }} text-xl"></i>
                            @else
                            <span class="text-xs font-bold">{{ substr($social['platform'] ?? 'S', 0, 1) }}</span>
                            @endif
                        </a>
                        @endforeach
                    @endif
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
                    <li><a href="/portfolio" wire:navigate class="text-slate-400 hover:text-white transition-colors">Portfolio</a></li>
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
