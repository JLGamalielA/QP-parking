<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ParkingPlanController.php
 * Created on: 07/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 07/12/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: ParkingPlanController for managing parking subscription plans. |
 */

namespace App\Http\Controllers\ParkingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ParkingPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View | RedirectResponse
    {
        $user = Auth::user();
        $hasActiveSubscription = $user->subscription && $user->subscription->is_active;
        if ($hasActiveSubscription) {
            $route = ($user->subscription->subscription_id == 2)
                ? 'qpk.dashboard.index'
                : 'qpk.parkings.index';

            return redirect()->route($route);
        }
        $subscriptions = Subscription::with('benefits')->get();
        return view('modules.parking_admin.parking_plan.index', compact('subscriptions'));
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
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        //
    }


    /**
     * Show the checkout form for a specific subscription.
     *
     * @param Subscription $subscription
     * @return View
     */
    public function checkout(Subscription $subscription): View
    {
        // Retornamos la vista pasando el plan seleccionado
        return view('modules.parking_admin.parking_plan.checkout', compact('subscription'));
    }
}
