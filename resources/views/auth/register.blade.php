<x-guest-layout>
    <x-slot:title>Create Account</x-slot:title>
    <x-slot:subtitle>Join our inventory management system</x-slot:subtitle>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <x-input-label for="name" :value="__('Full Name')" class="block text-sm font-medium text-gray-700 mb-1" />
            <x-text-input id="name" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name" 
                placeholder="Enter your full name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-600 text-sm" />
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 mb-1" />
            <x-text-input id="email" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autocomplete="username" 
                placeholder="Enter your email address" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-600 text-sm" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 mb-1" />

            <x-text-input id="password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password"
                            required 
                            autocomplete="new-password"
                            placeholder="Create a password" />

            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-600 text-sm" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-sm font-medium text-gray-700 mb-1" />

            <x-text-input id="password_confirmation" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            placeholder="Confirm your password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-600 text-sm" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-indigo-600 hover:text-indigo-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
               href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition duration-300">
                {{ __('Register') }}
            </x-primary-button>
        </div>
        
        <div class="mt-6 text-center">
            <p class="text-gray-600 text-sm">
                By registering, you agree to our 
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Terms of Service</a> 
                and 
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Privacy Policy</a>.
            </p>
        </div>
    </form>
</x-guest-layout>
