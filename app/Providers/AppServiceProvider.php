<?php

namespace App\Providers;

use App\Repositories\Eloquent\PlanRepositoryEloquent;
use App\Repositories\Interfaces\PlanRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
            $this->app->bind(PlanRepositoryInterface::class, PlanRepositoryEloquent::class);

    }

    public function boot(): void
    {
    }
}
