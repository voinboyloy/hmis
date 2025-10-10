<?php
namespace App\Filament\Resources\EncounterResource\RelationManagers;
use App\Models\LabTest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
class LabOrdersRelationManager extends RelationManager {
    protected static string $relationship = 'labOrders';
    public function form(Form $form): Form { return $form->schema([Forms\Components\CheckboxList::make('tests_ordered')->label('Select Tests')->options(LabTest::all()->pluck('name', 'id'))->columns(3)->required(), Forms\Components\Hidden::make('status')->default('Pending')]); }
    public function table(Table $table): Table { return $table->recordTitleAttribute('id')->columns([Tables\Columns\TextColumn::make('id')->label('Order ID'), Tables\Columns\TextColumn::make('status')->badge()])->headerActions([Tables\Actions\CreateAction::make()])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]); }
}
