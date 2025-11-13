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
            margin: 40px 100px 50px 100px;
        }

        body {
            font-family: sans-serif;
            font-size: 9pt;
            color: #000000;
            line-height: 1.3;
            padding: 20px 60px;
        }

        .container {
            width: 100%;
            max-width: 100%;
        }

        /* Header */
        .header {
            margin-bottom: 15px;
            text-align: center;
        }

        .document-title {
            font-size: 15pt;
            font-weight: bold;
            color: #000000;
            text-transform: uppercase;
        }

        /* Basic Information Table */
        .info-table {
            width: 100%;
            margin-bottom: 12px;
            border-collapse: collapse;
            border: 1px solid #cccccc;
            table-layout: fixed;
        }

        .info-table td,
        .info-table th {
            padding: 10px 15px;
            border: 1px solid #cccccc;
            font-size: 8pt;
            vertical-align: top;
            width: 50%;
        }

        .info-table th {
            background-color: #d3d3d3;
            font-weight: bold;
            text-align: left;
        }

        .info-table td {
            font-weight: bold;
            font-size: 8.5pt;
        }

        /* Section styles */
        .section {
            margin-bottom: 12px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 10pt;
            font-weight: bold;
            color: #ffffff;
            background-color: #ee3124;
            padding: 5px 10px;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .section-content {
            padding: 8px 10px;
            border: 1px solid #cccccc;
            background-color: #ffffff;
            font-size: 8.5pt;
            line-height: 1.4;
            text-align: justify;
        }

        /* KRA Items */
        .kra-container {
            border: 1px solid #cccccc;
            margin-bottom: 8px;
        }

        .kra-item {
            margin-bottom: 8px;
            padding: 8px 10px;
            background-color: #ffffff;
        }

        .kra-item:last-child {
            margin-bottom: 0;
        }

        .kra-header {
            font-weight: bold;
            color: #000000;
            margin-bottom: 4px;
            font-size: 8.5pt;
            padding: 4px;
            background-color: #f0f0f0;
            border-left: 3px solid #ee3124;
        }

        .kra-description {
            margin-bottom: 6px;
            color: #000000;
            font-size: 8.5pt;
            line-height: 1.4;
            padding-left: 5px;
            text-align: justify;
        }

        /* Profile KRA (Deliverables) */
        .deliverables-section {
            margin-top: 6px;
            padding-left: 15px;
        }

        .deliverables-title {
            font-weight: bold;
            font-size: 8.5pt;
            margin-bottom: 4px;
            color: #000000;
        }

        .deliverable-item {
            margin-bottom: 6px;
            padding: 6px;
            background-color: #fafafa;
            border-left: 2px solid #999999;
        }

        .deliverable-item .deliverable-kra {
            font-weight: bold;
            color: #000000;
            font-size: 8pt;
            margin-bottom: 3px;
        }

        .deliverable-item .deliverable-desc {
            color: #000000;
            font-size: 8pt;
            line-height: 1.3;
            text-align: justify;
        }

        /* Standard items (for Job Performance Standards, etc.) */
        .standard-list {
            border: 1px solid #cccccc;
            padding: 8px;
        }

        .standard-item {
            margin-bottom: 8px;
            padding: 6px;
            background-color: #ffffff;
            border-bottom: 1px solid #dddddd;
        }

        .standard-item:last-child {
            border-bottom: none;
        }

        .standard-item .item-name {
            font-weight: bold;
            color: #000000;
            margin-bottom: 4px;
            font-size: 8.5pt;
        }

        .standard-item ul {
            margin-left: 18px;
            margin-top: 3px;
        }

        .standard-item li {
            margin-bottom: 3px;
            color: #000000;
            font-size: 8pt;
            line-height: 1.3;
        }

        /* Signature sections */
        .acknowledgment-section {
            margin-top: 20px;
            margin-bottom: 15px;
            border: 1px solid #cccccc;
            page-break-inside: avoid;
        }

        .acknowledgment-title {
            font-size: 10pt;
            font-weight: bold;
            background-color: #ee3124;
            color: #ffffff;
            padding: 5px 10px;
            text-transform: uppercase;
        }

        .acknowledgment-content {
            padding: 12px;
            text-align: center;
            font-size: 8.5pt;
            line-height: 1.5;
        }

        .acknowledgment-content .highlight {
            color: #ee3124;
            font-weight: bold;
        }

        .signature-space {
            height: 40px;
            margin: 12px 0;
        }

        .signature-name {
            font-weight: bold;
            font-size: 8.5pt;
            margin-bottom: 2px;
        }

        .signature-label {
            font-size: 8pt;
            font-weight: bold;
        }

        .sign-off-section {
            margin-bottom: 15px;
            border: 1px solid #cccccc;
            page-break-inside: avoid;
        }

        .sign-off-title {
            font-size: 10pt;
            font-weight: bold;
            background-color: #ee3124;
            color: #ffffff;
            padding: 5px 10px;
            text-transform: uppercase;
        }

        .sign-off-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sign-off-table td {
            padding: 8px;
            border: 1px solid #cccccc;
            vertical-align: top;
            font-size: 8pt;
        }

        .sign-off-table .table-header {
            font-weight: bold;
            text-align: center;
            background-color: #f5f5f5;
            font-size: 8.5pt;
        }

        .sign-off-table .signature-cell {
            height: 50px;
            text-align: center;
        }

        .sign-off-table .name-cell {
            text-align: center;
            font-weight: bold;
            font-size: 8.5pt;
        }

        .sign-off-table .position-cell {
            text-align: center;
            font-style: italic;
            font-size: 7.5pt;
        }

        .sign-off-table .label-cell {
            text-align: center;
            font-weight: bold;
            font-size: 8pt;
            background-color: #f5f5f5;
        }

        /* Footer */
        .footer {
            margin-top: 15px;
            padding-top: 8px;
            border-top: 1px solid #cccccc;
            text-align: center;
            font-size: 7.5pt;
            color: #666666;
        }

        .no-data {
            color: #666666;
            font-style: italic;
            font-size: 8.5pt;
        }

        /* Page break helper */
        .page-break {
            page-break-after: always;
        }

        /* Additional styling for better readability */
        strong {
            font-weight: bold;
        }

        em {
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            @if(!empty($data['logo_data_uri']))
                <div style="margin-bottom:8px;">
                    <img src="{{ $data['logo_data_uri'] }}" alt="Megawide Logo" style="height:80px; width:auto; display:block; margin:0 auto;">
                </div>
            @endif
            <div class="document-title">JOB PROFILE</div>
        </div>

        <!-- Basic Information Table -->
        <table class="info-table">
            <tr>
                <th>Job Title:</th>
                <th>Division:</th>
            </tr>
            <tr>
                <td>{{ $data['position_title'] ?? 'N/A' }}</td>
                <td>{{ $data['business_unit'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Name of Employee:</th>
                <th>Department:</th>
            </tr>
            <tr>
                <td>{{ $data['name'] ?? 'N/A' }}</td>
                <td>{{ $data['department'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Job Category:</th>
                <th>Section:</th>
            </tr>
            <tr>
                <td>{{ $data['level'] ?? 'N/A' }}</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <th>Job Grade:</th>
                <th>Supervises:</th>
            </tr>
            <tr>
                <td></td>
                <td>{{ isset($data['supervises']) && count($data['supervises']) > 0 ? implode(', ', $data['supervises']) : 'None' }}
                </td>
            </tr>
            <tr>
                <th>Reports to:</th>
                <th>Name of Immediate Superior:</th>
            </tr>
            <tr>
                <td>{{ $data['reports_to_position'] ?? 'N/A' }}</td>
                <td>{{ $data['reports_to_name'] ?? 'N/A' }}</td>
            </tr>
        </table>

        @if (isset($data['job_profile']))
            @php $jobProfile = $data['job_profile']; @endphp

            <!-- Subfunction -->
            @if (isset($jobProfile['subfunction_position']) && $jobProfile['subfunction_position'])
                <div class="section">
                    <div class="section-title">Subfunction</div>
                    <div class="section-content">
                        {{ $jobProfile['subfunction_position']['name'] ?? 'N/A' }}
                    </div>
                </div>
            @endif

            <!-- Job Purpose -->
            @if (isset($jobProfile['job_purpose']) && $jobProfile['job_purpose'])
                <div class="section">
                    <div class="section-title">Job Purpose</div>
                    <div class="section-content" style="font-style: italic; margin-bottom: 8px; font-size: 8pt;">
                        Please state what your duties and responsibilities aim to accomplish. Please also indicate the
                        end result of the job and whom do you serve?
                    </div>
                    <div class="section-content">
                        {{ $jobProfile['job_purpose'] }}
                    </div>
                </div>
            @endif

            <!-- Job Descriptions & KRAs (renamed to Job Purpose as requested) -->
            @if (isset($jobProfile['job_descriptions']) && count($jobProfile['job_descriptions']) > 0)
                <div class="section">
                    <div class="section-title">Job Purpose</div>
                    <div class="kra-container">
                        @foreach ($jobProfile['job_descriptions'] as $jd)
                            <div class="kra-item">
                                <div class="kra-header">
                                    KRA:
                                    {{ $jd['job_profile_kra']['kra'] ?? ($jd['kra']['kra'] ?? ($jd['kra'] ?? 'N/A')) }}
                                </div>
                                <div class="kra-description">{{ $jd['description'] ?? 'N/A' }}</div>

                                @if (isset($jd['profile_kras']) && count($jd['profile_kras']) > 0)
                                    <div class="deliverables-section">
                                        <div class="deliverables-title">Specific Deliverables:</div>
                                        @foreach ($jd['profile_kras'] as $pk)
                                            <div class="deliverable-item">
                                                <div class="deliverable-kra">{{ $pk['kra_description'] ?? 'N/A' }}
                                                </div>
                                                <div class="deliverable-desc">{{ $pk['deliverables'] ?? 'N/A' }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Job Performance Standards -->
            @if (isset($jobProfile['job_performance_standards']) &&
                    isset($jobProfile['job_performance_standards']['items']) &&
                    count($jobProfile['job_performance_standards']['items']) > 0)
                <div class="section">
                    <div class="section-title">
                        {{ $jobProfile['job_performance_standards']['title'] ?? 'Job Performance Standards' }}</div>
                    <div class="standard-list">
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
                </div>
            @endif

            <!-- Reporting Relationships -->
            @if (isset($jobProfile['reporting_relationships']) &&
                    isset($jobProfile['reporting_relationships']['items']) &&
                    count($jobProfile['reporting_relationships']['items']) > 0)
                <div class="section">
                    <div class="section-title">
                        {{ $jobProfile['reporting_relationships']['title'] ?? '1.0 Reporting Relationships' }}</div>
                    <div class="standard-list">
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
                </div>
            @endif

            <!-- Levels of Authority -->
            @if (isset($jobProfile['levels_of_authority']) &&
                    isset($jobProfile['levels_of_authority']['items']) &&
                    count($jobProfile['levels_of_authority']['items']) > 0)
                <div class="section">
                    <div class="section-title">
                        {{ $jobProfile['levels_of_authority']['title'] ?? '2.0 Levels of Authority' }}</div>
                    <div class="standard-list">
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
                </div>
            @endif

            <!-- Job Specifications -->
            @if (isset($jobProfile['job_specifications']) &&
                    isset($jobProfile['job_specifications']['items']) &&
                    count($jobProfile['job_specifications']['items']) > 0)
                <div class="section">
                    <div class="section-title">
                        {{ $jobProfile['job_specifications']['title'] ?? '3.0 Job Specifications' }}
                    </div>
                    <div class="standard-list">
                        @foreach ($jobProfile['job_specifications']['items'] as $spec)
                            <div class="standard-item">
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
                </div>
            @endif
        @endif

        <!-- 4.0 Understanding and Acceptance -->
        <div class="acknowledgment-section">
            <div class="acknowledgment-title">4.0 Understanding and Acceptance</div>
            <div class="acknowledgment-content">
                I have read and fully understood my <span class="highlight">Job Profile</span> and the related duties
                and responsibilities. I agree to fulfill the requirements of the job to the best of my knowledge and
                ability.
                <div class="signature-space"></div>
                <div class="signature-name">{{ $data['signatures']['prepared_by']['name'] ?? 'N/A' }}</div>
                <div class="signature-label">Name of Employee and Signature</div>
            </div>
        </div>

        <!-- 5.0 Acknowledgment and Sign-Off -->
        <div class="sign-off-section">
            <div class="sign-off-title">5.0 Acknowledgment and Sign-Off</div>
            <table class="sign-off-table">
                <tr>
                    <td class="table-header">Job Profile Prepared by:</td>
                    <td class="table-header">Reviewed by:</td>
                </tr>
                <tr>
                    <td class="signature-cell"></td>
                    <td class="signature-cell"></td>
                </tr>
                <tr>
                    <td class="name-cell">{{ $data['signatures']['prepared_by']['name'] ?? 'N/A' }}</td>
                    <td class="name-cell">{{ $data['signatures']['reviewed_by']['name'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="position-cell">
                        {{ $data['signatures']['prepared_by']['position'] ?? 'N/A' }} /
                        <span
                            style="color: #0066cc;">{{ $data['signatures']['prepared_by']['date'] ?? 'DD MM YYYY' }}</span>
                    </td>
                    <td class="position-cell">
                        {{ $data['signatures']['reviewed_by']['position'] ?? 'N/A' }} /
                        <span
                            style="color: #0066cc;">{{ $data['signatures']['reviewed_by']['date'] ?? 'DD MM YYYY' }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px; text-align: center; font-size: 8pt;">Name and Designation / Date</td>
                    <td style="padding: 5px; text-align: center; font-size: 8pt;">Name and Designation of Immediate
                        Superior / Date</td>
                </tr>
                <tr>
                    <td class="table-header">Approved by:</td>
                    <td class="table-header">Job Profile Noted by:</td>
                </tr>
                <tr>
                    <td class="signature-cell"></td>
                    <td class="signature-cell"></td>
                </tr>
                <tr>
                    <td class="name-cell">{{ $data['signatures']['approved_by']['name'] ?? 'N/A' }}</td>
                    <td class="name-cell">{{ $data['signatures']['noted_by']['name'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="position-cell">
                        {{ $data['signatures']['approved_by']['position'] ?? 'N/A' }} /
                        <span
                            style="color: #0066cc;">{{ $data['signatures']['approved_by']['date'] ?? 'DD MM YYYY' }}</span>
                    </td>
                    <td class="position-cell">
                        {{ $data['signatures']['noted_by']['position'] ?? 'N/A' }} /
                        <span
                            style="color: #0066cc;">{{ $data['signatures']['noted_by']['date'] ?? 'DD MM YYYY' }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px; text-align: center; font-size: 8pt;">Name and Designation of Department
                        Head / Date</td>
                    <td style="padding: 5px; text-align: center; font-size: 8pt;">Name and Designation, Human Resources
                        / Date</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            Generated on {{ date('F d, Y') }} | Megawide Construction Corporation
        </div>
    </div>
</body>

</html>
