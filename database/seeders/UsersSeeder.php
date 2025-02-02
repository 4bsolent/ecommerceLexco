<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Repositories\RoleUserRepository;

use function Symfony\Component\Clock\now;

class UsersSeeder extends Seeder
{
    public $roleUserRepository;

    public function __construct(RoleUserRepository $roleUserRepository) {
        $this->roleUserRepository = $roleUserRepository;
    }

    public function run(): void
    {
        $userAdmon = User::create([
            'user' => 'Absolent',
            'password' => Hash::make('Jigsawlmn12'),
            'name' => 'Alejandro',
            'lastname' => 'Aldana Martínez',
            'email' => 'ba.aldana92@gmail.com',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $userId = $userAdmon->id;
        $category = Role::where('role', 'administrador')->first();
        $categoryId = $category->id;

        $this->roleUserRepository->newRoleUser($userId, $categoryId);
    }
}
