<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ManualAccessController.php
 * Created on: 06/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 06/12/2025 | 
 *   Modified by: Daniel Yair Mendoza Alvarez | 
 *   Description: Controller for handling manual access registration via phone number |
 * 
 */

namespace App\Http\Controllers\ParkingAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManualAccess\StoreManualAccessRequest;
use App\Models\ParkingEntry;
use App\Models\User;
use App\Services\ActiveUserQrScan\QrAccessService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManualAccessController extends Controller
{

    // Service instance for QR access handling
    protected QrAccessService $qrService;

    /**
     * Constructor to inject dependencies.
     *
     * @param QrAccessService $qrService
     */
    public function __construct(QrAccessService $qrService)
    {
        $this->qrService = $qrService;
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
     * (Replaces createManualAccess)
     *
     * @param ParkingEntry $parkingEntry
     * @return View
     */
    public function create(ParkingEntry $parkingEntry): View
    {
        return view('modules.parking_admin.manual_access.create', compact('parkingEntry'));
    }

    /**
     * Store a newly created resource in storage.
     * (Replaces storeManualAccess)
     *
     * @param StoreManualAccessRequest $request
     * @param ParkingEntry $parkingEntry // ID from the URL
     * @return RedirectResponse
     */
    public function store(StoreManualAccessRequest $request, ParkingEntry $parkingEntry): RedirectResponse
    {
        // 1. Find User
        $user = User::where('phone_number', $request->phone_number)->first();

        // 2. Delegate to Service
        $result = $this->qrService->processScan(
            $user->user_id,
            $parkingEntry->parking_id,
            $parkingEntry->parking_entry_id
        );

        if (!$result['ok']) {
            return back()->withInput()->with('swal', [
                'icon'  => 'error',
                'title' => 'Error',
                'text'  => $result['error'] ?? 'Ocurrió un error inesperado.',
            ]);
        }

        // 3. Success Feedback
        $type = $result['data']['action'] === 'entry' ? 'entrada' : 'salida';
        $msg = "La {$type} se ha registrado correctamente.";
        
        if ($type === 'salida' && isset($result['data']['amount_paid'])) {
            $msg .= " Monto cobrado: $" . number_format($result['data']['amount_paid'], 2);
        }

        return redirect()->route('qpk.parking-entries.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => $msg,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ParkingEntry $parkingEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParkingEntry $parkingEntry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParkingEntry $parkingEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParkingEntry $parkingEntry)
    {
        //
    }
}
