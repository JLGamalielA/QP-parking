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
use App\Http\Requests\ActiveUserQrScan\ProcessQrScanRequest;
use App\Models\ActiveUserQrScan;
use App\Models\Parking;
use App\Services\ActiveUserQrScan\QrAccessService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ActiveUserQrScanController extends Controller
{

    // Protected property for QrAccessService
    protected QrAccessService $qrService;

    /**
     * Constructor to initialize QrAccessService.
     */
    public function __construct(QrAccessService $qrService)
    {
        $this->qrService = $qrService;
    }

    /**
     * Display a listing of active scans with search capability.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $parking = Parking::where('user_id', Auth::id())->first();

        if (!$parking) {
            return view('modules.parking_admin.parkings.no-elements');
        }

        $search = $request->input('search');

        // Delegate data retrieval to Service (Business Logic)
        $activeEntries = $this->qrService->getActiveScans(
            $parking->parking_id,
            $search,
            5
        );

        // View Logic: Determine which view to render based on emptiness and search context
        if ($activeEntries->isEmpty() && empty($search)) {
            return view('modules.parking_admin.active_user_qr_scans.no-elements');
        }

        return view('modules.parking_admin.active_user_qr_scans.index', compact('activeEntries', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Process the incoming QR scan from Web Serial API.
     */
    public function store(ProcessQrScanRequest $request): JsonResponse
    {
        $data = $request->validated();
        // Logic delegated to service
        $result = $this->qrService->processScan(
            (int) $data['code'],
            (int) $data['parking_id'],
            (int) $data['entry_id']
        );
        if (!$result['ok']) {
            // Returns JSON error. JS catches this in the 'else' block.
            return response()->json($result, $result['code'] ?? 400);
        }
        // Returns JSON success. JS catches this in the 'if (response.ok)' block.
        return response()->json($result);
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
     * Remove the specified resource from storage (Force Manual Exit).
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        // Delegate business logic (force exit transaction) to the service
        $result = $this->qrService->forceExit($id);

        if (request()->wantsJson()) {
            if (!$result['ok']) {
                return response()->json(['error' => $result['error']], 500);
            }

            $qrImage = QrCode::format('svg')->size(200)->generate($result['value']);

            return response()->json([
                'html'    => (string) $qrImage,
                'message' => $result['message'],
                'qrText' => $result['value'],
                'amount'  => number_format($result['amount'], 2)
            ]);
        }

        if ($result['ok']) {
            return redirect()->route('qpk.active-user-qr-scans.index')->with('swal', [
                'icon'  => 'success',
                'title' => '¡Éxito!',
                'text'  => $result['message'],
            ]);
        }
        // Handle logical errors (not found or transaction failed)
        return back()->with('swal', [
            'icon'  => 'error',
            'title' => 'Error',
            'text'  => $result['error'] ?? 'No se pudo liberar la entrada.',
        ]);
    }
}
