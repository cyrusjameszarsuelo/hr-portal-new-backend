<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FunctionPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Chief Executive Office',
            'Business Process Management',
            'Facilities Management',
            'Information Technology',
            'Business Development',
            'Corporate Affairs',
            'Corporate Branding',
            'Corporate Communications',
            'Finance',
            'Legal',
            'Human Resources',
            'Internal Audit',
        ];

        foreach ($data as $item) {
            \App\Models\FunctionPosition::create(['name' => $item]);
        }
    }
}
