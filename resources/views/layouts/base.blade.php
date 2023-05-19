<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
    {!! seo() !!}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    @stack('styles')
</head>

<body class="font-sans antialiased" x-data="{ darkMode: false }" x-init="
    if (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      localStorage.setItem('darkMode', JSON.stringify(true));
    }
    darkMode = JSON.parse(localStorage.getItem('darkMode'));
    if(darkMode){document.body.classList.add('dark')} else if(!darkMode){document.body.classList.remove('dark')}
    $watch('darkMode', value => {
        localStorage.setItem('darkMode', JSON.stringify(value))
        document.body.classList.toggle('dark')
    })">
    <x-top-banner />

    <div x-data="{ open: false , cart:false}" @keydown.window.escape="open = false" class="bg-white dark:bg-gray-800">
        <x-base.navbar />
        {{ $slot }}
        <!-- px-6 py-4 -->
        <div x-cloak class="relative z-40">
            <div x-show="cart" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>
            <div :class="cart ? 'translate-x-0 ease-out' : 'translate-x-full ease-in'" class="fixed top-0 right-0 z-40 w-full h-full max-w-xs overflow-hidden transition duration-300 transform bg-white border-l border-gray-300 shadow-xl dark:bg-gray-800 dark:border-gray-600">
                <livewire:cart />
            </div>
        </div>
        <x-base.footer />
        <div x-data class="absolute top-0 z-50 w-64 p-4 overflow-x-hidden inset-x-50">
            <template x-for="(toast, index) in $store.toasts.list" :key="toast.id">
                <div x-show="toast.visible" @click="$store.toasts.destroyToast(index)" x-transition:enter="transition ease-in duration-200" x-transition:enter-start="transform opacity-0 translate-y-2" x-transition:enter-end="transform opacity-100" x-transition:leave="transition ease-out duration-500" x-transition:leave-start="transform translate-x-0 opacity-100" x-transition:leave-end="transform translate-x-full opacity-0" class="flex items-center p-3 mb-3 text-white bg-gray-900 rounded shadow-lg bg-gradient-to-r" :class="{
                    'from-blue-500 to-blue-600': toast.type === 'info',
                    'from-green-500 to-green-600': toast.type === 'success',
                    'from-yellow-400 to-yellow-500': toast.type === 'warning',
                    'from-red-500 to-pink-500': toast.type === 'error',
                    }">
                    <svg x-show="toast.type == 'info'" class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <svg x-show="toast.type == 'success'" class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <svg x-show="toast.type == 'warning'" class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <svg x-show="toast.type == 'error'" class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <div x-text="toast.message"></div>
                </div>
            </template>
        </div>
    </div>

    @livewire('livewire-ui-modal')
    @livewire('notifications')
    @stack('modals')
    @livewireScripts
    @stack('scripts')
</body>

</html>