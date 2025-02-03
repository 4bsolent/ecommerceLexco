<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use App\Traits\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserService {

    use JsonResponse;

    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function newUser(array $userData) {
        foreach ($userData as $user) {
            $user['password'] = Hash::make($user['password']);
            return $this->userRepository->newUser($user);
        }
    }

    public function allUsers () {
        return $this->userRepository->allUsers();
    }

    public function userById (int $userId) {
        return $this->userRepository->userById($userId);
    }

    public function changeStatus(int $userId, string $newStatus) {
        return $this->userRepository->changeStatus($userId, $newStatus);
    }

    public function validationUserStatus(int $userId) {
        return $this->userRepository->statusUser($userId);
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

        // Eliminación de tokens de autenticación

        $user->tokens()->delete();

        // Creación token de autenticación
        
        $token = $user->createToken('auth_token')->plainTextToken;

        // Respuesta de token de autenticación

        return $this->successResponse(['bearerToken ' => $token], 200);
    }
}
