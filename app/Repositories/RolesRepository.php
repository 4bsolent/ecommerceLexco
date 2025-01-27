<?php

namespace App\Repositories;

use App\Models\Roles;
use Illuminate\Database\Eloquent\Collection;

class RolesRepository {
    
    public function getByRole(string $role) {
        return Roles::where('role', $role)->first();
    }
}
