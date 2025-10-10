<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;
    // protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Billing';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Invoice Details')
                    ->schema([
                        Forms\Components\Select::make('patient_id')->relationship('patient', 'first_name')->disabled(),
                        Forms\Components\Select::make('encounter_id')->relationship('encounter', 'id')->label('Encounter ID')->disabled(),
                        Forms\Components\TextInput::make('total_amount')->numeric()->prefix('$')->disabled(),
                        Forms\Components\TextInput::make('paid_amount')->numeric()->prefix('$')->live(onBlur: true)->required(),
                        Forms\Components\Placeholder::make('balance')->label('Outstanding Balance')
                            ->content(fn ($get) => '$' . number_format((float) $get('total_amount') - (float) $get('paid_amount'), 2)),
                        Forms\Components\Select::make('status')
                            ->options(['Unpaid' => 'Unpaid', 'Paid' => 'Paid', 'Partially Paid' => 'Partially Paid'])->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Invoice ID')->sortable(),
                Tables\Columns\TextColumn::make('patient.first_name')->label('Patient')->searchable(),
                Tables\Columns\TextColumn::make('total_amount')->money('usd')->sortable(),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn (string $state): string => match ($state) { 'Unpaid' => 'danger', 'Partially Paid' => 'warning', 'Paid' => 'success', }),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->actions([Tables\Actions\ViewAction::make(), Tables\Actions\EditAction::make()]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            //'view' => Pages\ViewInvoice::route('/{record}'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
