<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductSettingResource\Pages;
use App\Filament\Resources\ProductSettingResource\RelationManagers;
use App\Models\ProductSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductSettingResource extends Resource
{
    protected static ?string $model = ProductSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationGroup = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('hero_title')
                    ->maxLength(255),
                Forms\Components\Textarea::make('hero_subtitle')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('cta_heading')
                    ->maxLength(255),
                Forms\Components\Textarea::make('cta_description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('seo_title')
                    ->maxLength(255),
                Forms\Components\Textarea::make('seo_description')
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
                Tables\Columns\TextColumn::make('seo_title')
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
            'index' => Pages\ListProductSettings::route('/'),
            'create' => Pages\CreateProductSetting::route('/create'),
            'edit' => Pages\EditProductSetting::route('/{record}/edit'),
        ];
    }
}
