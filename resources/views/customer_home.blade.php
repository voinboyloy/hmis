<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HMIS') }} - Customer Home</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    <link href="{{ asset('css/hmis.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-indigo-600">{{ config('app.name', 'HMIS') }}</h1>
                    </div>
                    <nav class="flex space-x-4">
                        <a href="{{ route('portal.landing') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">Home</a>
                        <a href="{{ route('portal.login') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">Login</a>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Welcome to Your Health Portal</h2>
                
                <div class="prose max-w-none">
                    <p class="text-lg text-gray-700 mb-4">
                        We're committed to providing you with easy access to your healthcare information and services.
                    </p>

                    <h3 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Getting Started</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-8 w-8 rounded-full bg-indigo-500 text-white">1</div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">Login to Your Account</h4>
                                <p class="mt-1 text-gray-600">Use your credentials to access your patient portal.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-8 w-8 rounded-full bg-indigo-500 text-white">2</div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">View Your Dashboard</h4>
                                <p class="mt-1 text-gray-600">Access your health information, appointments, and medical records.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-8 w-8 rounded-full bg-indigo-500 text-white">3</div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">Stay Connected</h4>
                                <p class="mt-1 text-gray-600">Manage appointments and communicate with your healthcare team.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 p-6 bg-indigo-50 rounded-lg">
                        <h3 class="text-xl font-semibold text-indigo-900 mb-2">Need Help?</h3>
                        <p class="text-indigo-700">
                            If you're having trouble accessing your account or have questions about your healthcare information, 
                            please contact our support team.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('portal.login') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Go to Login
                            </a>
                        </div>
                    </div>
                </div>
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
