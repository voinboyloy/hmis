<?php

// app/Livewire/PatientDashboard.php
namespace App\Livewire;

use App\Models\Patient;
use Livewire\Component;

class PatientDashboard extends Component
{
    public Patient $patient;
    public bool $showCreateAppointmentForm = false;

    public function mount(Patient $patient)
    {
        $this->patient = $patient;
    }

    public function toggleCreateAppointmentForm()
    {
        $this->showCreateAppointmentForm = !$this->showCreateAppointmentForm;
    }

    public function render()
    {
        return view('livewire.patient-dashboard');
    }
}
