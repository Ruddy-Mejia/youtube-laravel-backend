<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'rmejiam.dev@gmail.com',
            'channel_name' => 'admin',
            'status' => true,
            'password' => bcrypt('password'),
        ]);
        // User::factory(99)->create();
    }
}
