<?php

namespace App\Filament\Resources\FlagshipProductResource\Pages;

use App\Filament\Resources\FlagshipProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFlagshipProducts extends ListRecords
{
    protected static string $resource = FlagshipProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
