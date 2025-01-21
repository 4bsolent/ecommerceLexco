<?php

namespace App\Services;

use App\Repositories\UsersRepository;
use Illuminate\Support\Facades\Hash;

class UsersService {
    private $usersRepository;

    public function __construct(UsersRepository $usersRepository) {
        $this->usersRepository = $usersRepository;
    }

    public function newUser(array $userData) {
        $userData['password'] = Hash::make($userData['password']);
        return $this->usersRepository->newUser($userData);
    }
}
