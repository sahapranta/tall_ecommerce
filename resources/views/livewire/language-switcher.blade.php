<x-dropdown align="right" width="48">
    <x-slot name="trigger">
        <span class="inline-flex rounded-md">
            <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-gray-200 rounded-md dark:border-gray-500 dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700">

                <x-dynamic-component :component="'flag-1x1-'. $flag " class="flex-shrink-0 w-4 mr-1 rtl:ml-2 " style="border-radius: 0.25rem" /> {{ LaravelLocalization::getCurrentLocaleName() }}

                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                </svg>
            </button>
        </span>
    </x-slot>
    <x-slot name="content">
        <div class="w-48">
            <div class="block px-4 py-2 text-xs text-gray-400">
                {{ __('Select Locale') }}
            </div>
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <x-dropdown-link rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                <div class="flex"><x-dynamic-component :component="'flag-1x1-'. placename($properties['regional'])" class="flex-shrink-0 w-4 mr-1 rtl:ml-2" /> {{ $properties['native'] }}</div>
            </x-dropdown-link>
            @endforeach
        </div>
    </x-slot>
</x-dropdown>