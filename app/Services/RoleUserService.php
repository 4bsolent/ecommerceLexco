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

    public function newRoleUser(array $data) {
        return $this->roleUserRepository->newRoleUser($data);
    }

    public function getAllRoleUser() {
        return $this->roleUserRepository->getAllRoleUser();
    }
}