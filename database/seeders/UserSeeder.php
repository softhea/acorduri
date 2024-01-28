<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = 'parola';
        $time = time();

        User::query()->create([
            'id' => 1,
            'name' => 'superadmin',
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => $password,
            'role_id' => 1,
            'email_verified_at' => $time,
        ]);

        User::query()->create([
            'id' => 2,
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => $password,
            'role_id' => 2,
            'email_verified_at' => $time,
        ]);

        User::factory(8)->create();
    }
}
