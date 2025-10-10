<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LabOrderResource\Pages;
use App\Models\LabOrder;
use App\Models\LabTest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class LabOrderResource extends Resource
{
    protected static ?string $model = LabOrder::class;
    // protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationGroup = 'Clinical';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Order Information')
                    ->schema([
                        Forms\Components\Select::make('patient_id')->relationship('patient', 'first_name')->disabled(),
                        Forms\Components\Placeholder::make('tests_ordered_list')->label('Tests Ordered')
                            ->content(fn ($record) => $record ? LabTest::whereIn('id', $record->tests_ordered)->pluck('name')->join(', ') : ''),
                    ])->columns(2),
                Forms\Components\Section::make('Results')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options(['Pending' => 'Pending', 'Completed' => 'Completed', 'Canceled' => 'Canceled'])->required(),
                        Forms\Components\RichEditor::make('results_notes')->label('Result Notes')->columnSpanFull(),
                        Forms\Components\FileUpload::make('results_file_path')->label('Results Document')->disk('public')->directory('lab-results')->downloadable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Order ID')->sortable(),
                Tables\Columns\TextColumn::make('patient.first_name')->label('Patient')->searchable(),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn (string $state): string => match ($state) { 'Pending' => 'warning', 'Completed' => 'success', 'Canceled' => 'danger', }),
                Tables\Columns\TextColumn::make('tests_ordered')->label('Tests')
                    ->formatStateUsing(fn ($state) => is_array($state) ? count($state) . ' tests' : 'N/A'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([Tables\Filters\SelectFilter::make('status')
                ->options(['Pending' => 'Pending', 'Completed' => 'Completed', 'Canceled' => 'Canceled'])->default('Pending'),
            ])
            ->actions([Tables\Actions\ViewAction::make(), Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLabOrders::route('/'),
            'view' => Pages\ViewLabOrder::route('/{record}'),
            'edit' => Pages\EditLabOrder::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Results')
                    ->schema([
                        Infolists\Components\TextEntry::make('status')->badge()
                            ->color(fn (string $state): string => match ($state) { 'Pending' => 'warning', 'Completed' => 'success', 'Canceled' => 'danger', }),
                        Infolists\Components\TextEntry::make('tests_ordered')->label('Tests Ordered')
                            ->formatStateUsing(fn ($record) => LabTest::whereIn('id', $record->tests_ordered)->pluck('name')->join(', ')),
                        Infolists\Components\Actions::make([Infolists\Components\Actions\Action::make('downloadResult')
                                ->label('Download Result File')->icon('heroicon-o-arrow-down-tray')
                                ->action(fn ($record) => Storage::disk('public')->download($record->results_file_path))
                                ->visible(fn ($record) => !empty($record->results_file_path)),
                        ]),
                    ]),
            ]);
    }
}
