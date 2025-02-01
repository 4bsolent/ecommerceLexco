<?php

namespace App\Services;

use App\Repositories\RoleUserRepository;
use App\Traits\JsonResponse;

class RoleUserService {

    use JsonResponse;

    private $roleUserRepository;

    public function __construct(RoleUserRepository $roleUserRepository) {
        $this->roleUserRepository = $roleUserRepository;
    }

    public function assignRoleToUser (int $userId, int $roleId) {
        return $this->roleUserRepository->newRoleUser($userId, $roleId);
    }

    public function updateRoleUserStatus (int $roleUserId, string $newStatus) {
        $roleUser = $this->roleUserRepository->roleUserById($roleUserId);

        if ($roleUser->status === $newStatus) {
            return $this->errorResponse([
                'info' => 'El rol: ' . $roleUser->role->role . ' asignado al usario con ID: ' . $roleUser->user->id . ' ya tiene asignado el status: ' . $newStatus
            ],422);
        }

        $this->roleUserRepository->updateRoleUserStatus($roleUserId, $newStatus);

        return $this->successResponse([
            'info' => 'El status del rol: ' . $roleUser->role->role . ' asignado al usuario con ID: ' . $roleUser->user->id . ' fue cambiado a: ' . $newStatus
        ], 200);
    }

    public function validationOfAssignedRole(int $userId, int $roleId) {
        return $this->roleUserRepository->validationRoleUser($userId, $roleId);
    }

    public function getAllRoleUser() {
        return $this->roleUserRepository->allRoleUser();
    }

    public function getAllRoleUserByUserId (int $userId) {
        return $this->roleUserRepository->allRoleUserByUserId($userId);
    }

    public function deleteRoleUser(int $roleUserId) {

        $roleUser = $this->roleUserRepository->roleUserById($roleUserId);

        try {
            $this->roleUserRepository->deleteRoleUser($roleUserId);
            return $this->successResponse([
                'info' => 'El role: ' . $roleUser->role->role . ' asignado al usuario con ID: ' . $roleUser->user->id . ' fue eliminado correctamente'
            ], 200);
        } catch (\Throwable $th) {
            return $this->errorResponse($th, 500);
        }
    }
}
