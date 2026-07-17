<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactSettingResource\Pages;
use App\Filament\Resources\ContactSettingResource\RelationManagers;
use App\Models\ContactSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactSettingResource extends Resource
{
    protected static ?string $model = ContactSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Contact & Leads';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('hero_title')
                    ->maxLength(255),
                Forms\Components\Textarea::make('hero_subtitle')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('general_email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('general_phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sales_email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sales_phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('support_email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('help_desk_url')
                    ->url()
                    ->maxLength(255),
                Forms\Components\TextInput::make('partnership_email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('careers_email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\Repeater::make('social_links')
                    ->schema([
                        Forms\Components\TextInput::make('platform')->required(),
                        Forms\Components\TextInput::make('url')->url()->required(),
                        Forms\Components\TextInput::make('icon'),
                    ])
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
                Tables\Columns\TextColumn::make('general_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('general_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sales_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sales_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('support_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('help_desk_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('partnership_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('careers_email')
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
            'index' => Pages\ListContactSettings::route('/'),
            'create' => Pages\CreateContactSetting::route('/create'),
            'edit' => Pages\EditContactSetting::route('/{record}/edit'),
        ];
    }
}
