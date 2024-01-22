<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password')
        ]);
        $user->assignRole('admin');

        $user = \App\Models\User::factory()->create([
            'name' => 'Jahanzaib',
            'email' => 'jahanzaib@example.com',
            'password' => Hash::make('password')
        ]);
        $user->assignRole('user');
    }
}
