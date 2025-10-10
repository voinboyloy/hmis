<?php

namespace App\Filament\Resources\PatientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class LabOrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'labOrders';

    public function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Order ID'),
                Tables\Columns\TextColumn::make('status')->badge()->color(fn(string $state) => match($state) {
                    'Pending' => 'warning',
                    'Completed' => 'success',
                    'Canceled' => 'danger',
                }),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ]);
    }
}
