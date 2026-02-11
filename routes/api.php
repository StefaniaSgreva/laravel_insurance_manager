<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\PolicyController;
use App\Http\Controllers\Api\AuthController;

// Rotte pubbliche
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rotte protette (richiedono token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    Route::apiResource('clients', ClientController::class);
    Route::apiResource('policies', PolicyController::class);

    // Route per statistiche
    Route::get('/stats', function () {
        return response()->json([
            'total_clients' => \App\Models\Client::count(),
            'total_policies' => \App\Models\Policy::count(),
            'active_policies' => \App\Models\Policy::where('status', 'active')->count(),
            'expired_policies' => \App\Models\Policy::where('status', 'expired')->count(),
            'total_premium' => \App\Models\Policy::sum('premium'),
        ]);
    });
});
