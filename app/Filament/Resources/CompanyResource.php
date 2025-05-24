<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Symfony\Component\Intl\Countries;
use App\Constants\States;
use App\Filament\Resources\CompanyProjectResource\RelationManagers\CompanyRelationManager;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(6),

                TextInput::make('website')
                    ->maxLength(255)
                    ->columnSpan(6),

                Repeater::make('locations')
                    ->label('Locations')
                    ->relationship()
                    ->columns(12) // Use 12-column layout inside repeater
                    ->columnSpan(12)
                    ->itemLabel(fn($state) => $state['label'] ?? 'New Address')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->nullable()
                            ->maxLength(50)
                            ->reactive()
                            ->required()
                            ->columnSpan(12), // full width

                        Select::make('country')
                            ->label('Country')
                            ->options(Countries::getNames())
                            ->searchable()
                            ->placeholder('Select a country')
                            ->required()
                            ->columnSpan(2),

                        TextInput::make('address')
                            ->label('Street')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(3),

                        TextInput::make('city')
                            ->label('City')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(3),

                        Select::make('state')
                            ->label('State')
                            ->options(States::us())
                            ->searchable()
                            ->placeholder('Select a state')
                            ->required()
                            ->columnSpan(2),

                        TextInput::make('postal_code')
                            ->label('Postal Code')
                            ->nullable()
                            ->maxLength(20)
                            ->required()
                            ->columnSpan(2),
                    ]),

                FileUpload::make('logo')
                    ->label('Company Logo')
                    ->directory('company-logos')
                    ->columnSpan(6),
            ])
            ->columns(12); // Overall form layout
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('logo')
                    ->circular(),
                Tables\Columns\TextColumn::make('website')
                    ->searchable(),
                Tables\Columns\TextColumn::make('locations_count')
                    ->label('Locations')
                    ->counts('locations'),
                Tables\Columns\TextColumn::make('projects_count')
                    ->label('Projects')
                    ->counts('projects'),
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
            CompanyRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
