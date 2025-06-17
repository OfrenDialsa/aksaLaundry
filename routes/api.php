<?php

use App\Http\Controllers\Dashboard\PaymentController;
use Illuminate\Support\Facades\Route;

Route::post('/dashboard/payment/callback', [PaymentController::class, 'callback']);