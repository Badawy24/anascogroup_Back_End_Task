<?php
namespace App\Repositories\Eloquent;

use App\Models\Plan;
use App\Repositories\Interfaces\PlanRepositoryInterface;

class PlanRepositoryEloquent implements PlanRepositoryInterface
{
    public function all()
    {
        return Plan::all();
    }
}
