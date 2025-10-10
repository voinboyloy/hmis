<?php

namespace App\Filament\Resources\EncounterResource\Pages;

use App\Filament\Resources\EncounterResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEncounter extends CreateRecord
{
    protected static string $resource = EncounterResource::class;

    public function mount(): void
    {
        parent::mount();

        $appointmentId = request()->query('appointment_id');
        $patientId = request()->query('patient_id');

        if ($appointmentId && $patientId) {
            $this->form->fill([
                'appointment_id' => $appointmentId,
                'patient_id' => $patientId,
            ]);
        }
    }
}
