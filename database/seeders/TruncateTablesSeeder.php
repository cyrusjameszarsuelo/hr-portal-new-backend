<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TruncateTablesSeeder extends Seeder
{
    /**
     * Disable foreign key checks and truncate tables that have FK relationships.
     */
    public function run(): void
    {
        // Disable FK checks so we can truncate in any order
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $tables = [
            'function_parameters',
            'subfunction_descriptions',
            'subfunction_positions',
            'function_positions',
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
