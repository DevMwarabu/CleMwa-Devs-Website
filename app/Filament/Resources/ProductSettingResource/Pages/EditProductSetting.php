<?php

namespace App\Filament\Resources\ProductSettingResource\Pages;

use App\Filament\Resources\ProductSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductSetting extends EditRecord
{
    protected static string $resource = ProductSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
