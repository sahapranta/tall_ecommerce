<div class="relative flex flex-col justify-between h-screen shadow-xl dark:shadow-slate-500" x-data="{ subtotal:@entangle('total'), modalOpen:false,
    isConfirm: function(cb, arg){
        this.modalOpen=true;
        this.execute=cb;
        this.args=arg;
    },
     closeConfirm:function(){
        this.modalOpen=false;
        this.execute=null;
        this.args=[];
     }, execute:null, args:[] }">
    <div class="flex items-center justify-between p-4 bg-gray-800 shadow-md dark:shadow-none dark:border-b dark:border-b-gray-400 ">
        <h5 id="drawer-right-label" class="inline-flex items-center text-base font-semibold text-white">
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M6 5v1H4.667a1.75 1.75 0 00-1.743 1.598l-.826 9.5A1.75 1.75 0 003.84 19H16.16a1.75 1.75 0 001.743-1.902l-.826-9.5A1.75 1.75 0 0015.333 6H14V5a4 4 0 00-8 0zm4-2.5A2.5 2.5 0 007.5 5v1h5V5A2.5 2.5 0 0010 2.5zM7.5 10a2.5 2.5 0 005 0V8.75a.75.75 0 011.5 0V10a4 4 0 01-8 0V8.75a.75.75 0 011.5 0V10z" clip-rule="evenodd" />
            </svg>
            {{__('cart.shopping_cart')}}
        </h5>
        <button type="button" x-on:click="cart=false" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Close menu</span>
        </button>
    </div>

    @if ($couponApplied)
    <x-base.small-alert wire:click="clearCoupon">{{$coupon->code}} {{__('cart.applied_successfully')}}</x-base.small-alert>
    @endif

    <div x-show="subtotal<=0" class="px-4 py-2 mx-4 mt-4 mb-auto text-center border-2 border-dashed dark:border-gray-400">
        <img src="{{asset('images/cart-empty.svg')}}" class="w-64 h-64" alt="cart is empty" />
        <p class="mt-4 text-base font-semibold text-gray-900 dark:text-white">{{__('cart.cart_empty')}}</p>
        <p class="mt-2 text-sm font-normal text-gray-500 dark:text-gray-300">{{__('cart.not_added_yet')}}</p>
    </div>

    <div x-show="subtotal>0" class="h-full p-4 overflow-y-auto" style="scrollbar-width: thin;" wire:key="cart">
        <div class="flow-root">
            <ul role="list" class="-my-4 divide-y divide-gray-200">
                @foreach ($content as $id => $product)
                <li class="flex py-4" wire:key="{{$id}}-{{$product['slug']}}">
                    <div class="flex-shrink-0 w-16 h-16 overflow-hidden border border-gray-300 rounded-md dark:border-gray-400">
                        <img src="{{$product['thumb']}}" alt="{{$product['title']}}" class="object-cover object-center w-full h-full">
                    </div>

                    <div class="flex flex-col flex-1 ml-4">
                        <div>
                            <div class="flex justify-between text-base font-medium text-gray-900 dark:text-gray-100">
                                <h3>
                                    <a href="{{route('product.view', $product['slug'])}}">{{$product['title']}}</a>
                                </h3>
                                <p class="ml-3 whitespace-nowrap">{{format_money($product['price'])}}</p>
                            </div>
                            @foreach ($product['options'] as $key=>$option)
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-100">
                                {{$key}}:{{$option}}
                            </p>
                            @endforeach
                        </div>
                        <div class="flex items-center justify-between flex-1 text-sm">
                            <div class="flex items-center mt-2">
                                @php
                                $disallowMinus = $product['quantity'] <= 1; $disallowPlus=$product['quantity']>= $product['stock'];
                                    @endphp
                                    <button class="<?= $disallowMinus ? 'cursor-not-allowed' : '' ?> text-gray-500 dark:text-gray-300 focus:outline-none focus:text-gray-600 dark:focus:text-gray-100" wire:click="updateCartItem({{$id}}, 'minus')" <?= $disallowMinus ? 'disabled' : '' ?>>
                                        <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                    <p class="mx-2 text-gray-700 dark:text-gray-100">{{$product['quantity']}}</p>
                                    <!-- $wire.updateCartItem(id, 'plus') -->
                                    <button class="<?= $disallowPlus ? 'cursor-not-allowed' : '' ?> text-gray-500 dark:text-gray-300 focus:outline-none focus:text-gray-600 dark:focus:text-gray-100" wire:click="updateCartItem({{$id}}, 'plus')" <?= $disallowPlus ? 'disabled' : '' ?>>
                                        <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                            </div>
                            <!-- <p class="text-gray-500 dark:text-gray-100">Qty 1</p> -->

                            <div class="flex">
                                <button type="button" class="font-medium text-rose-500 hover:text-rose-400" @click="isConfirm($wire.removeFromCart, [{{$id}}])">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div x-show="subtotal>0" class="p-4 border-t border-gray-300 dark:border-gray-400 sm:px-6">
        <div class="flex justify-between text-base font-medium text-gray-900 dark:text-white">
            <p>{{__('cart.subtotal')}}</p>
            @if ($couponApplied)
            <p><span class="mr-1 text-sm text-red-400 line-through">({{format_money($total)}})</span> {{ format_money($total-$discount) }} </p>
            @else
            <p>{{format_money($total)}}</p>
            @endif
        </div>
        <p class="mt-0.5 text-sm text-gray-500 dark:text-white">{{__('cart.shipping_at_checkout')}}</p>
        <div class="mt-4">
            <div class="flex items-center justify-center">
                <div>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <input type="text" {{$couponApplied?'disabled':''}} placeholder="{{__('cart.promocode')}}" name="promo" wire:model.lazy="promo" id="promo" class="block w-full pr-10 rounded-md  focus:outline-none  sm:text-sm
                        @error('promo')
                        text-red-900 placeholder-red-300 border-red-300 focus:border-red-500 focus:ring-red-500
                        @enderror" aria-invalid="false" aria-describedby="promo-error" wire:keydown.enter="applyPromo">
                        @error('promo')<div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <!-- Heroicon name: mini/exclamation-circle -->
                            <svg class="w-5 h-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                        </div>@enderror
                    </div>
                    @error('promo')<p class="mt-2 text-sm text-red-600" id="promo-error">{{ $message }}</p>@enderror
                </div>

                <x-base.loading-button wire:click="applyPromo" wire:loading.attr="disabled" loading="true" disabled="{{$couponApplied}}">
                    <span>{{__('cart.apply')}}</span>
                </x-base.loading-button>
            </div>
        </div>
        <a href="{{route('shop.checkout')}}" class="flex items-center justify-center px-3 py-2 mt-4 text-sm font-medium text-white uppercase bg-blue-600 rounded hover:bg-blue-500 focus:outline-none focus:bg-blue-500 disabled:opacity-75 disabled:cursor-not-allowed" {{$total>0?'':'disabled'}}>
            <span>{{__('cart.checkout')}}</span>
            <svg class="w-5 h-5 mx-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg>
        </a>
    </div>

    <div x-show="modalOpen" class="absolute inset-0 z-10 w-full h-full bg-black opacity-25"></div>
    <div x-show="modalOpen" x-transition:enter="transition ease-in duration-200" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-out duration-300" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90" class="absolute right-[15%] top-[30%] z-50 p-3 bg-white rounded-lg max-w-[70%]" @click.away="closeConfirm()">
        <div class="mt-4 text-center md:mt-0 md:text-left">
            <p class="font-bold">{{ __('common.are_you_sure') }}</p>
            <p class="mt-1 text-sm text-gray-700">{{ __('cart.remove_product') }}</p>
        </div>
        <div class="mt-4 text-center md:text-right md:flex md:justify-end">
            <button class="block w-full px-2 py-1 text-sm font-semibold text-red-700 bg-red-200 rounded-lg md:inline-block md:w-auto md:ml-2 md:order-2" @click="execute instanceof Function?(execute(...args), closeConfirm()):$store.toasts.createToast('Something went Wrong, try Again', 'error')">{{ __('common.yes') }}</button>
            <button class="block w-full px-2 py-1 mt-4 text-sm font-semibold bg-gray-200 rounded-lg md:inline-block md:w-auto md:mt-0 md:order-1" @click="closeConfirm()">{{ __('common.no') }}</button>
        </div>
    </div>
</div>