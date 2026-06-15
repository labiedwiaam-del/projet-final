<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Doctor;
use App\Http\Controllers\Patient;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirection racine : si connecté, vers le tableau de bord, sinon la page d'accueil
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

// Route globale de redirection de tableau de bord selon le rôle
Route::middleware(['auth'])->get('/dashboard', function () {
    $user = auth()->user();
    return match($user->role) {
        'admin'   => redirect()->route('admin.dashboard'),
        'medecin' => redirect()->route('doctor.dashboard'),
        default   => redirect()->route('patient.dashboard'),
    };
})->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    // ── PROFIL (commun à tous les rôles) ─────────────────────────
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── ADMIN (auth seulement — pas de vérification email requise) ─
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/statistics', [Admin\DashboardController::class, 'statistics'])->name('statistics');

        Route::resource('/users', Admin\UserController::class);
        Route::resource('/doctors', Admin\DoctorController::class);

        Route::get('/appointments', [Admin\AppointmentController::class, 'index'])->name('appointments.index');
        Route::patch('/appointments/{id}/status', [Admin\AppointmentController::class, 'updateStatus'])->name('appointments.status');
        Route::delete('/appointments/{id}', [Admin\AppointmentController::class, 'destroy'])->name('appointments.destroy');
    });

// ── MÉDECIN (auth seulement — pas de vérification email requise) ─
Route::middleware(['auth', 'role:medecin'])
    ->prefix('doctor')
    ->name('doctor.')
    ->group(function () {
        Route::get('/dashboard', [Doctor\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/appointments', [Doctor\DashboardController::class, 'appointments'])->name('appointments');
        Route::patch('/appointments/{id}/status', [Doctor\DashboardController::class, 'updateStatus'])->name('appointments.status');
        Route::get('/schedules', [Doctor\ScheduleController::class, 'index'])->name('schedules');
        Route::post('/schedules', [Doctor\ScheduleController::class, 'store'])->name('schedules.store');
    });

// ── PATIENT (auth + email vérifié obligatoire) ─────────────────
Route::middleware(['auth', 'verified', 'role:patient'])
    ->prefix('patient')
    ->name('patient.')
    ->group(function () {
        Route::get('/dashboard', [Patient\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/doctors', [Patient\DoctorController::class, 'index'])->name('doctors.index');
        Route::get('/appointments', [Patient\AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/create', [Patient\AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('/appointments', [Patient\AppointmentController::class, 'store'])->name('appointments.store');
        Route::delete('/appointments/{id}', [Patient\AppointmentController::class, 'cancel'])->name('appointments.cancel');
        Route::get('/appointments/slots', [Patient\AppointmentController::class, 'slots'])->name('appointments.slots');
    });

require __DIR__ . '/auth.php';
