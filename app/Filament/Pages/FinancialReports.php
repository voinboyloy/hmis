<?php

namespace App\Filament\Pages;

use App\Models\Invoice;
use App\Models\Service;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class FinancialReports extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static string $view = 'filament.pages.financial-reports';

    protected static ?string $navigationGroup = 'Reports';
    protected static bool $shouldRegisterNavigation = true;

    public function table(Table $table): Table
    {
        return $table
            ->query(Invoice::query())
            ->columns([
                TextColumn::make('patient.first_name')->label('Patient First Name'),
                TextColumn::make('patient.last_name')->label('Patient Last Name'),
                TextColumn::make('encounter.appointment.user.name')->label('Doctor'),
                TextColumn::make('encounter.appointment.service.name')->label('Service'),
                TextColumn::make('total_amount')->formatStateUsing(fn ($state) => number_format($state, 2))->label('Total Amount'),
                TextColumn::make('paid_amount')->formatStateUsing(fn ($state) => number_format($state, 2))->label('Paid Amount'),
                TextColumn::make('status'),
                TextColumn::make('created_at')->label('Date')->date(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('startDate'),
                        DatePicker::make('endDate'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['startDate'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['endDate'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                Filter::make('doctor')
                    ->form([
                        Select::make('doctor')
                            ->options(User::whereHas('roles', fn ($query) => $query->where('name', 'Doctor'))->pluck('name', 'id'))
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['doctor'], fn ($query, $doctorId) => $query->whereHas('encounter.appointment.user', fn ($q) => $q->where('id', $doctorId)));
                    }),
                Filter::make('service')
                    ->form([
                        Select::make('service')
                            ->options(Service::pluck('name', 'id'))
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['service'], fn ($query, $serviceId) => $query->whereHas('encounter.appointment.service', fn ($q) => $q->where('id', $serviceId)));
                    }),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->exports([
                ExcelExport::make()->fromTable(),
            ]),
        ];
    }
}
