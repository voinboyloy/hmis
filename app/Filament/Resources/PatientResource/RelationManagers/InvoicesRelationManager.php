<?php

namespace App\Filament\Resources\PatientResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Tables\Columns\TernaryColumn;
use Filament\Resources\RelationManagers\RelationManager;

class InvoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'invoices';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('status')
                ->options([
                    'Unpaid' => 'Unpaid',
                    'Partially Paid' => 'Partially Paid',
                    'Paid' => 'Paid',
                ])
                ->required(),
            Forms\Components\TextInput::make('total_amount')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('paid_amount')
                ->required()
                ->numeric(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Invoice #'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Unpaid' => 'danger',
                        'Partially Paid' => 'warning',
                        'Paid' => 'success',
                    }),
                Tables\Columns\TextColumn::make('total_amount')->money('usd'),
                Tables\Columns\TextColumn::make('created_at')->date(),
            // ->headerActions([
            //     Tables\Actions\CreateAction::make(),
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
