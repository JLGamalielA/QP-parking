<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ParkingEntryController.php
 * Created on: 24/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 24/11/2025 | }
 *   Modified by: Daniel Yair Mendoza Alvarez | 
 *   Description: Controller for managing parking entry scanners. |
 */

namespace App\Http\Controllers\ParkingAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParkingEntry\StoreParkingEntryRequest;
use App\Http\Requests\ParkingEntry\UpdateParkingEntryRequest;
use App\Models\Parking;
use App\Models\ParkingEntry;
use App\Services\ParkingEntry\ParkingEntryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ParkingEntryController extends Controller
{

    // Protected property for ParkingEntryService
    protected ParkingEntryService $entryService;

    /**
     * Constructor to initialize ParkingEntryService.
     */
    public function __construct(ParkingEntryService $entryService)
    {
        $this->entryService = $entryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parking = Parking::where('user_id', Auth::id())->first();

        if (!$parking) {
            return view('modules.parking_admin.parkings.no-elements');
        }

        $entries = $parking->parkingEntries()->orderBy('parking_entry_id', 'desc')->paginate(10);

        if ($entries->isEmpty()) {
            return view('modules.parking_admin.parking_entries.no-elements');
        }

        return view('modules.parking_admin.parking_entries.index', compact('entries', 'parking'));
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        return view('modules.parking_admin.parking_entries.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreParkingEntryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreParkingEntryRequest $request): RedirectResponse
    {
        try {
            $this->entryService->createEntry($request->validated());

            return redirect()->route('qpk.parking-entries.index')->with('swal', [
                'icon'  => 'success',
                'title' => '¡Éxito!',
                'text'  => 'El lector se ha registrado correctamente.',
            ]);
        } catch (\Exception $e) {
            return back()->with('swal', [
                'icon'  => 'error',
                'title' => 'Error',
                'text'  => 'No se pudo guardar el lector. Intenta nuevamente.',
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ParkingEntry $parkingEntry) {}

    /**
     * Show the form for editing the specified resource.
     * @return View
     */
    public function edit(ParkingEntry $parkingEntry): View
    {
        return view('modules.parking_admin.parking_entries.edit', ['entry' => $parkingEntry]);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateParkingEntryRequest $request
     * @param ParkingEntry $parkingEntry
     * @return RedirectResponse
     */
    public function update(UpdateParkingEntryRequest $request, int $id): RedirectResponse
    {
        try {
            $entry = ParkingEntry::findOrFail($id);
            $this->entryService->updateEntry($entry, $request->validated());

            return redirect()->route('qpk.parking-entries.index')->with('swal', [
                'icon' => 'success',
                'title' => '¡Éxito!',
                'text' => 'El lector ha sido actualizado correctamente.',
            ]);
        } catch (\Exception $e) {
            return back()->with('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo actualizar el lector.',
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param ParkingEntry $parkingEntry
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $status = $this->entryService->deleteEntryById($id);
        return match ($status) {
            'success' => redirect()->route('qpk.parking-entries.index')->with('swal', [
                'icon' => 'success',
                'title' => '¡Éxito!',
                'text' => 'El lector ha sido eliminado correctamente.',
            ]),
            'not_found' => redirect()->route('qpk.parking-entries.index')->with('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'El lector ya no existe o fue eliminado previamente.',
            ]),
            default => back()->with('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo eliminar el lector.',
            ]),
        };
    }
}
