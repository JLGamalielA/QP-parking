<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ParkingController.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Refactored ParkingController (Admin Module) to comply with thin controller architecture. |
 */

namespace App\Http\Controllers\ParkingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Parking;
use App\Http\Requests\Parking\StoreParkingRequest;
use App\Services\Parking\ParkingValidationService;
use App\Services\Parking\StoreParkingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Parking\ParkingService;
use App\Http\Requests\Parking\UpdateParkingRequest;
use App\Services\Parking\UpdateParkingService;

class ParkingController extends Controller
{
    protected ParkingValidationService $validationService;
    protected StoreParkingService $storeService;
    protected ParkingService $parkingService;
    protected UpdateParkingService $updateService;

    /**
     * Constructor dependency injection.
     *
     * @param ParkingValidationService $validationService
     * @param StoreParkingService $storeService
     * @param ParkingService $parkingService
     * @param UpdateParkingService $updateService
     */
    public function __construct(
        ParkingValidationService $validationService,
        StoreParkingService $storeService,
        ParkingService $parkingService,
        UpdateParkingService $updateService
    ) {
        $this->validationService = $validationService;
        $this->storeService = $storeService;
        $this->parkingService = $parkingService;
        $this->updateService = $updateService;
    }

    /**
     * Display the user's parking information.
     *
     * @return View
     */
    public function index(): View
    {
        $parking = Parking::where('user_id', Auth::id())->first();

        if (!$parking) {
            return view('modules.parking_admin.parkings.no-elements');
        }

        return view('modules.parking_admin.parkings.index', compact('parking'));
    }

    /**
     * Show the form for creating a new parking.
     *
     * @return View
     */
    public function create(): View | RedirectResponse
    {
        if (Parking::where('user_id', Auth::id())->exists()) {
            return redirect()->route('qpk.parkings.index');
        }
        return view('modules.parking_admin.parkings.create');
    }

    /**
     * Store a newly created parking in storage.
     *
     * @param StoreParkingRequest $request
     * @return RedirectResponse
     */
    public function store(StoreParkingRequest $request): RedirectResponse
    {
        // 1. Geofence Validation
        if ($error = $this->validationService->validateGeofence($request->validated())) {
            return back()->withErrors($error)->withInput();
        }
        try {
            // 2. Execute Transaction via Service
            $this->storeService->execute(
                $request->safe()->except(['schedules']),
                $request->input('schedules')
            );

            return redirect()->route('qpk.parkings.index')->with('swal', [
                'icon'  => 'success',
                'title' => '¡Éxito!',
                'text'  => 'El estacionamiento se ha registrado correctamente.',
            ]);
        } catch (\Exception $e) {
            // Log error here if needed
            return back()->with('swal', [
                'icon'  => 'error',
                'title' => 'Error',
                'text'  => 'Ocurrió un error inesperado al guardar. Por favor intenta de nuevo.',
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Parking $parking
     * @return void
     */
    public function show(Parking $parking)
    {
        // Not implemented
    }

    /**
     * Show the form for editing the specified parking.
     *
     * @param Parking $parking
     * @return View
     */
    public function edit(Parking $parking): View
    {
        // Use the General Service to prepare data
        $schedules = $this->parkingService->prepareScheduleForEdit($parking);
        return view('modules.parking_admin.parkings.edit', compact('parking', 'schedules'));
    }

    /**
     * Update the specified parking in storage.
     *
     * @param UpdateParkingRequest $request
     * @param Parking $parking
     * @return RedirectResponse
     */
    public function update(UpdateParkingRequest $request, Parking $parking): RedirectResponse
    {
        // 1. Geofence Validation (Excluding current parking ID)
        if ($error = $this->validationService->validateGeofence($request->validated(), $parking->parking_id)) {
            return back()->withErrors($error)->withInput();
        }
        try {
            // 2. Execute Update Transaction via Service
            $this->updateService->execute(
                $parking,
                $request->safe()->except(['schedules']),
                $request->input('schedules')
            );

            return redirect()->route('qpk.parkings.index')->with('swal', [
                'icon'  => 'success',
                'title' => '¡Actualizado!',
                'text'  => 'La información del estacionamiento se ha actualizado correctamente.',
            ]);
        } catch (\Exception $e) {
            return back()->with('swal', [
                'icon'  => 'error',
                'title' => 'Error',
                'text'  => 'Ocurrió un error inesperado al actualizar. Por favor intenta de nuevo.',
            ])->withInput();
        }
    }


    /**
     * Remove the specified parking from storage.
     *
     * @param Parking $parking
     * @return RedirectResponse
     */
    public function destroy(Parking $parking): RedirectResponse
    {
        $parking->delete();

        return redirect()->route('qpk.parkings.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Estacionamiento eliminado!',
                'text' => 'El estacionamiento ha sido eliminado correctamente.',
            ]);
    }
}
