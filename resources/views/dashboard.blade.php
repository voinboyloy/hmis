<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patient Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Welcome back, {{ $patient->user->name }}! (Patient ID: {{ $patient->id }})

                    @if ($nextAppointment)
                        <h3 class="mt-4 text-lg font-semibold">Your Next Appointment:</h3>
                        <p>
                            **Date/Time:** {{ $nextAppointment->schedule->format('F j, Y g:i A') }}
                        </p>
                        <p>
                            **Doctor:** {{ $nextAppointment->doctor->name }}
                            </p>
                    @else
                        <p class="mt-4 text-red-600">You have no upcoming appointments.</p>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <livewire:patient-dashboard :patient="$patient" />
            </div>
        </div>
    </div>
</x-app-layout>
