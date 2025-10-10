<?php

namespace App\Filament\Pages;

use App\Filament\Widgets;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFilters; // <-- Import this

class Dashboard extends BaseDashboard
{
    use HasFilters; // <-- Use the trait

    // Optional: Define a filter form
    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate'),
                        DatePicker::make('endDate'),
                    ])
                    ->columns(2),
            ]);
    }

    public function getWidgets(): array
    {
        return [
            Widgets\StatsOverview::class,
            Widgets\LatestAppointments::class,
            Widgets\PatientsChart::class,
        ];
    }
}
