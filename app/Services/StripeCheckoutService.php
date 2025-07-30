<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Transaction;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeCheckoutService
{
    public function createCheckoutSession(Plan $plan, $user)
    {
        Stripe::setApiKey(config('stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $plan->price * 100,
                    'product_data' => [
                        'name' => $plan->name,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'https://httpbin.org/status/200',
            'cancel_url' => 'https://httpbin.org/status/400',
            'metadata' => [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
            ],
        ]);

        Transaction::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'provider' => 'stripe',
            'amount' => $plan->price,
            'status' => 'pending',
            'payment_id' => $session->id,
        ]);

        return $session->url;
    }
}
