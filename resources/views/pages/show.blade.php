<x-base-layout>
    <div class="relative py-16 overflow-hidden bg-white dark:bg-gray-800">
        <div class="hidden lg:absolute lg:inset-y-0 lg:block lg:h-full lg:w-full lg:[overflow-anchor:none]">
            <div class="relative h-full mx-auto text-lg max-w-prose" aria-hidden="true">
                <svg class="absolute transform translate-x-32 top-12 left-full" width="404" height="384" fill="none" viewBox="0 0 404 384">
                    <defs>
                        <pattern id="74b3fd99-0a6f-4271-bef2-e80eeafdf357" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="404" height="384" fill="url(#74b3fd99-0a6f-4271-bef2-e80eeafdf357)" />
                </svg>
                <svg class="absolute transform -translate-x-32 -translate-y-1/2 top-1/2 right-full" width="404" height="384" fill="none" viewBox="0 0 404 384">
                    <defs>
                        <pattern id="f210dbf6-a58d-4871-961e-36d5016a0f49" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="404" height="384" fill="url(#f210dbf6-a58d-4871-961e-36d5016a0f49)" />
                </svg>
                <svg class="absolute transform translate-x-32 bottom-12 left-full" width="404" height="384" fill="none" viewBox="0 0 404 384">
                    <defs>
                        <pattern id="d3eb07ae-5182-43e6-857d-35c643af9034" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="404" height="384" fill="url(#d3eb07ae-5182-43e6-857d-35c643af9034)" />
                </svg>
            </div>
        </div>
        <div class="relative px-6 lg:px-8">
            <div class="mx-auto text-lg max-w-prose">
                <h1>
                    <span class="block text-lg font-semibold text-center text-indigo-600 dark:text-indigo-200">Page</span>
                    <span class="block mt-2 text-3xl font-bold leading-8 tracking-tight text-center text-gray-900 dark:text-white sm:text-4xl">{{$page->title}}</span>
                </h1>
                <!-- <p class="mt-8 text-xl leading-8 text-gray-500">Aliquet nec orci mattis amet quisque ullamcorper neque, nibh sem. At arcu, sit dui mi, nibh dui, diam eget aliquam. Quisque id at vitae feugiat egestas ac. Diam nulla orci at in viverra scelerisque eget. Eleifend egestas fringilla sapien.</p> -->
            </div>
            <div class="mx-auto mt-6 prose prose-lg text-gray-500 dark:text-gray-100 prose-indigo">
                {!! $page->data['content']['content'] !!}
            </div>
        </div>
    </div>
</x-base-layout>