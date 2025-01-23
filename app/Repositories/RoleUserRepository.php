<?php

namespace App\Repositories;

use App\Models\RoleUser;
use Illuminate\Database\Eloquent\Collection;

class RoleUserRepository {
    public function newRoleUser(array $data) {
        return RoleUser::create([
            'id_role' => $data['id_role'],
            'id_user' => $data['id_user']
        ]);
    }

    public function getAllRoleUser() {
        return RoleUser::all();
    }
}