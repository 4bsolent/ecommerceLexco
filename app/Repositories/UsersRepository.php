<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UsersRepository {
    public function newUser(array $data): User {
        return User::create($data);
    }
}

