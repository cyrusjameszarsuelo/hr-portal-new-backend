<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DescriptionParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('function_parameters')->truncate();

        $csvPath = __DIR__ . '/data/function_parameters.csv';
        if (!file_exists($csvPath) || !is_readable($csvPath)) {
            // nothing to seed
            return;
        }

        if (($handle = fopen($csvPath, 'r')) === false) {
            return;
        }

        $headers = fgetcsv($handle);
        if ($headers === false) {
            fclose($handle);
            return;
        }

        while (($row = fgetcsv($handle)) !== false) {
            // skip rows that don't match header length
            if (count($row) !== count($headers)) {
                continue;
            }

            $assoc = array_combine($headers, $row);

            $item = [
                'subfunction_description_id' => (isset($assoc['subfunction_description_id']) && $assoc['subfunction_description_id'] !== '') ? (int)$assoc['subfunction_description_id'] : ((isset($assoc['id']) && $assoc['id'] !== '') ? (int)$assoc['id'] : null),
                'deliverable' => $assoc['deliverable'] ?? $assoc['Deliverable'] ?? null,
                'frequency_deliverable' => $assoc['frequency_deliverable'] ?? $assoc['frequency'] ?? null,
                'responsible' => $assoc['responsible'] ?? null,
                'accountable' => $assoc['accountable'] ?? null,
                'support' => $assoc['support'] ?? null,
                'consulted' => $assoc['consulted'] ?? null,
                'informed' => $assoc['informed'] ?? null,
            ];

            // require at minimum a subfunction_description_id and a deliverable
            if ($item['subfunction_description_id'] === null || $item['deliverable'] === null) {
                continue;
            }

            // Ensure the referenced subfunction_description exists before inserting to avoid FK violations
            $exists = \App\Models\SubfunctionDescription::where('id', $item['subfunction_description_id'])->exists();
            if (!$exists) {
                // skip rows that reference non-existent descriptions
                continue;
            }

            try {
                \App\Models\FunctionParameter::create($item);
            } catch (\Illuminate\Database\QueryException $e) {
                // skip problematic rows and continue seeding
                // optionally: \Log::error('Failed to seed FunctionParameter', ['item' => $item, 'error' => $e->getMessage()]);
                continue;
            }
        }

        fclose($handle);
    }
}
