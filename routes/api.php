<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiVersionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProductController;

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
        
        //Gestión de Usuarios
        Route::post('/users/add', [UserController::class, 'adminCreateUser']);
        Route::get('/users', [UserController::class, 'showAllUsers']);
        Route::post('/users/id', [UserController::class, 'showUserById']);
        Route::post('/users/delete', [UserController::class, 'changeUserStatus']);

        //Gestión de RoleUser
        Route::post('/role_user/add', [RoleUserController::class, 'createRoleUser']);
        Route::get('/role_user', [RoleUserController::class, 'showAllRoleUser']);
        Route::post('/role_user/userid', [RoleUserController::class, 'showAllRoleUserByUserId']);
        Route::post('/role_user/update', [RoleUserController::class, 'editRoleUserStatus']);
        Route::post('/role_user/delete', [RoleUserController::class, 'removeRoleUser']);
    });

    // Rutas de Productos

    Route::prefix('products')->middleware(['auth:sanctum'])->group(function() {
        Route::post('/add', [ProductController::class, 'create']);
        Route::get('/', [ProductController::class, 'showAllProducts']);
    });

});
