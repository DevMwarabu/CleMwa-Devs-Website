<x-layouts.legal title="Cookie Policy - CleMwa Developers" description="Our Cookie Policy explains how we use cookies and tracking technologies.">
    <!-- Hero Section -->
    <div class="max-w-[900px] mx-auto px-4 sm:px-6 lg:px-8 text-center pt-8 pb-16 md:pt-16 md:pb-24 border-b border-slate-800">
        <h1 class="text-[32px] md:text-[48px] font-bold text-white mb-4 leading-tight">Cookie Policy</h1>
        <p class="text-[18px] md:text-[20px] text-slate-400 mb-10">How we use cookies and tracking technologies.</p>
        
        <p class="text-[16px] md:text-[18px] text-slate-300 max-w-[800px] mx-auto mb-12 leading-[1.8]">
            This Cookie Policy explains how CleMwa Developers ("we", "our", or "us") uses cookies and similar tracking technologies when you visit our website, web applications, mobile applications, and other digital services.
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-6 sm:gap-8 text-sm text-slate-400">
            <div>
                <span class="block text-slate-500 uppercase tracking-wider text-[10px] sm:text-xs mb-1">Last Updated</span>
                <span class="text-white font-medium">July 16, 2026</span>
            </div>
            <div class="hidden sm:block w-px h-8 bg-slate-800"></div>
            <div>
                <span class="block text-slate-500 uppercase tracking-wider text-[10px] sm:text-xs mb-1">Effective Date</span>
                <span class="text-white font-medium">July 16, 2026</span>
            </div>
            <div class="hidden sm:block w-px h-8 bg-slate-800"></div>
            <div>
                <span class="block text-slate-500 uppercase tracking-wider text-[10px] sm:text-xs mb-1">Estimated Reading Time</span>
                <span class="text-white font-medium">5 Minutes</span>
            </div>
        </div>
        
        <!-- Interactive Actions -->
        <div class="mt-12 flex items-center justify-center gap-4 no-print">
            <button onclick="window.print()" class="flex items-center gap-2 text-sm font-medium text-slate-300 hover:text-white bg-[#1e293b] hover:bg-[#334155] px-5 py-2.5 rounded-full transition-colors border border-slate-700">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print / Save PDF
            </button>
        </div>
    </div>

    <!-- Content Layout -->
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 mt-16" 
         x-data="legalToc()" 
         x-init="initObserver()">
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-20 relative">
            
            <!-- Sticky TOC (Sidebar) -->
            <div class="lg:w-72 flex-shrink-0 no-print">
                <div class="sticky top-32 max-h-[calc(100vh-10rem)] overflow-y-auto pr-4 scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-transparent">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-6">Contents</h3>
                    
                    <!-- Mobile TOC Toggle -->
                    <button @click="mobileTocOpen = !mobileTocOpen" class="lg:hidden w-full flex items-center justify-between bg-[#1e293b] px-4 py-3 rounded-sm text-sm font-medium text-white border border-slate-700 mb-4">
                        <span>Navigate Sections</span>
                        <svg class="w-4 h-4 transform transition-transform" :class="mobileTocOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <!-- TOC Links -->
                    <nav class="flex flex-col space-y-1 lg:block" :class="mobileTocOpen ? 'block' : 'hidden lg:block'">
                        <template x-for="section in sections" :key="section.id">
                            <a :href="`#${section.id}`" 
                               @click="mobileTocOpen = false"
                               class="block py-2 px-3 -mx-3 rounded-sm text-[14px] transition-colors duration-200"
                               :class="activeSection === section.id ? 'bg-accent-500/10 text-accent-500 font-semibold' : 'text-slate-400 hover:text-white'">
                                <span x-text="section.title"></span>
                            </a>
                        </template>
                    </nav>
                </div>
            </div>
            
            <!-- Reading Content -->
            <div class="lg:w-[850px] w-full flex-grow pb-32 max-w-full">
                
                <style>
                    /* Specialized Netflix-Style Document Typography */
                    .legal-content section { margin-bottom: 4rem; scroll-margin-top: 120px; }
                    .legal-content h2 { color: white; font-size: 32px; font-weight: 700; margin-top: 0; margin-bottom: 1.5rem; line-height: 1.3; display: flex; align-items: center; gap: 0.75rem; }
                    .legal-content h3 { color: white; font-size: 24px; font-weight: 600; margin-top: 2.5rem; margin-bottom: 1rem; line-height: 1.4; }
                    .legal-content p { color: #cbd5e1; font-size: 18px; line-height: 1.8; margin-bottom: 1.5rem; max-width: 80ch; }
                    .legal-content ul { color: #cbd5e1; font-size: 18px; line-height: 1.8; margin-bottom: 1.5rem; list-style-type: none; padding-left: 0; max-width: 80ch; }
                    .legal-content ul li { position: relative; padding-left: 1.5rem; margin-bottom: 0.75rem; }
                    .legal-content ul li::before { content: "•"; color: #38bdf8; position: absolute; left: 0; font-size: 24px; line-height: 1.5; top: -2px; }
                    .legal-content a { color: #38bdf8; text-decoration: underline; text-underline-offset: 4px; transition: color 0.2s; }
                    .legal-content a:hover { color: #7dd3fc; text-decoration-color: #7dd3fc; }
                    .legal-content hr { border-color: #1e293b; margin: 4rem 0; border-width: 1px; }
                    .legal-content strong { color: white; font-weight: 600; }
                    
                    /* Highlight Boxes */
                    .highlight-box { background-color: #1e293b; border-left: 4px solid #38bdf8; padding: 1.5rem 2rem; border-radius: 4px; margin-bottom: 2.5rem; margin-top: 1.5rem; }
                    .highlight-box.security { border-color: #10b981; }
                    .highlight-box.important { border-color: #f59e0b; }
                    .highlight-box h4 { color: white; font-size: 18px; font-weight: 700; margin-top: 0; margin-bottom: 0.5rem; }
                    .highlight-box p { font-size: 16px; margin-bottom: 0; }
                    
                    .copy-link { opacity: 0; transition: all 0.2s; color: #64748b; cursor: pointer; padding: 4px; border-radius: 4px; }
                    .legal-content h2:hover .copy-link { opacity: 1; }
                    .copy-link:hover { color: #38bdf8; background: rgba(56, 189, 248, 0.1); }
                </style>

                <div class="legal-content">
                    
                    <section id="introduction">
                        <h2>
                            1. Introduction
                            <button @click="copyLink('introduction')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>This Cookie Policy explains how CleMwa Developers ("we", "our", or "us") uses cookies and similar tracking technologies when you visit our website, web applications, mobile applications, and other digital services.</p>
                        <p>This policy should be read together with our <a href="/privacy-policy">Privacy Policy</a>.</p>
                    </section>

                    <section id="what-are-cookies">
                        <h2>
                            2. What Are Cookies?
                            <button @click="copyLink('what-are-cookies')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Cookies are small text files stored on your device by your web browser. They help websites remember your preferences, improve performance, enhance security, and provide a better user experience.</p>
                        <p>Cookies may be:</p>
                        <ul>
                            <li>Session Cookies</li>
                            <li>Persistent Cookies</li>
                            <li>First-Party Cookies</li>
                            <li>Third-Party Cookies</li>
                        </ul>
                    </section>

                    <section id="why-we-use-cookies">
                        <h2>
                            3. Why We Use Cookies
                            <button @click="copyLink('why-we-use-cookies')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>We use cookies to:</p>
                        <ul>
                            <li>Maintain secure sessions</li>
                            <li>Keep you signed in</li>
                            <li>Remember your preferences</li>
                            <li>Improve website performance</li>
                            <li>Analyze traffic</li>
                            <li>Measure marketing performance</li>
                            <li>Personalize content</li>
                            <li>Detect suspicious activity</li>
                            <li>Prevent fraud</li>
                            <li>Improve our products</li>
                        </ul>
                    </section>

                    <section id="types-of-cookies">
                        <h2>
                            4. Types of Cookies We Use
                            <button @click="copyLink('types-of-cookies')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        
                        <h3>Essential Cookies</h3>
                        <p>Required for basic website functionality.</p>
                        <p><strong>Examples:</strong></p>
                        <ul>
                            <li>Authentication</li>
                            <li>Session management</li>
                            <li>Security</li>
                            <li>CSRF protection</li>
                            <li>Load balancing</li>
                        </ul>
                        <p><em>These cookies cannot be disabled.</em></p>
                        
                        <hr class="!my-8 !border-slate-800 border-dashed">

                        <h3>Preference Cookies</h3>
                        <p>Remember your settings.</p>
                        <p><strong>Examples:</strong></p>
                        <ul>
                            <li>Language</li>
                            <li>Theme</li>
                            <li>Region</li>
                            <li>Timezone</li>
                            <li>Accessibility preferences</li>
                        </ul>

                        <hr class="!my-8 !border-slate-800 border-dashed">

                        <h3>Analytics Cookies</h3>
                        <p>Help us understand website usage.</p>
                        <p><strong>Examples:</strong></p>
                        <ul>
                            <li>Page visits</li>
                            <li>Session duration</li>
                            <li>Navigation paths</li>
                            <li>Device information</li>
                            <li>Browser statistics</li>
                        </ul>
                        <p>Analytics may be provided by trusted services such as Google Analytics or similar platforms.</p>

                        <hr class="!my-8 !border-slate-800 border-dashed">

                        <h3>Performance Cookies</h3>
                        <p>Used to improve website speed and reliability.</p>
                        <p><strong>Examples:</strong></p>
                        <ul>
                            <li>Caching</li>
                            <li>Performance monitoring</li>
                            <li>Error tracking</li>
                        </ul>

                        <hr class="!my-8 !border-slate-800 border-dashed">

                        <h3>Functional Cookies</h3>
                        <p>Enable enhanced website features.</p>
                        <p><strong>Examples:</strong></p>
                        <ul>
                            <li>Live chat</li>
                            <li>Video playback</li>
                            <li>Interactive forms</li>
                            <li>AI Assistant</li>
                        </ul>

                        <hr class="!my-8 !border-slate-800 border-dashed">

                        <h3>Marketing Cookies</h3>
                        <p>Used only where applicable and with consent.</p>
                        <p><strong>Examples:</strong></p>
                        <ul>
                            <li>Campaign measurement</li>
                            <li>Advertising effectiveness</li>
                            <li>Referral tracking</li>
                        </ul>
                    </section>

                    <section id="third-party-cookies">
                        <h2>
                            5. Third-Party Cookies
                            <button @click="copyLink('third-party-cookies')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Some cookies may be placed by trusted third-party services integrated into our website.</p>
                        <p>These may include:</p>
                        <ul>
                            <li>Google</li>
                            <li>Microsoft</li>
                            <li>Cloud providers</li>
                            <li>Payment processors</li>
                            <li>Customer support platforms</li>
                            <li>Analytics providers</li>
                        </ul>
                        <p>Each provider manages its own cookies according to its privacy policy.</p>
                    </section>

                    <section id="managing-cookies">
                        <h2>
                            6. Managing Cookies
                            <button @click="copyLink('managing-cookies')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Most browsers allow you to:</p>
                        <ul>
                            <li>View cookies</li>
                            <li>Delete cookies</li>
                            <li>Block cookies</li>
                            <li>Block third-party cookies</li>
                            <li>Clear browsing data</li>
                        </ul>
                        <div class="highlight-box important">
                            <h4>Important</h4>
                            <p>Please note that disabling certain cookies may affect website functionality.</p>
                        </div>
                    </section>

                    <section id="cookie-consent">
                        <h2>
                            7. Cookie Consent
                            <button @click="copyLink('cookie-consent')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Where required by applicable law, we request your consent before placing non-essential cookies on your device.</p>
                        <p>You may update your preferences at any time using our Cookie Preferences settings.</p>
                    </section>

                    <section id="mobile-applications">
                        <h2>
                            8. Mobile Applications
                            <button @click="copyLink('mobile-applications')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Our mobile applications generally do not use browser cookies but may use similar technologies such as:</p>
                        <ul>
                            <li>Secure local storage</li>
                            <li>Device identifiers</li>
                            <li>Analytics SDKs</li>
                            <li>Authentication tokens</li>
                            <li>Push notification identifiers</li>
                        </ul>
                        <p>These technologies are used only to improve functionality, security, and user experience.</p>
                    </section>

                    <section id="app-store-google-play">
                        <h2>
                            9. Apple App Store & Google Play
                            <button @click="copyLink('app-store-google-play')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Applications distributed through Apple App Store and Google Play Store comply with their respective privacy and data collection requirements.</p>
                        <p>Only technologies necessary for application functionality and analytics are used, and users may manage permissions through their device settings.</p>
                    </section>

                    <section id="changes-to-this-policy">
                        <h2>
                            10. Changes to This Policy
                            <button @click="copyLink('changes-to-this-policy')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>We may update this Cookie Policy from time to time.</p>
                        <p>Any updates become effective immediately upon publication.</p>
                    </section>

                    <section id="contact-us">
                        <h2>
                            11. Contact Us
                            <button @click="copyLink('contact-us')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>If you have any questions regarding this Cookie Policy, please contact:</p>
                        <ul>
                            <li><strong>CleMwa Developers</strong></li>
                            <li>Email: <a href="mailto:privacy@clemwadevelopers.com">privacy@clemwadevelopers.com</a></li>
                            <li>Website: <a href="https://clemwadevelopers.com">https://clemwadevelopers.com</a></li>
                        </ul>
                    </section>

                    <hr>

                    <!-- Contact Card -->
                    <div class="bg-[#1e293b] border border-slate-700 rounded-lg p-8 md:p-12 text-center mt-16 no-print">
                        <h3 class="!mt-0 !mb-4 text-[32px] font-bold text-white">Have a Question?</h3>
                        <p class="text-slate-300 text-[18px] mb-8 leading-[1.6]">
                            If you have any questions regarding how we use Cookies, please reach out to our privacy team.
                        </p>
                        
                        <div class="flex flex-col md:flex-row items-center justify-center gap-6 mb-10 text-left">
                            <div>
                                <span class="block text-slate-500 uppercase tracking-wider text-xs font-bold mb-1">Privacy Team</span>
                                <a href="mailto:privacy@clemwadevelopers.com" class="text-accent-500 font-medium hover:underline text-[16px]">privacy@clemwadevelopers.com</a>
                            </div>
                            <div class="hidden md:block w-px h-10 bg-slate-700"></div>
                            <div>
                                <span class="block text-slate-500 uppercase tracking-wider text-xs font-bold mb-1">Website</span>
                                <a href="https://clemwadevelopers.com" target="_blank" class="text-accent-500 font-medium hover:underline text-[16px]">clemwadevelopers.com</a>
                            </div>
                        </div>
                        
                        <a href="/contact" class="inline-block bg-white text-slate-900 font-bold px-8 py-4 rounded-sm hover:bg-slate-200 transition-colors shadow-lg hover:scale-105 active:scale-95 text-[16px]">
                            Contact Us
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <!-- Alpine.js logic for TOC -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('legalToc', () => ({
                activeSection: 'introduction',
                mobileTocOpen: false,
                sections: [
                    { id: 'introduction', title: '1. Introduction' },
                    { id: 'what-are-cookies', title: '2. What Are Cookies?' },
                    { id: 'why-we-use-cookies', title: '3. Why We Use Cookies' },
                    { id: 'types-of-cookies', title: '4. Types of Cookies We Use' },
                    { id: 'third-party-cookies', title: '5. Third-Party Cookies' },
                    { id: 'managing-cookies', title: '6. Managing Cookies' },
                    { id: 'cookie-consent', title: '7. Cookie Consent' },
                    { id: 'mobile-applications', title: '8. Mobile Applications' },
                    { id: 'app-store-google-play', title: '9. App Store & Google Play' },
                    { id: 'changes-to-this-policy', title: '10. Changes to This Policy' },
                    { id: 'contact-us', title: '11. Contact Us' }
                ],
                initObserver() {
                    // Update active section based on scroll position
                    const observer = new IntersectionObserver((entries) => {
                        // Find the topmost intersecting entry
                        let currentIntersecting = null;
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                currentIntersecting = entry.target.id;
                            }
                        });
                        
                        if (currentIntersecting) {
                            this.activeSection = currentIntersecting;
                        }
                    }, { rootMargin: '-10% 0px -70% 0px', threshold: 0 });
                    
                    // Observe all section IDs
                    this.sections.forEach(section => {
                        const el = document.getElementById(section.id);
                        if (el) observer.observe(el);
                    });
                },
                copyLink(id) {
                    const url = window.location.origin + window.location.pathname + '#' + id;
                    navigator.clipboard.writeText(url).then(() => {
                        const btn = document.querySelector(`#${id} .copy-link`);
                        const originalHTML = btn.innerHTML;
                        btn.innerHTML = '<svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                        setTimeout(() => {
                            btn.innerHTML = originalHTML;
                        }, 2000);
                    }).catch(err => {
                        console.error('Failed to copy link: ', err);
                    });
                }
            }));
        });
    </script>
</x-layouts.legal>
