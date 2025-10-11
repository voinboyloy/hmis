<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EncounterResource\Pages;
use App\Filament\Resources\EncounterResource\RelationManagers;
use App\Models\Encounter;
use App\Models\IcdCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EncounterResource extends Resource
{
    protected static ?string $model = Encounter::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static bool $shouldRegisterNavigation = false; // Hidden from main navigation

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('patient_id')->relationship('patient', 'first_name')->disabled(fn ($get) => request()->has('appointment_id'))->required(),
                Forms\Components\Select::make('appointment_id')->relationship('appointment', 'id')->disabled(fn ($get) => request()->has('appointment_id'))->required(),
                Forms\Components\Section::make('Clinical Details')
                    ->schema([
                        Forms\Components\KeyValue::make('vitals')->keyLabel('Vital Sign')->valueLabel('Value')->reorderable(),
                        Forms\Components\RichEditor::make('notes')->required()->columnSpanFull(),
                        Forms\Components\Select::make('icd_code_id')
                            ->label('ICD-10 Diagnosis')
                            ->options(IcdCode::all()->pluck('description', 'id'))
                            ->searchable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient.first_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('appointment.schedule')->label('Appointment Time')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('icdCode.code')->label('ICD Code')->searchable(),
                Tables\Columns\TextColumn::make('icdCode.description')->label('Diagnosis')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\ViewAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PrescriptionsRelationManager::class,
            RelationManagers\LabOrdersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEncounters::route('/'),
            'create' => Pages\CreateEncounter::route('/create'),
            'edit' => Pages\EditEncounter::route('/{record}/edit'),
            'view' => Pages\ViewEncounter::route('/{record}'),
        ];
    }
}
