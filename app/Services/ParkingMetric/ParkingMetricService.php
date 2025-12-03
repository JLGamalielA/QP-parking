<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ParkingMetricsService.php
 * Created on: 02/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Date: 02/12/2025
 * Modified by: Daniel Yair Mendoza Alvarez
 * Description: Service to calculate financial metrics (daily, weekly, monthly income) and chart data from transactions.
 */

namespace App\Services\ParkingMetric;

use App\Models\Parking;
use App\Models\ParkingTransaction;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ParkingMetricService
{
    /**
     * Get income metrics for a specific parking lot (Cards).
     *
     * @param int $parkingId
     * @return array
     */
    public function getIncomeStats(int $parkingId): array
    {
        $now = Carbon::now();

        // 1. Daily Income (Today)
        $daily = ParkingTransaction::where('parking_id', $parkingId)
            ->whereDate('created_at', $now->today())
            ->sum('amount_paid');

        // 2. Weekly Income (Current Week - Mon to Sun)
        $weekly = ParkingTransaction::where('parking_id', $parkingId)
            ->whereBetween('created_at', [
                $now->copy()->startOfWeek(Carbon::MONDAY),
                $now->copy()->endOfWeek(Carbon::SUNDAY)
            ])
            ->sum('amount_paid');

        // 3. Monthly Income (Current Month)
        $monthly = ParkingTransaction::where('parking_id', $parkingId)
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('amount_paid');

        return [
            'daily'   => $daily,
            'weekly'  => $weekly,
            'monthly' => $monthly,
        ];
    }

    /**
     * Get chart data based on the selected period.
     * Uses Collections to group data, avoiding SQL strict mode errors.
     *
     * @param int $parkingId
     * @param string $period 'day', 'week', 'month'
     * @return array
     */
    public function getChartData(int $parkingId, string $period = 'week'): array
    {
        Carbon::setLocale('es');
        $now = Carbon::now();

        // 1. Define Time Range and Iteration Logic
        if ($period === 'day') {
            $startDate = $now->copy()->startOfDay();
            $endDate   = $now->copy()->endOfDay();
            $formatKey = 'H'; // Group by Hour (00-23)
            $iteratorCount = 24;
            $addMethod = 'addHour';
        } elseif ($period === 'month') {
            $startDate = $now->copy()->startOfMonth();
            $endDate   = $now->copy()->endOfMonth();
            $formatKey = 'Y-m-d'; // Group by Date
            $iteratorCount = $startDate->daysInMonth;
            $addMethod = 'addDay';
        } else {
            // Week (Default)
            $startDate = $now->copy()->startOfWeek(Carbon::MONDAY);
            $endDate   = $now->copy()->endOfWeek(Carbon::SUNDAY);
            $formatKey = 'Y-m-d'; // Group by Date
            $iteratorCount = 7;
            $addMethod = 'addDay';
        }

        // 2. Fetch Raw Transactions (No Group By in SQL to prevent errors)
        // We use selectRaw to calculate 'is_special' efficiently per row
        $rawTransactions = ParkingTransaction::where('parking_id', $parkingId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw("
                created_at, 
                amount_paid,
                (EXISTS (
                    SELECT 1 FROM special_parking_users spu 
                    WHERE spu.user_id = parking_transactions.user_id 
                    AND spu.parking_id = parking_transactions.parking_id
                )) as is_special
            ")
            ->get();

        // 3. Group by Time Unit using Collection
        $grouped = $rawTransactions->groupBy(function ($item) use ($formatKey) {
            return $item->created_at->format($formatKey);
        });

        // 4. Build Chart Arrays
        $categories = [];
        $normalData = [];
        $specialData = [];
        $totalData = [];

        $currentDate = $startDate->copy();

        for ($i = 0; $i < $iteratorCount; $i++) {
            // Generate Key and Label
            if ($period === 'day') {
                $key = $currentDate->format('H'); // e.g., "14"
                $label = $currentDate->format('H:00');
            } else {
                $key = $currentDate->format('Y-m-d'); // e.g., "2025-12-02"
                // Format: "Lun 02" or "02 Dic"
                $label = ucfirst($currentDate->isoFormat($period === 'month' ? 'DD MMM' : 'ddd DD'));
            }

            $categories[] = $label;

            // Retrieve transactions for this time slot
            $slotTransactions = $grouped->get($key, collect());

            // Sum values using Collection methods
            // is_special returns 1 (true) or 0 (false) from SQL
            $normalAmount = $slotTransactions->where('is_special', 0)->sum('amount_paid');
            $specialAmount = $slotTransactions->where('is_special', 1)->sum('amount_paid');
            $totalAmount = $normalAmount + $specialAmount;

            $normalData[] = floatval($normalAmount);
            $specialData[] = floatval($specialAmount);
            $totalData[] = floatval($totalAmount);

            // Advance Date/Time
            $currentDate->$addMethod();
        }

        return [
            'categories' => $categories,
            'series' => [
                [
                    'name' => 'Usuarios Normales',
                    'type' => 'area',
                    'data' => $normalData
                ],
                [
                    'name' => 'Usuarios Especiales',
                    'type' => 'area',
                    'data' => $specialData
                ],
                [
                    'name' => 'Total',
                    'type' => 'line',
                    'data' => $totalData
                ]
            ]
        ];
    }
}
