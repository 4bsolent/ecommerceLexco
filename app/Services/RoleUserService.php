<?php

namespace App\Services;

use App\Repositories\RoleUserRepository;
use App\Models\RoleUser;
use App\Traits\JsonResponse;

class RoleUserService {

    use JsonResponse;

    private $roleUserRepository;

    public function __construct(RoleUserRepository $roleUserRepository) {
        $this->roleUserRepository = $roleUserRepository;
    }

    public function assignRoleToUser (int $userId, array $rolesIds) {

        try {
            foreach ($rolesIds as $roleId) {
                $this->roleUserRepository->newRoleUser((int)$userId, (int)$roleId);
            }
        } catch (\Exception $e) {
            return $this->errorResponse([
                'identifier' => 'El usuario ya tiene asignado el role',
                'errorLog' => $e->getMessage()
            ], 422);
        }

        return $this->successResponse([
            'rolesAsignation' => $rolesIds,
            'userId' => $userId
        ], 201);
    }

    public function getAllRoleUser() {
        return $this->roleUserRepository->getAllRoleUser();
    }
}
