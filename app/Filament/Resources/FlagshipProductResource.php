<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FlagshipProductResource\Pages;
use App\Filament\Resources\FlagshipProductResource\RelationManagers;
use App\Models\FlagshipProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FlagshipProductResource extends Resource
{
    protected static ?string $model = FlagshipProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';

    protected static ?string $navigationGroup = 'Homepage';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image_url')
                    ->image(),
                Forms\Components\TextInput::make('theme_color')
                    ->required()
                    ->maxLength(255)
                    ->default('sky'),
                Forms\Components\Toggle::make('is_live')
                    ->required(),
                Forms\Components\TextInput::make('demo_link')
                    ->maxLength(255),
                Forms\Components\TextInput::make('details_link')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_url'),
                Tables\Columns\TextColumn::make('theme_color')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_live')
                    ->boolean(),
                Tables\Columns\TextColumn::make('demo_link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('details_link')
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
            'index' => Pages\ListFlagshipProducts::route('/'),
            'create' => Pages\CreateFlagshipProduct::route('/create'),
            'edit' => Pages\EditFlagshipProduct::route('/{record}/edit'),
        ];
    }
}
