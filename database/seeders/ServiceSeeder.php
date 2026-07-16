<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::updateOrCreate(['slug' => 'web-development'], [
            'title' => 'Web Development',
            'description' => 'Tailor-made web applications engineered to address your unique business challenges with precision and scalability.',
            'content' => '<p>Our Web Development service focuses on creating modern, scalable, and secure web applications. From complex enterprise portals to fast, responsive single-page applications, we utilize cutting-edge frameworks like Laravel and React to bring your digital vision to life.</p>
                          <h3>What We Offer</h3>
                          <ul>
                              <li>Custom Web Application Development</li>
                              <li>API Design and Integration</li>
                              <li>Progressive Web Apps (PWA)</li>
                              <li>E-commerce Solutions</li>
                          </ul>',
            'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />',
            'color_theme' => 'sky',
            'image_url' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=2072&auto=format&fit=crop',
            'delay' => 0,
        ]);

        Service::updateOrCreate(['slug' => 'mobile-apps'], [
            'title' => 'Mobile Apps',
            'description' => 'Native and cross-platform mobile applications that deliver exceptional user experiences across iOS and Android.',
            'content' => '<p>Reach your users wherever they are. We specialize in building robust mobile applications that offer seamless experiences across platforms. Whether it is a native iOS/Android app or a unified cross-platform Flutter solution, we deliver high performance and beautiful UI.</p>
                          <h3>Our Mobile Capabilities</h3>
                          <ul>
                              <li>Cross-Platform App Development (Flutter, React Native)</li>
                              <li>Native iOS and Android Development</li>
                              <li>Mobile UI/UX Design</li>
                              <li>App Store Optimization and Deployment</li>
                          </ul>',
            'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />',
            'color_theme' => 'violet',
            'image_url' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?q=80&w=2070&auto=format&fit=crop',
            'delay' => 100,
        ]);

        Service::updateOrCreate(['slug' => 'ai-solutions'], [
            'title' => 'AI Solutions',
            'description' => 'Intelligent machine learning models and AI integrations to automate processes and unlock data-driven insights.',
            'content' => '<p>Unlock the power of your data with our Artificial Intelligence and Machine Learning solutions. We help businesses automate mundane tasks, predict market trends, and create intelligent systems that learn and adapt.</p>
                          <h3>Our AI Services</h3>
                          <ul>
                              <li>Machine Learning Models</li>
                              <li>Natural Language Processing (NLP)</li>
                              <li>Predictive Analytics</li>
                              <li>AI Chatbot Integration</li>
                          </ul>',
            'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />',
            'color_theme' => 'emerald',
            'image_url' => 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?q=80&w=1965&auto=format&fit=crop',
            'delay' => 200,
        ]);

        Service::updateOrCreate(['slug' => 'erp-pos'], [
            'title' => 'ERP & POS',
            'description' => 'Robust Enterprise Resource Planning and Point of Sale systems to streamline your daily operations and inventory.',
            'content' => '<p>Streamline your business operations with our comprehensive ERP and POS solutions. Designed for retail, hospitality, and complex enterprise environments, our systems integrate seamlessly to manage inventory, sales, and employee workflows in real-time.</p>
                          <h3>Core Features</h3>
                          <ul>
                              <li>Omnichannel Sales Management</li>
                              <li>Real-Time Inventory Tracking</li>
                              <li>Employee and Shift Management</li>
                              <li>Detailed Financial Reporting</li>
                          </ul>',
            'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />',
            'color_theme' => 'orange',
            'image_url' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?q=80&w=2070&auto=format&fit=crop',
            'delay' => 0,
        ]);

        Service::updateOrCreate(['slug' => 'cloud-devops'], [
            'title' => 'Cloud & DevOps',
            'description' => 'Secure, scalable cloud infrastructure and automated deployment pipelines tailored to your architecture.',
            'content' => '<p>Ensure maximum uptime and scalability for your applications. Our Cloud & DevOps experts design and manage robust architectures on AWS, Azure, and Google Cloud. We implement CI/CD pipelines to guarantee smooth, reliable, and rapid software delivery.</p>
                          <h3>What We Provide</h3>
                          <ul>
                              <li>Cloud Infrastructure Setup & Management</li>
                              <li>Continuous Integration / Continuous Deployment (CI/CD)</li>
                              <li>Containerization (Docker, Kubernetes)</li>
                              <li>Server Monitoring & Optimization</li>
                          </ul>',
            'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />',
            'color_theme' => 'teal',
            'image_url' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2072&auto=format&fit=crop',
            'delay' => 100,
        ]);
    }
}
