<?php

namespace App\Filament\Resources\ProductSettingResource\Pages;

use App\Filament\Resources\ProductSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductSettings extends ListRecords
{
    protected static string $resource = ProductSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
