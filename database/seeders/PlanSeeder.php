<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
     public function run(): void
    {
        Plan::insert([
            [
                'name' => 'Basic',
                'price' => 10.00,
                'currency' => 'USD',
                'description' => 'Basic features for individuals',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pro',
                'price' => 20.00,
                'currency' => 'USD',
                'description' => 'Advanced features for professionals',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Full',
                'price' => 30.00,
                'currency' => 'USD',
                'description' => 'Full features for teams and companies',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
