<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: web.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Route definitions for QParking application following CETAM standards. |
 */

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ParkingOwnerController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\ParkingAdmin\ActiveUserQrScanController;
use App\Http\Controllers\ParkingAdmin\DashboardController;
use App\Http\Controllers\ParkingAdmin\ManualAccessController;
use App\Http\Controllers\ParkingAdmin\ParkingController;
use App\Http\Controllers\ParkingAdmin\ParkingEntryController;
use App\Http\Controllers\ParkingAdmin\ParkingPlanController;
use App\Http\Controllers\ParkingAdmin\SpecialParkingRoleController;
use App\Http\Controllers\ParkingAdmin\SpecialParkingUserController;
use App\Http\Controllers\ParkingAdmin\SpecialUserApplicationController;
use App\Livewire\BootstrapTables;
use App\Livewire\Components\Buttons;
use App\Livewire\Components\Forms;
use App\Livewire\Components\Modals;
use App\Livewire\Components\Notifications;
use App\Livewire\Components\Typography;
use App\Livewire\Dashboard;
use App\Livewire\Err404;
use App\Livewire\Err500;
use App\Livewire\ResetPassword;
use App\Livewire\ForgotPassword;
use App\Livewire\Lock;
use App\Livewire\Auth\Login;
use App\Livewire\Profile;
use App\Livewire\Auth\Register;
use App\Livewire\ForgotPasswordExample;
use App\Livewire\Index;
use App\Livewire\LoginExample;
use App\Livewire\ProfileExample;
use App\Livewire\RegisterExample;
use App\Livewire\Transactions;
use Illuminate\Support\Facades\Route;
use App\Livewire\ResetPasswordExample;
use App\Livewire\UpgradeToPro;
use App\Livewire\Users;

/*
  Web Routes
  Here is where you can register web routes for your application. These
  routes are loaded by the RouteServiceProvider within a group which
   contains the "web" middleware group. Now create something great!
 */

// Configurable project prefix: /p/<slug>
$slug = config('proj.slug');
$namePrefix = config('proj.route_name_prefix', 'proj');

// Base redirect to login within the prefix
Route::redirect('/', "/p/{$slug}/login");

Route::prefix("p/{$slug}")
    ->as($namePrefix . '.')
    ->group(function () use ($namePrefix) {
        // Public
        Route::get('/register', Register::class)->name('auth.register');
        Route::get('/login', Login::class)->name('auth.login');
        Route::get('/forgot-password', ForgotPassword::class)->name('auth.forgot-password');
        Route::get('/reset-password/{id}', ResetPassword::class)->name('auth.reset-password')->middleware('signed');

        // Errors and informational pages
        Route::get('/404', Err404::class)->name('errors.404');
        Route::get('/500', Err500::class)->name('errors.500');
        Route::get('/upgrade-to-pro', UpgradeToPro::class)->name('marketing.upgrade-to-pro');

        // Private
        Route::middleware('auth')->group(function () {

            Route::middleware('admin')->group(function () {
                Route::resource('admin-dashboard', AdminDashboardController::class);
                Route::resource('subscriptions', SubscriptionController::class);
            });

            Route::get('parking-plans/{subscription}/checkout', [ParkingPlanController::class, 'checkout'])
                ->name('parking-plans.checkout');
            Route::resource('parking-plans', ParkingPlanController::class);

            Route::middleware('parkingAdmin')->group(function () {
                Route::get('/dashboard/chart', [DashboardController::class, 'chartData'])
                    ->name('dashboard.chart');
                Route::resource('/dashboard', DashboardController::class);
                // Parking Management
                Route::resource('parkings', ParkingController::class);
                // Special Roles (Using kebab-case for URLs)
                Route::resource('special-parking-roles', SpecialParkingRoleController::class);
                // Parking Entries (Readers)
                Route::resource('parking-entries', ParkingEntryController::class);

                Route::resource('parking-entries.manual-access', ManualAccessController::class);

                // Active QR Scans
                Route::resource('active-user-qr-scans', ActiveUserQrScanController::class);

                Route::put('/special-user-applications/{id}/approve', [SpecialUserApplicationController::class, 'approve'])
                    ->name('special-user-applications.approve');

                Route::resource('special-user-applications', SpecialUserApplicationController::class);
                // Special Parking Users
                Route::resource('special-parking-users', SpecialParkingUserController::class);
            });
        });
    });
