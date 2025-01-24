<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UsersRepository {
    public function newUser(array $data) {
        return User::create([
            'user' => $data['user'],
            'password' => $data['password'],
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
        ]);
    }
}

