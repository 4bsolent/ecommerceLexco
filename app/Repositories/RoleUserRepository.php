<?php

namespace App\Repositories;

use App\Models\RoleUser;

class RoleUserRepository {
    public function newRoleUser(int $userId, int $roleId) {
        return RoleUser::create([
            'id_role' => $roleId,
            'id_user' => $userId
        ]);
    }

    public function validationRoleUser (int $userId, int $roleId) {
        return RoleUser::where('id_role', $roleId)
                        ->where('id_user', $userId)
                        ->exists();
    }

    public function getAllRoleUser() {
        return RoleUser::all();
    }
}
