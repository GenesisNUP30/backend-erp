<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::get('/trabajadores', [UserController::class, 'index']);
Route::get('/trabajadores/{id}', [UserController::class, 'show']);
Route::post('/trabajadores/crear', [UserController::class, 'store']);
Route::put('/trabajadores/{id}/editar', [UserController::class, 'update']);
Route::delete('/trabajadores/{id}/eliminar', [UserController::class, 'destroy']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
