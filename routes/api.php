<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\PolicyController;

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
