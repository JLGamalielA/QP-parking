<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: DashboardController.php
 * Created on: 24/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 24/11/2025 | 
 *   Modified by: Daniel Yair Mendoza Alvarez | 
 *   Description: Controller for managing the dashboard view and related data. |
 */


namespace App\Http\Controllers\ParkingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Parking;
use App\Services\ParkingMetric\ParkingMetricService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Service instance for calculating financial and operational metrics.
     *
     * @var ParkingMetricService
     */
    protected ParkingMetricService $metricsService;

    /**
     * Constructor to inject dependencies.
     *
     * @param ParkingMetricService $metricsService
     */
    public function __construct(ParkingMetricService $metricsService)
    {
        $this->metricsService = $metricsService;
    }

    /**
     * Display the main dashboard view with income statistics and charts.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        // Retrieve the parking associated with the authenticated user
        $parking = Parking::where('user_id', Auth::id())->first();

        // Validation: Check if the user has a parking registered
        if (!$parking) {
            return view('modules.parking_admin.parkings.no-elements');
        }

        // 1. Retrieve income statistics (Daily, Weekly, Monthly)
        // Delegate business logic to the Service layer (Manual Section 6.7)
        $stats = $this->metricsService->getIncomeStats($parking->parking_id);

        // 2. Retrieve chart data for the "Last 7 Days" income overview
        $chartData = $this->metricsService->getChartData($parking->parking_id);

        // Render the view with the prepared data
        return view('modules.parking_admin.dashboard.index', compact('parking', 'stats', 'chartData'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(int $id)
    {
        //
    }

    public function edit(int $id)
    {
        //
    }

    public function update(Request $request, int $id)
    {
        //
    }

    public function destroy(int $id)
    {
        //
    }

    /**
     * AJAX Endpoint: Get chart data based on the selected time period.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function chartData(Request $request): JsonResponse
    {
        $parking = Parking::where('user_id', Auth::id())->first();

        if (!$parking) {
            return response()->json(['error' => 'Parking not found'], 404);
        }

        // Validate period (day, week, month). Default to week.
        $period = $request->input('period', 'week');

        // Get data from service
        $data = $this->metricsService->getChartData($parking->parking_id, $period);

        return response()->json($data);
    }
}
