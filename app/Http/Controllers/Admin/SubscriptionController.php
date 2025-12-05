<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: SubscriptionController.php
 * Created on: 04/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Date: 04/12/2025
 *   Modified by: Daniel Yair Mendoza Alvarez
 *   Description: SubscriptionController implementation. |
 */


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSubscriptionRequest;
use App\Models\Subscription;
use App\Services\Admin\SubscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{

    protected SubscriptionService $subscriptionService;

    /**
     * Constructor to inject dependencies.
     *
     * @param SubscriptionService $subscriptionService
     */
    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        // Retrieve paginated plans from service
        $subscriptions = $this->subscriptionService->getSubscriptionsList(10);
        return view('modules.admin.subscriptions.index', compact('subscriptions'));
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
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        // Retrieve the subscription via service
        $subscription = $this->subscriptionService->getSubscriptionById($id);
        return view('modules.admin.subscriptions.edit', compact('subscription'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSubscriptionRequest $request Validated request.
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdateSubscriptionRequest $request, int $id): RedirectResponse
    {
        // Retrieve instance
        $subscription = $this->subscriptionService->getSubscriptionById($id);
        // Delegate update logic to service
        $this->subscriptionService->updateSubscription($subscription, $request->validated());
        return redirect()->route('qpk.subscriptions.index')->with('swal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'Los datos de la suscripción se han actualizado correctamente.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
