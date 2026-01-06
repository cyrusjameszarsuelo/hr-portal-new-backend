<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('levels')->insert([
            ['level' => 'Executive', 'created_at' => now(), 'updated_at' => now()],
            ['level' => 'N/A', 'created_at' => now(), 'updated_at' => now()],
            ['level' => 'Manager', 'created_at' => now(), 'updated_at' => now()],
            ['level' => 'Supervisor / Officer', 'created_at' => now(), 'updated_at' => now()],
            ['level' => 'Rank & File', 'created_at' => now(), 'updated_at' => now()],
            ['level' => 'Chairman & CEO', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
