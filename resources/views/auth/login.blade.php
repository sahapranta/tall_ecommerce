<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('auth.remember_me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('auth.forgot_password') }}
                </a>
                @endif

                <x-button class="ml-4">
                    {{ __('auth.login') }}
                </x-button>
            </div>
        </form>
        <div class="w-full pt-3 mt-3 text-base text-center text-gray-600">
            {{ __('auth.dont_have_account') }}
            <a href="{{route('register')}}" class="font-semibold text-indigo-500 hover:text-indigo-600">
                {{ __('auth.signup') }}
            </a>
        </div>
    </x-authentication-card>
</x-guest-layout>