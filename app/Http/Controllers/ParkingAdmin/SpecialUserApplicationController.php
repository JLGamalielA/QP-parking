<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: SpecialUserApplicationController.php
 * Created on: 26/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 26/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Controller for managing special user parking applications.
 */

namespace App\Http\Controllers\ParkingAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecialUserApplication\ApproveApplicationRequest;
use App\Models\Parking;
use App\Models\SpecialUserApplication;
use App\Services\SpecialUserApplication\SpecialUserApplicationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SpecialUserApplicationController extends Controller
{

    // Service for handling special user parking application logic
    protected SpecialUserApplicationService $applicationService;

    // Dependency injection of the service
    public function __construct(SpecialUserApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $parking = Parking::where('user_id', Auth::id())->first();

        if (!$parking) {
            return view('modules.parking_admin.parkings.no-elements');
        }

        // If no roles exist, guide user to create roles first (Business Rule from old project)
        if ($parking->specialParkingRoles->isEmpty()) {
            return view('modules.parking_admin.special_parking_roles.no-elements');
        }

        $search = $request->input('search');

        $applications = $this->applicationService->getApplications(
            $parking->parking_id,
            $search,
            5
        );

        // Empty state logic
        if ($applications->isEmpty() && empty($search)) {
            return view('modules.parking_admin.special_user_applications.no-elements');
        }

        return view('modules.parking_admin.special_user_applications.index', compact('applications', 'search'));
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
    public function show(SpecialUserApplication $specialUserParkingApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SpecialUserApplication $specialUserParkingApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SpecialUserApplication $specialUserParkingApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage (Reject).
     */
    public function destroy(int $id): RedirectResponse
    {
        $success = $this->applicationService->rejectApplication($id);

        if ($success) {
            return redirect()->back()->with('swal', [
                'icon' => 'success',
                'title' => '¡Exito!',
                'text' => 'La solicitud ha sido eliminada correctamente.',
            ]);
        }

        return back()->with('swal', [
            'icon' => 'error',
            'title' => 'Error',
            'text' => 'La solicitud ya fue rechazada.',
        ]);
    }

    /**
     * Approve the application (Create Special User).
     * Direct action, no extra data required.
     */
    public function approve(int $id): RedirectResponse
    {
        // Call service without date parameter
        $result = $this->applicationService->approveApplication($id);

        if ($result['ok']) {
            return redirect()->route('qpk.special-user-applications.index')->with('swal', [
                'icon' => 'success',
                'title' => '¡Éxito!',
                'text' => 'El usuario ha sido registrado exitosamente.',
            ]);
        }
        return back()->with('swal', [
            'icon' => 'error',
            'title' => 'Error',
            'text' => $result['error'] ?? 'No se pudo aprobar la solicitud.',
        ]);
    }
}
