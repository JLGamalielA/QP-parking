<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: AdminMiddleware.php
 * Created on: 07/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 07/12/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Middleware to restrict access to general admin users. |
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isGeneralAdmin()) {
            return $next($request);
        }
        return redirect()->route('qpk.dashboard.index');
    }
}
