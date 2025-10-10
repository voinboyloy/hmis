<?php
namespace App\Filament\Resources\EncounterResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
class PrescriptionsRelationManager extends RelationManager {
    protected static string $relationship = 'prescriptions';
    public function form(Form $form): Form { return $form->schema([Forms\Components\Select::make('medication_id')->relationship('medication', 'name')->searchable()->required(), Forms\Components\TextInput::make('dosage')->required(), Forms\Components\TextInput::make('frequency')->required(), Forms\Components\TextInput::make('duration')->required()]); }
    public function table(Table $table): Table { return $table->recordTitleAttribute('medication.name')->columns([Tables\Columns\TextColumn::make('medication.name'), Tables\Columns\TextColumn::make('dosage'), Tables\Columns\TextColumn::make('frequency')])->headerActions([Tables\Actions\CreateAction::make()])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]); }
}
