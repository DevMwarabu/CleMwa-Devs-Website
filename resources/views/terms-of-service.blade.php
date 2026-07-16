<x-layouts.legal title="Terms of Service - CleMwa Developers" description="Our Terms of Service govern your use of CleMwa Developers' products and services.">
    <!-- Hero Section -->
    <div class="max-w-[900px] mx-auto px-4 sm:px-6 lg:px-8 text-center pt-8 pb-16 md:pt-16 md:pb-24 border-b border-slate-800">
        <h1 class="text-[32px] md:text-[48px] font-bold text-white mb-4 leading-tight">Terms of Service</h1>
        <p class="text-[18px] md:text-[20px] text-slate-400 mb-10">Please read these terms carefully before using our services.</p>
        
        <p class="text-[16px] md:text-[18px] text-slate-300 max-w-[800px] mx-auto mb-12 leading-[1.8]">
            These Terms of Service ("Terms") govern your access to and use of our website, software products, mobile applications, APIs, cloud services, and any other digital services provided by CleMwa Developers.
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
                <span class="text-white font-medium">15 Minutes</span>
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
                        <p>These Terms of Service ("Terms") govern your access to and use of our website, software products, mobile applications, APIs, cloud services, and any other digital services provided by CleMwa Developers.</p>
                        <p>By accessing or using our services, you acknowledge that you have read, understood, and agree to be bound by these Terms. If you do not agree to these Terms, you should discontinue use of our services immediately.</p>
                    </section>

                    <section id="eligibility">
                        <h2>
                            2. Eligibility
                            <button @click="copyLink('eligibility')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>To use our services, you must:</p>
                        <ul>
                            <li>Be at least the age of majority in your jurisdiction or have the consent of a parent or legal guardian.</li>
                            <li>Have the legal capacity to enter into binding agreements.</li>
                            <li>Comply with all applicable laws and regulations.</li>
                        </ul>
                    </section>

                    <section id="services">
                        <h2>
                            3. Services
                            <button @click="copyLink('services')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>CleMwa Developers provides professional technology solutions including, but not limited to:</p>
                        <ul>
                            <li>Custom Software Development</li>
                            <li>Web Development</li>
                            <li>Mobile Application Development</li>
                            <li>Artificial Intelligence Solutions</li>
                            <li>Enterprise Resource Planning (ERP)</li>
                            <li>Point of Sale (POS) Systems</li>
                            <li>API Development</li>
                            <li>Cloud Services</li>
                            <li>System Integration</li>
                            <li>UI/UX Design</li>
                            <li>IT Consultancy</li>
                            <li>Software Maintenance and Support</li>
                        </ul>
                        <p>Certain services may be governed by separate agreements, contracts, or service-level agreements (SLAs).</p>
                    </section>

                    <section id="user-accounts">
                        <h2>
                            4. User Accounts
                            <button @click="copyLink('user-accounts')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Certain features require users to create an account.</p>
                        <p>You agree to:</p>
                        <ul>
                            <li>Provide accurate information.</li>
                            <li>Keep your account information current.</li>
                            <li>Maintain the confidentiality of your login credentials.</li>
                            <li>Notify us immediately of unauthorized account access.</li>
                            <li>Accept responsibility for activities performed using your account.</li>
                        </ul>
                        <p>We reserve the right to suspend or terminate accounts that violate these Terms.</p>
                    </section>

                    <section id="acceptable-use">
                        <h2>
                            5. Acceptable Use
                            <button @click="copyLink('acceptable-use')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>You agree not to:</p>
                        <ul>
                            <li>Use our services for unlawful purposes.</li>
                            <li>Upload malicious software or viruses.</li>
                            <li>Attempt unauthorized access to our systems.</li>
                            <li>Reverse engineer our software where prohibited.</li>
                            <li>Interfere with system performance.</li>
                            <li>Abuse APIs or rate limits.</li>
                            <li>Harvest user information without authorization.</li>
                            <li>Distribute spam or unsolicited communications.</li>
                            <li>Infringe intellectual property rights.</li>
                            <li>Use our services to facilitate fraud or illegal activities.</li>
                        </ul>
                        <div class="highlight-box important">
                            <h4>Important</h4>
                            <p>Violation of these Terms may result in immediate suspension or termination.</p>
                        </div>
                    </section>

                    <section id="intellectual-property">
                        <h2>
                            6. Intellectual Property
                            <button @click="copyLink('intellectual-property')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Unless otherwise stated, all content provided by CleMwa Developers, including:</p>
                        <ul>
                            <li>Software and Source code</li>
                            <li>Databases and APIs</li>
                            <li>Logos, Graphics, and Icons</li>
                            <li>Documentation and Designs</li>
                            <li>Trademarks, Text, and Images</li>
                        </ul>
                        <p>is owned by CleMwa Developers or its licensors and is protected under applicable intellectual property laws.</p>
                        <p>No ownership rights are transferred to users unless expressly agreed in writing.</p>
                    </section>

                    <section id="client-projects">
                        <h2>
                            7. Client Projects
                            <button @click="copyLink('client-projects')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>For custom software projects:</p>
                        <ul>
                            <li>Ownership of deliverables is governed by the applicable project agreement.</li>
                            <li>Intellectual property rights transfer only upon full payment, unless otherwise agreed.</li>
                            <li>CleMwa Developers may showcase completed work in its portfolio unless restricted by a confidentiality agreement.</li>
                            <li>Clients are responsible for reviewing and approving deliverables before deployment.</li>
                        </ul>
                    </section>

                    <section id="payments">
                        <h2>
                            8. Payments
                            <button @click="copyLink('payments')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Where applicable:</p>
                        <ul>
                            <li>Fees are payable according to agreed quotations or contracts.</li>
                            <li>Payments may be required before work commences.</li>
                            <li>Late payments may result in suspension of services.</li>
                            <li>Taxes and applicable government charges remain the responsibility of the client unless otherwise specified.</li>
                        </ul>
                        <div class="highlight-box security">
                            <h4>Secure Processing</h4>
                            <p>All payments are processed securely through authorized payment providers.</p>
                        </div>
                    </section>

                    <section id="subscription-services">
                        <h2>
                            9. Subscription Services
                            <button @click="copyLink('subscription-services')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>For subscription-based products:</p>
                        <ul>
                            <li>Billing may occur monthly or annually.</li>
                            <li>Subscriptions automatically renew unless cancelled before the renewal date.</li>
                            <li>Pricing may change with prior notice.</li>
                            <li>Cancellation does not entitle users to refunds for unused subscription periods unless required by law.</li>
                        </ul>
                    </section>

                    <section id="refund-policy">
                        <h2>
                            10. Refund Policy
                            <button @click="copyLink('refund-policy')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Refund eligibility depends on the specific product or service.</p>
                        <p>Unless otherwise stated:</p>
                        <ul>
                            <li>Digital products are generally non-refundable once delivered.</li>
                            <li>Custom software development services are non-refundable for completed work.</li>
                            <li>Subscription refunds are subject to applicable laws and contractual terms.</li>
                        </ul>
                    </section>

                    <section id="software-licensing">
                        <h2>
                            11. Software Licensing
                            <button @click="copyLink('software-licensing')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Unless otherwise agreed:</p>
                        <ul>
                            <li>Users receive a limited, non-exclusive, non-transferable license to use our software.</li>
                            <li>Users may not resell, sublicense, or redistribute our software without written authorization.</li>
                            <li>Trial versions may include feature limitations or expiration periods.</li>
                        </ul>
                    </section>

                    <section id="third-party-services">
                        <h2>
                            12. Third-Party Services
                            <button @click="copyLink('third-party-services')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Our services may integrate with third-party platforms, including:</p>
                        <ul>
                            <li>Apple Services</li>
                            <li>Google Services</li>
                            <li>Firebase</li>
                            <li>Payment gateways</li>
                            <li>Cloud hosting providers</li>
                            <li>Mapping services</li>
                            <li>Analytics providers</li>
                        </ul>
                        <p>Your use of third-party services is subject to their respective terms and privacy policies.</p>
                        <p>CleMwa Developers is not responsible for third-party service availability or policies.</p>
                    </section>

                    <section id="mobile-applications">
                        <h2>
                            13. Mobile Applications
                            <button @click="copyLink('mobile-applications')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Applications distributed through the Apple App Store, Google Play Store, or other official marketplaces are also subject to the applicable platform terms.</p>
                        <p>Users are responsible for:</p>
                        <ul>
                            <li>Keeping applications updated.</li>
                            <li>Installing applications from official sources.</li>
                            <li>Maintaining device security.</li>
                            <li>Respecting applicable licensing restrictions.</li>
                        </ul>
                    </section>

                    <section id="apple-app-store-terms">
                        <h2>
                            14. Apple App Store Terms
                            <button @click="copyLink('apple-app-store-terms')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>If you download an application through the Apple App Store:</p>
                        <ul>
                            <li>Apple is not responsible for the application or its support.</li>
                            <li>Apple has no obligation to provide maintenance or support services.</li>
                            <li>Apple is not responsible for warranty claims except where required by law.</li>
                            <li>Users must comply with the Apple Media Services Terms and Conditions.</li>
                            <li>Apple and its subsidiaries are third-party beneficiaries of these Terms where applicable.</li>
                        </ul>
                    </section>

                    <section id="google-play-store-terms">
                        <h2>
                            15. Google Play Store Terms
                            <button @click="copyLink('google-play-store-terms')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Applications distributed through Google Play must comply with Google's Developer Program Policies.</p>
                        <p>Users acknowledge that:</p>
                        <ul>
                            <li>Google is not responsible for support or maintenance.</li>
                            <li>Google Play services are governed by Google's own terms.</li>
                            <li>Certain features may depend on Google Play Services availability.</li>
                        </ul>
                    </section>

                    <section id="availability">
                        <h2>
                            16. Availability
                            <button @click="copyLink('availability')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>We strive to maintain reliable services but do not guarantee uninterrupted availability.</p>
                        <p>Services may occasionally be unavailable due to:</p>
                        <ul>
                            <li>Maintenance</li>
                            <li>Security updates</li>
                            <li>Infrastructure upgrades</li>
                            <li>Force majeure events</li>
                            <li>Third-party failures</li>
                        </ul>
                    </section>

                    <section id="data-protection">
                        <h2>
                            17. Data Protection
                            <button @click="copyLink('data-protection')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Your use of our services is also governed by our <a href="/privacy-policy">Privacy Policy</a>.</p>
                        <p>We implement reasonable technical and organizational measures to protect user information.</p>
                    </section>

                    <section id="artificial-intelligence-features">
                        <h2>
                            18. Artificial Intelligence Features
                            <button @click="copyLink('artificial-intelligence-features')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Some services may include AI-powered functionality.</p>
                        <p>Users acknowledge that:</p>
                        <ul>
                            <li>AI-generated content may contain inaccuracies.</li>
                            <li>Users remain responsible for verifying AI-generated outputs.</li>
                            <li>AI should not replace professional advice where accuracy is critical.</li>
                            <li>AI services may improve over time through ongoing development.</li>
                        </ul>
                    </section>

                    <section id="user-content">
                        <h2>
                            19. User Content
                            <button @click="copyLink('user-content')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>If users upload content:</p>
                        <ul>
                            <li>Users retain ownership of their content.</li>
                            <li>Users grant CleMwa Developers a limited license to process, store, display, and transmit the content solely for providing the requested services.</li>
                            <li>Users are responsible for ensuring they have the necessary rights to upload such content.</li>
                        </ul>
                    </section>

                    <section id="confidentiality">
                        <h2>
                            20. Confidentiality
                            <button @click="copyLink('confidentiality')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Both parties agree to protect confidential information exchanged during the course of providing services.</p>
                        <p>Confidential information shall not be disclosed except where required by law or with written consent.</p>
                    </section>

                    <section id="limitation-of-liability">
                        <h2>
                            21. Limitation of Liability
                            <button @click="copyLink('limitation-of-liability')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>To the fullest extent permitted by law:</p>
                        <ul>
                            <li>CleMwa Developers shall not be liable for indirect, incidental, special, consequential, or punitive damages.</li>
                            <li>Our total liability arising from the use of our services shall not exceed the amount paid by the customer for the relevant service during the preceding twelve (12) months, unless otherwise required by law.</li>
                        </ul>
                        <p>Nothing in these Terms limits liability where such limitation is prohibited by applicable law.</p>
                    </section>

                    <section id="indemnification">
                        <h2>
                            22. Indemnification
                            <button @click="copyLink('indemnification')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>You agree to indemnify and hold harmless CleMwa Developers, its employees, directors, contractors, and affiliates from claims, damages, losses, liabilities, and expenses arising from:</p>
                        <ul>
                            <li>Your misuse of the services.</li>
                            <li>Your violation of these Terms.</li>
                            <li>Your infringement of third-party rights.</li>
                            <li>Your unlawful activities.</li>
                        </ul>
                    </section>

                    <section id="suspension-and-termination">
                        <h2>
                            23. Suspension and Termination
                            <button @click="copyLink('suspension-and-termination')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>We may suspend or terminate access where users:</p>
                        <ul>
                            <li>Violate these Terms.</li>
                            <li>Engage in fraudulent activity.</li>
                            <li>Compromise system security.</li>
                            <li>Abuse our services.</li>
                            <li>Fail to meet payment obligations.</li>
                        </ul>
                        <p>Termination does not relieve users of outstanding contractual or financial obligations.</p>
                    </section>

                    <section id="changes-to-services">
                        <h2>
                            24. Changes to Services
                            <button @click="copyLink('changes-to-services')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>We reserve the right to:</p>
                        <ul>
                            <li>Modify services.</li>
                            <li>Introduce new features.</li>
                            <li>Discontinue products.</li>
                            <li>Improve functionality.</li>
                            <li>Update pricing.</li>
                            <li>Change technical requirements.</li>
                        </ul>
                        <p>Reasonable notice will be provided where appropriate.</p>
                    </section>

                    <section id="disclaimer">
                        <h2>
                            25. Disclaimer
                            <button @click="copyLink('disclaimer')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Services are provided on an "as is" and "as available" basis.</p>
                        <p>To the maximum extent permitted by law, CleMwa Developers disclaims warranties including:</p>
                        <ul>
                            <li>Merchantability</li>
                            <li>Fitness for a particular purpose</li>
                            <li>Non-infringement</li>
                            <li>Continuous availability</li>
                            <li>Error-free operation</li>
                        </ul>
                        <p>Nothing in this section excludes warranties that cannot legally be excluded.</p>
                    </section>

                    <section id="governing-law">
                        <h2>
                            26. Governing Law
                            <button @click="copyLink('governing-law')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>These Terms shall be governed by and interpreted in accordance with the laws applicable in the jurisdiction where CleMwa Developers is registered or where a separate written agreement specifies a governing law.</p>
                    </section>

                    <section id="dispute-resolution">
                        <h2>
                            27. Dispute Resolution
                            <button @click="copyLink('dispute-resolution')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Before initiating formal legal proceedings, both parties agree to make reasonable efforts to resolve disputes through good-faith discussions or other agreed dispute resolution mechanisms.</p>
                    </section>

                    <section id="severability">
                        <h2>
                            28. Severability
                            <button @click="copyLink('severability')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>If any provision of these Terms is found to be unenforceable, the remaining provisions shall continue in full force and effect.</p>
                    </section>

                    <section id="entire-agreement">
                        <h2>
                            29. Entire Agreement
                            <button @click="copyLink('entire-agreement')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>These Terms, together with our Privacy Policy and any applicable agreements, constitute the entire agreement between you and CleMwa Developers regarding the use of our services.</p>
                    </section>

                    <section id="contact-information">
                        <h2>
                            30. Contact Information
                            <button @click="copyLink('contact-information')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>If you have questions regarding these Terms, please contact us.</p>
                        <ul>
                            <li><strong>CleMwa Developers</strong></li>
                            <li>Email: <a href="mailto:legal@clemwadevelopers.com">legal@clemwadevelopers.com</a></li>
                            <li>Support: <a href="mailto:support@clemwadevelopers.com">support@clemwadevelopers.com</a></li>
                            <li>Website: <a href="https://clemwadevelopers.com">https://clemwadevelopers.com</a></li>
                        </ul>
                    </section>

                    <section id="acceptance">
                        <h2>
                            31. Acceptance
                            <button @click="copyLink('acceptance')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <div class="highlight-box important">
                            <h4>Agreement</h4>
                            <p>By accessing, downloading, installing, purchasing, or using any website, application, software, API, cloud service, or product provided by CleMwa Developers, you acknowledge that you have read, understood, and agreed to these Terms of Service.</p>
                        </div>
                        <p>If you do not agree with these Terms, you must discontinue use of our services immediately.</p>
                    </section>

                    <hr>

                    <!-- Contact Card -->
                    <div class="bg-[#1e293b] border border-slate-700 rounded-lg p-8 md:p-12 text-center mt-16 no-print">
                        <h3 class="!mt-0 !mb-4 text-[32px] font-bold text-white">Have a Question?</h3>
                        <p class="text-slate-300 text-[18px] mb-8 leading-[1.6]">
                            If you have any questions regarding these Terms of Service, please reach out to our legal team.
                        </p>
                        
                        <div class="flex flex-col md:flex-row items-center justify-center gap-6 mb-10 text-left">
                            <div>
                                <span class="block text-slate-500 uppercase tracking-wider text-xs font-bold mb-1">Legal Inquiries</span>
                                <a href="mailto:legal@clemwadevelopers.com" class="text-accent-500 font-medium hover:underline text-[16px]">legal@clemwadevelopers.com</a>
                            </div>
                            <div class="hidden md:block w-px h-10 bg-slate-700"></div>
                            <div>
                                <span class="block text-slate-500 uppercase tracking-wider text-xs font-bold mb-1">General Support</span>
                                <a href="mailto:support@clemwadevelopers.com" class="text-accent-500 font-medium hover:underline text-[16px]">support@clemwadevelopers.com</a>
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
                    { id: 'eligibility', title: '2. Eligibility' },
                    { id: 'services', title: '3. Services' },
                    { id: 'user-accounts', title: '4. User Accounts' },
                    { id: 'acceptable-use', title: '5. Acceptable Use' },
                    { id: 'intellectual-property', title: '6. Intellectual Property' },
                    { id: 'client-projects', title: '7. Client Projects' },
                    { id: 'payments', title: '8. Payments' },
                    { id: 'subscription-services', title: '9. Subscription Services' },
                    { id: 'refund-policy', title: '10. Refund Policy' },
                    { id: 'software-licensing', title: '11. Software Licensing' },
                    { id: 'third-party-services', title: '12. Third-Party Services' },
                    { id: 'mobile-applications', title: '13. Mobile Applications' },
                    { id: 'apple-app-store-terms', title: '14. Apple App Store Terms' },
                    { id: 'google-play-store-terms', title: '15. Google Play Store Terms' },
                    { id: 'availability', title: '16. Availability' },
                    { id: 'data-protection', title: '17. Data Protection' },
                    { id: 'artificial-intelligence-features', title: '18. AI Features' },
                    { id: 'user-content', title: '19. User Content' },
                    { id: 'confidentiality', title: '20. Confidentiality' },
                    { id: 'limitation-of-liability', title: '21. Limitation of Liability' },
                    { id: 'indemnification', title: '22. Indemnification' },
                    { id: 'suspension-and-termination', title: '23. Suspension & Termination' },
                    { id: 'changes-to-services', title: '24. Changes to Services' },
                    { id: 'disclaimer', title: '25. Disclaimer' },
                    { id: 'governing-law', title: '26. Governing Law' },
                    { id: 'dispute-resolution', title: '27. Dispute Resolution' },
                    { id: 'severability', title: '28. Severability' },
                    { id: 'entire-agreement', title: '29. Entire Agreement' },
                    { id: 'contact-information', title: '30. Contact Information' },
                    { id: 'acceptance', title: '31. Acceptance' }
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
