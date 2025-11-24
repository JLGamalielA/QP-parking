<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ScannerInteractionController.php
 * Created on: 24/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 24/11/2025 | 
 *   Modified by: Daniel Yair Mendoza Alvarez | 
 *   Description: Controller handling AJAX requests from physical QR scanners. |
 */

namespace App\Http\Controllers\ParkingAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Scanner\ProcessQrScanRequest;
use App\Services\Scanner\QrScanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScannerInteractionController extends Controller
{

    // Protected property for QrScanService
    protected QrScanService $scanService;

    /**
     * Constructor to initialize QrScanService.
     */
    public function __construct(QrScanService $scanService)
    {
        $this->scanService = $scanService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Process the incoming QR code from the physical scanner.
     *
     * @param ProcessQrScanRequest $request
     * @return JsonResponse
     */
    public function store(ProcessQrScanRequest $request): JsonResponse
    {
        try {
            $result = $this->scanService->processScan($request->validated());

            return response()->json($result, 200);
        } catch (\Exception $e) {
            // Return JSON error following API standards (Section 6.8)
            return response()->json([
                'status' => 'error',
                'error' => [
                    'code' => $e->getCode() ?: 500,
                    'message' => $e->getMessage()
                ]
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(QrScanService $qrScanService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QrScanService $qrScanService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QrScanService $qrScanService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QrScanService $qrScanService)
    {
        //
    }
}
