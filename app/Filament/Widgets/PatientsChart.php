<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class PatientsChart extends ChartWidget
{
    protected static ?string $heading = 'New Patient Registrations';
    protected static ?int $sort = 2; // Sort order on the dashboard

    protected function getData(): array
    {
        $data = Patient::select('created_at')
            ->get()
            ->groupBy(function ($patient) {
                return Carbon::parse($patient->created_at)->format('M Y'); // Group by month and year
            })
            ->map(function ($group) {
                return count($group);
            });

        // Ensure we have data for the last 12 months
        $labels = [];
        for ($i = 11; $i >= 0; $i--) {
            $labels[] = Carbon::now()->subMonths($i)->format('M Y');
        }

        $chartData = [];
        foreach ($labels as $label) {
            $chartData[] = $data[$label] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'New Patients',
                    'data' => $chartData,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
