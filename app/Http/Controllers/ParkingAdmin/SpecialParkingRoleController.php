<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: SpecialParkingRoleController.php
 * Created on: 24/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 24/11/2025 | 
 * Modified by: Daniel Yair Mendoza Alvarez | 
 * Description: Controller for managing special parking roles (Single entry form). |
 */

namespace App\Http\Controllers\ParkingAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSpecialParkingRoleRequest;
use App\Models\Parking;
use App\Models\SpecialParkingRole;
use App\Services\SpecialParkingRoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SpecialParkingRoleController extends Controller
{

    protected SpecialParkingRoleService $roleService;

    /**
     * Constructor to initialize the SpecialParkingRoleService.
     *
     * @param SpecialParkingRoleService $roleService
     */
    public function __construct(SpecialParkingRoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $parking = Parking::where('user_id', Auth::id())->first();
        if (!$parking) {
            // Redirect to parking creation if no parking exists
            return view('modules.parking_admin.parkings.no-elements');
        }
        $roles = $parking->roles()->paginate(10);
        if ($roles->isEmpty()) {
            return view('modules.parking_admin.special_parking_roles.no-elements');
        }
        return view('modules.parking_admin.special_parking_roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        return view('modules.parking_admin.special_parking_roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSpecialParkingRoleRequest $request
     * @return RedirectResponse
     */
    public function store(StoreSpecialParkingRoleRequest $request): RedirectResponse
    {
        try {
            $this->roleService->createRole($request->validated());

            return redirect()->route('qpk.special-parking-roles.index')->with('swal', [
                'icon'  => 'success',
                'title' => '¡Éxito!',
                'text'  => 'El tipo de usuario se ha registrado correctamente.',
            ]);
        } catch (\Exception $e) {
            return back()->with('swal', [
                'icon'  => 'error',
                'title' => 'Error',
                'text'  => 'No se pudo guardar el registro. Intenta nuevamente.',
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SpecialParkingRole $specialParkingRole)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SpecialParkingRole $specialParkingRole)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SpecialParkingRole $specialParkingRole)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SpecialParkingRole $specialParkingRole)
    {
        //
    }
}
