<?php

use App\Http\Controllers\Dashboard\LocationController;
use App\Http\Controllers\MinDashboard\MinLocationController;
use App\Http\Controllers\MinDashboard\MinOrderController;
use App\Http\Controllers\MinDashboard\MinPaymentController;
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

Route::middleware('auth')->group(function () {
    Route::get('/minprofile', [ProfileController::class, 'edit'])->name('minprofile.edit');
    Route::patch('/minprofile', [ProfileController::class, 'update'])->name('minprofile.update');
    Route::delete('/minprofile', [ProfileController::class, 'destroy'])->name('minprofile.destroy');
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

Route::prefix('mindashboard')->name('mindashboard.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('order', MinOrderController::class)->names('order');
    Route::get('/location', [MinLocationController::class, 'index'])->name('location');
    Route::get('/payment', [MinPaymentController::class, 'index'])->name('payment');
});

require __DIR__.'/auth.php';