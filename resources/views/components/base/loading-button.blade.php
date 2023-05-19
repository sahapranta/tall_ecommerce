@props(['loading' => false, 'disabled'=>false])
@php
$is_disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN) ? 'disabled' : '';
@endphp
<button {{ $attributes->merge(['class' => "flex items-center px-3 py-2 ml-3 text-sm font-medium text-white uppercase bg-blue-600 rounded hover:bg-blue-500 focus:outline-none focus:bg-blue-500 cursor-pointer disabled:opacity-75 disabled:cursor-not-allowed"]) }} {{ $is_disabled }}>
    {{ $slot }} @if ($loading && $target=$attributes->wire('click')->value())
    <span wire:loading wire:target="{{$target}}">
        <svg class="w-5 h-5 mx-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </span>
    @endif
</button>