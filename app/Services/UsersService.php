<?php

namespace App\Services;

use App\Repositories\UsersRepository;
use App\Models\User;
use App\Traits\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UsersService {

    use JsonResponse;

    private $usersRepository;

    public function __construct(UsersRepository $usersRepository) {
        $this->usersRepository = $usersRepository;
    }

    public function newUser(array $userData) {
        $userData['password'] = Hash::make($userData['password']);
        return $this->usersRepository->newUser($userData);
    }

    
    /**
        * Validación de usuario
        *
        * Devuelve una respuesta JSON con un mensaje de la validación de usuario
        *
        * @param array  $userData Data del usuario
        * @return App\Services\UsersService
    */

    public function validateUserLogin(array $userData) {
        
        $user = User::where('user', $userData['user'])->first();

        if (!$user || !Hash::check($userData['password'], $user->password)) {
            return $this->errorResponse(['data' => 'user o password incorrectos'], 401);
        }

        if ($user->status == 'inactive') {
            return $this->errorResponse(['data' => 'Usuario inactivo'], 401);
        }

        // Creación token de autenticación

        $token = $user->createToken('auth_token')->plainTextToken;

        // Respuesta de token de autenticación

        return $this->successResponse(['bearerToeken' => $token], 200);
    }
}
