<div>
    <form class="flex mt-2 sm:max-w-md" @submit.prevent>
        <label for="email-address" class="sr-only">Email address</label>
        <div class="flex flex-col">
            <input wire:model.lazy="email" id="email-address" type="text" autocomplete="email" required="" class="w-full min-w-0 px-4 py-2 text-base text-indigo-500 placeholder-gray-500 bg-white border rounded-md shadow-sm appearance-none focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('email') border-red-500 @else border-gray-300 @enderror">
            @error('email') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
            @if(!empty(config('extra.recaptcha_key')))
            @error('captcha') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
            @endif
        </div>
        <div class="flex-shrink-0 ml-4">
            @if(!empty(config('extra.recaptcha_key')))
            <button class="flex items-center justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm g-recaptcha hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" wire:click="submit">
                @else
                <button class="flex items-center justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm g-recaptcha hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" data-sitekey="{{config('extra.recaptcha_key')}}" data-callback='handle' data-action='submit'>
                    @endif
                    Signup
                    <span wire:loading wire:target="submit">
                        <svg class="w-5 h-5 mx-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
        </div>
    </form>
    @if(!empty(config('extra.recaptcha_key')))
    @push('scripts')
    <link rel="preconnect" href="https://www.google.com">
    <link rel="preconnect" href="https://www.gstatic.com" crossorigin>
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('extra.recaptcha_key') }}"></script>
    <script>
        function handle(e) {
            grecaptcha.ready(function() {
                grecaptcha.execute("{{config('extra.recaptcha_key')}}", {
                        action: 'submit'
                    })
                    .then((token) => {
                        @this.submit(token)
                    });
            })
        }
    </script>
    @endpush
    @endif
</div>