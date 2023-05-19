@props(['formAction' => false])

<div>
    @if($formAction)
    <form wire:submit.prevent="{{ $formAction }}">
    @endif
        <div class="p-4 bg-white border-b dark:bg-gray-800 sm:px-6 sm:py-4 border-gray-150">
            @if(isset($title))
            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                {{ $title }}
            </h3>
            @endif
        </div>
        <div class="px-4 bg-white dark:bg-gray-800 sm:p-6">
            <div class="space-y-6">
                {{ $content }}
            </div>
        </div>
        @if(isset($buttons))
        <div class="px-4 pb-5 bg-white dark:bg-gray-800 sm:px-4 sm:flex">
            {{ $buttons }}
        </div>
        @endif
    @if($formAction)
    </form>
    @endif
</div>