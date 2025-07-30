<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\PlanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function __construct(protected PlanService $planService) {}

    public function index(): JsonResponse
    {
        $plans = $this->planService->getAllPlans();
        return response()->json([
            'data' => $plans,
        ]);
    }
}
