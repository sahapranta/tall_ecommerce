<div>

    <div class="max-w-3xl px-4 pt-4 pb-12 mx-auto sm:px-6 lg:px-8">
        <div class="mt-6 mb-12">
            <h4 class="sr-only">Status</h4>
            <p class="text-sm font-medium text-gray-900 dark:text-white">Preparing to ship on <time datetime="2021-03-24">{{$order?->expected_shipping}}</time></p>
            <div class="mt-6" aria-hidden="true">
                <div class="overflow-hidden bg-gray-200 rounded-full">
                    <div class="h-2 bg-indigo-600 rounded-full" style="width: calc((1 * 2 + 1) / 8 * 100%)"></div>
                </div>
                <div class="hidden grid-cols-4 mt-6 text-sm font-medium text-gray-600 dark:text-gray-300 sm:grid">
                    <div class="text-indigo-600 dark:text-indigo-300">Order placed</div>
                    <div class="text-center text-indigo-600 dark:text-indigo-300">Processing</div>
                    <div class="text-center">Shipped</div>
                    <div class="text-right">Delivered</div>
                </div>
            </div>
        </div>

        <div class="max-w-xl">
            <h1 class="text-base font-medium text-indigo-600 dark:text-indigo-300">Thank you!</h1>
            <p class="mt-2 text-4xl font-bold tracking-tight sm:text-5xl dark:text-white">We received your order!</p>
            <p class="mt-2 text-base text-gray-500 dark:text-gray-200">Your order #{{$order->order_number}} has shipped and will be with you soon.</p>

            <dl class="mt-8 text-sm font-medium">
                <dt class="text-gray-900 dark:text-white">Tracking number</dt>
                <button x-clipboard.raw="{{ $order->tracking_id }}">
                    <dd class="mt-2 text-indigo-600 dark:text-indigo-300">{{$order->tracking_id}}</dd>
                </button>
            </dl>
        </div>

        <div class="mt-10 border-t border-gray-200">
            <h2 class="sr-only">Your order</h2>

            <h3 class="sr-only">Items</h3>

            <div class="flex py-10 space-x-6 border-b border-gray-200">
                <ul role="list" class="-my-4 divide-y divide-gray-200">
                    @foreach ($order->items as $item)
                    @php
                    $product = $item->variant->product;
                    @endphp
                    <li class="flex py-4">
                        <div class="flex-shrink-0 w-16 h-16 overflow-hidden border border-gray-300 rounded-md dark:border-gray-400">
                            <img src="{{$product['thumb']}}" alt="{{$product['title']}}" class="object-cover object-center w-full h-full">
                        </div>

                        <div class="flex flex-col flex-1 ml-4">
                            <div>
                                <div class="text-base font-medium text-gray-900 dark:text-gray-100">
                                    <h3>
                                        <a href="{{route('product.view', $product['slug'])}}">{{$product['title']}}</a>
                                    </h3>
                                    <p class="ml-3 whitespace-nowrap">{{format_money($item->unit_price)}}</p>
                                </div>

                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-100">
                                    {{$item->item_description}}
                                </p>
                            </div>
                            <div class="flex items-center justify-between flex-1 text-sm">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Qty 1</p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>

            </div>

            <div class="sm:ml-40 sm:pl-6">
                <h3 class="sr-only">Your information</h3>

                <h4 class="sr-only">Addresses</h4>
                <dl class="grid grid-cols-2 py-10 text-sm gap-x-6">
                    <div>
                        <dt class="font-medium text-gray-900 dark:text-white">Shipping address</dt>
                        <dd class="mt-2 text-gray-700 dark:text-gray-200">
                            <address class="not-italic">
                                <span class="block">Kristin Watson</span>
                                <span class="block">7363 Cynthia Pass</span>
                                <span class="block">Toronto, ON N3Y 4H8</span>
                            </address>
                        </dd>
                    </div>
                </dl>

                <h4 class="sr-only">Payment</h4>
                <dl class="grid grid-cols-2 py-10 text-sm border-t border-gray-200 gap-x-6">
                    <div>
                        <dt class="font-medium text-gray-900 dark:text-white">Payment method</dt>
                        <dd class="mt-2 text-gray-700 dark:text-gray-200">
                            <p>Stripe/COD</p>
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-900 dark:text-white">Shipping method</dt>
                        <dd class="mt-2 text-gray-700 dark:text-gray-200">
                            <p>DHL</p>
                            <p>Takes up to 3 working days</p>
                        </dd>
                    </div>
                </dl>

                <h3 class="sr-only">Summary</h3>

                <dl class="pt-10 space-y-6 text-sm border-t border-gray-200">
                    <div class="flex justify-between">
                        <dt class="font-medium text-gray-900 dark:text-white">Subtotal</dt>
                        <dd class="text-gray-700 dark:text-gray-200">{{format_money($order->subtotal)}}</dd>
                    </div>
                    @if ($order->discount>0 && !is_null($order->coupon_id))
                    <div class="flex justify-between">
                        <dt class="flex font-medium text-gray-900 dark:text-white">
                            Discount
                            <span class="ml-2 rounded-full bg-gray-200 py-0.5 px-2 text-xs text-gray-600 dark:text-gray-300">{{$order->coupon->code}}</span>
                        </dt>
                        <dd class="text-gray-700 dark:text-gray-200">-{{format_money($order->discount)}} (50%)</dd>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <dt class="font-medium text-gray-900 dark:text-white">Tax ({{$order->taxrate}})</dt>
                        <dd class="text-gray-700 dark:text-gray-200">{{format_money($order->taxable)}}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium text-gray-900 dark:text-white">Shipping</dt>
                        <dd class="text-gray-700 dark:text-gray-200">{{format_money($order->shipping_charge)}}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium text-gray-900 dark:text-white">Total</dt>
                        <dd class="text-gray-900 dark:text-white">{{format_money($order->total)}}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
    <hr />

    @push('scripts')
    <script src="{{asset('vendor/x-copy.js') }}"></script>
    @endpush
</div>