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

    public function assignRoleToUser (int $idUser, array $idRoles) {

        try {
            foreach ($idRoles as $idRole) {
                $this->roleUserRepository->newRoleUser((int)$idUser, (int)$idRole);
            }
        } catch (\Exception $e) {
            return $this->errorResponse([
                'identifier' => 'El usuario ya tiene asignado el role',
                'errorLog' => $e->getMessage()
            ], 422);
        }

        return $this->successResponse([
            'rolesAsignation' => $idRoles,
            'idUser' => $idUser
        ], 201);
    }

    public function getAllRoleUser() {
        return $this->roleUserRepository->getAllRoleUser();
    }
}
