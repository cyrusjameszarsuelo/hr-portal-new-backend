<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Profile - {{ $data['position_title'] ?? 'N/A' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            margin: 40px 130px 40px 130px;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 8.5pt;
            color: #231F20;
            line-height: 1.3;
            padding: 15px 60px;
        }

        .container {
            width: 100%;
            max-width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #ee3124;
        }

        .header h1 {
            font-size: 16pt;
            color: #c52026;
            margin-bottom: 4px;
            font-weight: bold;
        }

        .header .subtitle {
            font-size: 10pt;
            color: #2B2C2B;
            font-weight: normal;
        }

        .info-section {
            margin-bottom: 8px;
            background-color: #ffffff;
            padding: 6px 8px;
            border-left: 3px solid #ee3124;
            border: 1px solid #dcdbdb;
        }

        .info-section .label {
            font-weight: bold;
            color: #2B2C2B;
            display: inline-block;
            width: 120px;
            font-size: 8pt;
        }

        .info-section .value {
            color: #231F20;
            font-size: 8pt;
        }

        .section {
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 11pt;
            font-weight: bold;
            color: #ffffff;
            background-color: #ee3124;
            padding: 5px 8px;
            margin-bottom: 6px;
        }

        .subsection-title {
            font-size: 9pt;
            font-weight: bold;
            color: #2B2C2B;
            margin-top: 6px;
            margin-bottom: 4px;
            padding-bottom: 2px;
            border-bottom: 1px solid #dcdbdb;
        }

        .content-block {
            padding: 6px 8px;
            background-color: #ffffff;
            border: 1px solid #dcdbdb;
            margin-bottom: 6px;
            font-size: 8pt;
        }

        .kra-item {
            margin-bottom: 8px;
            padding: 6px 8px;
            background-color: #ffffff;
            border-left: 2px solid #c52026;
            border: 1px solid #dcdbdb;
        }

        .kra-item .kra-title {
            font-weight: bold;
            color: #c52026;
            margin-bottom: 3px;
            font-size: 8.5pt;
        }

        .kra-item .kra-description {
            margin-bottom: 4px;
            color: #231F20;
            font-size: 8pt;
        }

        .profile-kra-list {
            margin-left: 10px;
            margin-top: 4px;
        }

        .profile-kra-item {
            margin-bottom: 4px;
            padding: 4px 6px;
            background-color: #ffffff;
            border-left: 2px solid #2B2C2B;
            border: 1px solid #dcdbdb;
        }

        .profile-kra-item .pk-title {
            font-weight: bold;
            color: #2B2C2B;
            font-size: 7.5pt;
            margin-bottom: 2px;
        }

        .profile-kra-item .pk-description {
            color: #231F20;
            font-size: 7.5pt;
        }

        .standard-item,
        .spec-item {
            margin-bottom: 6px;
            padding: 5px 6px;
            background-color: #ffffff;
            border: 1px solid #dcdbdb;
        }

        .standard-item .item-name,
        .spec-item .item-name {
            font-weight: bold;
            color: #2B2C2B;
            margin-bottom: 3px;
            font-size: 8pt;
        }

        .standard-item ul,
        .spec-item ul {
            margin-left: 15px;
            margin-top: 2px;
        }

        .standard-item li,
        .spec-item li {
            margin-bottom: 2px;
            color: #231F20;
            font-size: 7.5pt;
        }

        .footer {
            margin-top: 15px;
            padding-top: 8px;
            border-top: 1px solid #dcdbdb;
            text-align: center;
            font-size: 7pt;
            color: #2B2C2B;
        }

        .no-data {
            color: #2B2C2B;
            font-style: italic;
            font-size: 7.5pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        table th {
            background-color: #2B2C2B;
            color: #ffffff;
            padding: 5px;
            text-align: left;
            font-weight: bold;
            font-size: 8pt;
        }

        table td {
            padding: 5px;
            border: 1px solid #dcdbdb;
            font-size: 7.5pt;
        }

        table tr:nth-child(even) {
            background-color: #ffffff;
        }

        .page-break {
            page-break-after: always;
        }

        /* Compact list of deliverables */
        .deliverables-compact {
            font-size: 7.5pt;
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Job Profile</h1>
            <div class="subtitle">Employee Position Details</div>
        </div>

        <!-- Basic Information -->
        <div class="info-section">
            <div><span class="label">Position Title:</span> <span
                    class="value">{{ $data['position_title'] ?? 'N/A' }}</span></div>
        </div>
        <div class="info-section">
            <div><span class="label">Department:</span> <span class="value">{{ $data['department'] ?? 'N/A' }}</span>
            </div>
        </div>
        <div class="info-section">
            <div><span class="label">Reporting To:</span> <span class="value">{{ $data['reporting'] ?? 'N/A' }}</span>
            </div>
        </div>

        @if (isset($data['job_profile']))
            @php $jobProfile = $data['job_profile']; @endphp

            <!-- Subfunction -->
            @if (isset($jobProfile['subfunction_position']) && $jobProfile['subfunction_position'])
                <div class="section">
                    <div class="section-title">Subfunction</div>
                    <div class="content-block">
                        {{ $jobProfile['subfunction_position']['name'] ?? 'N/A' }}
                    </div>
                </div>
            @endif

            <!-- Job Purpose -->
            @if (isset($jobProfile['job_purpose']) && $jobProfile['job_purpose'])
                <div class="section">
                    <div class="section-title">Job Purpose</div>
                    <div class="content-block">
                        {{ $jobProfile['job_purpose'] }}
                    </div>
                </div>
            @endif

            <!-- Job Descriptions & KRAs -->
            @if (isset($jobProfile['job_descriptions']) && count($jobProfile['job_descriptions']) > 0)
                <div class="section">
                    <div class="section-title">Key Responsibility Areas (KRAs) & Job Descriptions</div>
                    @foreach ($jobProfile['job_descriptions'] as $jd)
                        <div class="kra-item">
                            <div class="kra-title">KRA: {{ $jd['kra'] ?? 'N/A' }}</div>
                            <div class="kra-description">{{ $jd['description'] ?? 'N/A' }}</div>

                            @if (isset($jd['profile_kras']) && count($jd['profile_kras']) > 0)
                                <div class="profile-kra-list">
                                    <strong style="font-size: 9pt; color: #34495e;">Specific Deliverables:</strong>
                                    @foreach ($jd['profile_kras'] as $pk)
                                        <div class="profile-kra-item">
                                            <div class="pk-title">{{ $pk['kra_description'] ?? 'N/A' }}</div>
                                            <div class="pk-description">{{ $pk['deliverables'] ?? 'N/A' }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Job Performance Standards -->
            @if (isset($jobProfile['job_performance_standards']) &&
                    isset($jobProfile['job_performance_standards']['items']) &&
                    count($jobProfile['job_performance_standards']['items']) > 0)
                <div class="section">
                    <div class="section-title">
                        {{ $jobProfile['job_performance_standards']['title'] ?? 'Job Performance Standards' }}</div>
                    @foreach ($jobProfile['job_performance_standards']['items'] as $standard)
                        <div class="standard-item">
                            <div class="item-name">{{ $standard['name'] ?? 'N/A' }}</div>
                            @if (isset($standard['values']) && count($standard['values']) > 0)
                                <ul>
                                    @foreach ($standard['values'] as $value)
                                        <li>{{ $value }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="no-data">No values specified</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Reporting Relationships -->
            @if (isset($jobProfile['reporting_relationships']) &&
                    isset($jobProfile['reporting_relationships']['items']) &&
                    count($jobProfile['reporting_relationships']['items']) > 0)
                <div class="section">
                    <div class="section-title">
                        {{ $jobProfile['reporting_relationships']['title'] ?? 'Reporting Relationships' }}</div>
                    @foreach ($jobProfile['reporting_relationships']['items'] as $relationship)
                        <div class="standard-item">
                            <div class="item-name">{{ $relationship['name'] ?? 'N/A' }}</div>
                            @if (isset($relationship['values']) && count($relationship['values']) > 0)
                                <ul>
                                    @foreach ($relationship['values'] as $value)
                                        <li>{{ $value }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="no-data">Not specified</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Levels of Authority -->
            @if (isset($jobProfile['levels_of_authority']) &&
                    isset($jobProfile['levels_of_authority']['items']) &&
                    count($jobProfile['levels_of_authority']['items']) > 0)
                <div class="section">
                    <div class="section-title">
                        {{ $jobProfile['levels_of_authority']['title'] ?? 'Levels of Authority' }}</div>
                    @foreach ($jobProfile['levels_of_authority']['items'] as $authority)
                        <div class="standard-item">
                            <div class="item-name">{{ $authority['name'] ?? 'N/A' }}</div>
                            @if (isset($authority['values']) && count($authority['values']) > 0)
                                <ul>
                                    @foreach ($authority['values'] as $value)
                                        <li>{{ $value }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="no-data">Not specified</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Job Specifications -->
            @if (isset($jobProfile['job_specifications']) &&
                    isset($jobProfile['job_specifications']['items']) &&
                    count($jobProfile['job_specifications']['items']) > 0)
                <div class="section">
                    <div class="section-title">{{ $jobProfile['job_specifications']['title'] ?? 'Job Specifications' }}
                    </div>
                    @foreach ($jobProfile['job_specifications']['items'] as $spec)
                        <div class="spec-item">
                            <div class="item-name">{{ $spec['name'] ?? 'N/A' }}</div>
                            @if (isset($spec['values']) && count($spec['values']) > 0)
                                <ul>
                                    @foreach ($spec['values'] as $value)
                                        <li>{{ $value }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="no-data">Not specified</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        @endif

        <!-- Footer -->
        <div class="footer">
            Generated on {{ date('F d, Y \a\t h:i A') }} | HR Portal - Megawide
        </div>
    </div>
</body>

</html>
