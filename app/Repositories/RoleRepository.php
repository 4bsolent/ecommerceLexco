<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository {
    
    public function getByRole(string $role) {
        return Role::where('role', $role)->first();
    }
}
