<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Invoice;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Get the start and end dates from the dashboard filter
        $startDate = $this->filters['startDate'] ?? now()->startOfMonth();
        $endDate = $this->filters['endDate'] ?? now()->endOfMonth();

        return [
            Stat::make('Total Patients', Patient::count())
                ->description('All registered patients')
                ->color('success')
                ->icon('heroicon-o-user-group'),
            Stat::make('Appointments in Range', Appointment::whereBetween('schedule', [$startDate, $endDate])->count())
                ->description('Appointments in the selected date range')
                ->color('info')
                ->icon('heroicon-o-calendar-days'),
            Stat::make('Revenue in Range', Invoice::whereBetween('created_at', [$startDate, $endDate])->sum('paid_amount'))
                ->description('Total revenue in the selected date range')
                ->color('success')
                ->icon('heroicon-o-currency-dollar'),
        ];
    }
}
