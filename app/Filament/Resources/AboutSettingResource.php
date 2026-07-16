<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutSettingResource\Pages;
use App\Filament\Resources\AboutSettingResource\RelationManagers;
use App\Models\AboutSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutSettingResource extends Resource
{
    protected static ?string $model = AboutSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('hero_title')
                    ->maxLength(255),
                Forms\Components\Textarea::make('hero_description')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('overview')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('our_story')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('mission')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('vision')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('development_philosophy')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('culture_description')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('careers_preview')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('cta_heading')
                    ->maxLength(255),
                Forms\Components\Textarea::make('cta_description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hero_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cta_heading')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAboutSettings::route('/'),
            'create' => Pages\CreateAboutSetting::route('/create'),
            'edit' => Pages\EditAboutSetting::route('/{record}/edit'),
        ];
    }
}
