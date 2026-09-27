<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9.5px;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .brand-title {
            font-size: 18px;
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }

        .report-subtitle {
            font-size: 12px;
            color: #2563eb;
            font-weight: bold;
            margin: 4px 0 2px 0;
            text-transform: uppercase;
        }

        .period-label {
            font-size: 9.5px;
            color: #64748b;
            margin: 0;
        }

        .summary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px;
            margin-bottom: 12px;
        }

        .summary-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px;
            text-align: center;
        }

        .summary-label {
            font-size: 8.5px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .summary-value {
            font-size: 13px;
            font-weight: bold;
            color: #0f172a;
            margin-top: 3px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        table.data-table th {
            background-color: #1e293b;
            color: #ffffff;
            text-align: left;
            padding: 6px 7px;
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        table.data-table td {
            padding: 6px 7px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 9px;
            vertical-align: top;
        }

        table.data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .sub-text {
            color: #64748b;
            font-size: 8px;
            display: block;
        }

        .service-tag {
            display: inline-block;
            background-color: #e0f2fe;
            color: #0369a1;
            padding: 1px 4px;
            border-radius: 3px;
            font-size: 7.5px;
            margin: 1px;
            white-space: nowrap;
        }

        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            font-size: 8px;
            text-align: center;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 6px;
        }

        .empty-state {
            text-align: center;
            padding: 25px;
            color: #64748b;
            font-style: italic;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="brand-title">Speedlane Auto Detailing</div>
        <div class="report-subtitle">{{ $title }}</div>
        <div class="period-label">Period: {{ $periodLabel }}</div>
    </div>

    <table class="summary-table">
        <tr>
            <td width="50%">
                <div class="summary-card">
                    <div class="summary-label">Total Transactions Completed</div>
                    <div class="summary-value">{{ number_format($totalCount) }}</div>
                </div>
            </td>
            <td width="50%">
                <div class="summary-card">
                    <div class="summary-label">Total Revenue Generated</div>
                    <div class="summary-value">&#8369;{{ number_format($totalRevenue, 2) }}</div>
                </div>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="11%">Tracking #</th>
                <th width="18%">Customer & Contact</th>
                <th width="19%">Vehicle & Tech</th>
                <th width="22%">Services</th>
                <th width="15%">Dates (Reg / Comp)</th>
                <th width="15%" class="text-right">Total Estimated Cost</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $trx)
                @php
                    // Dynamic phone contact lookup
                    $contactPhone = $trx->contact_number 
                        ?? $trx->phone_number 
                        ?? $trx->customer_phone 
                        ?? $trx->phone 
                        ?? $trx->contact 
                        ?? 'N/A';

                    // Mechanic / Technician lookup
                    $vehiclesList = $trx->vehicles ?? collect();
                    if ($vehiclesList->count() > 0) {
                        $technician = $vehiclesList->pluck('mechanic_assigned')->filter()->unique()->implode(', ');
                    } else {
                        $technician = $trx->mechanic_assigned ?? $trx->technician ?? '';
                    }

                    // Services parsing
                    $services = is_array($trx->selected_services) 
                        ? $trx->selected_services 
                        : json_decode($trx->selected_services ?? '[]', true);

                    if (!is_array($services)) {
                        $services = array_filter(explode(', ', (string) $trx->selected_services));
                    }
                @endphp
                <tr>
                    <!-- Tracking Code -->
                    <td><strong>{{ $trx->tracking_code ?? 'N/A' }}</strong></td>

                    <!-- Customer Name & Contact Number -->
                    <td>
                        <strong>{{ $trx->customer_name ?? 'N/A' }}</strong>
                        <span class="sub-text">{{ $contactPhone }}</span>
                    </td>

                    <!-- Vehicle Info & Technician -->
                    <td>
                        {{ $trx->vehicle_type ?? $trx->vehicle_body_type ?? 'Vehicle' }}
                        @if($trx->vehicle_model || $trx->plate_number)
                            <span class="sub-text">
                                {{ $trx->vehicle_model ?? '' }} 
                                {{ $trx->plate_number ? '('.$trx->plate_number.')' : '' }}
                            </span>
                        @endif
                        <span class="sub-text" style="color: #2563eb;">Tech: {{ $technician ?: 'Unassigned' }}</span>
                    </td>

                    <!-- Services -->
                    <td>
                        @foreach($services as $srv)
                            @php $sName = is_array($srv) ? ($srv['name'] ?? '') : (string) $srv; @endphp
                            @if(!empty(trim($sName)))
                                <span class="service-tag">{{ trim($sName) }}</span>
                            @endif
                        @endforeach
                    </td>

                    <!-- Registered Date & Completed Date -->
                    <td>
                        <span class="sub-text"><strong>Reg:</strong> {{ \Carbon\Carbon::parse($trx->created_at)->format('M d, Y') }}</span>
                        <span class="sub-text"><strong>Comp:</strong> {{ \Carbon\Carbon::parse($trx->updated_at ?? $trx->created_at)->format('M d, Y') }}</span>
                    </td>

                    <!-- Total Estimated Cost -->
                    <td class="text-right">
                        <strong>&#8369;{{ number_format((float)($trx->total_cost ?? 0), 2) }}</strong>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty-state">
                        No completed transactions found for this period.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Generated automatically on {{ date('F d, Y h:i A') }} | Speedlane Auto Detailing System
    </div>

</body>
</html>