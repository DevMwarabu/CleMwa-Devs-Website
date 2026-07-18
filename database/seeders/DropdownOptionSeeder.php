<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DropdownOption;

class DropdownOptionSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            'project_type' => [
                'Web App', 'Mobile App', 'E-Commerce', 'SaaS',
                'Design', 'Branding', 'Consulting', 'Other',
            ],
            'project_status' => [
                'completed' => 'Completed',
                'in-progress' => 'In Progress',
                'on-hold' => 'On Hold',
            ],
        ];

        $colorThemes = [
            'sky' => '#0ea5e9',
            'violet' => '#8b5cf6',
            'rose' => '#f43f5e',
            'amber' => '#f59e0b',
            'emerald' => '#10b981',
            'teal' => '#14b8a6',
            'orange' => '#f97316',
            'pink' => '#ec4899',
        ];

        foreach ($groups as $group => $options) {
            $order = 0;
            foreach ($options as $key => $option) {
                $value = is_string($key) ? $key : $option;
                $label = is_string($key) ? $option : $option;

                DropdownOption::updateOrCreate(
                    ['group' => $group, 'value' => $value],
                    ['label' => $label, 'sort_order' => $order]
                );

                $order++;
            }
        }

        $order = 0;
        foreach ($colorThemes as $value => $hex) {
            DropdownOption::updateOrCreate(
                ['group' => 'color_theme', 'value' => $value],
                ['label' => ucfirst($value), 'color' => $hex, 'sort_order' => $order]
            );
            $order++;
        }
    }
}
