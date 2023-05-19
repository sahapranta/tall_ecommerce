<div class="max-w-2xl px-4 py-6 mx-auto lg:max-w-none sm:px-6">

    <!-- Product -->
    <div class="lg:grid lg:grid-cols-2 lg:items-center lg:gap-x-8">
        <!-- Image gallery -->
        <div class="flex flex-col-reverse" wire:ignore>
            <div class="w-full aspect-w-1 aspect-h-1">
                <div class="ta-gallery ta-gallery-aspect-hd" x-data="taGallery" data-item="ta-gallery-element" data-size="ta-gallery-size" data-active="ta-gallery-element-active" data-lazy="ta-gallery-image-lazy" data-min-height="10rem" data-start="0" data-duration="0.3s" data-origin="center center" data-timing="ease-in-out" data-autoplay="true" data-interval="5000" data-pauseonhover="true">
                    <!--- START SLIDES /-->
                    @forelse($product->media as $key => $media)
                    <div class="rounded-lg ta-gallery-element ta-gallery-anim-slide" x-cloak>
                        <figure>
                            <img src="{{$media->getUrl()}}" alt="{{$media->name}}" class="ta-gallery-image" loading="lazy" x-ref="height" />
                            <figcaption class="px-4 py-1 text-sm font-semibold text-white bg-gray-900 bg-opacity-25 ta-gallery-image-caption bg-blur-2">
                                {{$media->name}}
                            </figcaption>
                        </figure>
                    </div>
                    @empty
                    <div class="rounded-lg ta-gallery-element ta-gallery-anim-slide" x-cloak>
                        <figure>
                            <img src="{{placeholder_image()}}" alt="{{$product->title}}" class="ta-gallery-image" loading="lazy" x-ref="height" />
                            <figcaption class="px-4 py-1 text-sm font-semibold text-white bg-gray-900 bg-opacity-25 ta-gallery-image-caption bg-blur-2">
                                Product Image
                            </figcaption>
                        </figure>
                    </div>
                    @endforelse
                    <!--- START BUTTONS /-->
                    <button type="button" class="flex items-center justify-center w-10 h-10 text-white bg-black bg-opacity-75 border-2 border-white rounded-full shadow-xl ta-gallery-button -left-5 sm:left-2 focus:ring focus:ring-primary" x-on:click="previous()" x-show="loaded">
                        <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                            <path d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"></path>
                        </svg>
                    </button>
                    <button type="button" class="flex items-center justify-center w-10 h-10 text-white bg-black bg-opacity-75 border-2 border-white rounded-full shadow-xl ta-gallery-button -right-5 sm:right-2 focus:ring focus:ring-primary" x-on:click="next()" x-show="loaded">
                        <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                            <path d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path>
                        </svg>
                    </button>
                    <!--- END BUTTONS /-->
                </div>
            </div>

        </div>


        <!-- Product info -->
        <div class="px-4 mt-10 sm:mt-16 sm:px-0 lg:mt-0">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100">{{$product->title}}</h1>

            <div class="mt-3">
                <h2 class="sr-only">Product information</h2>
                <!-- Reviews -->
                <div class="flex flex-col mt-3 mb-4 md:flex-row">
                    <a href="#{{$product->category->slug}}" class="text-base font-medium text-indigo-600 md:mr-4 hover:text-indigo-500 dark:text-indigo-200 dark:hover:text-indigo-300">{{$product->category->name}}</a>
                    <h2 class="sr-only">Reviews</h2>
                    <x-review-star :review="3.9">
                        <x-slot name="prefix">
                            <p class="text-sm text-gray-700 dark:text-gray-200">
                                <span class="sr-only">3.9 out of 5 stars</span>
                            </p>
                        </x-slot>
                        <x-slot name="suffix">
                            <!-- <div aria-hidden="true" class="ml-4 text-sm text-gray-300">·</div> -->
                            <div class="flex ml-4">
                                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-200 dark:hover:text-indigo-300">{{trans_choice('product.see_all_review', 512, ['count'=>512])}}</a>
                            </div>
                        </x-slot>
                    </x-review-star>

                </div>
                <div class="flex align-center ">
                    <p class="text-4xl font-bold tracking-tight text-green-900 dark:text-gray-100">{{format_money($variant->final_price)}}</p>
                    <p class="ml-3 text-base font-bold text-gray-500"><span class="pr-1 line-through">{{format_money($variant->sale_price)}}</span>({{$variant->save_percent}} {{__('common.save')}})</p>
                </div>
                <p class="text-xs text-gray-500">{{ __('product.local_tax_included') }}</p>
            </div>

            @foreach ($variant_options as $key=>$options)
            @if ($key==='color')
            <!-- Color picker -->
            <div class="mt-6">
                <h2 class="font-medium text-gray-900 dark:text-gray-100">{{__('common.color')}}</h2>
                <fieldset x-data="{color:@entangle('color').defer}" class="mt-2">
                    <legend class="sr-only"> Choose a color </legend>
                    <div class="flex items-center space-x-3">
                        @foreach ($options as $color)
                        <label class="-m-0.5 relative rounded-full flex items-center justify-center cursor-pointer focus:outline-none ring-indigo-600" :class="{ 'ring-2 ring-offset-2': color==='{{$color['value']}}', 'cursor-not-allowed':color==='disabled' }">
                            <input x-bind:disabled="color==='disabled'" type="radio" x-model="color" name="color-choice" value="{{$color['value']}}" class="sr-only" aria-labelledby="color-choice-0-label" wire:click="changeVariant('color','{{$color['value']}}', '{{$color['variant_id']}}')">
                            <span id="color-choice-0-label" class="sr-only"> {{$color['value']}} </span>
                            <!-- I don't know why, using blade {{}} syntax here inside style shows warning -->
                            <span aria-hidden="true" class="w-8 h-8 border border-gray-400 rounded-full shadow" style="background:<?= $color['value'] ?>"></span>
                        </label>
                        @endforeach
                    </div>
                </fieldset>
            </div>

            @elseif ($key === 'size')
            <!-- Size picker -->
            <div class="mt-6">
                <div class="flex items-center">
                    <h2 class="font-medium text-gray-900 dark:text-gray-100">{{__('common.size')}}</h2>
                    <a href="#" class="ml-2 text-sm font-medium text-indigo-600 dark:text-indigo-200 hover:dark:text-indigo-300 hover:text-indigo-500">({{__('product.sizing_info')}})</a>
                </div>

                <fieldset x-data="{size:@entangle('size').defer}" class="mt-2">
                    <legend class="sr-only"> Choose a size </legend>
                    <div class="grid grid-cols-3 gap-3 sm:grid-cols-6">
                        @foreach ($options as $size)
                        <label class="flex items-center justify-center px-2 py-3 text-sm font-medium uppercase border rounded-md shadow-sm cursor-pointer sm:flex-1 focus:outline-none" :class="{ 'cursor-not-allowed': size ==='disabled', 'ring-2 ring-offset-2 ring-indigo-500': size === '{{$size['value']}}', 'bg-indigo-600 border-transparent text-white hover:bg-indigo-700': (size === '{{$size['value']}}'), 'bg-white border-gray-200 text-gray-900 hover:bg-gray-50': !(size === '{{$size['value']}}') }">
                            <input :class="{'cursor-not-allowed':size ==='disabled'}" :disabled="size==='disabled'" type="radio" x-model="size" name="size-choice" value="{{$size['value']}}" class="sr-only" aria-labelledby="size-choice-0-label" wire:click="changeVariant('size','{{$size['value']}}', '{{$size['variant_id']}}')">
                            <span id="size-choice-0-label">{{$size['value']}}</span>
                        </label>
                        @endforeach
                    </div>
                </fieldset>
            </div>
            @endif
            @endforeach

            <div class="flex mt-6">
                <button type="submit" @click.prevent="Livewire.emit('addToCart', '{{$variant->id}}')" class="flex items-center justify-center flex-1 max-w-xs px-8 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50 sm:w-full">{{__('product.add_to_cart')}}</button>

                <button type="button" class="flex items-center justify-center px-3 py-3 ml-4 text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-50">
                    <span class="hidden mr-2 text-base sm:block">{{__('product.add_to_favourite')}}</span>
                    <svg class="flex-shrink-0 w-6 h-6" x-description="Heroicon name: outline/heart" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Descriptions -->
    <section aria-labelledby="product-description">
        <div class="mt-10">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-50">Description</h2>
            <div class="mt-4 text-base prose-sm prose text-gray-600 dark:text-gray-100">
                <p>{!! $product->description !!}</p>
            </div>
        </div>
    </section>

    <!-- Policies -->
    <section aria-labelledby="policies-heading" class="mt-10">
        <h2 id="policies-heading" class="sr-only">Our Policies</h2>

        <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-4">

            <div class="p-6 text-center border border-gray-200 rounded-lg dark:border-gray-400 bg-gray-50 dark:bg-gray-600">
                <dt>
                    <svg class="flex-shrink-0 w-6 h-6 mx-auto text-gray-400 dark:text-gray-200" x-description="Heroicon name: outline/globe-americas" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.115 5.19l.319 1.913A6 6 0 008.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 002.288-4.042 1.087 1.087 0 00-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 01-.98-.314l-.295-.295a1.125 1.125 0 010-1.591l.13-.132a1.125 1.125 0 011.3-.21l.603.302a.809.809 0 001.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 001.528-1.732l.146-.292M6.115 5.19A9 9 0 1017.18 4.64M6.115 5.19A8.965 8.965 0 0112 3c1.929 0 3.716.607 5.18 1.64"></path>
                    </svg>
                    <span class="mt-4 text-sm font-medium text-gray-900 dark:text-gray-100">International delivery</span>
                </dt>
                <dd class="mt-1 text-sm text-gray-500 dark:text-gray-200">Get your order in 2 years</dd>
            </div>

            <div class="p-6 text-center border border-gray-200 rounded-lg dark:border-gray-400 bg-gray-50 dark:bg-gray-600">
                <dt>
                    <svg class="flex-shrink-0 w-6 h-6 mx-auto text-gray-400 dark:text-gray-200" x-description="Heroicon name: outline/globe-americas" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.115 5.19l.319 1.913A6 6 0 008.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 002.288-4.042 1.087 1.087 0 00-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 01-.98-.314l-.295-.295a1.125 1.125 0 010-1.591l.13-.132a1.125 1.125 0 011.3-.21l.603.302a.809.809 0 001.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 001.528-1.732l.146-.292M6.115 5.19A9 9 0 1017.18 4.64M6.115 5.19A8.965 8.965 0 0112 3c1.929 0 3.716.607 5.18 1.64"></path>
                    </svg>
                    <span class="mt-4 text-sm font-medium text-gray-900 dark:text-gray-100">International delivery</span>
                </dt>
                <dd class="mt-1 text-sm text-gray-500 dark:text-gray-200">Get your order in 2 years</dd>
            </div>

            <div class="p-6 text-center border border-gray-200 rounded-lg dark:border-gray-400 bg-gray-50 dark:bg-gray-600">
                <dt>
                    <svg class="flex-shrink-0 w-6 h-6 mx-auto text-gray-400 dark:text-gray-200" x-description="Heroicon name: outline/currency-dollar" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="mt-4 text-sm font-medium text-gray-900 dark:text-gray-100">Loyalty rewards</span>
                </dt>
                <dd class="mt-1 text-sm text-gray-500 dark:text-gray-200">Don't look at other tees</dd>
            </div>
            <div class="p-6 text-center border border-gray-200 rounded-lg dark:border-gray-400 bg-gray-50 dark:bg-gray-600">
                <dt>
                    <svg class="flex-shrink-0 w-6 h-6 mx-auto text-gray-400 dark:text-gray-200" x-description="Heroicon name: outline/currency-dollar" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="mt-4 text-sm font-medium text-gray-900 dark:text-gray-100">Loyalty rewards</span>
                </dt>
                <dd class="mt-1 text-sm text-gray-500 dark:text-gray-200">Don't look at other tees</dd>
            </div>

        </dl>
    </section>

    <!-- Reviews -->
    <section aria-labelledby="reviews-heading">
        <div class="max-w-2xl px-4 py-24 mx-auto sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-12 lg:gap-x-8 lg:py-32 lg:px-8">
            <div class="lg:col-span-4">
                <h2 id="reviews-heading" class="text-2xl font-bold tracking-tight text-gray-900">{{__('product.customer_reviews')}}</h2>

                <div class="flex items-center mt-3">
                    <div>
                        <div class="flex items-center">

                            <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" x-description="Heroicon name: mini/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                            </svg>

                            <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                            </svg>

                            <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                            </svg>

                            <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                            </svg>

                            <svg class="flex-shrink-0 w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                            </svg>

                        </div>
                        <p class="sr-only">4 out of 5 stars</p>
                    </div>
                    <p class="ml-2 text-sm text-gray-900">{{__('product.based_on_reviews', ['count'=>rand(120,540)])}}</p>
                </div>

                <div class="mt-6">
                    <h3 class="sr-only">Review data</h3>

                    <dl class="space-y-3">

                        <div class="flex items-center text-sm">
                            <dt class="flex items-center flex-1">
                                <p class="w-3 font-medium text-gray-900">5<span class="sr-only"> star reviews</span></p>
                                <div aria-hidden="true" class="flex items-center flex-1 ml-1">
                                    <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" x-description="Heroicon name: mini/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                    </svg>

                                    <div class="relative flex-1 ml-3">
                                        <div class="h-3 bg-gray-100 border border-gray-200 rounded-full"></div>

                                        <div style="width: calc(1019 / 1624 * 100%)" class="absolute inset-y-0 bg-yellow-400 border border-yellow-400 rounded-full"></div>
                                    </div>
                                </div>
                            </dt>
                            <dd class="w-10 ml-3 text-sm text-right text-gray-900 tabular-nums">63%</dd>
                        </div>

                        <div class="flex items-center text-sm">
                            <dt class="flex items-center flex-1">
                                <p class="w-3 font-medium text-gray-900">4<span class="sr-only"> star reviews</span></p>
                                <div aria-hidden="true" class="flex items-center flex-1 ml-1">
                                    <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" x-description="Heroicon name: mini/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                    </svg>

                                    <div class="relative flex-1 ml-3">
                                        <div class="h-3 bg-gray-100 border border-gray-200 rounded-full"></div>

                                        <div style="width: calc(162 / 1624 * 100%)" class="absolute inset-y-0 bg-yellow-400 border border-yellow-400 rounded-full"></div>
                                    </div>
                                </div>
                            </dt>
                            <dd class="w-10 ml-3 text-sm text-right text-gray-900 tabular-nums">10%</dd>
                        </div>

                        <div class="flex items-center text-sm">
                            <dt class="flex items-center flex-1">
                                <p class="w-3 font-medium text-gray-900">3<span class="sr-only"> star reviews</span></p>
                                <div aria-hidden="true" class="flex items-center flex-1 ml-1">
                                    <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" x-description="Heroicon name: mini/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                    </svg>

                                    <div class="relative flex-1 ml-3">
                                        <div class="h-3 bg-gray-100 border border-gray-200 rounded-full"></div>

                                        <div style="width: calc(97 / 1624 * 100%)" class="absolute inset-y-0 bg-yellow-400 border border-yellow-400 rounded-full"></div>
                                    </div>
                                </div>
                            </dt>
                            <dd class="w-10 ml-3 text-sm text-right text-gray-900 tabular-nums">6%</dd>
                        </div>

                        <div class="flex items-center text-sm">
                            <dt class="flex items-center flex-1">
                                <p class="w-3 font-medium text-gray-900">2<span class="sr-only"> star reviews</span></p>
                                <div aria-hidden="true" class="flex items-center flex-1 ml-1">
                                    <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" x-description="Heroicon name: mini/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                    </svg>

                                    <div class="relative flex-1 ml-3">
                                        <div class="h-3 bg-gray-100 border border-gray-200 rounded-full"></div>

                                        <div style="width: calc(199 / 1624 * 100%)" class="absolute inset-y-0 bg-yellow-400 border border-yellow-400 rounded-full"></div>
                                    </div>
                                </div>
                            </dt>
                            <dd class="w-10 ml-3 text-sm text-right text-gray-900 tabular-nums">12%</dd>
                        </div>

                        <div class="flex items-center text-sm">
                            <dt class="flex items-center flex-1">
                                <p class="w-3 font-medium text-gray-900">1<span class="sr-only"> star reviews</span></p>
                                <div aria-hidden="true" class="flex items-center flex-1 ml-1">
                                    <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" x-description="Heroicon name: mini/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                    </svg>

                                    <div class="relative flex-1 ml-3">
                                        <div class="h-3 bg-gray-100 border border-gray-200 rounded-full"></div>

                                        <div style="width: calc(147 / 1624 * 100%)" class="absolute inset-y-0 bg-yellow-400 border border-yellow-400 rounded-full"></div>
                                    </div>
                                </div>
                            </dt>
                            <dd class="w-10 ml-3 text-sm text-right text-gray-900 tabular-nums">9%</dd>
                        </div>

                    </dl>
                </div>

                <div class="mt-10">
                    <h3 class="text-lg font-medium text-gray-900">{{__('product.share_thoughts')}}</h3>
                    <p class="mt-1 text-sm text-gray-600">{{__('product.if_you_used')}}</p>

                    <a href="#" class="inline-flex items-center justify-center w-full px-8 py-2 mt-6 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-md hover:bg-gray-50 sm:w-auto lg:w-full">{{__('product.write_review')}}</a>
                </div>
            </div>

            <div class="mt-16 lg:col-span-7 lg:col-start-6 lg:mt-0">
                <h3 class="sr-only">Recent reviews</h3>

                <div class="flow-root">
                    <div class="-my-12 divide-y divide-gray-200">

                        <div class="py-12">
                            <div class="flex items-center">
                                <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=8&amp;w=256&amp;h=256&amp;q=80" alt="Emily Selman." class="w-12 h-12 rounded-full">
                                <div class="ml-4">
                                    <h4 class="text-sm font-bold text-gray-900">Emily Selman</h4>
                                    <div class="flex items-center mt-1">

                                        <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                        </svg>

                                        <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                        </svg>

                                        <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                        </svg>

                                        <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                        </svg>

                                        <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                        </svg>

                                    </div>
                                    <p class="sr-only">5 out of 5 stars</p>
                                </div>
                            </div>

                            <div class="mt-4 space-y-6 text-base italic text-gray-600">
                                <p>This is the bag of my dreams. I took it on my last vacation and was able to fit an absurd amount of snacks for the many long and hungry flights.</p>
                            </div>
                        </div>

                        <div class="py-12">
                            <div class="flex items-center">
                                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=8&amp;w=256&amp;h=256&amp;q=80" alt="Hector Gibbons." class="w-12 h-12 rounded-full">
                                <div class="ml-4">
                                    <h4 class="text-sm font-bold text-gray-900">Hector Gibbons</h4>
                                    <div class="flex items-center mt-1">

                                        <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" x-state:on="Active" x-state:off="Default" x-state-description="Active: &quot;text-yellow-400&quot;, Default: &quot;text-gray-300&quot;" x-description="Heroicon name: mini/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                        </svg>

                                        <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" x-state-description="undefined: &quot;text-yellow-400&quot;, undefined: &quot;text-gray-300&quot;" x-description="Heroicon name: mini/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                        </svg>

                                        <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" x-state-description="undefined: &quot;text-yellow-400&quot;, undefined: &quot;text-gray-300&quot;" x-description="Heroicon name: mini/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                        </svg>

                                        <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" x-state-description="undefined: &quot;text-yellow-400&quot;, undefined: &quot;text-gray-300&quot;" x-description="Heroicon name: mini/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                        </svg>

                                        <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" x-state-description="undefined: &quot;text-yellow-400&quot;, undefined: &quot;text-gray-300&quot;" x-description="Heroicon name: mini/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                        </svg>

                                    </div>
                                    <p class="sr-only">5 out of 5 stars</p>
                                </div>
                            </div>

                            <div class="mt-4 space-y-6 text-base italic text-gray-600">
                                <p>Before getting the Ruck Snack, I struggled my whole life with pulverized snacks, endless crumbs, and other heartbreaking snack catastrophes. Now, I can stow my snacks with confidence and style!</p>
                            </div>
                        </div>

                        <div class="py-12">
                            <div class="flex items-center">
                                <img src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&amp;ixqx=oilqXxSqey&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80" alt="Mark Edwards." class="w-12 h-12 rounded-full">
                                <div class="ml-4">
                                    <h4 class="text-sm font-bold text-gray-900">Mark Edwards</h4>
                                    <div class="flex items-center mt-1">

                                        <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" x-state:on="Active" x-state:off="Default" x-state-description="Active: &quot;text-yellow-400&quot;, Default: &quot;text-gray-300&quot;" x-description="Heroicon name: mini/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                        </svg>

                                        <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" x-state-description="undefined: &quot;text-yellow-400&quot;, undefined: &quot;text-gray-300&quot;" x-description="Heroicon name: mini/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                        </svg>

                                        <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" x-state-description="undefined: &quot;text-yellow-400&quot;, undefined: &quot;text-gray-300&quot;" x-description="Heroicon name: mini/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                        </svg>

                                        <svg class="flex-shrink-0 w-5 h-5 text-yellow-400" x-state-description="undefined: &quot;text-yellow-400&quot;, undefined: &quot;text-gray-300&quot;" x-description="Heroicon name: mini/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                        </svg>

                                        <svg class="flex-shrink-0 w-5 h-5 text-gray-300" x-state-description="undefined: &quot;text-yellow-400&quot;, undefined: &quot;text-gray-300&quot;" x-description="Heroicon name: mini/star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"></path>
                                        </svg>

                                    </div>
                                    <p class="sr-only">4 out of 5 stars</p>
                                </div>
                            </div>

                            <div class="mt-4 space-y-6 text-base italic text-gray-600">
                                <p>I love how versatile this bag is. It can hold anything ranging from cookies that come in trays to cookies that come in tins.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <livewire:relative-products />

    <div class="ta-gallery-element-active ta-gallery-anim-slide ta-gallery-anim-right-in ta-gallery-anim-right-out ta-gallery-anim-left-in ta-gallery-anim-left-out"></div>
    @push('styles')
    <link href="{{asset('vendor/ta-gallery/ta-gallery.css')}}" rel="stylesheet">
    @endpush

    @push('scripts')
    <script src="{{asset('vendor/ta-gallery/ta-gallery-next.min.js')}}"></script>
    @endpush
</div>