<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FeedController;




Route::get('/', function () {
    return view('feed');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/profile-picture', [SettingsController::class, 'updateProfilePicture'])->name('settings.update-profile-picture');
    Route::delete('/settings', [SettingsController::class, 'destroy'])->name('settings.destroy');
});

// Profile page
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

// Profile edit page
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // New routes for avatar and cover upload
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update-avatar');
    Route::post('/profile/cover', [ProfileController::class, 'updateCover'])->name('profile.update-cover');

Route::prefix('cart')->group(function () {
    Route::get('/{user?}', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history'); 
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');         
Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout')->middleware('auth');
});
require __DIR__.'/auth.php';






// ✅ Products routes (controller only)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

Route::middleware('auth')->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
   Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy'); // ✅ Add this

});

// Dynamic route last
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::post('/chat', [ChatController::class, 'sendMessage'])->name('chat.send');


Route::post('/cart/toggle/{product}', [CartController::class, 'toggle'])->name('cart.toggle');

Route::middleware('auth')->group(function () {
    // Show checkout form
Route::get('/checkout', [OrderController::class, 'showCheckoutPage'])->name('checkout')->middleware('auth');

    // Process checkout (POST)
    Route::post('/checkout/process', [OrderController::class, 'checkout'])->name('checkout.process');
});


Route::get('/payment/{order}', [OrderController::class, 'showPayment'])->name('payment')->middleware('auth');


Route::get('/', [FeedController::class, 'index'])->name('feed.index');


Route::middleware('auth')->group(function () {
    Route::get('/feed/create', [FeedController::class, 'create'])->name('feed.create');
    Route::post('/feed', [FeedController::class, 'store'])->name('feed.store');
});