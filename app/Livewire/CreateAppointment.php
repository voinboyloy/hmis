<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class CreateAppointment extends Component
{
    public Patient $patient;
    public $doctor_id;
    public $schedule;
    public $reason;
    public $doctors;

    public function mount(Patient $patient)
    {
        $this->patient = $patient;
        $doctorRole = Role::where('name', 'Doctor')->first();
        $this->doctors = $doctorRole ? $doctorRole->users : collect();
        $this->schedule = now()->format('Y-m-d\TH:i');
    }

    public function createAppointment()
    {
        $this->validate([
            'doctor_id' => 'required|exists:users,id',
            'schedule' => 'required|date',
            'reason' => 'required|string|max:255',
        ]);

        Appointment::create([
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor_id,
            'schedule' => $this->schedule,
            'reason' => $this->reason,
            'status' => 'scheduled',
        ]);

        $this->dispatchBrowserEvent('reload');
        $this->reset(['doctor_id', 'schedule', 'reason']);
    }

    public function render()
    {
        return view('livewire.create-appointment');
    }
}
