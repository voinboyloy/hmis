<?php

namespace App\Filament\Pages;

use App\Filament\Widgets;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Pages\Dashboard\Concerns\HasFilters;

class Dashboard extends BaseDashboard
{
    // The view property is often not needed unless you have a custom view file.
    // protected static string $view = 'filament.pages.dashboard';
    
    use HasFilters;

    /**
     * Defines the form schema for the dashboard filters.
     *
     * @param Form $form
     * @return Form
     */
    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate')
                            ->label(__('Start Date')),
                        DatePicker::make('endDate')
                            ->label(__('End Date'))
                            ->afterOrEqual('startDate'), // Add validation
                    ])
                    ->columns(2),
            ]);
    }

    /**
     * Defines the widgets that should be displayed on the dashboard.
     *
     * @return array<class-string<(\Filament\Widgets\Widget)>>
     */
    public function getWidgets(): array
    {
        return [
            Widgets\StatsOverview::class,
            Widgets\LatestAppointments::class,
            Widgets\PatientsChart::class,
            
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            AccountWidget::class,
            FilamentInfoWidget::class,
            Widgets\LowStockAlertsWidget::class,
        ];
    }
}
