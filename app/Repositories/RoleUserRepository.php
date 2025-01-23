<?php

namespace App\Repositories;

use App\Models\RoleUser;
use Illuminate\Database\Eloquent\Collection;

class RoleUserRepository {
    public function newRoleUser(int $idUser, int $idRole) {
        return RoleUser::create([
            'id_role' => $idRole,
            'id_user' => $idUser
        ]);
    }

    public function getAllRoleUser() {
        return RoleUser::all();
    }
}
