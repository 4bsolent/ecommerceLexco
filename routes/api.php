<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiVersionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\AddressController;

    // Rutas de Testing

Route::post('/create/role', [RoleUserController::class, 'createRoleUser']);
Route::post('/create/phone', [PhoneController::class, 'createPhone']);
Route::post('/create/address', [AddressController::class, 'createAddress']);

    // Rutas Públicas

Route::get('/test', [ApiVersionController::class, 'index']);
Route::post('/customer/user/create', [UserController::class, 'customerCreateUser']);
Route::post('/login', [UserController::class, 'loginUser']);

    // Rutas Protegidas y Versionadas con el Prefijo de la API

Route::prefix('v1.0')->group(function () {

    // Routas Administrador

    Route::prefix('admin')->middleware(['auth:sanctum'])->group(function() {
        Route::post('/users/add', [UserController::class, 'adminCreateUser']);
        Route::get('/users', [UserController::class, 'showAllUsers']);
        Route::post('/users/id', [UserController::class, 'showUserById']);
        Route::post('/users/delete', [UserController::class, 'changeUserStatus']);
        Route::post('/role_user/add', [RoleUserController::class, 'createRoleUser']);
    });
});
