<x-guest-layout>
    <x-slot:title>Login</x-slot:title>
    <x-slot:subtitle>Sign in to your account</x-slot:subtitle>
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 mb-1" />
            <x-text-input id="email" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username" 
                placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-600 text-sm" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 mb-1" />

            <x-text-input id="password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password"
                            required 
                            autocomplete="current-password"
                            placeholder="Enter your password" />

            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-600 text-sm" />
        </div>

        <!-- Remember Me -->
        <div class="block mb-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-indigo-600 hover:text-indigo-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
                   href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition duration-300">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        
        <div class="mt-6 text-center">
            <p class="text-gray-600 text-sm">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Register here
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
