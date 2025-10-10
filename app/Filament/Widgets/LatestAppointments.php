<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\AppointmentResource;
use App\Models\Appointment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Carbon;

class LatestAppointments extends BaseWidget
{
    protected static ?int $sort = 1; // Show this widget at the top

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Appointment::whereDate('schedule', Carbon::today())
                    ->whereNotIn('status', ['Completed', 'Canceled'])
            )
            ->columns([
                Tables\Columns\TextColumn::make('patient.first_name')
                    ->label('Patient')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('doctor.name')
                    ->label('Doctor')
                    ->sortable(),
                Tables\Columns\TextColumn::make('schedule')
                    ->label('Time')
                    ->time(),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn (Appointment $record): string => AppointmentResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
