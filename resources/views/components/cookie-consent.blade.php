<div x-data="cookieConsent()" x-init="initConsent()" class="no-print">
    
    <!-- Cookie Banner -->
    <div x-show="showBanner" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-y-full opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-full opacity-0"
         class="fixed bottom-0 left-0 right-0 z-[100] p-4 sm:p-6 pb-safe pointer-events-none"
         style="display: none;">
        
        <div class="max-w-5xl mx-auto bg-[#0f172a]/95 backdrop-blur-xl border border-slate-700/50 rounded-xl shadow-2xl p-5 sm:p-6 lg:p-8 pointer-events-auto flex flex-col md:flex-row gap-6 items-start md:items-center">
            
            <div class="flex-grow">
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-2xl">🍪</span>
                    <h3 class="text-white font-bold text-lg sm:text-xl">We Value Your Privacy</h3>
                </div>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-2">
                    We use cookies and similar technologies to keep our website secure, improve performance, remember your preferences, and understand how our services are used. With your permission, we may also use analytics and optional cookies to enhance your experience.
                </p>
                <p class="text-slate-400 text-xs sm:text-sm">
                    You can accept all cookies, reject optional cookies, or customize your preferences at any time.
                </p>
            </div>
            
            <div class="flex flex-col sm:flex-row md:flex-col lg:flex-row gap-3 w-full md:w-auto flex-shrink-0">
                <button @click="acceptAll()" class="w-full sm:w-auto px-6 py-2.5 bg-accent-500 hover:bg-accent-400 text-slate-900 font-bold rounded-sm transition-colors text-sm shadow-lg hover:shadow-accent-500/25">
                    Accept All
                </button>
                <button @click="rejectOptional()" class="w-full sm:w-auto px-6 py-2.5 bg-[#1e293b] hover:bg-[#334155] text-white font-medium rounded-sm border border-slate-600 transition-colors text-sm">
                    Reject Optional
                </button>
                <button @click="openPreferences()" class="w-full sm:w-auto px-6 py-2.5 bg-transparent hover:bg-white/5 text-slate-300 font-medium rounded-sm transition-colors text-sm underline underline-offset-4">
                    Customize
                </button>
            </div>
        </div>
    </div>

    <!-- Cookie Preferences Modal -->
    <div x-show="showPreferences" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[110] overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true"
         style="display: none;"
         @open-cookie-preferences.window="openPreferences()">
         
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity" @click="closePreferences()" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <!-- Modal panel -->
            <div class="relative inline-block align-bottom bg-[#0f172a] border border-slate-700 rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                
                <!-- Header -->
                <div class="px-6 py-5 border-b border-slate-800 flex items-center justify-between bg-[#1e293b]/50">
                    <div>
                        <h3 class="text-xl font-bold text-white" id="modal-title">Cookie Preferences</h3>
                        <p class="text-sm text-slate-400 mt-1">Manage how we use cookies on your device.</p>
                    </div>
                    <button @click="closePreferences()" class="text-slate-400 hover:text-white transition-colors bg-white/5 p-2 rounded-full hover:bg-white/10">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body - Scrollable -->
                <div class="px-6 py-6 max-h-[60vh] overflow-y-auto scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-transparent">
                    
                    <div class="space-y-6">
                        <!-- Essential -->
                        <div class="flex items-start gap-4 p-4 rounded-lg bg-[#1e293b]/30 border border-slate-800">
                            <div class="flex-grow">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="text-base font-bold text-white">Essential Cookies</h4>
                                    <span class="text-xs font-semibold px-2.5 py-1 bg-slate-800 text-slate-300 rounded-sm">Always Active</span>
                                </div>
                                <p class="text-sm text-slate-400 mb-2">These cookies are required for core website functionality and cannot be disabled. Examples include authentication, security, session management, and CSRF protection.</p>
                            </div>
                        </div>

                        <!-- Functional -->
                        <div class="flex items-start gap-4 p-4 rounded-lg border border-slate-800 transition-colors" :class="preferences.functional ? 'bg-accent-500/5 border-accent-500/20' : 'bg-transparent'">
                            <div class="flex-grow">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="text-base font-bold text-white">Functional Cookies</h4>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" x-model="preferences.functional" class="sr-only peer">
                                        <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent-500"></div>
                                    </label>
                                </div>
                                <p class="text-sm text-slate-400">These cookies enhance website functionality and personalization. Examples include language preference, theme (Light/Dark Mode), and recently viewed pages.</p>
                            </div>
                        </div>

                        <!-- Analytics -->
                        <div class="flex items-start gap-4 p-4 rounded-lg border border-slate-800 transition-colors" :class="preferences.analytics ? 'bg-accent-500/5 border-accent-500/20' : 'bg-transparent'">
                            <div class="flex-grow">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="text-base font-bold text-white">Analytics Cookies</h4>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" x-model="preferences.analytics" class="sr-only peer">
                                        <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent-500"></div>
                                    </label>
                                </div>
                                <p class="text-sm text-slate-400">These cookies help us understand how visitors interact with our website. Examples include page visits, user journeys, and performance metrics. Data is aggregated.</p>
                            </div>
                        </div>

                        <!-- Performance -->
                        <div class="flex items-start gap-4 p-4 rounded-lg border border-slate-800 transition-colors" :class="preferences.performance ? 'bg-accent-500/5 border-accent-500/20' : 'bg-transparent'">
                            <div class="flex-grow">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="text-base font-bold text-white">Performance Cookies</h4>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" x-model="preferences.performance" class="sr-only peer">
                                        <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent-500"></div>
                                    </label>
                                </div>
                                <p class="text-sm text-slate-400">These cookies help improve website speed and reliability. Examples include resource caching, error monitoring, and load optimization.</p>
                            </div>
                        </div>

                        <!-- Marketing -->
                        <div class="flex items-start gap-4 p-4 rounded-lg border border-slate-800 transition-colors" :class="preferences.marketing ? 'bg-accent-500/5 border-accent-500/20' : 'bg-transparent'">
                            <div class="flex-grow">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="text-base font-bold text-white">Marketing Cookies</h4>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" x-model="preferences.marketing" class="sr-only peer">
                                        <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent-500"></div>
                                    </label>
                                </div>
                                <p class="text-sm text-slate-400">Used only if marketing campaigns are enabled. Examples include campaign attribution and advertisement measurement. We do not sell your personal information.</p>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <!-- Footer -->
                <div class="px-6 py-5 border-t border-slate-800 bg-[#1e293b]/50 flex flex-col sm:flex-row gap-3 sm:justify-end items-center">
                    <button @click="resetPreferences()" class="w-full sm:w-auto sm:mr-auto px-4 py-2 text-sm font-medium text-slate-400 hover:text-white transition-colors">
                        Reset
                    </button>
                    <button @click="rejectOptional()" class="w-full sm:w-auto px-5 py-2.5 bg-[#0f172a] hover:bg-slate-800 text-white font-medium rounded-sm border border-slate-600 transition-colors text-sm">
                        Reject Optional
                    </button>
                    <button @click="savePreferences()" class="w-full sm:w-auto px-6 py-2.5 bg-accent-500 hover:bg-accent-400 text-slate-900 font-bold rounded-sm transition-colors text-sm shadow-lg hover:shadow-accent-500/25">
                        Save Preferences
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('cookieConsent', () => ({
                showBanner: false,
                showPreferences: false,
                preferences: {
                    functional: true,
                    analytics: true,
                    performance: true,
                    marketing: false
                },
                
                initConsent() {
                    const saved = localStorage.getItem('clemwa_cookie_consent');
                    if (!saved) {
                        // Small delay before showing banner for better UX
                        setTimeout(() => {
                            this.showBanner = true;
                        }, 1500);
                    } else {
                        try {
                            const parsed = JSON.parse(saved);
                            this.preferences = { ...this.preferences, ...parsed.preferences };
                            
                            // Check expiration (e.g., 6 months = 180 days)
                            const expirationDays = 180;
                            const timestamp = parsed.timestamp;
                            const now = new Date().getTime();
                            const daysPassed = (now - timestamp) / (1000 * 60 * 60 * 24);
                            
                            if (daysPassed > expirationDays) {
                                this.showBanner = true;
                                localStorage.removeItem('clemwa_cookie_consent');
                            }
                        } catch (e) {
                            this.showBanner = true;
                        }
                    }
                },
                
                acceptAll() {
                    this.preferences = {
                        functional: true,
                        analytics: true,
                        performance: true,
                        marketing: true
                    };
                    this.saveConsent();
                },
                
                rejectOptional() {
                    this.preferences = {
                        functional: false,
                        analytics: false,
                        performance: false,
                        marketing: false
                    };
                    this.saveConsent();
                },
                
                savePreferences() {
                    this.saveConsent();
                },
                
                resetPreferences() {
                    this.preferences = {
                        functional: true,
                        analytics: true,
                        performance: true,
                        marketing: false
                    };
                },
                
                openPreferences() {
                    this.showBanner = false;
                    this.showPreferences = true;
                },
                
                closePreferences() {
                    this.showPreferences = false;
                    // If they haven't saved any consent yet, show banner again
                    if (!localStorage.getItem('clemwa_cookie_consent')) {
                        this.showBanner = true;
                    }
                },
                
                saveConsent() {
                    const data = {
                        preferences: this.preferences,
                        timestamp: new Date().getTime(),
                        version: '1.0'
                    };
                    localStorage.setItem('clemwa_cookie_consent', JSON.stringify(data));
                    this.showBanner = false;
                    this.showPreferences = false;
                    
                    // Dispatch an event so other scripts can initialize tags based on consent
                    window.dispatchEvent(new CustomEvent('cookie-consent-updated', {
                        detail: this.preferences
                    }));
                }
            }));
        });
    </script>
</div>
