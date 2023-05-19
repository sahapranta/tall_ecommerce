<div>
    <x-dropdown align="right" width="w-28">
        <x-slot name="trigger">
            <span class="inline-flex rounded-md">
                <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-gray-200 rounded-md dark:border-gray-500 dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700">
                    <span class="block">{{$activeCurrency}}</span>
                    <span class="sr-only">, change currency</span>
                </button>
            </span>
        </x-slot>
        <x-slot name="content">
            <div>
                @foreach($supported as $code => $sign)
                <x-dropdown-link href="#" class="border-bottom" wire:click.prevent="changeActiveCurrency('{{$code}}')">
                    {{ $code }} - {{ $sign }}
                </x-dropdown-link>
                @endforeach
            </div>
        </x-slot>
    </x-dropdown>
    @push('scripts')
    <script>
        window.Shopify = {
            locale: "{{ Str::replace('_', '-', LaravelLocalization::getCurrentLocaleRegional()) }}",
            currency: {
                active: '{{$activeCurrency}}'
            }
        }

        window.addEventListener('currencyUpdated', (event) => {
            window.Shopify.currency.active = event.detail.currency;
        });
    </script>
    @endpush
</div>