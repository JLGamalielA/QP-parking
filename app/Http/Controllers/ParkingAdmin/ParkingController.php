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
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Refactored ParkingController (Admin Module) to comply with thin controller architecture. |
 */

namespace App\Http\Controllers\ParkingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Parking;
use App\Http\Requests\Parking\StoreParkingRequest;
use App\Http\Requests\Parking\UpdateParkingRequest;
use App\Services\Parking\ParkingValidationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ParkingController extends Controller
{
    protected ParkingValidationService $validationService;

    /**
     * Constructor dependency injection.
     *
     * @param ParkingValidationService $validationService
     */
    public function __construct(ParkingValidationService $validationService)
    {
        $this->validationService = $validationService;
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
    public function create(): View
    {
        return view('parking_admin.parkings.create');
    }

    /**
     * Store a newly created parking in storage.
     *
     * @param StoreParkingRequest $request
     * @return RedirectResponse
     */
    public function store(StoreParkingRequest $request): RedirectResponse
    {
        // Business logic validation (Geofence check) via Service
        if ($error = $this->validationService->validateGeofence($request->validated())) {
            return back()->withErrors($error)->withInput();
        }

        // Create parking associated with the authenticated user
        Parking::create(array_merge(
            $request->validated(),
            ['user_id' => Auth::id()]
        ));

        return redirect()->route('parking_admin.parkings.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Estacionamiento creado!',
                'text' => 'El estacionamiento ha sido creado correctamente.'
            ]);
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
        return view('parking_admin.parkings.edit', compact('parking'));
    }

    /**
     * Update the specified parking in storage.
     *
     * @param UpdateParkingRequest $request
     * @param Parking $parking
     * @return RedirectResponse
     */
    // public function update(UpdateParkingRequest $request, Parking $parking): RedirectResponse
    // {
    //     // Business logic validation (Geofence check excluding self)
    //     if ($error = $this->validationService->validateGeofence($request->validated(), $parking->parking_id)) {
    //         return back()->withErrors($error)->withInput();
    //     }

    //     $parking->update($request->validated());

    //     return redirect()->route('parking_admin.parkings.index')
    //         ->with('swal', [
    //             'icon' => 'success',
    //             'title' => '¡Estacionamiento actualizado!',
    //             'text' => 'El estacionamiento ha sido actualizado correctamente.',
    //         ]);
    // }

    /**
     * Remove the specified parking from storage.
     *
     * @param Parking $parking
     * @return RedirectResponse
     */
    public function destroy(Parking $parking): RedirectResponse
    {
        $parking->delete();

        return redirect()->route('parking_admin.parkings.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Estacionamiento eliminado!',
                'text' => 'El estacionamiento ha sido eliminado correctamente.',
            ]);
    }
}
