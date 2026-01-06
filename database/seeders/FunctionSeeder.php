<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('function_positions')->insert([
            ['id' => 1, 'name' => 'Chief Executive Office', 'order_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Business Process Management', 'order_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Facilities Management', 'order_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Information Technology', 'order_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Business Development', 'order_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Corporate Affairs', 'order_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'Communications & Branding', 'order_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'Finance', 'order_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'Legal', 'order_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name' => 'Human Resources', 'order_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'name' => 'Internal Audit', 'order_id' => 11, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}