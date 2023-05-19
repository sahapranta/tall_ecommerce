<div class="flow-root ml-4 lg:ml-6">
    <a href="#" x-on:click="cart=true" class="flex items-center p-2 -m-2 group">
        <svg class="flex-shrink-0 w-6 h-6 text-gray-400 group-hover:text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
        </svg>
        @if ($cartCount)
        <span class="px-2 py-1 mb-2 -ml-1 font-medium leading-none tracking-wide text-white rounded-full group-hover:text-gray-200 bg-rose-500 dark:text-white">{{$cartCount<100?$cartCount:'99+'}}</span>
        @else
        <span class="ml-2 font-medium text-gray-700 text-md dark:text-white group-hover:text-gray-800 dark:group-hover:text-gray-300">{{$cartCount}}</span>
        @endif
        <span class="sr-only">items in cart, view bag</span>
    </a>
</div>