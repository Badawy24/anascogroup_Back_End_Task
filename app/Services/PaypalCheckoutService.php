<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Support\Facades\Http;

class PaypalCheckoutService
{
    public function createOneTimeOrder(int $planId): array
    {
        $plan = Plan::findOrFail($planId);
        $mode = config('services.paypal.mode', 'sandbox');


        $baseUrl = $mode === 'live'
            ? 'https://api-m.paypal.com'
            : 'https://api-m.sandbox.paypal.com';
            
        $authResponse = Http::asForm()->withBasicAuth(
            config('services.paypal.client_id'),
            config('services.paypal.secret')
        )->post("$baseUrl/v1/oauth2/token", [
            'grant_type' => 'client_credentials',
        ]);

        if ($authResponse->failed()) {
            return ['error' => 'PayPal authentication failed'];
        }

        $accessToken = $authResponse->json()['access_token'] ?? null;

        if (!$accessToken) {
            return ['error' => 'PayPal access token not received'];
        }

        $response = Http::withToken($accessToken)->post("$baseUrl/v2/checkout/orders", [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => strtoupper($plan->currency ?? 'USD'),
                    'value' => number_format($plan->price, 2, '.', ''),
                ],
                'description' => $plan->name,
            ]],
            'application_context' => [
                'return_url' => 'https://httpbin.org/status/200',
                'cancel_url' => 'https://httpbin.org/status/400',
            ]
        ]);

        if ($response->failed()) {
            return ['error' => 'Failed to create PayPal order'];
        }

        $order = $response->json();

        $approvalUrl = collect($order['links'] ?? [])
            ->firstWhere('rel', 'approve')['href'] ?? null;

        if (!$approvalUrl) {
            return ['error' => 'Approval URL not found'];
        }

        return ['url' => $approvalUrl];
    }
}
