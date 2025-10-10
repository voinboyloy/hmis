<?php

namespace App\Filament\Resources\StockBatchResource\Pages;

use App\Filament\Resources\StockBatchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStockBatch extends EditRecord
{
    protected static string $resource = StockBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
