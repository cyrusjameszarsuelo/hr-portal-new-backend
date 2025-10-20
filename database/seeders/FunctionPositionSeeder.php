<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FunctionPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'name' => 'Chief Executive Office', 'order_id' => 1],
            ['id' => 2, 'name' => 'Business Process Management', 'order_id' => 2],
            ['id' => 3, 'name' => 'Facilities Management', 'order_id' => 3],
            ['id' => 4, 'name' => 'Information Technology', 'order_id' => 4],
            ['id' => 5, 'name' => 'Business Development', 'order_id' => 5],
            ['id' => 6, 'name' => 'Corporate Affairs', 'order_id' => 6],
            ['id' => 8, 'name' => 'Communications & Branding', 'order_id' => 7],
            ['id' => 9, 'name' => 'Finance', 'order_id' => 8],
            ['id' => 10, 'name' => 'Legal', 'order_id' => 9],
            ['id' => 11, 'name' => 'Human Resources', 'order_id' => 10],
            ['id' => 12, 'name' => 'Internal Audit', 'order_id' => 11],
        ];

        // DB::table('function_positions')->truncate();

        foreach ($data as $item) {
            \App\Models\FunctionPosition::create($item);
        }
    }
}