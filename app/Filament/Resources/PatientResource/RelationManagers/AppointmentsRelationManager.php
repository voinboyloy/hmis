<?php
namespace App\Filament\Resources\PatientResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Model;

class AppointmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'appointments';
    protected static bool $shouldSkipAuthorization = true;

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')->relationship('doctor', 'name')->required(),
            Forms\Components\DateTimePicker::make('schedule')->required(),
            Forms\Components\Select::make('status')->options([
                'Scheduled' => 'Scheduled',
                'Completed' => 'Completed'
            ])->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->recordTitleAttribute('id')->columns([
            Tables\Columns\TextColumn::make('doctor.name'),
            Tables\Columns\TextColumn::make('schedule')->dateTime(),
            Tables\Columns\TextColumn::make('status')->badge(),
        ])->headerActions([
            Tables\Actions\CreateAction::make(),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }
}
