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
        $this->call(SbuSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(FunctionSeeder::class);
        $this->call(SubfunctionSeeder::class);
        $this->call(SubfunctionDescriptionSeeder::class);
        $this->call(DescriptionParameterSeeder::class);
        $this->call(PositionTitleSeeder::class);
        $this->call(OrgStructureSeeder::class);
        // $this->call(JobProfileKraSeeder::class);
    }
}
