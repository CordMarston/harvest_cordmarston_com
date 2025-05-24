<?php

namespace App\Filament\Resources\CompanyProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyRelationManager extends RelationManager
{
    protected static string $relationship = 'projects';

    protected static ?string $icon = 'heroicon-o-briefcase';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
                Forms\Components\Select::make('company_id')
                    ->relationship('company', 'name')
                    ->reactive()
                    ->searchable()
                    ->default(fn(RelationManager $livewire) => $livewire->getOwnerRecord()->id)
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                Forms\Components\Select::make('company_location_id')
                    ->label('Location')
                    ->placeholder('Select a location')
                    ->options(function ($get) {
                        $companyId = $get('company_id');
                        if (!$companyId) {
                            return [];
                        }

                        return \App\Models\CompanyLocation::where('company_id', $companyId)
                            ->pluck('name', 'id');
                    })
                    ->required()
                    ->reactive()
                    ->searchable()
                    ->disabled(fn($get) => $get('company_id') === null),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
