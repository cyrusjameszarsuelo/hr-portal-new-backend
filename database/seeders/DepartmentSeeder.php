<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            ['department' => 'OCEO', 'sbu_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'OCHR', 'sbu_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'BDV', 'sbu_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'TDV', 'sbu_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'CCAB', 'sbu_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'FIN', 'sbu_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'HRD', 'sbu_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'LEG', 'sbu_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
