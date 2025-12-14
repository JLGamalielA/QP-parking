<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: PremiumPlanMiddleware.php
 * Created on: 11/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 11/12/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Middleware to restrict access to premium plan users |
 * 
 */

namespace App\Http\Middleware;

use Closure;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PremiumPlanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hasPremium = UserSubscription::where('user_id', Auth::id())
            ->where('subscription_id', 2)
            ->where('is_active', true)
            ->where('end_date', '>=', now())
            ->exists();

        if (!$hasPremium) {
            $prefix = config('proj.route_name_prefix', 'proj');
            return redirect()->route($prefix . '.parkings.index');
        }

        return $next($request);
    }
}
