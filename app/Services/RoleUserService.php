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

    public function assignRoleToUser (int $userId, int $roleId) {
        return $this->roleUserRepository->newRoleUser($userId, $roleId);
    }

    public function validationOfAssignedRole(int $userId, int $roleId) {
        return $this->roleUserRepository->validationRoleUser($userId, $roleId);
    }

    public function getAllRoleUser() {
        return $this->roleUserRepository->allRoleUser();
    }
}
