<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $this->call(FunctionPositionSeeder::class);
        // $this->call(SubfunctionPositionSeeder::class);
        // $this->call(SubfunctionDescriptionSeeder::class);
        // $this->call(FunctionParameterSeeder::class);
        $this->call(OrgStructureSeeder::class);
    }
}
