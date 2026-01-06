<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SbuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sbus')->insert([
            ['sbu' => 'C2W', 'created_at' => now(), 'updated_at' => now()],
            ['sbu' => 'CORP', 'created_at' => now(), 'updated_at' => now()],
            ['sbu' => 'EPC', 'created_at' => now(), 'updated_at' => now()],
            ['sbu' => 'FDN', 'created_at' => now(), 'updated_at' => now()],
            ['sbu' => 'PCS', 'created_at' => now(), 'updated_at' => now()],
            ['sbu' => 'PH1', 'created_at' => now(), 'updated_at' => now()],
            ['sbu' => 'PITX', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
