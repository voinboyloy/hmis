<?php

namespace App\Filament\Pages;

use App\Filament\Resources\AppointmentResource;
use App\Models\Appointment;
use Filament\Pages\Page;
use Saade\FilamentFullCalendar\Actions;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

// The class should extend FullCalendarWidget directly, not Page
class AppointmentCalendar extends FullCalendarWidget
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Clinical';

    public function fetchEvents(array $fetchInfo): array
    {
        return Appointment::query()
            ->with(['patient', 'doctor']) // Eager load relationships for performance
            ->where('schedule', '>=', $fetchInfo['start'])
            ->where('schedule', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (Appointment $appointment) => [
                    'id' => $appointment->id,
                    'title' => "{$appointment->patient->first_name} w/ {$appointment->doctor->name}",
                    'start' => $appointment->schedule,
                    'end' => $appointment->schedule->addHour(), // Assumes a 1-hour appointment
                    'url' => AppointmentResource::getUrl('edit', ['record' => $appointment]),
                    'shouldOpenUrlInNewTab' => false,
                    // Add colors based on status for better visibility
                    'color' => match ($appointment->status) {
                        'Scheduled' => '#64748b', // Slate
                        'Confirmed' => '#f59e0b', // Amber
                        'Completed' => '#10b981', // Emerald
                        'Canceled' => '#ef4444', // Red
                        default => '#6b7280',
                    },
                ]
            )
            ->all();
    }
}

