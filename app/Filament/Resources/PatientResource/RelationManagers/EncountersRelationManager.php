<?php

namespace App\Filament\Resources\PatientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class EncountersRelationManager extends RelationManager
{
    protected static string $relationship = 'encounters';

    public function form(Form $form): Form
    {
        return $form->schema([]); // Form is handled in EncounterResource
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('diagnosis')
            ->columns([
                Tables\Columns\TextColumn::make('appointment.schedule')->label('Date')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('diagnosis')->searchable(),
            ])
            ->actions([
                // You can add an action to view the full encounter
            ]);
    }
}
