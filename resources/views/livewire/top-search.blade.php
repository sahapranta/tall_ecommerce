<div class="max-w-2xl mx-auto overflow-hidden transition-all transform bg-white bg-opacity-50 divide-y divide-gray-500 shadow-2xl dark:bg-gray-800 dark:divide-gray-400 divide-opacity-10 rounded-xl ring-1 ring-black ring-opacity-5 dark:ring-opacity-2 backdrop-blur backdrop-filter">
    <div class="relative">
        <!-- Heroicon name: mini/magnifying-glass -->
        <svg class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-900 dark:text-gray-100 text-opacity-40" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
        </svg>
        <input wire:model="search" wire:change="searchChanged" type="text" class="w-full h-12 pr-4 text-gray-900 placeholder-gray-500 bg-transparent border-0 dark:text-gray-100 pl-11 focus:ring-0 sm:text-sm" placeholder="Search..." />
    </div>
    @if (!empty($results))


    <!-- Default state, show/hide based on command palette state. -->
    <ul class="overflow-y-auto divide-y divide-gray-500 max-h-80 scroll-py-2 divide-opacity-10">
        <li class="p-2">
            <h2 class="px-3 mt-4 mb-2 text-xs font-semibold text-gray-900 dark:text-gray-100">Recent searches</h2>
            <ul class="text-sm text-gray-700 dark:text-teal-100">
                <!-- Active: "bg-gray-900 bg-opacity-5 text-gray-900 dark:text-gray-100" -->
                <li class="flex items-center px-3 py-2 rounded-md cursor-default select-none group">
                    <!-- Not Active: "text-opacity-40" -->
                    <!-- Heroicon name: outline/folder -->
                    <svg class="flex-none w-6 h-6 text-gray-900 dark:text-gray-100 text-opacity-40" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                    </svg>
                    <span class="flex-auto ml-3 truncate">Workflow Inc. / Website Redesign</span>
                    <!-- Not Active: "hidden" -->
                    <span class="flex-none hidden ml-3 text-gray-500 dark:text-gray-200">Jump to...</span>
                </li>
            </ul>
        </li>
        <li class="p-2">
            <h2 class="sr-only">Quick actions</h2>
            <ul class="text-sm text-gray-700">
                <!-- Active: "bg-gray-900 bg-opacity-5 text-gray-900 dark:text-gray-100" -->
                <li class="flex items-center px-3 py-2 rounded-md cursor-default select-none group">
                    <!-- Not Active: "text-opacity-40" -->
                    <!-- Heroicon name: outline/document-plus -->
                    <svg class="flex-none w-6 h-6 text-gray-900 dark:text-gray-100 text-opacity-40" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <span class="flex-auto ml-3 truncate">Add new file...</span>
                    <span class="flex-none ml-3 text-xs font-semibold text-gray-500 dark:text-gray-200"><kbd class="font-sans">⌘</kbd><kbd class="font-sans">N</kbd></span>
                </li>
                <li class="flex items-center px-3 py-2 rounded-md cursor-default select-none group">
                    <!-- Heroicon name: outline/folder-plus -->
                    <svg class="flex-none w-6 h-6 text-gray-900 dark:text-gray-100 text-opacity-40" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                    </svg>
                    <span class="flex-auto ml-3 truncate">Add new folder...</span>
                    <span class="flex-none ml-3 text-xs font-semibold text-gray-500 dark:text-gray-200"><kbd class="font-sans">⌘</kbd><kbd class="font-sans">F</kbd></span>
                </li>
                <li class="flex items-center px-3 py-2 rounded-md cursor-default select-none group">
                    <!-- Heroicon name: outline/hashtag -->
                    <svg class="flex-none w-6 h-6 text-gray-900 dark:text-gray-100 text-opacity-40" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5l-3.9 19.5m-2.1-19.5l-3.9 19.5" />
                    </svg>
                    <span class="flex-auto ml-3 truncate">Add hashtag...</span>
                    <span class="flex-none ml-3 text-xs font-semibold text-gray-500 dark:text-gray-200"><kbd class="font-sans">⌘</kbd><kbd class="font-sans">H</kbd></span>
                </li>
                <li class="flex items-center px-3 py-2 rounded-md cursor-default select-none group">
                    <!-- Heroicon name: outline/tag -->
                    <svg class="flex-none w-6 h-6 text-gray-900 dark:text-gray-100 text-opacity-40" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                    </svg>
                    <span class="flex-auto ml-3 truncate">Add label...</span>
                    <span class="flex-none ml-3 text-xs font-semibold text-gray-500 dark:text-gray-200"><kbd class="font-sans">⌘</kbd><kbd class="font-sans">L</kbd></span>
                </li>
            </ul>
        </li>
    </ul>

    @else

    <div class="px-6 text-center py-14 sm:px-14">
        <!-- Heroicon name: outline/folder -->
        <svg class="w-6 h-6 mx-auto text-gray-900 dark:text-gray-100 text-opacity-40" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
        </svg>
        <p class="mt-4 text-sm text-gray-900 dark:text-gray-100">We couldn't find any products with that term. Please try again.</p>
    </div>
    @endif
</div>