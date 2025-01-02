<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use App\Models\User;
use App\Models\Userdetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(InstitusisTableSeeder::class);
        $this->call(DivisisTableSeeder::class);
        $this->call(TipesTableSeeder::class);
        $this->call(KelompoksTableSeeder::class);
        $this->call(JenisTableSeeder::class);
        $this->call(LokasisTableSeeder::class);
        $this->call(RuangsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UserDetailsTableSeeder::class);
        $this->call(RolesTableSeeder::class);

    }
}
