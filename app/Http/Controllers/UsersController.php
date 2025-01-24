<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UsersService;
use App\Services\RoleUserService;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    use JsonResponse;

    private $userService;
    private $roleUser;

    public function __construct(UsersService $userService, RoleUserService $roleUser) {
        $this->userService = $userService;
        $this->roleUser = $roleUser;
    }

    public function createUser(Request $request) {

        $validator = Validator::make($request->all(), [
            'user' => 'required|string|unique:users,user|max:255',
            'password' => 'required|string|min:8',
            'name' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email|max:150'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $user = $this->userService->newUser($request->all());
        $idUser = $user->id;
        $idRole = [3];

        $this->roleUser->assignRoleToUser($idUser, $idRole);

        return $this->successResponse(['user' => $request->user], 201);
    }

    public function loginUser (Request $request) {
        
        // Validación de los datos de entrada

        $validator = Validator::make($request->all(), [
            'user' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        // Respuesta Validación de usuario
        
        return $this->userService->validateUserLogin($request->all());
        
    }
}
