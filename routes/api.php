<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiVersionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RoleUserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', [ApiVersionController::class, 'index']);

Route::post('/customer/user/create', [UsersController::class, 'createUser']);
Route::post('/login', [UsersController::class, 'loginUser']);

Route::post('/create/role', [RoleUserController::class, 'newRoleUser']);
