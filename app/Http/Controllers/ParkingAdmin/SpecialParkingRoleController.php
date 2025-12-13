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
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Controller for managing special parking roles (Single entry form). |
 */

namespace App\Http\Controllers\ParkingAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecialParkingRole\StoreSpecialParkingRoleRequest;
use App\Http\Requests\SpecialParkingRole\UpdateSpecialParkingRoleRequest;
use App\Models\Parking;
use App\Models\SpecialParkingRole;
use App\Services\SpecialParkingRole\SpecialParkingRoleService;
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
        $roles = $parking->specialParkingRoles()->orderBy('special_parking_role_id', 'desc')->paginate(10);
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
     *
     * @param SpecialParkingRole $specialParkingRole
     * @return View
     */
    public function edit(int $id): View | RedirectResponse
    {
        $role = $this->roleService->getRoleById($id);
        if (!$role) {
            return redirect()->route('qpk.special-parking-roles.index')->with('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'El tipo de usuario que intentas editar no existe o fue eliminado.',
            ]);
        }
        return view('modules.parking_admin.special_parking_roles.edit', [
            'role' => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSpecialParkingRoleRequest $request
     * @param SpecialParkingRole $specialParkingRole
     * @return RedirectResponse
     */
    public function update(UpdateSpecialParkingRoleRequest $request, int $id): RedirectResponse
    {
        $role = $this->roleService->getRoleById($id);

        if (!$role) {
            return redirect()->route('qpk.special-parking-roles.index')->with('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'El tipo de usuario que intentas actualizar no existe o fue eliminado.',
            ]);
        }
        try {
            $this->roleService->updateRole($role, $request->validated());

            return redirect()->route('qpk.special-parking-roles.index')->with('swal', [
                'icon'  => 'success',
                'title' => '¡Éxito!',
                'text'  => 'El tipo de usuario ha sido actualizado correctamente.',
            ]);
        } catch (\Exception $e) {
            return back()->with('swal', [
                'icon'  => 'error',
                'title' => 'Error',
                'text'  => 'Ocurrió un problema al actualizar. Intenta nuevamente.',
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        // Delegate business logic (search & delete) to the service
        $status = $this->roleService->deleteRoleById($id);
        // Map service result to HTTP response/UI feedback
        return match ($status) {
            'success' => redirect()->route('qpk.special-parking-roles.index')->with('swal', [
                'icon'  => 'success',
                'title' => '¡Éxito!',
                'text'  => 'El tipo de usuario ha sido eliminado correctamente.',
            ]),
            'not_found' => redirect()->route('qpk.special-parking-roles.index')->with('swal', [
                'icon'  => 'error',
                'title' => 'Error',
                'text'  => 'El tipo de usuario ya no existe o fue eliminado previamente.',
            ]),
            default => back()->with('swal', [
                'icon'  => 'error',
                'title' => 'Error',
                'text'  => 'No se pudo eliminar el registro. Por favor, intente más tarde.',
            ]),
        };
    }
}
