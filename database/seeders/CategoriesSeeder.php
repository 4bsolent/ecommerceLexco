<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['category' => 'impresoras', 'created_at' => now(), 'updated_at' => now()],
            ['category' => 'insumos', 'created_at' => now(), 'updated_at' => now()],
            ['category' => 'partes', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
