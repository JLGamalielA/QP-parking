<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: UserFactory.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Updated factory definition to match QPK database schema (split names, phone, credit) |
 * 
 */

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{

    protected $model = User::class;

    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),

            // Generates a 10-digit phone number
            'phone_number' => $this->faker->numerify('##########'),

            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),

            // Default password is 'password'
            'password' => static::$password ??= Hash::make('password'),

            // Generates a random float with 2 decimal places between 0 and 1000
            'credit' => $this->faker->randomFloat(2, 0, 1000),

            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
