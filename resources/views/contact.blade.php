<x-layouts.app>
    <x-slot name="title">{{ $settings->seo_title ?? 'Contact Us - CleMwa Developers' }}</x-slot>
    <x-slot name="meta_description">{{ $settings->seo_description ?? 'Reach out to CleMwa Developers for consultations, support, or partnership opportunities. Let\'s build something amazing together.' }}</x-slot>

    {{-- ===================== HERO ===================== --}}
    <section class="relative pt-32 pb-24 lg:pt-44 lg:pb-32 overflow-hidden bg-[#05050A]">
        <div class="absolute inset-0 bg-grid-slate-400/[0.05] bg-[bottom_1px_center] [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
        <div class="absolute top-1/4 left-0 w-[500px] h-[500px] bg-sky-500/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-indigo-500/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="container mx-auto px-4 relative z-10 text-center max-w-4xl">
            {{-- Breadcrumb --}}
            <nav class="flex justify-center mb-8 text-sm text-slate-400" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/" class="hover:text-white transition-colors">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-slate-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 md:ml-2 text-white">Contact</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-sky-500/30 bg-sky-500/10 text-sky-400 text-xs font-semibold tracking-widest uppercase mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-sky-400 animate-pulse"></span>
                Get In Touch
            </div>

            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                {!! $settings->hero_title ?? 'Let\'s Build Something<br><span class="text-sky-400">Amazing Together</span>' !!}
            </h1>

            <p class="text-lg md:text-xl text-slate-400 leading-relaxed mb-10 mx-auto max-w-2xl">
                {{ $settings->hero_subtitle ?? 'Have a project in mind? We\'d love to hear from you. Reach out to our team for consultations, support, or partnership opportunities.' }}
            </p>
        </div>
    </section>

    {{-- ===================== CONTACT CARDS ===================== --}}
    <section class="py-12 bg-[#0B0B0F] border-t border-b border-white/5 relative z-20 -mt-10">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
                
                {{-- General Inquiries --}}
                <div class="p-6 rounded-sm bg-[#05050A] border border-white/5 hover:border-sky-500/30 transition-colors group">
                    <div class="w-12 h-12 rounded bg-sky-500/10 flex items-center justify-center text-sky-400 mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-envelope text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">General Inquiries</h3>
                    @if($settings->general_email)
                    <a href="mailto:{{ $settings->general_email }}" class="block text-sm text-slate-400 hover:text-sky-400 transition-colors mb-1">{{ $settings->general_email }}</a>
                    @endif
                    @if($settings->general_phone)
                    <a href="tel:{{ str_replace(' ', '', $settings->general_phone) }}" class="block text-sm text-slate-400 hover:text-sky-400 transition-colors">{{ $settings->general_phone }}</a>
                    @endif
                </div>

                {{-- Sales --}}
                <div class="p-6 rounded-sm bg-[#05050A] border border-white/5 hover:border-sky-500/30 transition-colors group">
                    <div class="w-12 h-12 rounded bg-sky-500/10 flex items-center justify-center text-sky-400 mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-chart-line text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Sales</h3>
                    @if($settings->sales_email)
                    <a href="mailto:{{ $settings->sales_email }}" class="block text-sm text-slate-400 hover:text-sky-400 transition-colors mb-1">{{ $settings->sales_email }}</a>
                    @endif
                    @if($settings->sales_phone)
                    <a href="tel:{{ str_replace(' ', '', $settings->sales_phone) }}" class="block text-sm text-slate-400 hover:text-sky-400 transition-colors">{{ $settings->sales_phone }}</a>
                    @endif
                </div>

                {{-- Technical Support --}}
                <div class="p-6 rounded-sm bg-[#05050A] border border-white/5 hover:border-sky-500/30 transition-colors group">
                    <div class="w-12 h-12 rounded bg-sky-500/10 flex items-center justify-center text-sky-400 mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-headset text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Technical Support</h3>
                    @if($settings->support_email)
                    <a href="mailto:{{ $settings->support_email }}" class="block text-sm text-slate-400 hover:text-sky-400 transition-colors mb-1">{{ $settings->support_email }}</a>
                    @endif
                    @if($settings->help_desk_url)
                    <a href="{{ $settings->help_desk_url }}" target="_blank" rel="noopener" class="block text-sm text-sky-400 font-semibold hover:underline">Visit Help Desk &rarr;</a>
                    @endif
                </div>

                {{-- Partnerships --}}
                <div class="p-6 rounded-sm bg-[#05050A] border border-white/5 hover:border-sky-500/30 transition-colors group">
                    <div class="w-12 h-12 rounded bg-sky-500/10 flex items-center justify-center text-sky-400 mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-handshake text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Partnerships</h3>
                    @if($settings->partnership_email)
                    <a href="mailto:{{ $settings->partnership_email }}" class="block text-sm text-slate-400 hover:text-sky-400 transition-colors mb-1">{{ $settings->partnership_email }}</a>
                    @endif
                    @if($settings->careers_email)
                    <div class="mt-3 pt-3 border-t border-white/5">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest block mb-1">Careers</span>
                        <a href="mailto:{{ $settings->careers_email }}" class="block text-sm text-slate-400 hover:text-sky-400 transition-colors">{{ $settings->careers_email }}</a>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

    {{-- ===================== FORM & MAP SECTION ===================== --}}
    <section class="py-24 bg-[#05050A]" x-data="{
        formType: 'inquiry',
        submitting: false,
        async submitForm(event, type) {
            this.submitting = true;
            const form = event.target;
            const formData = new FormData(form);
            formData.set('type', type);
            try {
                const res = await fetch('/contact', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json' },
                    body: formData,
                });
                const data = await res.json();
                if (!res.ok) {
                    const firstError = data.errors ? Object.values(data.errors)[0][0] : (data.message || 'Something went wrong. Please try again.');
                    this.$dispatch('show-dialog', { title: 'Something went wrong', message: firstError, type: 'error' });
                } else {
                    this.$dispatch('show-dialog', { title: 'Message Sent', message: data.message, type: 'success' });
                    form.reset();
                }
            } catch (e) {
                this.$dispatch('show-dialog', { title: 'Something went wrong', message: 'Please check your connection and try again.', type: 'error' });
            } finally {
                this.submitting = false;
            }
        }
    }">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-16">
                
                {{-- Form Area --}}
                <div class="lg:col-span-3 order-2 lg:order-1">
                    <div class="flex gap-4 mb-8">
                        <button @click="formType = 'inquiry'" 
                            :class="formType === 'inquiry' ? 'bg-sky-500 text-white' : 'bg-[#0B0B0F] text-slate-400 hover:text-white hover:bg-white/5'"
                            class="px-6 py-3 rounded-sm font-bold text-sm transition-colors border border-white/5 flex-1">
                            Project Inquiry
                        </button>
                        <button @click="formType = 'consultation'" 
                            :class="formType === 'consultation' ? 'bg-indigo-500 text-white' : 'bg-[#0B0B0F] text-slate-400 hover:text-white hover:bg-white/5'"
                            class="px-6 py-3 rounded-sm font-bold text-sm transition-colors border border-white/5 flex-1">
                            Book Consultation
                        </button>
                    </div>

                    <div class="p-8 md:p-10 rounded-sm bg-[#0B0B0F] border border-white/5 shadow-2xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-sky-500/5 rounded-full blur-[80px] pointer-events-none"></div>
                        
                        {{-- Inquiry Form --}}
                        <form x-show="formType === 'inquiry'" @submit.prevent="submitForm($event, 'inquiry')" class="space-y-6 relative z-10" x-transition>
                            @csrf
                            <h3 class="text-2xl font-bold text-white mb-6">Tell us about your project</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-xs font-bold tracking-wider text-slate-400 uppercase">Full Name *</label>
                                    <input type="text" name="name" required class="w-full bg-[#05050A] border border-white/10 rounded-sm px-4 py-3 text-white focus:outline-none focus:border-sky-500 transition-colors">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-xs font-bold tracking-wider text-slate-400 uppercase">Company Name</label>
                                    <input type="text" name="company" class="w-full bg-[#05050A] border border-white/10 rounded-sm px-4 py-3 text-white focus:outline-none focus:border-sky-500 transition-colors">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-xs font-bold tracking-wider text-slate-400 uppercase">Email Address *</label>
                                    <input type="email" name="email" required class="w-full bg-[#05050A] border border-white/10 rounded-sm px-4 py-3 text-white focus:outline-none focus:border-sky-500 transition-colors">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-xs font-bold tracking-wider text-slate-400 uppercase">Phone Number</label>
                                    <input type="tel" name="phone" class="w-full bg-[#05050A] border border-white/10 rounded-sm px-4 py-3 text-white focus:outline-none focus:border-sky-500 transition-colors">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-xs font-bold tracking-wider text-slate-400 uppercase">Service Interested In</label>
                                    <select name="service" class="w-full bg-[#05050A] border border-white/10 rounded-sm px-4 py-3 text-white focus:outline-none focus:border-sky-500 transition-colors appearance-none">
                                        <option value="">Select a service...</option>
                                        <option value="custom_software">Custom Software Development</option>
                                        <option value="web_app">Web Application</option>
                                        <option value="mobile_app">Mobile Application</option>
                                        <option value="enterprise">Enterprise Solution (ERP/POS)</option>
                                        <option value="consulting">IT Consulting</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-xs font-bold tracking-wider text-slate-400 uppercase">Budget Range</label>
                                    <select name="budget" class="w-full bg-[#05050A] border border-white/10 rounded-sm px-4 py-3 text-white focus:outline-none focus:border-sky-500 transition-colors appearance-none">
                                        <option value="">Select a range...</option>
                                        <option value="<5k">Less than $5,000</option>
                                        <option value="5k-10k">$5,000 - $10,000</option>
                                        <option value="10k-25k">$10,000 - $25,000</option>
                                        <option value="25k-50k">$25,000 - $50,000</option>
                                        <option value="50k+">$50,000+</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-bold tracking-wider text-slate-400 uppercase">Message *</label>
                                <textarea name="message" rows="4" required class="w-full bg-[#05050A] border border-white/10 rounded-sm px-4 py-3 text-white focus:outline-none focus:border-sky-500 transition-colors resize-none">{{ $prefillSubject ? 'Regarding: '.\Illuminate\Support\Str::title(str_replace('-', ' ', $prefillSubject)) : '' }}</textarea>
                            </div>

                            <div class="flex items-start gap-3">
                                <input type="checkbox" id="privacy" required class="mt-1 bg-[#05050A] border-white/20 rounded text-sky-500 focus:ring-sky-500 focus:ring-offset-[#0B0B0F]">
                                <label for="privacy" class="text-sm text-slate-400">I agree to the <a href="/privacy-policy" class="text-sky-400 hover:underline">Privacy Policy</a> and consent to having my information processed to respond to this inquiry. *</label>
                            </div>

                            {{-- Honeypot --}}
                            <div class="hidden">
                                <input type="text" name="honeypot_field" value="">
                            </div>

                            <div class="pt-4 flex items-center justify-between">
                                <button type="reset" class="text-sm text-slate-500 hover:text-slate-300 font-semibold transition-colors">Reset Form</button>
                                <button type="submit" :disabled="submitting" class="px-8 py-4 bg-sky-500 hover:bg-sky-400 disabled:opacity-60 disabled:cursor-not-allowed text-white font-bold rounded-sm transition-all shadow-lg shadow-sky-500/20">
                                    <span x-text="submitting ? 'Sending...' : 'Send Message'"></span>
                                </button>
                            </div>
                        </form>

                        {{-- Consultation Form --}}
                        <form x-show="formType === 'consultation'" @submit.prevent="submitForm($event, 'consultation')" class="space-y-6 relative z-10" x-transition style="display: none;">
                            @csrf
                            <h3 class="text-2xl font-bold text-white mb-6">Schedule a Meeting</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-xs font-bold tracking-wider text-slate-400 uppercase">Full Name *</label>
                                    <input type="text" name="name" required class="w-full bg-[#05050A] border border-white/10 rounded-sm px-4 py-3 text-white focus:outline-none focus:border-indigo-500 transition-colors">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-xs font-bold tracking-wider text-slate-400 uppercase">Email Address *</label>
                                    <input type="email" name="email" required class="w-full bg-[#05050A] border border-white/10 rounded-sm px-4 py-3 text-white focus:outline-none focus:border-indigo-500 transition-colors">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-xs font-bold tracking-wider text-slate-400 uppercase">Preferred Date</label>
                                    <input type="date" name="preferred_date" class="w-full bg-[#05050A] border border-white/10 rounded-sm px-4 py-3 text-white focus:outline-none focus:border-indigo-500 transition-colors">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-xs font-bold tracking-wider text-slate-400 uppercase">Preferred Time</label>
                                    <input type="time" name="preferred_time" class="w-full bg-[#05050A] border border-white/10 rounded-sm px-4 py-3 text-white focus:outline-none focus:border-indigo-500 transition-colors">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-xs font-bold tracking-wider text-slate-400 uppercase">Meeting Type</label>
                                    <select name="meeting_type" class="w-full bg-[#05050A] border border-white/10 rounded-sm px-4 py-3 text-white focus:outline-none focus:border-indigo-500 transition-colors appearance-none">
                                        <option value="google_meet">Google Meet</option>
                                        <option value="zoom">Zoom</option>
                                        <option value="phone">Phone Call</option>
                                        <option value="in_person">In-Person (HQ)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-bold tracking-wider text-slate-400 uppercase">What would you like to discuss? *</label>
                                <textarea name="message" rows="3" required class="w-full bg-[#05050A] border border-white/10 rounded-sm px-4 py-3 text-white focus:outline-none focus:border-indigo-500 transition-colors resize-none"></textarea>
                            </div>

                            {{-- Honeypot --}}
                            <div class="hidden">
                                <input type="text" name="honeypot_field" value="">
                            </div>

                            <div class="pt-4 flex items-center justify-end">
                                <button type="submit" :disabled="submitting" class="px-8 py-4 bg-indigo-500 hover:bg-indigo-400 disabled:opacity-60 disabled:cursor-not-allowed text-white font-bold rounded-sm transition-all shadow-lg shadow-indigo-500/20">
                                    <span x-text="submitting ? 'Sending...' : 'Request Appointment'"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Locations & Socials --}}
                <div class="lg:col-span-2 order-1 lg:order-2 space-y-10">
                    
                    {{-- Offices --}}
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-6">Our Offices</h3>
                        <div class="space-y-6">
                            @foreach($offices as $office)
                            <div class="p-6 rounded-sm {{ $office->is_primary ? 'bg-sky-500/5 border-sky-500/20' : 'bg-[#0B0B0F] border-white/5' }} border relative">
                                @if($office->is_primary)
                                <div class="absolute top-4 right-4 text-[10px] font-bold tracking-widest uppercase text-sky-400 bg-sky-500/10 px-2 py-1 rounded">Headquarters</div>
                                @endif
                                <h4 class="text-xl font-bold text-white mb-1">{{ $office->name }}</h4>
                                <div class="text-sm text-slate-400 mb-4">{{ $office->city ? $office->city . ', ' : '' }}{{ $office->country }}</div>
                                
                                <ul class="space-y-3 text-sm text-slate-300">
                                    <li class="flex items-start gap-3">
                                        <i class="fa-solid fa-location-dot mt-1 text-sky-400 shrink-0"></i>
                                        <span>{{ $office->address }}</span>
                                    </li>
                                    @if($office->phone)
                                    <li class="flex items-center gap-3">
                                        <i class="fa-solid fa-phone text-sky-400 shrink-0"></i>
                                        <span>{{ $office->phone }}</span>
                                    </li>
                                    @endif
                                    @if($office->working_hours || $office->office_hours)
                                    <li class="flex items-start gap-3">
                                        <i class="fa-solid fa-clock mt-1 text-sky-400 shrink-0"></i>
                                        <span class="whitespace-pre-line">{{ $office->working_hours ?? $office->office_hours }}</span>
                                    </li>
                                    @endif
                                </ul>

                                @if($office->map_embed_code)
                                <div class="mt-6 aspect-video rounded overflow-hidden border border-white/10 grayscale hover:grayscale-0 transition-all duration-500">
                                    {!! $office->map_embed_code !!}
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Social Media --}}
                    @if($settings->social_links && count($settings->social_links) > 0)
                    <div>
                        <h3 class="text-xl font-bold text-white mb-4">Connect With Us</h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($settings->social_links as $social)
                            <a href="{{ $social['url'] ?? '#' }}" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-sm bg-[#0B0B0F] border border-white/5 flex items-center justify-center text-slate-400 hover:text-sky-400 hover:border-sky-500/30 hover:bg-sky-500/5 transition-all group" aria-label="{{ $social['platform'] ?? '' }}">
                                @if(!empty($social['icon']))
                                <i class="{{ $social['icon'] }} text-xl group-hover:scale-110 transition-transform"></i>
                                @else
                                <span class="text-xs font-bold">{{ substr($social['platform'] ?? 'S', 0, 1) }}</span>
                                @endif
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </section>

    {{-- ===================== FAQS ===================== --}}
    @if($faqs->count() > 0)
    <section class="py-24 bg-[#0B0B0F] border-t border-white/5">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-4">Frequently Asked Questions</h2>
                <p class="text-lg text-slate-400">Find quick answers to common questions about working with us.</p>
            </div>

            <div class="space-y-4" x-data="{ openFaq: null }">
                @foreach($faqs as $i => $faq)
                <div class="rounded-sm bg-[#05050A] border border-white/5 overflow-hidden transition-all duration-300 hover:border-sky-500/20" :class="openFaq === {{ $i }} ? 'ring-1 ring-sky-500/20' : ''">
                    <button @click="openFaq = openFaq === {{ $i }} ? null : {{ $i }}" class="w-full flex items-center justify-between p-6 text-left">
                        <span class="font-bold text-white pr-8 text-lg">{{ $faq->question }}</span>
                        <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center shrink-0 transition-transform duration-300" :class="openFaq === {{ $i }} ? 'rotate-180 bg-sky-500/10 text-sky-400' : 'text-slate-400'">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </button>
                    <div x-show="openFaq === {{ $i }}" x-collapse>
                        <div class="px-6 pb-6 pt-0 text-slate-400 leading-relaxed border-t border-white/5 mt-2 pt-4">
                            {!! nl2br(e($faq->answer)) !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

</x-layouts.app>
