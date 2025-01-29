<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository {
    public function newUser(array $data) {
        return User::create([
            'user' => $data['user'],
            'password' => $data['password'],
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
        ]);
    }

    public function allUsers() {
        return User::all(['id', 'user', 'status', 'name', 'lastname', 'email', 'image_rute'])->toArray();
    }

    public function userById(int $userId) {
        return User::where('id', $userId)->select('id', 'user', 'status', 'name', 'lastname', 'email', 'image_rute')->first();
    }

    public function changeStatus(int $userId, string $status) {
        return User::where('id', $userId)
                    ->update(['status' => $status]);
    }

    public function statusUser (int $userId) {
        return User::where('id', $userId)->select('status')->first();
    }
}

