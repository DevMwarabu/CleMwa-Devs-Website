<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobListingResource\Pages;
use App\Filament\Resources\JobListingResource\RelationManagers;
use App\Models\JobListing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobListingResource extends Resource
{
    protected static ?string $model = JobListing::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('department')
                    ->maxLength(255),
                Forms\Components\TextInput::make('location')
                    ->maxLength(255),
                Forms\Components\Select::make('employment_type')
                    ->options([
                        'Full-time' => 'Full-time',
                        'Part-time' => 'Part-time',
                        'Contract' => 'Contract',
                        'Remote' => 'Remote',
                    ]),
                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull(),
                Forms\Components\TagsInput::make('requirements')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('responsibilities')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('salary_range')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\DateTimePicker::make('posted_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('department')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('employment_type')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('posted_at')
                    ->dateTime()
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
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
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
            'index' => Pages\ListJobListings::route('/'),
            'create' => Pages\CreateJobListing::route('/create'),
            'edit' => Pages\EditJobListing::route('/{record}/edit'),
        ];
    }
}
