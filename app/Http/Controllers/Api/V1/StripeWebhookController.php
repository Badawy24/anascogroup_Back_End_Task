<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use App\Services\TransactionService;


class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        \Log::info('Payment Succsess', ['payload' => request()->all()]);

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\UnexpectedValueException $e) {
             \Log::error('Payment Error', [
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
    ]);
            return response()->json(['message' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            app(TransactionService::class)->storeFromStripeSession($session);
        }

        return response()->json(['message' => 'Webhook received']);
    }
}
