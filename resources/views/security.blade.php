<x-layouts.legal title="Security - CleMwa Developers" description="Our commitment to protecting the confidentiality, integrity, and availability of our systems.">
    <!-- Hero Section -->
    <div class="max-w-[900px] mx-auto px-4 sm:px-6 lg:px-8 text-center pt-8 pb-16 md:pt-16 md:pb-24 border-b border-slate-800">
        <h1 class="text-[32px] md:text-[48px] font-bold text-white mb-4 leading-tight">Security at CleMwa Developers</h1>
        <p class="text-[18px] md:text-[20px] text-slate-400 mb-10">Protecting your data is our highest priority.</p>
        
        <p class="text-[16px] md:text-[18px] text-slate-300 max-w-[800px] mx-auto mb-12 leading-[1.8]">
            Security is a core principle embedded throughout our software development lifecycle. We are committed to protecting the confidentiality, integrity, and availability of our systems, applications, and customer data.
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-6 sm:gap-8 text-sm text-slate-400">
            <div>
                <span class="block text-slate-500 uppercase tracking-wider text-[10px] sm:text-xs mb-1">Last Updated</span>
                <span class="text-white font-medium">July 16, 2026</span>
            </div>
            <div class="hidden sm:block w-px h-8 bg-slate-800"></div>
            <div>
                <span class="block text-slate-500 uppercase tracking-wider text-[10px] sm:text-xs mb-1">Estimated Reading Time</span>
                <span class="text-white font-medium">10 Minutes</span>
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
                    .legal-content ol { color: #cbd5e1; font-size: 18px; line-height: 1.8; margin-bottom: 1.5rem; padding-left: 1.5rem; max-width: 80ch; }
                    .legal-content ol li { margin-bottom: 0.75rem; padding-left: 0.5rem; }
                    .legal-content ol li::marker { color: #38bdf8; font-weight: bold; }
                    
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

                    <section id="principles">
                        <h2>
                            Our Security Principles
                            <button @click="copyLink('principles')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Our security program is built on the following principles:</p>
                        <ul>
                            <li>Security by Design</li>
                            <li>Privacy by Design</li>
                            <li>Defense in Depth</li>
                            <li>Least Privilege Access</li>
                            <li>Secure by Default</li>
                            <li>Continuous Monitoring</li>
                            <li>Continuous Improvement</li>
                            <li>Responsible Disclosure</li>
                        </ul>
                    </section>

                    <section id="infrastructure">
                        <h2>
                            Infrastructure Security
                            <button @click="copyLink('infrastructure')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Our infrastructure is designed with multiple layers of protection to ensure reliability and resilience.</p>
                        
                        <h3>Network Security</h3>
                        <ul>
                            <li>Enterprise-grade firewalls</li>
                            <li>Network segmentation</li>
                            <li>DDoS protection</li>
                            <li>Intrusion Detection Systems (IDS)</li>
                            <li>Intrusion Prevention Systems (IPS)</li>
                            <li>Secure DNS configuration</li>
                            <li>Web Application Firewall (WAF)</li>
                        </ul>

                        <hr class="!my-8 !border-slate-800 border-dashed">
                        
                        <h3>Hosting Security</h3>
                        <ul>
                            <li>Secure cloud infrastructure</li>
                            <li>Redundant architecture</li>
                            <li>Automatic failover</li>
                            <li>Regular infrastructure updates</li>
                            <li>Secure server hardening</li>
                            <li>Continuous infrastructure monitoring</li>
                        </ul>
                    </section>

                    <section id="data-protection">
                        <h2>
                            Data Protection
                            <button @click="copyLink('data-protection')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Protecting customer data is our highest priority.</p>
                        <p>We implement:</p>
                        <ul>
                            <li>Encryption in transit using TLS/SSL</li>
                            <li>Encryption at rest where applicable</li>
                            <li>Secure password hashing</li>
                            <li>Secure backup storage</li>
                            <li>Role-Based Access Control (RBAC)</li>
                            <li>Principle of Least Privilege</li>
                            <li>Secure database configurations</li>
                            <li>Audit logging</li>
                        </ul>
                        <div class="highlight-box security">
                            <h4>Data Security</h4>
                            <p>Sensitive information is never stored in plain text.</p>
                        </div>
                    </section>

                    <section id="application-security">
                        <h2>
                            Application Security
                            <button @click="copyLink('application-security')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Our software is developed using secure coding standards and modern development practices.</p>
                        <p>Security measures include:</p>
                        <ul>
                            <li>Input validation</li>
                            <li>Output encoding</li>
                            <li>SQL Injection prevention</li>
                            <li>Cross-Site Scripting (XSS) protection</li>
                            <li>Cross-Site Request Forgery (CSRF) protection</li>
                            <li>Content Security Policy (CSP)</li>
                            <li>Secure HTTP headers</li>
                            <li>Request validation</li>
                            <li>Secure session management</li>
                            <li>Secure file upload validation</li>
                            <li>API authentication and authorization</li>
                            <li>Rate limiting</li>
                        </ul>
                    </section>

                    <section id="authentication">
                        <h2>
                            Authentication & Access Control
                            <button @click="copyLink('authentication')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>To protect user accounts and systems, we implement:</p>
                        <ul>
                            <li>Strong password policies</li>
                            <li>Password hashing using modern algorithms</li>
                            <li>Multi-Factor Authentication (where supported)</li>
                            <li>Secure session management</li>
                            <li>Session expiration</li>
                            <li>Login attempt throttling</li>
                            <li>Account lockout protection</li>
                            <li>Device verification (where applicable)</li>
                            <li>Role-Based Access Control (RBAC)</li>
                        </ul>
                    </section>

                    <section id="api-security">
                        <h2>
                            API Security
                            <button @click="copyLink('api-security')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Our APIs are secured through multiple layers of protection.</p>
                        <p>Features include:</p>
                        <ul>
                            <li>HTTPS-only communication</li>
                            <li>Token-based authentication</li>
                            <li>Authorization controls</li>
                            <li>Input validation</li>
                            <li>Request throttling</li>
                            <li>Rate limiting</li>
                            <li>API versioning</li>
                            <li>Access logging</li>
                            <li>Secure error handling</li>
                        </ul>
                    </section>

                    <section id="mobile-security">
                        <h2>
                            Mobile Application Security
                            <button @click="copyLink('mobile-security')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Applications published through the <strong>Apple App Store</strong> and <strong>Google Play Store</strong> are developed to meet platform security expectations and applicable developer policies.</p>
                        <p>Security features may include:</p>
                        <ul>
                            <li>Secure authentication</li>
                            <li>Encrypted communication</li>
                            <li>Secure local data storage</li>
                            <li>Permission-based access</li>
                            <li>Biometric authentication support</li>
                            <li>Device integrity verification</li>
                            <li>Secure offline data synchronization</li>
                            <li>Automatic security updates</li>
                        </ul>
                        <p>Applications request only the permissions necessary to provide their intended functionality.</p>
                    </section>

                    <section id="ssdlc">
                        <h2>
                            Secure Software Development Lifecycle
                            <button @click="copyLink('ssdlc')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Security is integrated throughout every stage of development.</p>
                        <p>Our lifecycle includes:</p>
                        <ol>
                            <li>Requirements Analysis</li>
                            <li>Secure Architecture Design</li>
                            <li>Secure Coding</li>
                            <li>Code Review</li>
                            <li>Automated Testing</li>
                            <li>Security Testing</li>
                            <li>Quality Assurance</li>
                            <li>Deployment Validation</li>
                            <li>Continuous Monitoring</li>
                            <li>Ongoing Maintenance</li>
                        </ol>
                    </section>

                    <section id="monitoring">
                        <h2>
                            Monitoring & Threat Detection
                            <button @click="copyLink('monitoring')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>We continuously monitor our infrastructure and applications to identify potential threats.</p>
                        <p>Monitoring includes:</p>
                        <ul>
                            <li>System health</li>
                            <li>Performance metrics</li>
                            <li>Failed login attempts</li>
                            <li>Suspicious activities</li>
                            <li>Application errors</li>
                            <li>Security events</li>
                            <li>Infrastructure availability</li>
                            <li>Audit logs</li>
                        </ul>
                        <p>Alerts are generated for unusual or potentially malicious activities.</p>
                    </section>

                    <section id="vulnerability-management">
                        <h2>
                            Vulnerability Management
                            <button @click="copyLink('vulnerability-management')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>We continuously improve our security posture through:</p>
                        <ul>
                            <li>Regular security assessments</li>
                            <li>Dependency scanning</li>
                            <li>Security patch management</li>
                            <li>Infrastructure reviews</li>
                            <li>Configuration audits</li>
                            <li>Secure software updates</li>
                            <li>Third-party library monitoring</li>
                        </ul>
                    </section>

                    <section id="backup-recovery">
                        <h2>
                            Backup & Disaster Recovery
                            <button @click="copyLink('backup-recovery')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>To ensure business continuity, we maintain comprehensive backup and recovery procedures.</p>
                        <p>These include:</p>
                        <ul>
                            <li>Automated backups</li>
                            <li>Encrypted backup storage</li>
                            <li>Redundant storage</li>
                            <li>Disaster recovery planning</li>
                            <li>Recovery testing</li>
                            <li>Business continuity planning</li>
                        </ul>
                    </section>

                    <section id="privacy-compliance">
                        <h2>
                            Privacy & Compliance
                            <button @click="copyLink('privacy-compliance')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>Our security practices support compliance with applicable privacy and data protection requirements.</p>
                        <p>Where applicable, we align our practices with recognized security and privacy standards and continuously review our controls to address evolving risks.</p>
                        <p>For information on how we collect and process personal data, please refer to our <a href="/privacy-policy">Privacy Policy</a>.</p>
                    </section>

                    <section id="responsible-disclosure">
                        <h2>
                            Responsible Disclosure
                            <button @click="copyLink('responsible-disclosure')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>We appreciate responsible security research and encourage the responsible reporting of potential vulnerabilities.</p>
                        <p>If you discover a security issue affecting any CleMwa Developers service, please report it to us with sufficient detail to reproduce the issue.</p>
                        <p>When reporting vulnerabilities, we ask that you:</p>
                        <ul>
                            <li>Act in good faith.</li>
                            <li>Avoid disrupting our services.</li>
                            <li>Do not access or modify data that does not belong to you.</li>
                            <li>Give us reasonable time to investigate and remediate the issue before public disclosure.</li>
                        </ul>
                        <p>We are committed to investigating all legitimate security reports promptly.</p>
                    </section>

                    <section id="customer-best-practices">
                        <h2>
                            Customer Security Best Practices
                            <button @click="copyLink('customer-best-practices')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>We encourage our customers to help protect their accounts by:</p>
                        <ul>
                            <li>Using strong, unique passwords.</li>
                            <li>Enabling Multi-Factor Authentication where available.</li>
                            <li>Keeping devices and browsers updated.</li>
                            <li>Protecting account credentials.</li>
                            <li>Logging out from shared devices.</li>
                            <li>Reporting suspicious activity immediately.</li>
                            <li>Installing applications only from trusted sources.</li>
                        </ul>
                    </section>

                    <section id="incident-response">
                        <h2>
                            Security Incident Response
                            <button @click="copyLink('incident-response')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>In the event of a security incident, we follow a structured response process that includes:</p>
                        <ul>
                            <li>Detection</li>
                            <li>Containment</li>
                            <li>Investigation</li>
                            <li>Remediation</li>
                            <li>Recovery</li>
                            <li>Post-incident review</li>
                        </ul>
                        <p>Where required by applicable laws or contractual obligations, affected users or clients will be notified appropriately.</p>
                    </section>

                    <section id="contact-us">
                        <h2>
                            Contact Our Security Team
                            <button @click="copyLink('contact-us')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <p>If you have security concerns, questions, or wish to report a potential vulnerability, please contact us.</p>
                        <ul>
                            <li><strong>Security Team</strong></li>
                            <li>CleMwa Developers</li>
                            <li>Email: <a href="mailto:security@clemwadevelopers.com">security@clemwadevelopers.com</a></li>
                            <li>Support: <a href="mailto:support@clemwadevelopers.com">support@clemwadevelopers.com</a></li>
                            <li>Website: <a href="https://clemwadevelopers.com">https://clemwadevelopers.com</a></li>
                        </ul>
                    </section>

                    <section id="our-commitment">
                        <h2>
                            Our Commitment
                            <button @click="copyLink('our-commitment')" class="copy-link no-print" title="Copy link to section">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </h2>
                        <div class="highlight-box security">
                            <h4>Continuous Security</h4>
                            <p>Security is not a one-time effort—it is an ongoing commitment. We continuously evaluate, improve, and strengthen our security practices to protect our customers, partners, and the solutions we build.</p>
                        </div>
                        <p>By combining secure engineering practices, proactive monitoring, and responsible data protection, CleMwa Developers is committed to delivering reliable, secure, and trustworthy software solutions.</p>
                    </section>

                    <hr>

                    <!-- Contact Card -->
                    <div class="bg-[#1e293b] border border-slate-700 rounded-lg p-8 md:p-12 text-center mt-16 no-print">
                        <h3 class="!mt-0 !mb-4 text-[32px] font-bold text-white">Report a Vulnerability</h3>
                        <p class="text-slate-300 text-[18px] mb-8 leading-[1.6]">
                            If you believe you have found a security vulnerability in any of our systems, please let us know immediately.
                        </p>
                        
                        <div class="flex flex-col md:flex-row items-center justify-center gap-6 mb-10 text-left">
                            <div>
                                <span class="block text-slate-500 uppercase tracking-wider text-xs font-bold mb-1">Security Team</span>
                                <a href="mailto:security@clemwadevelopers.com" class="text-accent-500 font-medium hover:underline text-[16px]">security@clemwadevelopers.com</a>
                            </div>
                        </div>
                        
                        <a href="mailto:security@clemwadevelopers.com" class="inline-block bg-white text-slate-900 font-bold px-8 py-4 rounded-sm hover:bg-slate-200 transition-colors shadow-lg hover:scale-105 active:scale-95 text-[16px]">
                            Contact Security Team
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
                activeSection: 'principles',
                mobileTocOpen: false,
                sections: [
                    { id: 'principles', title: 'Our Security Principles' },
                    { id: 'infrastructure', title: 'Infrastructure Security' },
                    { id: 'data-protection', title: 'Data Protection' },
                    { id: 'application-security', title: 'Application Security' },
                    { id: 'authentication', title: 'Authentication & Access' },
                    { id: 'api-security', title: 'API Security' },
                    { id: 'mobile-security', title: 'Mobile App Security' },
                    { id: 'ssdlc', title: 'Secure Development Lifecycle' },
                    { id: 'monitoring', title: 'Monitoring & Detection' },
                    { id: 'vulnerability-management', title: 'Vulnerability Management' },
                    { id: 'backup-recovery', title: 'Backup & Recovery' },
                    { id: 'privacy-compliance', title: 'Privacy & Compliance' },
                    { id: 'responsible-disclosure', title: 'Responsible Disclosure' },
                    { id: 'customer-best-practices', title: 'Customer Best Practices' },
                    { id: 'incident-response', title: 'Incident Response' },
                    { id: 'contact-us', title: 'Contact Security Team' },
                    { id: 'our-commitment', title: 'Our Commitment' }
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
