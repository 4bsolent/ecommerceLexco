<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiVersionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\AddressController;

    // Rutas de Testing

Route::post('/create/role', [RoleUserController::class, 'createRoleUser']);
Route::post('/create/phone', [PhoneController::class, 'createPhone']);
Route::post('/create/address', [AddressController::class, 'createAddress']);

    // Rutas Públicas

Route::get('/test', [ApiVersionController::class, 'index']);
Route::post('/customer/user/create', [UsersController::class, 'customerCreateUser']);
Route::post('/login', [UsersController::class, 'loginUser']);

    // Rutas Protegidas y Versionadas con el Prefijo de la API

Route::prefix('v1.0')->group(function () {

    // Routas Administrador

    Route::prefix('admin')->middleware(['auth:sanctum'])->group(function() {
        Route::post('/users/add', [UsersController::class, 'adminCreateUser']);
    });
});
