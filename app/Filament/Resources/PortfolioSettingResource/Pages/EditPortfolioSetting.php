<?php

namespace App\Filament\Resources\PortfolioSettingResource\Pages;

use App\Filament\Resources\PortfolioSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPortfolioSetting extends EditRecord
{
    protected static string $resource = PortfolioSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
