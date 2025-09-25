<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubfunctionPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // function_position_id 1
            ['function_position_id' => 1, 'name' => 'Strategic Leadership & Vision'],
            ['function_position_id' => 1, 'name' => 'Executive Committee & SBU Oversight'],
            ['function_position_id' => 1, 'name' => 'Board & Shareholder Engagement'],
            ['function_position_id' => 1, 'name' => 'Organizational Culture & Talent Leadership'],
            ['function_position_id' => 1, 'name' => 'Enterprise Risk Management'],
            ['function_position_id' => 1, 'name' => 'External Representation & Corporate Positioning'],

            // function_position_id 2
            ['function_position_id' => 2, 'name' => 'Process Mapping & Documentation'],
            ['function_position_id' => 2, 'name' => 'Process Improvement & Optimization'],
            ['function_position_id' => 2, 'name' => 'Process Performance Monitoring & Compliance'],
            ['function_position_id' => 2, 'name' => 'Process Change Management'],

            // function_position_id 3
            ['function_position_id' => 3, 'name' => 'Security & Access Coordination'],
            ['function_position_id' => 3, 'name' => 'Housekeeping Supervision'],
            ['function_position_id' => 3, 'name' => 'Health, Safety, & Emergency Readiness'],
            ['function_position_id' => 3, 'name' => 'Facilities Administration'],
            ['function_position_id' => 3, 'name' => 'Office Maintenance'],
            ['function_position_id' => 3, 'name' => 'Office Renovation and Upgrades'],
            ['function_position_id' => 3, 'name' => 'Facilities Vendor Coordination'],

            // function_position_id 4
            ['function_position_id' => 4, 'name' => 'Network & Infrastructure'],
            ['function_position_id' => 4, 'name' => 'Hardware Administration'],
            ['function_position_id' => 4, 'name' => 'Cybersecurity'],
            ['function_position_id' => 4, 'name' => 'Software Administration'],
            ['function_position_id' => 4, 'name' => 'Data Management'],
            ['function_position_id' => 4, 'name' => 'ERP System Administration (SAP)'],
            ['function_position_id' => 4, 'name' => 'Software Development'],

            // function_position_id 5
            ['function_position_id' => 5, 'name' => 'Networking & Lead Generation'],
            ['function_position_id' => 5, 'name' => 'New Business Evaluation'],
            ['function_position_id' => 5, 'name' => 'Bid Management & Proposal Submission'],
            ['function_position_id' => 5, 'name' => 'Business Plan Preparation & Development'],
            ['function_position_id' => 5, 'name' => 'Business Development Advisory & Consultancy'],

            // function_position_id 6
            ['function_position_id' => 6, 'name' => 'Government & Industry Relations'],
            ['function_position_id' => 6, 'name' => 'Stakeholder Engagement'],
            ['function_position_id' => 6, 'name' => 'Crisis & Issue Management'],

            // function_position_id 7
            ['function_position_id' => 7, 'name' => 'Brand Strategy & Identity Oversight'],
            ['function_position_id' => 7, 'name' => 'Brand Governance, Compliance, & Integration'],
            ['function_position_id' => 7, 'name' => 'Multimedia & Creatives Development'],
            ['function_position_id' => 7, 'name' => 'Brand Website, Social Media, & Promotions'],

            // function_position_id 8
            ['function_position_id' => 8, 'name' => 'Internal Communications'],
            ['function_position_id' => 8, 'name' => 'Media & Public Relations'],
            ['function_position_id' => 8, 'name' => 'External Communications'],
            ['function_position_id' => 8, 'name' => 'Executive Support'],

            // function_position_id 9
            ['function_position_id' => 9, 'name' => 'Financial Planning & Analysis'],
            ['function_position_id' => 9, 'name' => 'Corporate Governance, Corporate Secretarial, & Compliance'],
            ['function_position_id' => 9, 'name' => 'Treasury & Cash Management'],
            ['function_position_id' => 9, 'name' => 'Financial & Accounting Operation'],
            ['function_position_id' => 9, 'name' => 'Tax Compliance & Planning'],
            ['function_position_id' => 9, 'name' => 'Investor Relations'],

            // function_position_id 10
            ['function_position_id' => 10, 'name' => 'Corporate Governance, Corporate Secretarial, & Compliance'],
            ['function_position_id' => 10, 'name' => 'Contracts Review & Advisory'],
            ['function_position_id' => 10, 'name' => 'Litigation'],
            ['function_position_id' => 10, 'name' => 'Mergers, Acquisitions, & Fund Raising Support'],
            ['function_position_id' => 10, 'name' => 'Land Transactions'],
            ['function_position_id' => 10, 'name' => 'Legal Oversight & Audit'],

            // function_position_id 11
            ['function_position_id' => 11, 'name' => 'HR Strategy & Organizational Alignment'],
            ['function_position_id' => 11, 'name' => 'Executive & Key Talent Acquisition'],
            ['function_position_id' => 11, 'name' => 'Leadership Development & Succession Planning'],
            ['function_position_id' => 11, 'name' => 'Performance Management'],
            ['function_position_id' => 11, 'name' => 'HR and Labor Compliance'],
            ['function_position_id' => 11, 'name' => 'Learning and Capability Development'],
            ['function_position_id' => 11, 'name' => 'Employee Engagement and Culture Building'],
            ['function_position_id' => 11, 'name' => 'HR Analytics & Systems Oversight*'],
            ['function_position_id' => 11, 'name' => 'HR Advisory & Support'],
            ['function_position_id' => 11, 'name' => 'Office Administration'],

            // function_position_id 12
            ['function_position_id' => 12, 'name' => 'Operational Audit'],
            ['function_position_id' => 12, 'name' => 'Financial & Compliance Audit'],
            ['function_position_id' => 12, 'name' => 'IT & Cybersecurity Audit'],
            ['function_position_id' => 12, 'name' => 'Fraud Investigation.'],
        ];

        foreach ($data as $item) {
            \App\Models\SubfunctionPosition::create($item);
        }
    }
}
