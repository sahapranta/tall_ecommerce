<x-base-layout>
    <div class="max-w-3xl px-4 pt-4 pb-12 mx-auto sm:px-6 lg:px-8">
        <div class="mt-6 mb-12">
            <h4 class="sr-only">Status</h4>
            <p class="text-sm font-medium text-gray-900">Preparing to ship on <time datetime="2021-03-24">March 24, 2021</time></p>
            <div class="mt-6" aria-hidden="true">
                <div class="overflow-hidden bg-gray-200 rounded-full">
                    <div class="h-2 bg-indigo-600 rounded-full" style="width: calc((1 * 2 + 1) / 8 * 100%)"></div>
                </div>
                <div class="hidden grid-cols-4 mt-6 text-sm font-medium text-gray-600 sm:grid">
                    <div class="text-indigo-600">Order placed</div>
                    <div class="text-center text-indigo-600">Processing</div>
                    <div class="text-center">Shipped</div>
                    <div class="text-right">Delivered</div>
                </div>
            </div>
        </div>

        <div class="max-w-xl">
            <h1 class="text-base font-medium text-indigo-600">Thank you!</h1>
            <p class="mt-2 text-4xl font-bold tracking-tight sm:text-5xl">It's on the way!</p>
            <p class="mt-2 text-base text-gray-500">Your order #14034056 has shipped and will be with you soon.</p>

            <dl class="mt-8 text-sm font-medium">
                <dt class="text-gray-900">Tracking number</dt>
                <dd class="mt-2 text-indigo-600">51547878755545848512</dd>
            </dl>
        </div>

        <div class="mt-10 border-t border-gray-200">
            <h2 class="sr-only">Your order</h2>

            <h3 class="sr-only">Items</h3>

            <div class="flex py-10 space-x-6 border-b border-gray-200">
                <img src="https://tailwindui.com/img/ecommerce-images/confirmation-page-05-product-01.jpg" alt="Glass bottle with black plastic pour top and mesh insert." class="flex-none object-cover object-center w-20 h-20 bg-gray-100 rounded-lg sm:h-40 sm:w-40">
                <div class="flex flex-col flex-auto">
                    <div>
                        <h4 class="font-medium text-gray-900">
                            <a href="#">Cold Brew Bottle</a>
                        </h4>
                        <p class="mt-2 text-sm text-gray-600">This glass bottle comes with a mesh insert for steeping tea or cold-brewing coffee. Pour from any angle and remove the top for easy cleaning.</p>
                    </div>
                    <div class="flex items-end flex-1 mt-6">
                        <dl class="flex space-x-4 text-sm divide-x divide-gray-200 sm:space-x-6">
                            <div class="flex">
                                <dt class="font-medium text-gray-900">Quantity</dt>
                                <dd class="ml-2 text-gray-700">1</dd>
                            </div>
                            <div class="flex pl-4 sm:pl-6">
                                <dt class="font-medium text-gray-900">Price</dt>
                                <dd class="ml-2 text-gray-700">$32.00</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="sm:ml-40 sm:pl-6">
                <h3 class="sr-only">Your information</h3>

                <h4 class="sr-only">Addresses</h4>
                <dl class="grid grid-cols-2 py-10 text-sm gap-x-6">
                    <div>
                        <dt class="font-medium text-gray-900">Shipping address</dt>
                        <dd class="mt-2 text-gray-700">
                            <address class="not-italic">
                                <span class="block">Kristin Watson</span>
                                <span class="block">7363 Cynthia Pass</span>
                                <span class="block">Toronto, ON N3Y 4H8</span>
                            </address>
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-900">Billing address</dt>
                        <dd class="mt-2 text-gray-700">
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
                        <dt class="font-medium text-gray-900">Payment method</dt>
                        <dd class="mt-2 text-gray-700">
                            <p>Apple Pay</p>
                            <p>Mastercard</p>
                            <p><span aria-hidden="true">••••</span><span class="sr-only">Ending in </span>1545</p>
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-900">Shipping method</dt>
                        <dd class="mt-2 text-gray-700">
                            <p>DHL</p>
                            <p>Takes up to 3 working days</p>
                        </dd>
                    </div>
                </dl>

                <h3 class="sr-only">Summary</h3>

                <dl class="pt-10 space-y-6 text-sm border-t border-gray-200">
                    <div class="flex justify-between">
                        <dt class="font-medium text-gray-900">Subtotal</dt>
                        <dd class="text-gray-700">$36.00</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="flex font-medium text-gray-900">
                            Discount
                            <span class="ml-2 rounded-full bg-gray-200 py-0.5 px-2 text-xs text-gray-600">STUDENT50</span>
                        </dt>
                        <dd class="text-gray-700">-$18.00 (50%)</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium text-gray-900">Shipping</dt>
                        <dd class="text-gray-700">$5.00</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium text-gray-900">Total</dt>
                        <dd class="text-gray-900">$23.00</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
    <hr>
</x-base-layout>