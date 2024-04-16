<?php

namespace Database\Seeders;

use App\Models\AppUser;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = AppUser::firstOrCreate(['id' => 1], [
            'name' => 'Main',
            'email' => 'main@grr.la',
            'password' => 'main@grr.la',
        ]);
    }
}
