<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $characters = [
            // ['name' => 'Mickey Mouse', 'image' => 'mickey.jpg'],
            // ['name' => 'Minnie Mouse', 'image' => 'minnie.jpg'],
            // ['name' => 'Donald Duck', 'image' => 'donald.jpg'],
            // Add more characters as needed
        ];

        DB::table('characters')->insert($characters);
    }
}
