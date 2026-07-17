<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Project;
use App\Models\FlagshipProduct;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\ContactSetting;

class SiteOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $contactSettings = ContactSetting::first();

        return [
            Stat::make('Total Projects', Project::count())
                ->description('Projects in portfolio')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('primary'),

            Stat::make('Live Products', FlagshipProduct::where('is_live', true)->count())
                ->description('Total flagship products')
                ->descriptionIcon('heroicon-m-rocket-launch')
                ->color('success'),

            Stat::make('Services Offered', Service::count())
                ->description('Active services')
                ->descriptionIcon('heroicon-m-server-stack')
                ->color('warning'),

            Stat::make('Team Members', TeamMember::count())
                ->description('Active engineering staff')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
        ];
    }
}
