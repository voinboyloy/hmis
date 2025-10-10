<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;
    // protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Clinical';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')->required()->maxLength(255),
                Forms\Components\TextInput::make('last_name')->required()->maxLength(255),
                Forms\Components\DatePicker::make('date_of_birth')->required(),
                Forms\Components\Select::make('gender')->options(['Male' => 'Male', 'Female' => 'Female'])->required(),
                Forms\Components\TextInput::make('phone_number')->tel()->maxLength(255),
                Forms\Components\Textarea::make('address')->columnSpanFull(),
                Forms\Components\TextInput::make('patient_uid')->required()->maxLength(255)->default('P'.str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT))->disabledOn('edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient_uid')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('first_name')->searchable(),
                Tables\Columns\TextColumn::make('last_name')->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')->date()->sortable(),
                Tables\Columns\TextColumn::make('phone_number')->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

   // In PatientResource.php

public static function getRelations(): array
{
    return [
        RelationManagers\AppointmentsRelationManager::class,
        RelationManagers\EncountersRelationManager::class,
        RelationManagers\LabOrdersRelationManager::class,
        RelationManagers\InvoicesRelationManager::class,
    ];
}
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),

        ];
    }
}
