<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiVersionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\AddressController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', [ApiVersionController::class, 'index']);

Route::post('/customer/user/create', [UsersController::class, 'customerCreateUser']);
Route::post('/login', [UsersController::class, 'loginUser']);

Route::post('/create/role', [RoleUserController::class, 'createRoleUser']);
Route::post('/create/phone', [PhoneController::class, 'createPhone']);
Route::post('/create/address', [AddressController::class, 'createAddress']);

// Rutas de Administrador

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/v1.0/admin/users/add', [UsersController::class, 'adminCreateUser']);
});
