<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: DatabaseSeeder.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Database seeder for initial data |
 * 
 */


namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SubscriptionSeeder::class,
            UserSeeder::class,
            GeneralAdminSeeder::class,
            UserSubscriptionSeeder::class,
            ParkingSeeder::class,
            SpecialParkingRoleSeeder::class,
            SpecialUserApplicationSeeder::class,
        ]);
    }
}
