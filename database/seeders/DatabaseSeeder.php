<?php

namespace Database\Seeders;

use App\Repositories\RoleRepository;
use Faker\Provider\UserAgent;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            CategoriesSeeder::class,
            UsersSeeder::class
        ]);
    }
}
