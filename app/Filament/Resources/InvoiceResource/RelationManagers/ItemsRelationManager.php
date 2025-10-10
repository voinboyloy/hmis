<?php
namespace App\Filament\Resources\InvoiceResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
class ItemsRelationManager extends RelationManager {
    protected static string $relationship = 'items';
    public function form(Form $form): Form {
        return $form->schema([Forms\Components\TextInput::make('description')->required(),
         Forms\Components\TextInput::make('quantity')->numeric()->required(),
          Forms\Components\TextInput::make('unit_price')->numeric()->required(),
           Forms\Components\TextInput::make('total_price')->numeric()->required()]); }
    public function table(Table $table): Table {
        return $table->recordTitleAttribute('description')
        ->columns([Tables\Columns\TextColumn::make('description'),
         Tables\Columns\TextColumn::make('quantity'),
          Tables\Columns\TextColumn::make('unit_price')->money('usd'),
           Tables\Columns\TextColumn::make('total_price')->money('usd')])
           ->headerActions([Tables\Actions\CreateAction::make()])
           ->actions([Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make()]); }
}
