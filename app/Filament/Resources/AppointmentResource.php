<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\EncounterResource;
use App\Models\Appointment;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;
    // protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Clinical';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('patient_id')
                    ->label('Patient')
                    ->relationship('patient', 'first_name')
                    ->getOptionLabelFromRecordUsing(fn (Patient $record) => "{$record->first_name} {$record->last_name}")
                    ->searchable(['first_name', 'last_name'])
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label('Doctor')
                    ->relationship('doctor', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\DateTimePicker::make('schedule')->required()->minDate(now()),
                Forms\Components\Select::make('status')
                    ->options(['Scheduled' => 'Scheduled', 'Confirmed' => 'Confirmed', 'Completed' => 'Completed', 'Canceled' => 'Canceled'])
                    ->required()->default('Scheduled'),
                Forms\Components\Textarea::make('reason')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient.first_name')->label('Patient')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('doctor.name')->label('Doctor')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('schedule')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Scheduled' => 'gray', 'Confirmed' => 'warning', 'Completed' => 'success', 'Canceled' => 'danger',
                    })->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('Create Encounter')
                    ->url(fn (Appointment $record) => EncounterResource::getUrl('create', ['appointment_id' => $record->id, 'patient_id' => $record->patient_id]))
                    ->icon('heroicon-o-plus-circle')
                    ->visible(fn (Appointment $record): bool => is_null($record->encounter)),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
