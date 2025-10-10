{{-- resources/views/livewire/patient-dashboard.blade.php --}}
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold tracking-tight text-gray-900">
        Patient Overview
    </h2>
    <p class="mb-4 text-gray-500">
        Details for Patient ID: {{ $patient->patient_uid }}
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <h3 class="font-semibold text-gray-700">Full Name</h3>
            <p>{{ $patient->first_name }} {{ $patient->last_name }}</p>
        </div>
        <div>
            <h3 class="font-semibold text-gray-700">Date of Birth</h3>
            <p>{{ $patient->date_of_birth->format('F d, Y') }} ({{ $patient->date_of_birth->age }} years old)</p>
        </div>
        <div>
            <h3 class="font-semibold text-gray-700">Gender</h3>
            <p>{{ $patient->gender }}</p>
        </div>
        <div>
            <h3 class="font-semibold text-gray-700">Phone Number</h3>
            <p>{{ $patient->phone_number ?? 'N/A' }}</p>
        </div>
        <div class="md:col-span-2">
            <h3 class="font-semibold text-gray-700">Address</h3>
            <p>{{ $patient->address ?? 'N/A' }}</p>
        </div>
    </div>

    {{-- You can add more interactive elements here, like a button to create an appointment --}}
    <div class="mt-6">
        <x-filament::button wire:click="toggleCreateAppointmentForm">
            Schedule New Appointment
        </x-filament::button>
    </div>

    @if ($showCreateAppointmentForm)
        <div class="mt-6">
            <livewire:create-appointment :patient="$patient" />
        </div>
    @endif
</div>
