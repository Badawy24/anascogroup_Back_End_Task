<?php
namespace App\Services;

use App\Repositories\Interfaces\PlanRepositoryInterface;

class PlanService
{
    public function __construct(protected PlanRepositoryInterface $planRepo) {}

    public function getAllPlans()
    {
        return $this->planRepo->all();
    }
}
