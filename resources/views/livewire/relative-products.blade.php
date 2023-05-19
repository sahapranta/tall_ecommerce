<section aria-labelledby="related-heading" class="px-4 py-16 mt-10 border-t border-gray-200 sm:px-0">
    <h2 id="related-heading" class="text-xl font-bold text-gray-900 dark:text-white">{{__('product.customers_also')}}</h2>

    <div class="grid grid-cols-1 mt-8 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">

        @foreach ($products as $product)
        <x-product.card :product="$product" />
        @endforeach

    </div>
</section>