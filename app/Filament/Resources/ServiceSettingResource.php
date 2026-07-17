<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceSettingResource\Pages;
use App\Filament\Resources\ServiceSettingResource\RelationManagers;
use App\Models\ServiceSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceSettingResource extends Resource
{
    protected static ?string $model = ServiceSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Services';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('hero_title')
                    ->maxLength(255),
                Forms\Components\Textarea::make('hero_subtitle')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('hero_image_url')
                    ->image(),
                Forms\Components\RichEditor::make('overview_text')
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
                Tables\Columns\ImageColumn::make('hero_image_url'),
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
            'index' => Pages\ListServiceSettings::route('/'),
            'create' => Pages\CreateServiceSetting::route('/create'),
            'edit' => Pages\EditServiceSetting::route('/{record}/edit'),
        ];
    }
}
