<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: AdminDashboardController.php
 * Created on: 03/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Date: 03/12/2025
 *   Modified by: Daniel Yair Mendoza Alvarez
 *   Description: AdminDashboardController implementation. |
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{

    protected UserService $userService;

    /**
     * Constructor to inject dependencies.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the users.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return view('modules.admin.dashboard.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
