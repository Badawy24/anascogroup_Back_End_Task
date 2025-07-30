<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutStripeRequest;
use App\Http\Requests\CheckoutPaypalRequest;
use App\Models\Plan;
use App\Services\StripeCheckoutService;
use App\Services\PaypalCheckoutService;
use App\Repositories\Interfaces\PlanRepositoryInterface;

class CheckoutController extends Controller
{
    public function __construct(
        private StripeCheckoutService $stripeService,
        private PaypalCheckoutService $paypalService,
        private PlanRepositoryInterface $planRepository,
    ) {}

    public function checkoutStripe(CheckoutStripeRequest $request)
    {
        $plan = Plan::findOrFail($request->plan_id);
        $url = $this->stripeService->createCheckoutSession($plan, auth()->user());

        return response()->json(['url' => $url]);
    }

     public function checkoutPaypal(CheckoutPaypalRequest $request)
    {
        $plan = Plan::findOrFail($request->plan_id);

        $result = $this->paypalService->createOneTimeOrder($plan->id);

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 422);
        }

        return response()->json([
            'url' => $result['url'],
        ]);
    }
}
