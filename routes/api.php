<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Rutas sin proteger*/
Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('/trabajadores', UserController::class)->except(['create', 'edit']);

/* Rutas protegidas por el middleware de sanctum */
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
