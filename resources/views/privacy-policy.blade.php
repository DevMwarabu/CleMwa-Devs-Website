<x-layouts.legal title="Privacy Policy - CleMwa Developers" description="Our privacy policy explains how we collect and use your data.">
    <!-- Hero Section -->
    <div class="max-w-[900px] mx-auto px-4 sm:px-6 lg:px-8 text-center pt-8 pb-16 md:pt-16 md:pb-24 border-b border-slate-800">
        <h1 class="text-[32px] md:text-[48px] font-bold text-white mb-4 leading-tight">Privacy Policy</h1>
        <p class="text-[18px] md:text-[20px] text-slate-400 mb-10">Your privacy matters to us.</p>
        
        <p class="text-[16px] md:text-[18px] text-slate-300 max-w-[800px] mx-auto mb-12 leading-[1.8]">
            This Privacy Policy explains how CleMwa Developers collects, uses, protects, stores, and manages your personal information across our website, software products, mobile applications, APIs, and digital services.
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
                <span class="text-white font-medium">12 Minutes</span>
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
                        <p>Welcome to <strong>CleMwa Developers</strong> ("CleMwa Developers", "Company", "we", "our", or "us").</p>
                        <p>We are committed to protecting your privacy and ensuring that your personal information is handled securely, transparently, and in accordance with applicable data protection laws and industry best practices.</p>
                        <p>This Privacy Policy explains how we collect, use, disclose, store, and protect your information when you:</p>
                        <ul>
                            <li>Visit our website.</li>
                            <li>Use our web applications.</li>
                            <li>Use our mobile applications.</li>
                            <li>Request our services.</li>
                            <li>Contact our support team.</li>
                            <li>Subscribe to our newsletters.</li>
                            <li>Access any software, products, APIs, or digital platforms developed or operated by CleMwa Developers.</li>
                        </ul>
                        <p>This Privacy Policy also applies to applications distributed through the <strong>Apple App Store</strong>, <strong>Google Play Store</strong>, and other official software distribution platforms.</p>
                    </section>

                    <section id="who-we-are">
                        <h2>
                            2. Who We Are
                            <button @click="copyLink('who-we-are')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p><strong>Company Name:</strong> CleMwa Developers</p>
                        <p>We specialize in:</p>
                        <ul>
                            <li>Custom Software Development</li>
                            <li>Web Development</li>
                            <li>Mobile Application Development</li>
                            <li>Artificial Intelligence Solutions</li>
                            <li>Enterprise Resource Planning (ERP)</li>
                            <li>Point of Sale (POS) Systems</li>
                            <li>Cloud Solutions</li>
                            <li>API Development</li>
                            <li>UI/UX Design</li>
                            <li>IT Consultancy</li>
                        </ul>
                    </section>

                    <section id="information-we-collect">
                        <h2>
                            3. Information We Collect
                            <button @click="copyLink('information-we-collect')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Depending on the services you use, we may collect the following information.</p>
                        
                        <h3>Personal Information</h3>
                        <ul>
                            <li>Full name</li>
                            <li>Email address</li>
                            <li>Phone number</li>
                            <li>Company name</li>
                            <li>Job title</li>
                            <li>Country</li>
                            <li>Billing address</li>
                            <li>Postal address</li>
                        </ul>

                        <h3>Account Information</h3>
                        <ul>
                            <li>Username</li>
                            <li>Password (encrypted)</li>
                            <li>Profile photo</li>
                            <li>User preferences</li>
                            <li>Account settings</li>
                        </ul>

                        <h3>Technical Information</h3>
                        <ul>
                            <li>IP address</li>
                            <li>Device type</li>
                            <li>Operating system</li>
                            <li>Browser type</li>
                            <li>Screen resolution</li>
                            <li>Language</li>
                            <li>Time zone</li>
                            <li>Device identifiers</li>
                            <li>App version</li>
                            <li>Crash logs</li>
                        </ul>

                        <h3>Usage Information</h3>
                        <p>We may collect:</p>
                        <ul>
                            <li>Pages visited</li>
                            <li>Features used</li>
                            <li>Session duration</li>
                            <li>Click activity</li>
                            <li>Navigation behavior</li>
                            <li>Search history within our services</li>
                            <li>Referral sources</li>
                        </ul>
                    </section>
                    
                    <section id="how-we-collect-information">
                        <h2>
                            4. How We Collect Information
                            <button @click="copyLink('how-we-collect-information')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>We collect information when you:</p>
                        <ul>
                            <li>Visit our website</li>
                            <li>Register an account</li>
                            <li>Submit forms</li>
                            <li>Request quotations</li>
                            <li>Purchase products or services</li>
                            <li>Contact customer support</li>
                            <li>Subscribe to newsletters</li>
                            <li>Download resources</li>
                            <li>Apply for jobs</li>
                            <li>Use our applications</li>
                            <li>Interact with our AI assistant</li>
                            <li>Participate in surveys or promotions</li>
                        </ul>
                        <p>Information may also be collected automatically through cookies, analytics technologies, and server logs.</p>
                    </section>

                    <section id="how-we-use-your-information">
                        <h2>
                            5. How We Use Your Information
                            <button @click="copyLink('how-we-use-your-information')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Your information may be used to:</p>
                        <ul>
                            <li>Deliver our products and services</li>
                            <li>Create and manage user accounts</li>
                            <li>Process payments</li>
                            <li>Provide customer support</li>
                            <li>Improve our products</li>
                            <li>Personalize user experiences</li>
                            <li>Respond to inquiries</li>
                            <li>Send service notifications</li>
                            <li>Send security alerts</li>
                            <li>Prevent fraud</li>
                            <li>Detect abuse</li>
                            <li>Monitor system performance</li>
                            <li>Analyze website usage</li>
                            <li>Improve application stability</li>
                            <li>Conduct research and development</li>
                            <li>Meet legal obligations</li>
                        </ul>
                        <p>Where permitted by law and your preferences, we may also send newsletters, product announcements, or promotional communications.</p>
                    </section>

                    <section id="legal-basis-for-processing">
                        <h2>
                            6. Legal Basis for Processing
                            <button @click="copyLink('legal-basis-for-processing')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Where applicable, we process personal information based on:</p>
                        <ul>
                            <li>Your consent</li>
                            <li>Performance of a contract</li>
                            <li>Compliance with legal obligations</li>
                            <li>Legitimate business interests</li>
                            <li>Protection of vital interests</li>
                        </ul>
                    </section>

                    <section id="cookies-and-tracking-technologies">
                        <h2>
                            7. Cookies and Tracking Technologies
                            <button @click="copyLink('cookies-and-tracking-technologies')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>We use cookies and similar technologies to:</p>
                        <ul>
                            <li>Maintain secure sessions</li>
                            <li>Remember user preferences</li>
                            <li>Improve website performance</li>
                            <li>Analyze visitor behavior</li>
                            <li>Measure marketing effectiveness</li>
                            <li>Prevent fraud</li>
                        </ul>
                        <p>Users can manage cookie preferences through their browser settings. Disabling cookies may affect certain website features.</p>
                    </section>

                    <section id="third-party-services">
                        <h2>
                            8. Third-Party Services
                            <button @click="copyLink('third-party-services')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>We may integrate trusted third-party services including:</p>
                        <ul>
                            <li>Google Analytics</li>
                            <li>Firebase</li>
                            <li>Apple Services</li>
                            <li>Google Play Services</li>
                            <li>Cloud hosting providers</li>
                            <li>Email delivery services</li>
                            <li>Payment processors</li>
                            <li>Mapping services</li>
                            <li>Error reporting services</li>
                            <li>Customer support platforms</li>
                        </ul>
                        <p>Each provider processes information according to its own privacy policy.</p>
                    </section>
                    
                    <section id="mobile-applications">
                        <h2>
                            9. Mobile Applications
                            <button @click="copyLink('mobile-applications')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Our mobile applications may collect information such as Device model, Operating system version, App version, Push notification token, Device language, Network information, Diagnostic logs, and Performance analytics.</p>
                        
                        <div class="highlight-box">
                            <h4>Mobile Applications</h4>
                            <p>Permissions are only requested when necessary for application functionality.</p>
                        </div>
                        
                        <p>Depending on your consent and app functionality, we may request access to:</p>
                        <ul>
                            <li>Camera</li>
                            <li>Microphone</li>
                            <li>Photos</li>
                            <li>File storage</li>
                            <li>Contacts</li>
                            <li>Location (foreground or background)</li>
                            <li>Bluetooth</li>
                            <li>Notifications</li>
                            <li>Biometric authentication (Face ID, Touch ID, Fingerprint)</li>
                        </ul>
                    </section>

                    <section id="apple-app-store-compliance">
                        <h2>
                            10. Apple App Store Compliance
                            <button @click="copyLink('apple-app-store-compliance')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Applications distributed through the Apple App Store are designed to comply with Apple's App Review Guidelines.</p>
                        <div class="highlight-box">
                            <h4>Apple App Store</h4>
                            <p>Applications comply with Apple's App Review Guidelines and Privacy Requirements.</p>
                        </div>
                        <ul>
                            <li>We request only the permissions required for app functionality.</li>
                            <li>Users may manage permissions through iOS Settings.</li>
                            <li>Privacy-sensitive data is collected only with user consent where required.</li>
                            <li>Data collection practices are disclosed through Apple's Privacy Nutrition Labels.</li>
                            <li>Users may request deletion of their personal data, subject to legal or contractual requirements.</li>
                        </ul>
                    </section>

                    <section id="google-play-store-compliance">
                        <h2>
                            11. Google Play Store Compliance
                            <button @click="copyLink('google-play-store-compliance')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Applications distributed through Google Play comply with applicable Google Play Developer Program Policies.</p>
                        <div class="highlight-box">
                            <h4>Google Play</h4>
                            <p>Applications comply with Google Play Developer Program Policies and Data Safety requirements.</p>
                        </div>
                        <ul>
                            <li>Permissions are requested only when required.</li>
                            <li>Sensitive permissions are used solely to enable core features.</li>
                            <li>Data collection is disclosed through Google Play's Data Safety section.</li>
                            <li>Users may revoke permissions through Android settings.</li>
                            <li>Personal information is handled using secure transmission and storage practices.</li>
                        </ul>
                    </section>
                    
                    <section id="data-sharing">
                        <h2>
                            12. Data Sharing
                            <button @click="copyLink('data-sharing')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>We do not sell personal information.</p>
                        <div class="highlight-box important">
                            <h4>Important</h4>
                            <p>We never sell your personal information.</p>
                        </div>
                        <p>Information may be shared only when necessary with:</p>
                        <ul>
                            <li>Cloud infrastructure providers</li>
                            <li>Payment processors</li>
                            <li>Customer support providers</li>
                            <li>Analytics providers</li>
                            <li>Professional advisors</li>
                            <li>Regulatory authorities</li>
                            <li>Law enforcement where legally required</li>
                            <li>Business partners providing requested services</li>
                        </ul>
                        <p>All partners are expected to implement appropriate safeguards for personal information.</p>
                    </section>

                    <section id="international-data-transfers">
                        <h2>
                            13. International Data Transfers
                            <button @click="copyLink('international-data-transfers')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Your information may be processed or stored in countries other than your country of residence.</p>
                        <p>Where required, appropriate safeguards are implemented to protect transferred personal information.</p>
                    </section>

                    <section id="data-security">
                        <h2>
                            14. Data Security
                            <button @click="copyLink('data-security')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <div class="highlight-box security">
                            <h4>Security</h4>
                            <p>All sensitive information is transmitted using encrypted connections.</p>
                        </div>
                        <p>We implement industry-standard security measures including HTTPS encryption, TLS/SSL communication, Database encryption, Password hashing, Two-factor authentication, Access controls, Role-based permissions, Audit logging, Firewall protection, Intrusion monitoring, Vulnerability management, Regular security updates, Secure backups, and Disaster recovery procedures.</p>
                        <p>While we strive to protect your information, no method of electronic transmission or storage is completely secure.</p>
                    </section>

                    <section id="data-retention">
                        <h2>
                            15. Data Retention
                            <button @click="copyLink('data-retention')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>We retain personal information only for as long as necessary to:</p>
                        <ul>
                            <li>Provide our services</li>
                            <li>Comply with legal obligations</li>
                            <li>Resolve disputes</li>
                            <li>Enforce agreements</li>
                            <li>Improve our products</li>
                        </ul>
                        <p>When information is no longer required, it is securely deleted or anonymized.</p>
                    </section>

                    <section id="your-rights">
                        <h2>
                            16. Your Rights
                            <button @click="copyLink('your-rights')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Depending on applicable law, you may have the right to:</p>
                        <ul>
                            <li>Access your personal information</li>
                            <li>Correct inaccurate information</li>
                            <li>Delete your information</li>
                            <li>Restrict processing</li>
                            <li>Object to processing</li>
                            <li>Withdraw consent</li>
                            <li>Request data portability</li>
                            <li>Lodge a complaint with a supervisory authority</li>
                        </ul>
                        <p>Requests will be handled within applicable legal timeframes.</p>
                    </section>

                    <section id="childrens-privacy">
                        <h2>
                            17. Children's Privacy
                            <button @click="copyLink('childrens-privacy')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Our services are not intended for children under the age required by applicable law without parental or guardian consent.</p>
                        <p>If we become aware that personal information has been collected from a child in violation of applicable law, we will take appropriate steps to remove such information.</p>
                    </section>

                    <section id="artificial-intelligence-features">
                        <h2>
                            18. Artificial Intelligence Features
                            <button @click="copyLink('artificial-intelligence-features')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Some products may include AI-powered capabilities.</p>
                        <p>Where applicable:</p>
                        <ul>
                            <li>AI-generated responses are intended for informational purposes.</li>
                            <li>Users remain responsible for reviewing AI-generated content before relying on it.</li>
                            <li>AI interactions may be processed to improve service quality, unless prohibited by law or user settings.</li>
                            <li>Sensitive or confidential information should not be submitted to AI features unless explicitly supported and protected.</li>
                        </ul>
                    </section>

                    <section id="data-deletion-requests">
                        <h2>
                            19. Data Deletion Requests
                            <button @click="copyLink('data-deletion-requests')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Users may request deletion of their account and associated personal information by contacting us using the contact details below.</p>
                        <p>Some information may be retained where required by law, regulatory obligations, fraud prevention, security, or contractual requirements.</p>
                    </section>

                    <section id="third-party-links">
                        <h2>
                            20. Third-Party Links
                            <button @click="copyLink('third-party-links')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Our website and applications may contain links to third-party websites or services.</p>
                        <p>We are not responsible for the privacy practices or content of third-party platforms.</p>
                    </section>

                    <section id="changes-to-this-privacy-policy">
                        <h2>
                            21. Changes to This Privacy Policy
                            <button @click="copyLink('changes-to-this-privacy-policy')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>We may update this Privacy Policy periodically.</p>
                        <p>Material changes will be communicated through our website, applications, or other appropriate communication channels. The updated version becomes effective upon publication unless otherwise stated.</p>
                    </section>

                    <section id="contact-us">
                        <h2>
                            22. Contact Us
                            <button @click="copyLink('contact-us')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>If you have questions, concerns, or requests regarding this Privacy Policy or our handling of personal information, please contact us:</p>
                        <ul>
                            <li><strong>CleMwa Developers</strong></li>
                            <li>Email: <a href="mailto:privacy@clemwadevelopers.com">privacy@clemwadevelopers.com</a></li>
                            <li>Support: <a href="mailto:support@clemwadevelopers.com">support@clemwadevelopers.com</a></li>
                            <li>Website: <a href="https://clemwadevelopers.com">https://clemwadevelopers.com</a></li>
                        </ul>
                    </section>

                    <section id="consent">
                        <h2>
                            23. Consent
                            <button @click="copyLink('consent')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>By accessing or using our website, applications, products, or services, you acknowledge that you have read, understood, and agree to this Privacy Policy.</p>
                    </section>

                    <hr>

                    <!-- Contact Card -->
                    <div class="bg-[#1e293b] border border-slate-700 rounded-lg p-8 md:p-12 text-center mt-16 no-print">
                        <h3 class="!mt-0 !mb-4 text-[32px] font-bold text-white">Need Help?</h3>
                        <p class="text-slate-300 text-[18px] mb-8 leading-[1.6]">
                            If you have any questions regarding this Privacy Policy or your personal information, please contact us.
                        </p>
                        
                        <div class="flex flex-col md:flex-row items-center justify-center gap-6 mb-10 text-left">
                            <div>
                                <span class="block text-slate-500 uppercase tracking-wider text-xs font-bold mb-1">Email</span>
                                <a href="mailto:privacy@clemwadevelopers.com" class="text-accent-500 font-medium hover:underline text-[16px]">privacy@clemwadevelopers.com</a>
                            </div>
                            <div class="hidden md:block w-px h-10 bg-slate-700"></div>
                            <div>
                                <span class="block text-slate-500 uppercase tracking-wider text-xs font-bold mb-1">Support</span>
                                <a href="mailto:support@clemwadevelopers.com" class="text-accent-500 font-medium hover:underline text-[16px]">support@clemwadevelopers.com</a>
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
                    { id: 'who-we-are', title: '2. Who We Are' },
                    { id: 'information-we-collect', title: '3. Information We Collect' },
                    { id: 'how-we-collect-information', title: '4. How We Collect Information' },
                    { id: 'how-we-use-your-information', title: '5. How We Use Your Information' },
                    { id: 'legal-basis-for-processing', title: '6. Legal Basis for Processing' },
                    { id: 'cookies-and-tracking-technologies', title: '7. Cookies and Tracking Technologies' },
                    { id: 'third-party-services', title: '8. Third-Party Services' },
                    { id: 'mobile-applications', title: '9. Mobile Applications' },
                    { id: 'apple-app-store-compliance', title: '10. Apple App Store Compliance' },
                    { id: 'google-play-store-compliance', title: '11. Google Play Store Compliance' },
                    { id: 'data-sharing', title: '12. Data Sharing' },
                    { id: 'international-data-transfers', title: '13. International Data Transfers' },
                    { id: 'data-security', title: '14. Data Security' },
                    { id: 'data-retention', title: '15. Data Retention' },
                    { id: 'your-rights', title: '16. Your Rights' },
                    { id: 'childrens-privacy', title: '17. Childrens Privacy' },
                    { id: 'artificial-intelligence-features', title: '18. AI Features' },
                    { id: 'data-deletion-requests', title: '19. Data Deletion Requests' },
                    { id: 'third-party-links', title: '20. Third-Party Links' },
                    { id: 'changes-to-this-privacy-policy', title: '21. Changes to This Privacy Policy' },
                    { id: 'contact-us', title: '22. Contact Us' },
                    { id: 'consent', title: '23. Consent' }
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
                        // Very simple visual feedback, you could use a proper toast notification here
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
