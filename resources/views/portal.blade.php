<x-guest-layout>
    <div class="mb-4 text-center">
        <h1 class="text-2xl font-bold">Patient Portal</h1>
    </div>

    <div class="text-gray-600">
        <p class="mb-4">
            Welcome to the patient portal. Please log in to access your health records, appointments, and more.
        </p>

        <div class="mt-6">
            <a href="{{ route('login') }}" class="w-full flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Log In
            </a>
        </div>

        <div class="mt-4 text-center">
            <p class="text-sm">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Register here
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
