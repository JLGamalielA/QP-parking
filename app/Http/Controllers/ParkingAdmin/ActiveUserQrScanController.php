<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ActiveUserQrScanController.php
 * Created on: 24/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 24/11/2025 | 
 *   Modified by: Daniel Yair Mendoza Alvarez | 
 *   Description: Controller for listing active user scans (users currently inside). |
 */

namespace App\Http\Controllers\ParkingAdmin;

use App\Http\Controllers\Controller;
use App\Models\ActiveUserQrScan;
use App\Models\Parking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ActiveUserQrScanController extends Controller
{
    /**
     * Display a listing of active scans (users currently in parking).
     *
     * @return View
     */
    public function index(): View
    {
        $parking = Parking::where('user_id', Auth::id())->first();

        if (!$parking) {
            return view('modules.parking_admin.parkings.no-elements');
        }

        // Get all entry IDs for this parking
        $entryIds = $parking->entries()->pluck('parking_entry_id');

        // Fetch active scans related to those entries
        $activeEntries = ActiveUserQrScan::whereIn('parking_entry_id', $entryIds)
            ->with(['user', 'parkingEntry']) // Eager load relationships
            ->orderBy('active_user_qr_scan_id', 'desc')
            ->paginate(10);

        if ($activeEntries->isEmpty()) {
            return view('modules.parking_admin.active_user_qr_scans.no-elements');
        }

        return view('modules.parking_admin.active_user_qr_scans.index', compact('activeEntries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ActiveUserQrScan $activeUserQrScan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActiveUserQrScan $activeUserQrScan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActiveUserQrScan $activeUserQrScan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActiveUserQrScan $activeUserQrScan)
    {
        //
    }
}
