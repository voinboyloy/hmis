<?php

namespace App\Filament\Resources\LabOrderResource\Pages;

use App\Filament\Resources\LabOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord; // Corrected: 'ViewRecord' instead of 'view'

class ViewLabOrder extends ViewRecord // Corrected: 'ViewRecord' instead of 'Page'
{
    protected static string $resource = LabOrderResource::class;
}
