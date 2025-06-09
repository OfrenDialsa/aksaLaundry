<?php

use App\Http\Controllers\Dashboard\LocationController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\PaymentController;
use App\Http\Controllers\WelcomePage\AboutController;
use App\Http\Controllers\WelcomePage\HomeController;
use App\Http\Controllers\WelcomePage\PricingController;
use App\Http\Controllers\WelcomePage\FaqController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Redirect::to('/welcome/home');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('welcome')->name('welcome.')->group(function () {
    Route::resource('/home', HomeController::class);
    Route::resource('/pricing', PricingController::class);
    Route::resource('/faq', FaqController::class);
    Route::resource('/about', AboutController::class);
});

Route::prefix('dashboard')->name('dashboard.')->middleware(['auth', 'verified'])->group(function () {
    Route::resource('order', OrderController::class)->names('order');
    Route::get('/location', [LocationController::class, 'index'])->name('location');
    Route::get('/payment', [PaymentController::class, 'index'])->name('payment');
});


require __DIR__.'/auth.php';
