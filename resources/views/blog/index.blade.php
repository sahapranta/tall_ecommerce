<x-base-layout>

    <div class="relative px-6 pt-16 pb-20 bg-gray-50 lg:px-8 lg:pt-24 lg:pb-28">
        <div class="absolute inset-0">
            <div class="bg-white h-1/3 sm:h-2/3"></div>
        </div>
        <div class="relative mx-auto max-w-7xl">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">From the blog</h2>
                <p class="max-w-2xl mx-auto mt-3 text-xl text-gray-500 sm:mt-4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsa libero labore natus atque, ducimus sed.</p>
            </div>
            <div class="grid max-w-lg gap-5 mx-auto mt-12 lg:max-w-none lg:grid-cols-3">
                @foreach ([1,2,3] as $post)
                <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
                    <div class="flex-shrink-0">
                        <img class="object-cover w-full h-48" src="https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80" alt="">
                    </div>
                    <div class="flex flex-col justify-between flex-1 p-6 bg-white">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-indigo-600">
                                <a href="{{route('blog.view')}}" class="hover:underline">Article</a>
                            </p>
                            <a href="{{route('blog.view')}}" class="block mt-2">
                                <p class="text-xl font-semibold text-gray-900">Boost your conversion rate</p>
                                <p class="mt-3 text-base text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto accusantium praesentium eius, ut atque fuga culpa, similique sequi cum eos quis dolorum.</p>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
                    <div class="flex-shrink-0">
                        <img class="object-cover w-full h-48" src="https://images.unsplash.com/photo-1547586696-ea22b4d4235d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80" alt="">
                    </div>
                    <div class="flex flex-col justify-between flex-1 p-6 bg-white">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-indigo-600">
                                <a href="{{route('blog.view')}}" class="hover:underline">Video</a>
                            </p>
                            <a href="{{route('blog.view')}}" class="block mt-2">
                                <p class="text-xl font-semibold text-gray-900">How to use search engine optimization to drive sales</p>
                                <p class="mt-3 text-base text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit facilis asperiores porro quaerat doloribus, eveniet dolore. Adipisci tempora aut inventore optio animi., tempore temporibus quo laudantium.</p>
                            </a>
                        </div>

                    </div>
                </div>

                <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
                    <div class="flex-shrink-0">
                        <img class="object-cover w-full h-48" src="https://images.unsplash.com/photo-1492724441997-5dc865305da7?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80" alt="">
                    </div>
                    <div class="flex flex-col justify-between flex-1 p-6 bg-white">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-indigo-600">
                                <a href="{{route('blog.view')}}" class="hover:underline">Case Study</a>
                            </p>
                            <a href="{{route('blog.view')}}" class="block mt-2">
                                <p class="text-xl font-semibold text-gray-900">Improve your customer experience</p>
                                <p class="mt-3 text-base text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint harum rerum voluptatem quo recusandae magni placeat saepe molestiae, sed excepturi cumque corporis perferendis hic.</p>
                            </a>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>

        </div>
        <nav class="flex items-center justify-between px-4 mt-12 border-t border-gray-200 sm:px-0">
            <div class="flex flex-1 w-0 -mt-px">
                <a href="#" class="inline-flex items-center pt-4 pr-1 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700">
                    <!-- Heroicon name: mini/arrow-long-left -->
                    <svg class="w-5 h-5 mr-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a.75.75 0 01-.75.75H4.66l2.1 1.95a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 111.02 1.1l-2.1 1.95h12.59A.75.75 0 0118 10z" clip-rule="evenodd" />
                    </svg>
                    Previous
                </a>
            </div>
            <div class="hidden md:-mt-px md:flex">
                <a href="#" class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700">1</a>
                <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
                <a href="#" class="inline-flex items-center px-4 pt-4 text-sm font-medium text-indigo-600 border-t-2 border-indigo-500" aria-current="page">2</a>
                <a href="#" class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700">3</a>
                <span class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent">...</span>
                <a href="#" class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700">8</a>
                <a href="#" class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700">9</a>
                <a href="#" class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700">10</a>
            </div>
            <div class="flex justify-end flex-1 w-0 -mt-px">
                <a href="#" class="inline-flex items-center pt-4 pl-1 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700">
                    Next
                    <!-- Heroicon name: mini/arrow-long-right -->
                    <svg class="w-5 h-5 ml-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </nav>
    </div>


    <div class="relative py-16 overflow-hidden bg-gray-900 isolate sm:py-24 lg:py-32">
        <div class="px-6 mx-auto max-w-7xl lg:px-8">
            <div class="grid max-w-2xl grid-cols-1 mx-auto gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-2">
                <div class="max-w-xl lg:max-w-lg">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Subscribe to our newsletter.</h2>
                    <p class="mt-4 text-lg leading-8 text-gray-300">Nostrud amet eu ullamco nisi aute in ad minim nostrud adipisicing velit quis. Duis tempor incididunt dolore.</p>
                    <div class="flex max-w-md mt-6 gap-x-4">
                        <label for="email-address" class="sr-only">Email address</label>
                        <input id="email-address" name="email" type="email" autocomplete="email" required class="min-w-0 flex-auto rounded-md border-0 bg-white/5 px-3.5 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="Enter your email">
                        <button type="submit" class="flex-none rounded-md bg-indigo-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Subscribe</button>
                    </div>
                </div>
                <dl class="grid grid-cols-1 gap-x-8 gap-y-10 sm:grid-cols-2 lg:pt-2">
                    <div class="flex flex-col items-start">
                        <div class="p-2 rounded-md bg-white/5 ring-1 ring-white/10">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                            </svg>
                        </div>
                        <dt class="mt-4 font-semibold text-white">Weekly articles</dt>
                        <dd class="mt-2 leading-7 text-gray-400">Non laboris consequat cupidatat laborum magna. Eiusmod non irure cupidatat duis commodo amet.</dd>
                    </div>
                    <div class="flex flex-col items-start">
                        <div class="p-2 rounded-md bg-white/5 ring-1 ring-white/10">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.05 4.575a1.575 1.575 0 10-3.15 0v3m3.15-3v-1.5a1.575 1.575 0 013.15 0v1.5m-3.15 0l.075 5.925m3.075.75V4.575m0 0a1.575 1.575 0 013.15 0V15M6.9 7.575a1.575 1.575 0 10-3.15 0v8.175a6.75 6.75 0 006.75 6.75h2.018a5.25 5.25 0 003.712-1.538l1.732-1.732a5.25 5.25 0 001.538-3.712l.003-2.024a.668.668 0 01.198-.471 1.575 1.575 0 10-2.228-2.228 3.818 3.818 0 00-1.12 2.687M6.9 7.575V12m6.27 4.318A4.49 4.49 0 0116.35 15m.002 0h-.002" />
                            </svg>
                        </div>
                        <dt class="mt-4 font-semibold text-white">No spam</dt>
                        <dd class="mt-2 leading-7 text-gray-400">Officia excepteur ullamco ut sint duis proident non adipisicing. Voluptate incididunt anim.</dd>
                    </div>
                </dl>
            </div>
        </div>
        <div class="absolute top-0 -translate-x-1/2 left-1/2 -z-10 blur-3xl xl:-top-6" aria-hidden="true">
            <div class="aspect-[1155/678] w-[72.1875rem] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
    </div>

    <div class="bg-gray-50 dark:bg-gray-800">
        <div class="py-24 mx-auto max-w-7xl sm:px-2 sm:py-24 lg:px-4">
            <div class="max-w-2xl px-4 mx-auto lg:max-w-none">
                <div class="grid items-center grid-cols-1 gap-y-10 gap-x-16 lg:grid-cols-2">
                    <div>
                        <h2 class="text-4xl font-bold tracking-tight text-gray-900">We built our business on great customer service</h2>
                        <p class="mt-4 text-gray-500">At the beginning at least, but then we realized we could make a lot more money if we kinda stopped caring about that. Our new strategy is to write a bunch of things that look really good in the headlines, then clarify in the small print but hope people don't actually read it.</p>
                    </div>
                    <div class="overflow-hidden bg-gray-100 rounded-lg aspect-w-3 aspect-h-2">
                        <img src="https://tailwindui.com/img/ecommerce-images/incentives-07-hero.jpg" alt="" class="object-cover object-center">
                    </div>
                </div>
                <div class="max-w-2xl px-4 pt-12 mx-auto sm:px-6 lg:max-w-7xl lg:px-8">
                    <div class="grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 lg:gap-x-8">
                        <div>
                            <img src="https://tailwindui.com/img/ecommerce/icons/icon-delivery-light.svg" alt="" class="w-auto h-24">
                            <h3 class="mt-6 text-sm font-medium text-gray-900">Free Shipping</h3>
                            <p class="mt-2 text-sm text-gray-500">It&#039;s not actually free we just price it into the products. Someone&#039;s paying for it, and it&#039;s not us.</p>
                        </div>

                        <div>
                            <img src="https://tailwindui.com/img/ecommerce/icons/icon-chat-light.svg" alt="" class="w-auto h-24">
                            <h3 class="mt-6 text-sm font-medium text-gray-900">24/7 Customer Support</h3>
                            <p class="mt-2 text-sm text-gray-500">Our AI chat widget is powered by a naive series of if/else statements. Guaranteed to irritate.</p>
                        </div>

                        <div>
                            <img src="https://tailwindui.com/img/ecommerce/icons/icon-fast-checkout-light.svg" alt="" class="w-auto h-24">
                            <h3 class="mt-6 text-sm font-medium text-gray-900">Fast Shopping Cart</h3>
                            <p class="mt-2 text-sm text-gray-500">Look how fast that cart is going. What does this mean for the actual experience? I don&#039;t know.</p>
                        </div>

                        <div>
                            <img src="https://tailwindui.com/img/ecommerce/icons/icon-gift-card-light.svg" alt="" class="w-auto h-24">
                            <h3 class="mt-6 text-sm font-medium text-gray-900">Gift Cards</h3>
                            <p class="mt-2 text-sm text-gray-500">Buy them for your friends, especially if they don&#039;t like our store. Free money for us, it&#039;s great.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-base-layout>