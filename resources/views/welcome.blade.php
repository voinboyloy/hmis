<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HMIS Pro - Health Management System</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        amber: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 antialiased">
    <div class="relative min-h-screen flex flex-col items-center justify-center">
        <!-- Header for Login/Register Links -->
        <header class="absolute top-0 right-0 p-6 text-right">
            @if (Route::has('login'))
                <nav class="flex flex-1 justify-end items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2 text-gray-700 dark:text-gray-300 ring-1 ring-transparent transition hover:text-black/70 dark:hover:text-white/80 focus:outline-none focus-visible:ring-amber-500">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-gray-700 dark:text-gray-300 ring-1 ring-transparent transition hover:text-black/70 dark:hover:text-white/80 focus:outline-none focus-visible:ring-amber-500">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-md px-3 py-2 text-white bg-amber-500 transition hover:bg-amber-600 focus:outline-none focus-visible:ring-2 ring-amber-500 ring-offset-2">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <!-- Main Content -->
        <main class="text-center">
            <div class="flex items-center justify-center space-x-4">
                <svg class="w-16 h-16 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                <h1 class="text-5xl font-bold text-gray-800 dark:text-white">HMIS Pro</h1>
            </div>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
                Your Health, Managed Securely.
            </p>
            <p class="mt-2 max-w-xl mx-auto text-gray-500 dark:text-gray-500">
                The secure portal for managing your appointments, viewing results, and connecting with your healthcare provider.
            </p>
            <div class="mt-8 flex justify-center gap-4">
                 @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="rounded-md px-5 py-3 text-base font-medium text-white bg-amber-500 transition hover:bg-amber-600 focus:outline-none focus-visible:ring-2 ring-amber-500 ring-offset-2">
                        Create Your Patient Account
                    </a>
                @else
                     <a href="{{ route('login') }}" class="rounded-md px-5 py-3 text-base font-medium text-white bg-amber-500 transition hover:bg-amber-600 focus:outline-none focus-visible:ring-2 ring-amber-500 ring-offset-2">
                        Patient Portal Login
                    </a>
                 @endif
            </div>
        </main>

        <!-- Footer -->
        <footer class="absolute bottom-0 p-6 text-center text-sm text-gray-500 dark:text-gray-400 w-full">
            &copy; {{ date('Y') }} HMIS Pro. All rights reserved.
        </footer>
    </div>
</body>
</html>
