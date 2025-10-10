<?php

namespace App\Filament\Widgets;

use App\Models\Medication;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LowStockAlertsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $lowStockThreshold = 10;
        $lowStockCount = Medication::where('quantity', '<', $lowStockThreshold)->count();

        $lowStockMedications = Medication::where('quantity', '<', $lowStockThreshold)
            ->orderBy('quantity', 'asc')
            ->get();

        $description = $lowStockMedications->map(function ($medication) {
            return $medication->name . ' (' . $medication->quantity . ')';
        })->implode(', ');

        return [
            Stat::make('Low Stock Medications', $lowStockCount)
                ->description($description)
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
        ];
    }
}