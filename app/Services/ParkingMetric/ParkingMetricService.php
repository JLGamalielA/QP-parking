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

        $daily = ParkingTransaction::where('parking_id', $parkingId)
            ->whereDate('created_at', $now->today())
            ->sum('amount_paid');

        $weekly = ParkingTransaction::where('parking_id', $parkingId)
            ->whereBetween('created_at', [
                $now->copy()->startOfWeek(Carbon::MONDAY),
                $now->copy()->endOfWeek(Carbon::SUNDAY)
            ])
            ->sum('amount_paid');

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
     * Main entry point for chart data retrieval.
     *
     * @param int $parkingId
     * @param string $period 'day', 'week', 'month'
     * @return array
     */
    public function getChartData(int $parkingId, string $period = 'week'): array
    {
        Carbon::setLocale('es');
        $now = Carbon::now();

        // 1. Define range and format configuration based on period
        $config = $this->getPeriodConfig($period, $now);

        // 2. Fetch raw transactions from DB
        $rawTransactions = $this->getTransactionsForPeriod(
            $parkingId,
            $config['startDate'],
            $config['endDate']
        );

        // 3. Group transactions using Collections (Avoids SQL strict mode errors)
        $groupedTransactions = $this->groupTransactions($rawTransactions, $config['formatKey']);

        // 4. Build the final chart data structure
        return $this->buildChartArrays(
            $groupedTransactions,
            $config,
            $period
        );
    }

    /**
     * Helper: Define configuration for the requested period.
     * @param string $period
     * @param Carbon $now
     * @return array
     */
    private function getPeriodConfig(string $period, Carbon $now): array
    {
        if ($period === 'day') {
            return [
                'startDate'     => $now->copy()->startOfDay(),
                'endDate'       => $now->copy()->endOfDay(),
                'formatKey'     => 'H',         // Group key (e.g. "14")
                'iteratorCount' => 24,
                'addMethod'     => 'addHour',
                'dateFormat'    => 'H:00'       // Label format
            ];
        } elseif ($period === 'month') {
            $startDate = $now->copy()->startOfMonth();
            return [
                'startDate'     => $startDate,
                'endDate'       => $now->copy()->endOfMonth(),
                'formatKey'     => 'Y-m-d',
                'iteratorCount' => $startDate->daysInMonth,
                'addMethod'     => 'addDay',
                'dateFormat'    => null // Will use isoFormat in loop
            ];
        }

        // Default: Week
        return [
            'startDate'     => $now->copy()->startOfWeek(Carbon::MONDAY),
            'endDate'       => $now->copy()->endOfWeek(Carbon::SUNDAY),
            'formatKey'     => 'Y-m-d',
            'iteratorCount' => 7,
            'addMethod'     => 'addDay',
            'dateFormat'    => null
        ];
    }

    /**
     * Helper: Fetch transactions from database without grouping.
     * @param int $parkingId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return Collection
     */
    private function getTransactionsForPeriod(int $parkingId, Carbon $startDate, Carbon $endDate): Collection
    {
        return ParkingTransaction::where('parking_id', $parkingId)
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
    }

    /**
     * Helper: Group raw transactions by the specified time format key.
     * @param Collection $transactions
     * @param string $formatKey
     * @return Collection
     */
    private function groupTransactions(Collection $transactions, string $formatKey): Collection
    {
        return $transactions->groupBy(function ($item) use ($formatKey) {
            return $item->created_at->format($formatKey);
        });
    }

    /**
     * Helper: Iterate through the time range and build chart series data.
     * @param Collection $groupedTransactions
     * @param array $config
     * @param string $period
     * @return array
     */
    private function buildChartArrays(Collection $groupedTransactions, array $config, string $period): array
    {
        $categories = [];
        $normalData = [];
        $specialData = [];
        $totalData = [];

        $currentDate = $config['startDate']->copy();

        for ($i = 0; $i < $config['iteratorCount']; $i++) {
            // Generate Key and Label
            if ($period === 'day') {
                $key = $currentDate->format('H');
                $label = $currentDate->format($config['dateFormat']);
            } else {
                $key = $currentDate->format('Y-m-d');
                // Format: "Lun 02" or "02 Dic"
                $label = ucfirst($currentDate->isoFormat($period === 'month' ? 'DD MMM' : 'ddd DD'));
            }

            $categories[] = $label;

            // Calculate values for this specific time slot
            $values = $this->calculateSeriesValues($groupedTransactions, $key);

            $normalData[]  = $values['normal'];
            $specialData[] = $values['special'];
            $totalData[]   = $values['total'];

            // Advance time
            $method = $config['addMethod'];
            $currentDate->$method();
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

    /**
     * Helper: Sum amounts for a specific group/slot.
     * @param Collection $groupedTransactions
     * @param string $key
     * @return array
     */
    private function calculateSeriesValues(Collection $groupedTransactions, string $key): array
    {
        $slotTransactions = $groupedTransactions->get($key, collect());

        $normalAmount = $slotTransactions->where('is_special', 0)->sum('amount_paid');
        $specialAmount = $slotTransactions->where('is_special', 1)->sum('amount_paid');

        return [
            'normal'  => floatval($normalAmount),
            'special' => floatval($specialAmount),
            'total'   => floatval($normalAmount + $specialAmount)
        ];
    }
}
