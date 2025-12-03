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

use App\Http\Controllers\ParkingAdmin\ActiveUserQrScanController;
use App\Http\Controllers\ParkingAdmin\DashboardController;
use App\Http\Controllers\ParkingAdmin\ParkingController;
use App\Http\Controllers\ParkingAdmin\ParkingEntryController;
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
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Prefijo configurable del proyecto: /p/<slug>
$slug = config('proj.slug');
$namePrefix = config('proj.route_name_prefix', 'proj');

// Redirección base a login dentro del prefijo
Route::redirect('/', "/p/{$slug}/login");

Route::prefix("p/{$slug}")
    ->as($namePrefix . '.')
    ->group(function () use ($namePrefix) {
        // Público
        Route::get('/register', Register::class)->name('auth.register');
        Route::get('/login', Login::class)->name('auth.login');
        Route::get('/forgot-password', ForgotPassword::class)->name('auth.forgot-password');
        Route::get('/reset-password/{id}', ResetPassword::class)->name('auth.reset-password')->middleware('signed');

        // Errores y páginas informativas
        Route::get('/404', Err404::class)->name('errors.404');
        Route::get('/500', Err500::class)->name('errors.500');
        Route::get('/upgrade-to-pro', UpgradeToPro::class)->name('marketing.upgrade-to-pro');

        // Privado
        Route::middleware('auth')->group(function () {
            Route::get('/dashboard/chart', [DashboardController::class, 'chartData'])
                ->name('dashboard.chart');
            Route::resource('/dashboard', DashboardController::class);

            // Parking Management
            Route::resource('parkings', ParkingController::class);
            // Special Roles (Using kebab-case for URLs)
            Route::resource('special-parking-roles', SpecialParkingRoleController::class);
            // Parking Entries (Readers)
            Route::resource('parking-entries', ParkingEntryController::class);
            // Active QR Scans
            Route::resource('active-user-qr-scans', ActiveUserQrScanController::class);

            Route::put('/special-user-applications/{id}/approve', [SpecialUserApplicationController::class, 'approve'])
                ->name('special-user-applications.approve');

            Route::resource('special-user-applications', SpecialUserApplicationController::class);
            // Special Parking Users
            Route::resource('special-parking-users', SpecialParkingUserController::class);

            // Parking Requests


            // Scan History
            // Route::resource('user-qr-scan-histories', UserQrScanHistoryControl Gler::class);






            Route::get('/profile', Profile::class)->name('profile.index');
            Route::get('/profile-example', ProfileExample::class)->name('profile.example');
            Route::get('/users', Users::class)->name('users.index');
            Route::get('/login-example', LoginExample::class)->name('examples.login');
            Route::get('/register-example', RegisterExample::class)->name('examples.register');
            Route::get('/forgot-password-example', ForgotPasswordExample::class)->name('examples.forgot-password');
            Route::get('/reset-password-example', ResetPasswordExample::class)->name('examples.reset-password');
            Route::get('/transactions', Transactions::class)->name('billing.transactions');
            Route::get('/bootstrap-tables', BootstrapTables::class)->name('ui.bootstrap-tables');
            Route::get('/lock', Lock::class)->name('auth.lock');
            Route::get('/buttons', Buttons::class)->name('ui.buttons');
            Route::get('/notifications', Notifications::class)->name('ui.notifications');
            Route::get('/forms', Forms::class)->name('ui.forms');
            Route::get('/modals', Modals::class)->name('ui.modals');
            Route::get('/typography', Typography::class)->name('ui.typography');
        });
    });
