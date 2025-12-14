<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: PreventAdminAccess.php
 * Created on: 12/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 12/12/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Middleware to prevent access to admin routes for non-admin users |
 * 
 */


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isGeneralAdmin()) {

            $prefix = config('proj.route_name_prefix', 'proj');
            return redirect()->route($prefix . '.admin-dashboard.index');
        }

        return $next($request);
    }
}
