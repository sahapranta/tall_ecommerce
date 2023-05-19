<?php

use Beier\FilamentPages\Http\Controllers\FilamentPageController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    // 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::get('/', function () {
        // session()->flash('flash.banner', 'Get a huge discount of up to 80% on all items!');
        // session()->flash('flash.bannerStyle', 'warning');
        // \App\Models\Currency::find(1)->update(['default', 1]);
        $products = \App\Models\Product::with(['featuredImage', 'variant', 'variant.options'])->paginate(15);
        // dd($products[0]->featuredImage->getResponsiveImageUrls());
        // dd(asset('images/placeholder-image.webp'));
        return view('home', compact('products'));
    });

    Route::get('/payment/{code}', App\Http\Livewire\Payment::class)->name('checkout.payment');
    Route::get('/payment-success', App\Http\Livewire\Shop\PaymentSuccess::class)->name('checkout.success');
    Route::get('/order-success/{order}', App\Http\Livewire\Shop\OrderSuccess::class)->name('order.success');
    Route::get('/payment-canceled', [App\Http\Controllers\PaymentController::class, 'canceled'])->name('checkout.cancel');


    Route::get('/product/{product}', App\Http\Livewire\ProductView::class)->name('product.view');
    Route::get('/checkout', App\Http\Livewire\Checkout::class)->name('shop.checkout');
    Route::get('/order-confirmed', fn () => view('order.confirmed'))->name('order.confirmed');

    Route::get('/page/{filamentPage}', [FilamentPageController::class, 'show']);
    Route::get('/shop', fn () => view('shop.index'))->name('shop.index');
    Route::get('/blog', fn () => view('blog.index'))->name('blog.index');
    Route::get('/blog/article', fn () => view('blog.view'))->name('blog.view');



    // All Auth Route here

    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified'
    ])->group(function () {
        Route::get('/dashboard', function () {
            session()->flash('flash.banner', 'Get a huge discount of up to 80% on all items!');
            session()->flash('flash.bannerStyle', 'warning');
            return view('dashboard');
        })->name('dashboard');
    });



    require base_path('vendor/laravel/fortify/routes/routes.php');
    require base_path('vendor/laravel/jetstream/routes/livewire.php');
});
