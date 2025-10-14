<?php

namespace App\Filament\Resources\ActivityLogResource\Pages;

use App\Filament\Resources\ActivityLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;

class ViewActivityLog extends ViewRecord
{
    protected static string $resource = ActivityLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No actions for viewing a log
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Activity Details')
                    ->schema([
                        TextEntry::make('log_name'),
                        TextEntry::make('description'),
                        TextEntry::make('event'),
                        TextEntry::make('subject_type'),
                        TextEntry::make('subject_id'),
                        TextEntry::make('causer.name')->label('Causer'),
                        TextEntry::make('properties')
                            ->formatStateUsing(fn (?array $state): string => json_encode($state, JSON_PRETTY_PRINT))
                            ->extraAttributes(['class' => 'whitespace-pre-wrap font-mono text-sm']),
                        TextEntry::make('created_at')->dateTime(),
                    ])->columns(2),
            ]);
    }
}
