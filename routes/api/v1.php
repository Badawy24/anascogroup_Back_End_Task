<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CheckoutController;
use App\Http\Controllers\Api\V1\PlanController;
use App\Http\Controllers\Api\V1\StripeWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['status' => 'ok']);
});

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::get('/plans', [PlanController::class, 'index']);

Route::middleware('auth:sanctum')->post('/checkout/stripe', [CheckoutController::class, 'checkoutStripe']);

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);

Route::get('/payment-success', function () {
    return response()->json(['message' => 'Payment successful']);
})->name('payment-success');

Route::get('/payment-cancel', function () {
    return response()->json(['message' => 'Payment canceled']);
})->name('payment-cancel');
