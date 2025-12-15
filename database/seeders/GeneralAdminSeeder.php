<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: GeneralAdminSeeder.php
 * Created on: 14/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 14/12/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: General admin seeder for initial admin users |
 * 
 */

namespace Database\Seeders;

use App\Models\GeneralAdmin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeneralAdmin::firstOrCreate([
            'user_id' => 1
        ]);
    }
}
