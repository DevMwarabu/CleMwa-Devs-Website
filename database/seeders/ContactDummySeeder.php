<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactSetting;
use App\Models\OfficeLocation;
use App\Models\Faq;

class ContactDummySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Settings
        ContactSetting::updateOrCreate(['id' => 1], [
            'hero_title'        => 'Let\'s Build Something<br><span class="text-sky-400">Amazing Together</span>',
            'hero_subtitle'     => 'Have a project in mind? We\'d love to hear from you. Reach out to our team for consultations, support, or partnership opportunities.',
            'general_email'     => 'hello@clemwadevs.com',
            'general_phone'     => '+254 700 000 000',
            'sales_email'       => 'sales@clemwadevs.com',
            'sales_phone'       => '+254 711 111 111',
            'support_email'     => 'support@clemwadevs.com',
            'help_desk_url'     => 'https://support.clemwadevs.com',
            'partnership_email' => 'partners@clemwadevs.com',
            'careers_email'     => 'careers@clemwadevs.com',
            'social_links'      => [
                ['platform' => 'LinkedIn', 'url' => 'https://linkedin.com', 'icon' => 'fa-brands fa-linkedin'],
                ['platform' => 'Twitter', 'url' => 'https://twitter.com', 'icon' => 'fa-brands fa-x-twitter'],
                ['platform' => 'GitHub', 'url' => 'https://github.com', 'icon' => 'fa-brands fa-github'],
                ['platform' => 'Instagram', 'url' => 'https://instagram.com', 'icon' => 'fa-brands fa-instagram'],
            ],
            'seo_title'         => 'Contact Us - CleMwa Developers',
            'seo_description'   => 'Get in touch with CleMwa Developers for custom software development, enterprise solutions, and IT consulting.',
        ]);

        // 2. Office Locations
        OfficeLocation::truncate();
        
        OfficeLocation::create([
            'name'           => 'Global Headquarters',
            'address'        => '123 Tech Avenue, Silicon Savannah',
            'city'           => 'Nairobi',
            'country'        => 'Kenya',
            'phone'          => '+254 700 000 000',
            'office_hours'   => 'Mon - Fri: 8:00 AM - 5:00 PM',
            'working_hours'  => "Monday – Friday\n8:00 AM – 5:00 PM\n\nSaturday\nBy Appointment\n\nSunday\nClosed",
            'is_primary'     => true,
            'order_column'   => 1,
            'map_embed_code' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127641.19946450654!2d36.75704940562308!3d-1.3031933758064504!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f1172d84d49a7%3A0xf7cf0254b297924c!2sNairobi!5e0!3m2!1sen!2ske!4v1689324530000!5m2!1sen!2ske" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        ]);

        OfficeLocation::create([
            'name'           => 'Regional Office',
            'address'        => '45 Ocean Drive, Tech Hub',
            'city'           => 'Mombasa',
            'country'        => 'Kenya',
            'phone'          => '+254 722 222 222',
            'office_hours'   => 'Mon - Fri: 9:00 AM - 4:00 PM',
            'is_primary'     => false,
            'order_column'   => 2,
        ]);

        // 3. FAQs
        $faqs = [
            [
                'question' => 'How quickly do you respond to inquiries?',
                'answer'   => 'We aim to respond to all general inquiries within 24 business hours. If you are an existing client with an active SLA, please use your dedicated priority support channel for immediate assistance.',
                'category' => 'Contact',
            ],
            [
                'question' => 'Do you offer remote consultations?',
                'answer'   => 'Yes, we are a digital-first company. We offer consultations via Zoom, Google Meet, and Microsoft Teams to clients worldwide.',
                'category' => 'Contact',
            ],
            [
                'question' => 'Can you work with international clients?',
                'answer'   => 'Absolutely. We have successfully delivered software projects and enterprise solutions for clients across multiple continents.',
                'category' => 'Contact',
            ],
            [
                'question' => 'Do you sign Non-Disclosure Agreements (NDAs)?',
                'answer'   => 'Yes. We take intellectual property and confidentiality very seriously. We are happy to sign standard NDAs before discussing any sensitive project details.',
                'category' => 'Contact',
            ],
        ];

        foreach ($faqs as $i => $faq) {
            Faq::firstOrCreate(
                ['question' => $faq['question']],
                array_merge($faq, ['order_column' => $i])
            );
        }
    }
}
