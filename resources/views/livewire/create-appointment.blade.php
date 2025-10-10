<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
    <h3 class="text-lg font-semibold text-gray-900">Schedule New Appointment</h3>

    <form wire:submit.prevent="createAppointment">
        <div class="mt-4">
            <label for="doctor" class="block text-sm font-medium text-gray-700">Doctor</label>
            <select wire:model="doctor_id" id="doctor" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Select a doctor</option>
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                @endforeach
            </select>
            @error('doctor_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            <label for="schedule" class="block text-sm font-medium text-gray-700">Date and Time</label>
            <input wire:model="schedule" type="datetime-local" id="schedule" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('schedule') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Appointment</label>
            <textarea wire:model="reason" id="reason" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
            @error('reason') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mt-6">
            <x-filament::button type="submit">
                Submit Appointment
            </x-filament::button>
        </div>
    </form>
</div>
