<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UsersService;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UsersController extends Controller
{
    private $userService;

    public function __construct(UsersService $userService) {
        $this->userService = $userService;
    }

    public function createUser(Request $request) {

        $validator = Validator::make($request->all(), [
            'user' => 'required|string|unique:users,user|max:255',
            'password' => 'required|string|min:8',
            'name' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email|max:150',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Se encontraron errores en los datos enviados',
                'errors' => $validator->errors()
            ], 400);
        }

        $this->userService->newUser($request->all());

        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'user' => $request->user
        ], 201);
    }
}
