<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $positions = [
            'Chief Executive Officer',
            'Management Associate',
            'Management Trainee',
            'Facilities Management Officer',
            'Information Technology Project Manager',
            'Head of Internal Audit',
            'Internal Audit Officer',
            'Chief Business Development Officer',
            'Business Development Director',
            'Business Development Manager',
            'Assistant Business Development Manager',
            'Business Development Officer',
            'Senior Business Development Assistant',
            'Stakeholder Relations Officer',
            'Chief Corporate Communications, Affairs & Branding Officer',
            'Executive Assistant',
            'Group Chief Finance Officer',
            'Head of Corporate Finance & Planning',
            'Senior Corporate Finance & Planning Manager',
            'Assistant Corporate Finance & Planning Manager',
            'Treasury Head',
            'Assistant Treasury Manager',
            'Treasury Officer',
            'Head of Investor Relations & Comptrollership',
            'Corporate Comptroller',
            'Financial Reporting Officer',
            'Accounting Assistant',
            'Investor Relations Officer',
            'Chief Human Resources Officer',
            'Talent Acquisition & HR Operations Head',
            'HR Officer',
            'Talent Acquisition Officer',
            'Talent Acquisition Manager',
            'Assistant Payroll & Benefits Manager',
            'HCM Analyst',
            'Talent Management & Total Rewards Officer',
            'Learning & Engagement Officer',
            'Assistant Organization Development Manager',
            'Assistant Admin & Purchasing Manager',
            'Admin & Purchasing Assistant',
            'Admin Driver',
            'Admin Messenger',
            'Chief Legal Officer',
            'Senior Legal Counsel (CorSec)',
            'Senior Legal Counsel',
            'Legal Counsel',
            'Associate Legal Counsel',
            'Corporate Regulatory Officer',
            'Paralegal',
        ];

        // Insert all positions
        DB::table('position_titles')->insert(array_map(fn($title) => [
            'position_title' => $title,
            'created_at' => $now,
            'updated_at' => $now,
        ], $positions));
    }
}
