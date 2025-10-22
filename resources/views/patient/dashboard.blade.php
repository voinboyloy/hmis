<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HMIS') }} - Patient Dashboard</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    <link href="{{ asset('css/hmis.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-indigo-600">{{ config('app.name', 'HMIS') }}</h1>
                    </div>
                    <nav class="flex items-center space-x-4">
                        <span class="text-gray-700">Welcome, {{ $patient['name'] ?? 'Patient' }}</span>
                        <a href="{{ route('portal.logout') }}" class="text-red-600 hover:text-red-700 px-3 py-2">Logout</a>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Patient Information Card -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Patient Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="text-lg font-medium text-gray-900">{{ $patient['name'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Patient ID</p>
                        <p class="text-lg font-medium text-gray-900">{{ $patient['id'] ?? $patient['patient_id'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Date of Birth</p>
                        <p class="text-lg font-medium text-gray-900">{{ $patient['date_of_birth'] ?? $patient['dob'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Contact</p>
                        <p class="text-lg font-medium text-gray-900">{{ $patient['phone'] ?? $patient['contact'] ?? 'N/A' }}</p>
                    </div>
                    @if(isset($patient['email']))
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-lg font-medium text-gray-900">{{ $patient['email'] }}</p>
                    </div>
                    @endif
                    @if(isset($patient['address']))
                    <div>
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="text-lg font-medium text-gray-900">{{ $patient['address'] }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Appointments Section -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Upcoming Appointments</h2>
                @if(count($appointments) > 0)
                    <div class="space-y-4">
                        @foreach($appointments as $appointment)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">
                                            {{ $appointment['title'] ?? $appointment['type'] ?? 'Appointment' }}
                                        </h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Doctor: {{ $appointment['doctor'] ?? $appointment['provider'] ?? 'N/A' }}
                                        </p>
                                        @if(isset($appointment['department']))
                                        <p class="text-sm text-gray-500">
                                            Department: {{ $appointment['department'] }}
                                        </p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-indigo-600">
                                            {{ $appointment['date'] ?? $appointment['scheduled_date'] ?? 'N/A' }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $appointment['time'] ?? $appointment['scheduled_time'] ?? '' }}
                                        </p>
                                        @if(isset($appointment['status']))
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $appointment['status'] === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($appointment['status']) }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No upcoming appointments</p>
                    </div>
                @endif
            </div>

            <!-- Medical Records Section -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Medical Records</h2>
                @if(count($medicalRecords) > 0)
                    <div class="space-y-4">
                        @foreach($medicalRecords as $record)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            {{ $record['title'] ?? $record['type'] ?? 'Medical Record' }}
                                        </h3>
                                        @if(isset($record['description']))
                                        <p class="text-sm text-gray-600 mt-1">{{ $record['description'] }}</p>
                                        @endif
                                        @if(isset($record['diagnosis']))
                                        <p class="text-sm text-gray-600 mt-1">Diagnosis: {{ $record['diagnosis'] }}</p>
                                        @endif
                                        @if(isset($record['treatment']))
                                        <p class="text-sm text-gray-600 mt-1">Treatment: {{ $record['treatment'] }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right ml-4">
                                        <p class="text-sm text-gray-500">
                                            {{ $record['date'] ?? $record['record_date'] ?? 'N/A' }}
                                        </p>
                                        @if(isset($record['doctor']))
                                        <p class="text-xs text-gray-500 mt-1">
                                            Dr. {{ $record['doctor'] }}
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No medical records available</p>
                    </div>
                @endif
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'HMIS') }}. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
