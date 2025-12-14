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
 * - ID: 1 | Date: 02/12/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Service to calculate financial metrics (daily, weekly, monthly income) and chart data from transactions |
 * 
 */

namespace App\Services\ParkingMetric;

use App\Models\Parking;
use App\Models\ParkingSchedule;
use App\Models\ParkingTransaction;
use App\Models\UserQrScanHistory;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ParkingMetricService
{
    /**
     * Get comprehensive dashboard data (Metrics + Chart) for a specific period.
     *
     * @param int $parkingId
     * @param string $period 'day', 'week', 'month'
     * @return array
     */
    public function getDashboardData(int $parkingId, string $period): array
    {
        Carbon::setLocale('es');
        $now = Carbon::now();

        // Get configuration (Dates and formats)
        $config = $this->getPeriodConfig($period, $now, $parkingId);

        // Calculate Metrics for Cards (Total Income & Total Entries)
        $metrics = $this->calculateSummaryMetrics($parkingId, $config['startDate'], $config['endDate']);

        // Generate Chart Data
        $chartData = $this->generateChartData($parkingId, $config, $period);

        return [
            'metrics' => $metrics,
            'chart'   => $chartData
        ];
    }

    /**
     * Helper: Calculate total income and entries for the cards.
     * Adjusted to query only UserQrScanHistory for entry counts.
     *
     * @param int $parkingId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array
     */
    private function calculateSummaryMetrics(int $parkingId, Carbon $startDate, Carbon $endDate): array
    {
        // Total Income (Unchanged)
        $income = ParkingTransaction::where('parking_id', $parkingId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount_paid');

        // We use the 'parkingEntry' relationship defined in the model to filter by parking_id.
        $totalEntries = UserQrScanHistory::whereHas('parkingEntry', function ($q) use ($parkingId) {
            $q->where('parking_id', $parkingId);
        })
            ->whereBetween('last_scan_time', [$startDate, $endDate])
            ->count();

        return [
            'income'  => floatval($income),
            'entries' => intval($totalEntries)
        ];
    }

    /**
     * Helper: Orchestrate chart generation.
     *
     * @param int $parkingId
     * @param array $config
     * @param string $period
     * @return array
     */
    private function generateChartData(int $parkingId, array $config, string $period): array
    {
        // Fetch raw transactions
        $rawTransactions = $this->getTransactionsForPeriod($parkingId, $config['startDate'], $config['endDate']);

        // Group them using Collections to avoid SQL strict mode issues
        $groupedTransactions = $this->groupTransactions($rawTransactions, $config['formatKey']);

        // Build arrays for ApexCharts
        return $this->buildChartArrays($groupedTransactions, $config, $period);
    }

    /**
     * Private helper to get period configuration.
     * Delegates specific logic to sub-methods to keep complexity low.
     *
     * @param string $period
     * @param Carbon $now
     * @param int|null $parkingId
     * @return array
     */
    private function getPeriodConfig(string $period, Carbon $now, int $parkingId): array
    {
        if ($period === 'day') {
            return $this->getDailyConfig($now, $parkingId);
        }

        if ($period === 'month') {
            $startDate = $now->copy()->startOfMonth();
            return [
                'startDate'     => $startDate,
                'endDate'       => $now->copy()->endOfMonth(),
                'formatKey'     => 'Y-m-d',
                'iteratorCount' => $startDate->daysInMonth,
                'addMethod'     => 'addDay',
                'dateFormat'    => null
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
     * Specific helper to calculate daily configuration based on parking schedule.
     *
     * @param Carbon $now
     * @param int|null $parkingId
     * @return array
     */
    private function getDailyConfig(Carbon $now, ?int $parkingId): array
    {
        $startOfDay = $now->copy()->startOfDay();
        $endOfDay   = $now->copy()->endOfDay();

        $startHour = 0;
        $endHour   = 23;

        if ($parkingId) {

            $dayOfWeek = $now->dayOfWeek;

            $schedule = ParkingSchedule::where('parking_id', $parkingId)
                ->where('weekday', $dayOfWeek)
                ->first();

            if ($schedule && $schedule->is_open) {
                $open  = Carbon::parse($schedule->opening_time);
                $close = Carbon::parse($schedule->closing_time);

                $startHour = $open->hour;
                // Include closing hour if minutes > 0 (e.g. 18:30 -> include 19:00 slot)
                $endHour = $close->minute > 0 ? $close->hour + 1 : $close->hour;
                // Safety cap
                if ($endHour > 23) $endHour = 23;
            }
        }

        // Start date becomes the Opening Time
        $startDate = $now->copy()->startOfDay()->addHours($startHour);

        // Calculate total hours to display
        $iteratorCount = ($endHour - $startHour) + 1;

        return [
            'startDate'     => $startDate,
            'endDate'       => $endOfDay,
            'formatKey'     => 'H',
            'iteratorCount' => $iteratorCount > 0 ? $iteratorCount : 24,
            'addMethod'     => 'addHour',
            'dateFormat'    => 'H:00'
        ];
    }

    
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

    private function groupTransactions(Collection $transactions, string $formatKey): Collection
    {
        return $transactions->groupBy(function ($item) use ($formatKey) {
            return $item->created_at->format($formatKey);
        });
    }

    private function buildChartArrays(Collection $groupedTransactions, array $config, string $period): array
    {
        $categories = [];
        $normalData = [];
        $specialData = [];
        $totalData = [];

        $currentDate = $config['startDate']->copy();

        for ($i = 0; $i < $config['iteratorCount']; $i++) {
            if ($period === 'day') {
                $key = $currentDate->format('H');
                $label = $currentDate->format($config['dateFormat']);
            } else {
                $key = $currentDate->format('Y-m-d');
                $label = ucfirst($currentDate->isoFormat($period === 'month' ? 'DD MMM' : 'ddd DD'));
            }

            $categories[] = $label;
            $values = $this->calculateSeriesValues($groupedTransactions, $key);

            $normalData[]  = $values['normal'];
            $specialData[] = $values['special'];
            $totalData[]   = $values['total'];

            $method = $config['addMethod'];
            $currentDate->$method();
        }

        return [
            'categories' => $categories,
            'series' => [
                ['name' => 'Usuarios normales', 'type' => 'area', 'data' => $normalData],
                ['name' => 'Usuarios especiales', 'type' => 'area', 'data' => $specialData],
                ['name' => 'Total de ingresos', 'type' => 'line', 'data' => $totalData]
            ]
        ];
    }

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
