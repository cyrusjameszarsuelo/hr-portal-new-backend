<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubfunctionPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'function_position_id' => 1, 'name' => 'Strategic Leadership & Vision', 'order_id' => 1],
            ['id' => 2, 'function_position_id' => 1, 'name' => 'Executive Committee & SBU Oversight', 'order_id' => 2],
            ['id' => 3, 'function_position_id' => 1, 'name' => 'Board & Shareholder Engagement', 'order_id' => 3],
            ['id' => 4, 'function_position_id' => 1, 'name' => 'Organizational Culture & Talent Leadership', 'order_id' => 4],
            ['id' => 5, 'function_position_id' => 1, 'name' => 'Enterprise Risk Management', 'order_id' => 5],
            ['id' => 6, 'function_position_id' => 1, 'name' => 'Stakeholder Relations', 'order_id' => 6],

            ['id' => 7, 'function_position_id' => 2, 'name' => 'Process Mapping & Documentation', 'order_id' => 1],
            ['id' => 8, 'function_position_id' => 2, 'name' => 'Process Improvement & Optimization', 'order_id' => 2],
            ['id' => 9, 'function_position_id' => 2, 'name' => 'Process Performance Monitoring & Compliance', 'order_id' => 3],
            ['id' => 10, 'function_position_id' => 2, 'name' => 'Process Change Management', 'order_id' => 4],

            ['id' => 11, 'function_position_id' => 3, 'name' => 'Security & Access Control', 'order_id' => 1],
            ['id' => 12, 'function_position_id' => 3, 'name' => 'Housekeeping', 'order_id' => 2],
            ['id' => 13, 'function_position_id' => 3, 'name' => 'Health, Safety & Environment', 'order_id' => 3],
            ['id' => 14, 'function_position_id' => 3, 'name' => 'Facilities Administration', 'order_id' => 4],
            ['id' => 15, 'function_position_id' => 3, 'name' => 'Office Maintenance', 'order_id' => 5],
            ['id' => 16, 'function_position_id' => 3, 'name' => 'Office Renovation and Upgrades', 'order_id' => 6],

            ['id' => 18, 'function_position_id' => 4, 'name' => 'Network & Infrastructure', 'order_id' => 1],
            ['id' => 19, 'function_position_id' => 4, 'name' => 'Hardware Administration', 'order_id' => 2],
            ['id' => 20, 'function_position_id' => 4, 'name' => 'Cybersecurity', 'order_id' => 3],
            ['id' => 21, 'function_position_id' => 4, 'name' => 'Software Administration', 'order_id' => 4],
            ['id' => 22, 'function_position_id' => 4, 'name' => 'Data Management', 'order_id' => 5],
            ['id' => 24, 'function_position_id' => 4, 'name' => 'Software Development', 'order_id' => 6],

            ['id' => 25, 'function_position_id' => 5, 'name' => 'Networking & Lead Generation', 'order_id' => 1],
            ['id' => 26, 'function_position_id' => 5, 'name' => 'New Business Evaluation', 'order_id' => 2],

            ['id' => 30, 'function_position_id' => 6, 'name' => 'Government & Industry Relations', 'order_id' => 1],
            ['id' => 32, 'function_position_id' => 6, 'name' => 'Crisis & Issue Management', 'order_id' => 2],

            ['id' => 37, 'function_position_id' => 8, 'name' => 'Internal Communications', 'order_id' => 1],
            ['id' => 39, 'function_position_id' => 8, 'name' => 'Media & Public Relations', 'order_id' => 2],

            ['id' => 41, 'function_position_id' => 9, 'name' => 'Financial & Corporate Planning', 'order_id' => 1],
            ['id' => 42, 'function_position_id' => 9, 'name' => 'Corporate Finance', 'order_id' => 2],
            ['id' => 43, 'function_position_id' => 9, 'name' => 'Treasury & Cash Management', 'order_id' => 3],
            ['id' => 44, 'function_position_id' => 9, 'name' => 'Financial & Accounting Operation', 'order_id' => 4],
            ['id' => 45, 'function_position_id' => 9, 'name' => 'Tax Planning & Compliance', 'order_id' => 5],
            ['id' => 46, 'function_position_id' => 9, 'name' => 'Investor Relations', 'order_id' => 6],

            ['id' => 47, 'function_position_id' => 10, 'name' => 'Corporate Governance, Corporate Secretarial, & Compliance', 'order_id' => 1],
            ['id' => 48, 'function_position_id' => 10, 'name' => 'Contracts Review & Advisory', 'order_id' => 2],
            ['id' => 49, 'function_position_id' => 10, 'name' => 'Litigation', 'order_id' => 3],
            ['id' => 50, 'function_position_id' => 10, 'name' => 'Mergers, Acquisitions, & Fund Raising Support', 'order_id' => 4],
            ['id' => 51, 'function_position_id' => 10, 'name' => 'Land Transactions', 'order_id' => 5],
            ['id' => 52, 'function_position_id' => 10, 'name' => 'Legal Oversight & Audit', 'order_id' => 6],

            ['id' => 53, 'function_position_id' => 11, 'name' => 'Organizational Development', 'order_id' => 1],
            ['id' => 54, 'function_position_id' => 11, 'name' => 'Executive & Key Talent Acquisition', 'order_id' => 2],
            ['id' => 55, 'function_position_id' => 11, 'name' => 'Leadership & Talent Development', 'order_id' => 3],
            ['id' => 57, 'function_position_id' => 11, 'name' => 'HR Operations and Labor Compliance', 'order_id' => 4],
            ['id' => 59, 'function_position_id' => 11, 'name' => 'Employee Engagement and Culture Building', 'order_id' => 5],
            ['id' => 61, 'function_position_id' => 11, 'name' => 'HR Oversight', 'order_id' => 6],
            ['id' => 62, 'function_position_id' => 11, 'name' => 'Office Administration', 'order_id' => 7],

            ['id' => 63, 'function_position_id' => 12, 'name' => 'Operational Audit', 'order_id' => 1],
            ['id' => 64, 'function_position_id' => 12, 'name' => 'Financial & Compliance Audit', 'order_id' => 2],
            ['id' => 65, 'function_position_id' => 12, 'name' => 'IT & Cybersecurity Audit', 'order_id' => 3],
            ['id' => 66, 'function_position_id' => 12, 'name' => 'Fraud Investigation', 'order_id' => 4],

            ['id' => 67, 'function_position_id' => 8, 'name' => 'Branding Governance', 'order_id' => 3],
            ['id' => 68, 'function_position_id' => 8, 'name' => 'Social Media & Promotions', 'order_id' => 4],
            ['id' => 69, 'function_position_id' => 8, 'name' => 'Multimedia & Creative Development', 'order_id' => 5],

            ['id' => 74, 'function_position_id' => 5, 'name' => 'Bid Management', 'order_id' => 3],
            ['id' => 75, 'function_position_id' => 5, 'name' => 'Development of New Business', 'order_id' => 4],

            ['id' => 76, 'function_position_id' => 8, 'name' => 'Crisis Communication', 'order_id' => 6],
        ];

        // DB::table('subfunction_positions')->truncate();

        // Insert via Eloquent model preserving CSV order_id
        foreach ($data as $item) {
            \App\Models\SubfunctionPosition::create($item);
        }
    }
}
