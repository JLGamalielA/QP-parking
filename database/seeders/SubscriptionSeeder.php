<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Basic plan
        $plan = Subscription::create([
            'name' => 'Plan Básico',
            'platform' => 'web',
            'duration_days' => 31,
            'price' => 119,
        ]);

        $plan->benefits()->createMany([
            ['benefit' => 'Registro de estacionamiento.'],
            ['benefit' => 'Registro de lectores para estacionamientos.'],
            ['benefit' => 'Soporte para creación de usuarios especiales del estacionamiento.'],
        ]);

        //Premium plan
        $plan = Subscription::create([
            'name' => 'Plan Premium',
            'platform' => 'web',
            'duration_days' => 31,
            'price' => 349,
        ]);

        $plan->benefits()->createMany([
            ['benefit' => 'Todos los beneficios del Plan Básico.'],
            ['benefit' => 'Muestreo de total de ingresos y entradas por día, semana y mes.'],
            ['benefit' => 'Muestreo gráfico de total de ingresos por día, semana y mes.'],
        ]);
    }
}
