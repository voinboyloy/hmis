<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Infolists\Components\Actions as InfolistActions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Contracts\View\View;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('print')
                ->label('Print Invoice')
                ->color('info')
                ->icon('heroicon-o-printer')
                ->url(fn (): string => route('filament.admin.resources.invoices.print', ['record' => $this->record->id]))
                ->openUrlInNewTab(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Split::make([
                    Grid::make(2)
                        ->schema([
                            Section::make('Invoice Information')
                                ->schema([
                                    TextEntry::make('id')
                                        ->label('Invoice ID')
                                        ->badge(),
                                    TextEntry::make('status')
                                        ->badge()
                                        ->color(fn (string $state): string => match ($state) {
                                            'Unpaid' => 'danger',
                                            'Partially Paid' => 'warning',
                                            'Paid' => 'success',
                                        }),
                                    TextEntry::make('created_at')
                                        ->label('Invoice Date')
                                        ->date(),
                                ]),
                            Section::make('Patient Information')
                                ->schema([
                                    TextEntry::make('patient.full_name')
                                        ->label('Patient Name')
                                        ->weight(FontWeight::Bold),
                                    TextEntry::make('patient.phone')
                                        ->label('Phone'),
                                    TextEntry::make('patient.address')
                                        ->label('Address'),
                                ]),
                        ]),
                    Section::make('Payment Summary')
                        ->schema([
                            TextEntry::make('total_amount')
                                ->label('Total Amount')
                                ->money('usd')
                                ->size(TextEntry\TextEntrySize::Large)
                                ->weight(FontWeight::Bold),
                            TextEntry::make('paid_amount')
                                ->label('Amount Paid')
                                ->money('usd')
                                ->color('success'),
                            TextEntry::make('balance')
                                ->label('Outstanding Balance')
                                ->money('usd')
                                ->color('danger')
                                ->extraAttributes(['class' => 'border-t border-gray-200 pt-2 mt-2']),
                        ])
                        ->grow(false),
                ])->from('lg'),

                Section::make('Invoice Items')
                    ->schema([
                        InfolistActions::make([
                            Action::make('view_items')
                                ->label('View Invoice Items')
                                ->modalContent(fn (\App\Models\Invoice $record): string => $this->getInvoiceItemsTable($record))
                                ->modalSubmitAction(false)
                                ->modalCancelAction(false)
                                ->color('gray')
                                ->size('sm'),
                        ]),
                    ]),
            ]);
    }

    protected function getInvoiceItemsTable(\App\Models\Invoice $record): \Illuminate\Contracts\View\View
    {
        $items = $record->items;

        return view('invoices.partials.items-table', [
            'items' => $items,
        ]);
    }
}
