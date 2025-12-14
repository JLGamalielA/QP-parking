<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: SpecialParkingUserController.php
 * Created on: 26/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 26/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Controller for managing special parking users |
 * 
 */

namespace App\Http\Controllers\ParkingAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecialParkingUser\UpdateSpecialParkingUserRequest;
use App\Models\Parking;
use App\Models\SpecialParkingRole;
use App\Models\SpecialParkingUser;
use App\Services\SpecialParkingUser\SpecialParkingUserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SpecialParkingUserController extends Controller
{

    // Protected property for the SpecialParkingUserService
    protected SpecialParkingUserService $userService;

    /**
     * Constructor to initialize the SpecialParkingUserService.
     */
    public function __construct(SpecialParkingUserService $userService)
    {
        $this->userService = $userService;
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

        // Get available roles for the filter dropdown
        $roles = $parking->specialParkingRoles;

        if ($roles->isEmpty()) {
            return view('modules.parking_admin.special_parking_users.no-elements');
        }

        // Get Filter Value
        $roleFilter = $request->input('role_id');
        // Get Data from Service
        $specialUsers = $this->userService->getSpecialUsers($parking->parking_id, $roleFilter, 10);

        // Empty State Logic (Only if table is empty AND no filter applied)
        if ($specialUsers->isEmpty() && empty($roleFilter)) {
            return view('modules.parking_admin.special_parking_users.no-elements');
        }

        return view('modules.parking_admin.special_parking_users.index', compact('specialUsers', 'roles', 'roleFilter'));
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
    public function show(SpecialParkingUser $specialParkingUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SpecialParkingUser $specialParkingUser): View
    {
        $roles = SpecialParkingRole::where('parking_id', $specialParkingUser->parking_id)->get();
        return view('modules.parking_admin.special_parking_users.edit', compact('specialParkingUser', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpecialParkingUserRequest $request, int $id): RedirectResponse
    {
        $status = $this->userService->updateSpecialUser($id, $request->validated());

        return match ($status) {
            'success' => redirect()->route('qpk.special-parking-users.index')->with('swal', [
                'icon' => 'success',
                'title' => '¡Éxito!',
                'text' => 'Los permisos del usuario han sido actualizados correctamente.',
            ]),
            'not_found' => redirect()->route('qpk.special-parking-users.index')->with('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'El usuario especial ya no existe o fue eliminado.',
            ]),
            default => back()->with('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo actualizar el registro. Intente nuevamente.',
            ])->withInput(),
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $status = $this->userService->deleteSpecialUser($id);

        return match ($status) {
            'success' => redirect()->route('qpk.special-parking-users.index')->with('swal', [
                'icon' => 'success',
                'title' => '¡Éxito!',
                'text' => 'El usuario especial ha sido eliminado correctamente.',
            ]),
            'not_found' => redirect()->route('qpk.special-parking-users.index')->with('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'El usuario especial ya no existe o fue eliminado.',
            ]),
            default => back()->with('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo eliminar el registro.',
            ]),
        };
    }
}
