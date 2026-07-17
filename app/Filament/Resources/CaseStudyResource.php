<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CaseStudyResource\Pages;
use App\Filament\Resources\CaseStudyResource\RelationManagers;
use App\Models\CaseStudy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CaseStudyResource extends Resource
{
    protected static ?string $model = CaseStudy::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $navigationGroup = 'Portfolio';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('project_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('industry')
                    ->maxLength(255),
                Forms\Components\TextInput::make('client_name')
                    ->maxLength(255),
                Forms\Components\Textarea::make('challenge')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('solution')
                    ->columnSpanFull(),
                Forms\Components\TagsInput::make('technologies')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('project_outcome')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image_url')
                    ->image(),
                Forms\Components\TextInput::make('link')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_featured')
                    ->required(),
                Forms\Components\TextInput::make('order_column')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('industry')
                    ->searchable(),
                Tables\Columns\TextColumn::make('client_name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_url'),
                Tables\Columns\TextColumn::make('link')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                Tables\Columns\TextColumn::make('order_column')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListCaseStudies::route('/'),
            'create' => Pages\CreateCaseStudy::route('/create'),
            'edit' => Pages\EditCaseStudy::route('/{record}/edit'),
        ];
    }
}
