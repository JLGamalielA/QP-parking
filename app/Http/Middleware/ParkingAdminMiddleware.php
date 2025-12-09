<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ParkingAdminMiddleware.php
 * Created on: 07/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 07/12/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Middleware to protect parking admin routes. |
 */


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ParkingAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->subscription || ! $user->subscription->is_active) {

            return redirect()->route('qpk.parking-plans.index');
        }

        return $next($request);
    }
}
