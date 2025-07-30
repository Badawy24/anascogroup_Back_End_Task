<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CheckoutController;
use App\Http\Controllers\Api\V1\PlanController;
use App\Http\Controllers\Api\V1\StripeWebhookController;
use App\Http\Controllers\Api\V1\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['status' => 'ok']);
});

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);


Route::get('/plans', [PlanController::class, 'index']);


Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/my-transactions', [TransactionController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/checkout/stripe', [CheckoutController::class, 'checkoutStripe']);
    Route::post('/checkout/paypal', [CheckoutController::class, 'checkoutPaypal']);
});
