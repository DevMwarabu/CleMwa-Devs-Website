<?php

namespace App\Filament\Resources\FlagshipProductResource\Pages;

use App\Filament\Resources\FlagshipProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFlagshipProduct extends EditRecord
{
    protected static string $resource = FlagshipProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
