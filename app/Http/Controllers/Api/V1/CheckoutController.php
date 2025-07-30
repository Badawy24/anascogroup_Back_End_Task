<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutStripeRequest;
use App\Models\Plan;
use App\Services\StripeCheckoutService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(private StripeCheckoutService $stripeService) {}

    public function checkoutStripe(CheckoutStripeRequest $request)
    {
        $plan = Plan::findOrFail($request->plan_id);
        $url = $this->stripeService->createCheckoutSession($plan, auth()->user());

        return response()->json(['url' => $url]);
    }
}
