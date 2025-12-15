<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: UserSubscriptionSeeder.php
 * Created on: 14/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 14/12/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Seeder to assign initial subscriptions to specific users |
 * 
 */

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'daniel@gmail.com')->first();

        $plan = Subscription::find(2);

        if ($user && $plan) {
            UserSubscription::firstOrCreate(
                ['user_id' => $user->user_id],
                [
                    'subscription_id' => $plan->subscription_id,
                    'start_date' => Carbon::now(),
                    'end_date' => Carbon::now()->addDays($plan->duration_days),
                    'is_active' => true,
                ]
            );
        }
    }
}
