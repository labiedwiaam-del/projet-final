<?php

use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;

// ── PUBLIC ───────────────────────────────────────────────
Route::post('/register', [Api\AuthController::class, 'register']);
Route::post('/login',    [Api\AuthController::class, 'login']);

// Webhook ElevenLabs (voice assistant — pas d'auth requise)
Route::post('/voice/save-appointment', [Api\VoiceAppointmentController::class, 'save']);

// ── PROTÉGÉ (token Sanctum requis) ───────────────────────
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',   [Api\AuthController::class, 'logout']);
    Route::get('/profile',   [Api\AuthController::class, 'profile']);
    Route::put('/profile',   [Api\AuthController::class, 'updateProfile']);

    Route::get('/doctors',              [Api\DoctorController::class, 'index']);
    Route::get('/doctors/{id}',         [Api\DoctorController::class, 'show']);
    Route::get('/doctors/{id}/slots',   [Api\DoctorController::class, 'availableSlots']);

    Route::get('/appointments',         [Api\AppointmentController::class, 'index']);
    Route::post('/appointments',        [Api\AppointmentController::class, 'store']);
    Route::put('/appointments/{id}',    [Api\AppointmentController::class, 'update']);
    Route::delete('/appointments/{id}', [Api\AppointmentController::class, 'cancel']);
});
