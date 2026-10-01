<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>SpeedLane AutoSpa - {{ $title ?? 'Executive Report' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 12mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            line-height: 1.45;
            color: #1e293b;
            background: #ffffff;
            margin: 0;
            padding: 0;
        }
        .peso {
            font-family: 'DejaVu Sans', sans-serif;
        }
        .header-table {
            width: 100%;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .brand-title {
            font-size: 20px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: -0.3px;
        }
        .sub-title {
            font-size: 9.5px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 2px;
            font-weight: 600;
        }
        .meta-text {
            font-size: 9.5px;
            color: #475569;
            text-align: right;
            line-height: 1.35;
        }
        .subject-bar {
            margin-bottom: 12px;
        }
        .subject-title {
            font-size: 13px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
        }
        .subject-sub {
            font-size: 9px;
            color: #64748b;
        }
        
        .summary-text-bar {
            background-color: #f8fafc;
            border-left: 3px solid #0f172a;
            padding: 6px 10px;
            margin-bottom: 14px;
            font-size: 9.5px;
            color: #334155;
        }

        .section-header {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 4px;
            margin-bottom: 10px;
            color: #0f172a;
            letter-spacing: 0.3px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 9.5px;
        }
        .data-table th {
            background-color: #f1f5f9;
            color: #475569;
            padding: 6px 8px;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8.5px;
            border-bottom: 1px solid #cbd5e1;
        }
        .data-table td {
            border-bottom: 1px solid #f1f5f9;
            padding: 6px 8px;
            color: #1e293b;
        }
        .data-table tr:nth-child(even) td {
            background-color: #fafafa;
        }

        .list-container {
            border-left: 3px solid #2563eb;
            padding-left: 10px;
            margin-bottom: 14px;
        }
        .list-title {
            font-weight: bold;
            color: #0f172a;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .list-item {
            padding: 9px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .list-item-header {
            width: 100%;
            margin-bottom: 3px;
        }
        .list-item-title {
            font-size: 10.5px;
            font-weight: bold;
            color: #0f172a;
        }
        .list-item-meta {
            font-size: 9px;
            color: #475569;
            line-height: 1.55;
            margin-top: 3px;
        }

        .analysis-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 9px 11px;
            margin-bottom: 14px;
        }
        .analysis-title {
            font-size: 9.5px;
            font-weight: bold;
            text-transform: uppercase;
            color: #0f172a;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }
        .analysis-text {
            font-size: 9px;
            color: #475569;
            line-height: 1.45;
            margin: 0 0 4px 0;
        }
        .analysis-list {
            margin: 0;
            padding-left: 14px;
            font-size: 9px;
            color: #475569;
            line-height: 1.5;
        }

        .badge {
            font-weight: bold;
            color: #334155;
        }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .font-mono { font-family: 'Courier New', Courier, monospace; }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 8.5px;
            color: #94a3b8;
            text-align: center;
            border-top: 1px solid #f1f5f9;
            padding-top: 4px;
        }
    </style>
</head>
<body>

    @php
        $transactions = collect($transactions ?? []);

        // Resolve Report Category Group
        $typeKey = strtolower($reportType ?? 'financial');
        $isFinancial  = in_array($typeKey, ['financial', 'revenue', '1']);
        $isCustomer   = in_array($typeKey, ['customer', 'customers', '5']);
        $isService    = in_array($typeKey, ['service', 'services', 'service_demand', '3']);
        $isVehicle    = in_array($typeKey, ['vehicle', 'vehicles', '6']);
        $isTechnician = in_array($typeKey, ['technician', 'technicians', '2']);

        // Standardized Helper for Currency Formatting
        $formatMoney = function($amount) {
            return '<span class="peso">&#8369;</span>' . number_format((float)($amount ?? 0), 2);
        };

        $getDateRegistered = function($trx) {
            $item = is_array($trx) ? (object)$trx : $trx;
            $date = $item->created_at ?? $item->date_registered ?? $item->registered_at ?? $item->created_date ?? null;
            return $date ? \Carbon\Carbon::parse($date)->format('M d, Y h:i A') : 'N/A';
        };

        $getDateCompleted = function($trx) {
            $item = is_array($trx) ? (object)$trx : $trx;
            $date = $item->completed_at ?? $item->date_completed ?? $item->finished_at ?? $item->completed_date ?? null;
            if (!$date && strtolower($item->status ?? '') === 'completed') {
                $date = $item->updated_at ?? null;
            }
            return $date ? \Carbon\Carbon::parse($date)->format('M d, Y h:i A') : '-';
        };

        $getMechanicName = function($trx) {
            $item = is_array($trx) ? (object)$trx : $trx;
            return $item->mechanic_assigned 
                ?? ($item->technician->name ?? $item->technician->full_name ?? null)
                ?? ($item->mechanic->name ?? $item->mechanic->full_name ?? null)
                ?? $item->technician_name 
                ?? $item->mechanic_name
                ?? 'Unassigned';
        };

        $getCustomerName = function($trx) {
            $item = is_array($trx) ? (object)$trx : $trx;
            return $item->customer_name 
                ?? ($item->customer->name ?? null)
                ?? ($item->user->name ?? null)
                ?? $item->client_name 
                ?? $item->name
                ?? 'N/A';
        };

        $getContactPhone = function($trx) {
            $item = is_array($trx) ? (object)$trx : $trx;
            return $item->contact_number 
                ?? $item->phone_number 
                ?? $item->customer_phone 
                ?? $item->phone
                ?? ($item->customer->phone ?? 'N/A');
        };

        $getVehicleDetails = function($trx) {
            $item = is_array($trx) ? (object)$trx : $trx;
            $type  = trim($item->vehicle_type ?? '');
            $brand = trim($item->vehicle_brand ?? ($item->vehicle_make ?? ($item->brand ?? '')));
            $model = trim($item->vehicle_model ?? ($item->model ?? ''));
            $year  = trim($item->vehicle_year ?? ($item->year ?? ''));

            $brandModel = implode(' ', array_filter([$brand, $model]));
            if ($year !== '') {
                $brandModel = $brandModel !== '' ? "{$brandModel} ({$year})" : $year;
            }

            if ($type !== '' && $brandModel !== '') {
                return "{$type} - {$brandModel}";
            }
            return $type !== '' ? $type : ($brandModel !== '' ? $brandModel : 'Unspecified Vehicle');
        };

        $parseServices = function($trx) {
            $item = is_array($trx) ? (object)$trx : $trx;
            $raw = $item->selected_services ?? [];
            if (is_string($raw)) {
                $decoded = json_decode($raw, true);
                $services = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : explode(',', $raw);
            } else {
                $services = (array)$raw;
            }

            $result = [];
            foreach ($services as $s) {
                if (is_array($s)) {
                    $name = $s['name'] ?? ($s['service_name'] ?? '');
                } elseif (is_object($s)) {
                    $name = $s->name ?? ($s->service_name ?? '');
                } else {
                    $name = (string)$s;
                }
                $trimmed = trim($name);
                if ($trimmed !== '') {
                    $result[] = $trimmed;
                }
            }
            return $result;
        };

        $totalJobsCount = $totalCount ?? $transactions->count();
        $completedJobs = $transactions->where('status', 'Completed')->count();
        $inProgressJobs = $transactions->whereIn('status', ['In Progress', 'Pending', 'In Queue'])->count();
        $grossRevenue = $totalRevenue ?? $transactions->sum('total_cost');
        $avgOrderValue = $totalJobsCount > 0 ? ($grossRevenue / $totalJobsCount) : 0;
    @endphp

    <!-- Header Letterhead -->
    <table class="header-table">
        <tr>
            <td style="width: 60%;">
                <div class="brand-title">SpeedLane AutoSpa</div>
                <div class="sub-title">
                    {{ $isFinancial ? 'Executive Financial Summary' : 'Executive Business & Intelligence Analytics' }}
                </div>
            </td>
            <td style="width: 40%;" class="meta-text">
                <div><strong>Generated:</strong> {{ $generatedAt ?? date('M d, Y h:i A') }}</div>
                <div><strong>Timeframe:</strong> {{ $periodLabel ?? 'All Time' }}</div>
                <div><strong>Status Scope:</strong> {{ strtoupper($statusFilter ?? 'All Statuses') }}</div>
            </td>
        </tr>
    </table>

    <!-- Category Subject Bar -->
    <div class="subject-bar">
        <div class="subject-title">SUBJECT: {{ strtoupper($title ?? ($reportType . ' Executive Report')) }}</div>
        <div class="subject-sub">SpeedLane Management & Operational Decision Support Document</div>
    </div>

    <!-- ========================================================= -->
    <!-- 1. FINANCIAL & REVENUE REPORT                             -->
    <!-- ========================================================= -->
    @if($isFinancial)

        <div class="summary-text-bar">
            <strong>Financial Overview:</strong> Comprehensive transaction ledger and revenue distribution records for the selected period.
        </div>

        <div class="section-header">Financial Transaction Ledger</div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Tracking Code</th>
                    <th>Customer Name</th>
                    <th>Vehicle Details</th>
                    <th>Services Rendered</th>
                    <th>Status</th>
                    <th>Date Registered</th>
                    <th>Date Completed</th>
                    <th>Price Adjustment / Note</th>
                    <th class="text-end">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                    @php 
                        $trxObj = is_array($trx) ? (object)$trx : $trx; 
                        $sList = $parseServices($trx);
                    @endphp
                    <tr>
                        <td class="font-mono fw-bold">{{ $trxObj->tracking_code }}</td>
                        <td class="fw-bold">{{ $getCustomerName($trx) }}</td>
                        <td>{{ $getVehicleDetails($trx) }}</td>
                        <td><strong>{{ !empty($sList) ? implode(', ', $sList) : 'N/A' }}</strong></td>
                        <td class="text-center fw-bold">{{ $trxObj->status }}</td>
                        <td>{{ $getDateRegistered($trx) }}</td>
                        <td>{{ $getDateCompleted($trx) }}</td>
                        <td style="color: #64748b;">{{ $trxObj->price_adjustment_note ?? '-' }}</td>
                        <td class="text-end font-mono fw-bold">{!! $formatMoney($trxObj->total_cost ?? 0) !!}</td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center">No financial records match the criteria.</td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color: #f8fafc; font-weight: bold;">
                    <td colspan="8" class="text-end" style="font-size: 8.5px; text-transform: uppercase;">Total Realized Revenue:</td>
                    <td class="text-end font-mono text-primary-val">{!! $formatMoney($grossRevenue) !!}</td>
                </tr>
            </tfoot>
        </table>

        <div class="analysis-box">
            <div class="analysis-title">Executive Revenue Summary & Strategic Analysis</div>
            <p class="analysis-text">
                During this period, SpeedLane AutoSpa generated a total realized gross revenue of <strong>{!! $formatMoney($grossRevenue) !!}</strong> across <strong>{{ number_format($totalJobsCount) }}</strong> completed and processed service sessions. The average ticket value per vehicle stood firmly at <strong>{!! $formatMoney($avgOrderValue) !!}</strong>.
            </p>
            <p class="analysis-text" style="margin-bottom: 0;">
                <strong>Financial Note:</strong> Higher-value detailed packages and custom pricing adjustments contributed significantly to overall profit margins. It is recommended to bundle complimentary minor services into premium packages to maintain or increase the average transaction value in subsequent quarters.
            </p>
        </div>

    <!-- ========================================================= -->
    <!-- 2. CUSTOMER & RETENTION REPORT                            -->
    <!-- ========================================================= -->
    @elseif($isCustomer)

        @php
            $custGroups = $transactions->groupBy(function($item) use ($getCustomerName) {
                return trim($getCustomerName($item));
            });
            $uniqueCustomersCount = $custGroups->count();
            $repeatCustomersCount = $custGroups->filter(fn($group) => $group->count() > 1)->count();
            $repeatRate = $uniqueCustomersCount > 0 ? round(($repeatCustomersCount / $uniqueCustomersCount) * 100, 1) : 0;
            $avgVisitsPerClient = $uniqueCustomersCount > 0 ? round($totalJobsCount / $uniqueCustomersCount, 1) : 0;
        @endphp

        <div class="summary-text-bar">
            <strong>Customer Intelligence:</strong> Client retention, visit logs, vehicle count, acquired services, and key account profiles overview.
        </div>

        <div class="section-header">1. Customer Loyalty & Profile Summary</div>

        <p style="color: #475569; margin-bottom: 10px;">
            This evaluation analyzes client engagement and return frequency across SpeedLane AutoSpa services. Out of <strong>{{ number_format($uniqueCustomersCount) }} total unique clients</strong> recorded, <strong>{{ number_format($repeatCustomersCount) }} clients</strong> have returned for multiple service sessions, representing a customer retention rate of <strong>{{ $repeatRate }}%</strong>.
        </p>

        <div class="list-container">
            <div class="list-title">Client Loyalty Breakdown & Key Account Profiles</div>
            @forelse($custGroups as $cName => $cJobs)
                @php
                    $lastJob = $cJobs->sortByDesc('created_at')->first();
                    $visitCount = $cJobs->count();
                    $clientRevenue = $cJobs->sum('total_cost');
                    $cVehicles = $cJobs->map(fn($j) => $getVehicleDetails($j))->unique();
                    $vehicleCount = $cVehicles->count();
                    $cServices = $cJobs->flatMap(fn($j) => $parseServices($j))->unique()->values()->all();
                @endphp
                <div class="list-item" style="padding: 9px 0; border-bottom: 1px solid #e2e8f0;">
                    <table class="list-item-header" style="margin-bottom: 4px;">
                        <tr>
                            <td class="list-item-title" style="font-size: 10.5px;">{{ $cName }}</td>
                            <td class="text-end" style="font-size: 9px; font-weight: bold; color: {{ $visitCount > 1 ? '#2563eb' : '#0f172a' }};">
                                {{ $visitCount }} {{ \Illuminate\Support\Str::plural('Visit', $visitCount) }} &bull; {{ $vehicleCount }} {{ \Illuminate\Support\Str::plural('Vehicle', $vehicleCount) }} &bull; Spend: {!! $formatMoney($clientRevenue) !!}
                            </td>
                        </tr>
                    </table>
                    <div class="list-item-meta" style="line-height: 1.55; margin-top: 3px;">
                        <strong style="color: #0f172a;">Vehicles Serviced:</strong> {{ $cVehicles->implode(' | ') }}
                    </div>
                    <div class="list-item-meta" style="line-height: 1.55; margin-top: 3px;">
                        <strong style="color: #0f172a;">Contact:</strong> {{ $getContactPhone($lastJob) }} &nbsp;&nbsp;|&nbsp;&nbsp; 
                        <strong style="color: #0f172a;">Last Registered:</strong> {{ $getDateRegistered($lastJob) }}
                    </div>
                    <div class="list-item-meta" style="line-height: 1.55; margin-top: 3px;">
                        <strong style="color: #0f172a;">Services Acquired:</strong> {{ !empty($cServices) ? implode(', ', $cServices) : 'None' }}
                    </div>
                </div>
            @empty
                <div style="color: #64748b; font-size: 9px; padding: 4px 0;">No client profiles available for the selected parameters.</div>
            @endforelse
        </div>

        <div class="analysis-box">
            <div class="analysis-title">2. Retention Insights & Executive Recommendations</div>
            <ul class="analysis-list">
                <li style="margin-bottom: 2px;"><strong>Retention Efficiency:</strong> A retention rate of {{ $repeatRate }}% indicates strong organic client satisfaction. Repeat customers account for higher lifetime customer value (LTV) and significantly reduce acquisition costs.</li>
                <li style="margin-bottom: 2px;"><strong>VIP Accounts:</strong> Clients with more than 2 visits represent the backbone of recurring revenue. Special loyalty benefits or routine service reminder notifications (SMS/Email) should be prioritized for this tier.</li>
                <li><strong>Growth Opportunities:</strong> First-time visitors should be target candidates for post-service follow-up feedback calls or discounted follow-up maintenance bookings within 30 days.</li>
            </ul>
        </div>

    <!-- ========================================================= -->
    <!-- 3. SERVICE DEMAND REPORT                                  -->
    <!-- ========================================================= -->
    @elseif($isService)

        @php
            $svcStats = [];
            foreach ($transactions as $trx) {
                $parsedServices = $parseServices($trx);
                $cost = (float)(is_array($trx) ? ($trx['total_cost'] ?? 0) : ($trx->total_cost ?? 0));
                $svcCountForTrx = max(count($parsedServices), 1);
                $allocatedCost = $cost / $svcCountForTrx;

                foreach ($parsedServices as $sName) {
                    if (!isset($svcStats[$sName])) {
                        $svcStats[$sName] = ['name' => $sName, 'count' => 0, 'revenue' => 0];
                    }
                    $svcStats[$sName]['count'] += 1;
                    $svcStats[$sName]['revenue'] += $allocatedCost;
                }
            }
            $sortedServices = collect(array_values($svcStats))->sortByDesc('count');
            $totalSvcRequests = max($sortedServices->sum('count'), 1);
            $topService = $sortedServices->first()['name'] ?? 'N/A';
            $topServiceCount = $sortedServices->first()['count'] ?? 0;
            $topServiceShare = round(($topServiceCount / $totalSvcRequests) * 100, 1);
        @endphp

        <div class="summary-text-bar">
            <strong>Service Demand Analysis:</strong> Overview of package preferences, demand ranking, and line item activity.
        </div>

        <div class="section-header">1. Service Demand Breakdown & Package Performance</div>

        <p style="color: #475569; margin-bottom: 10px;">
            This analysis outlines client service preferences and operational volume across all offered packages. A total of <strong>{{ number_format($totalSvcRequests) }} individual service procedures</strong> were rendered across the evaluated time period.
        </p>

        <div class="list-container">
            <div class="list-title">Service Popularity & Volume Ranking</div>
            @forelse($sortedServices as $sRow)
                @php
                    $share = round(($sRow['count'] / $totalSvcRequests) * 100, 1);
                @endphp
                <div class="list-item">
                    <table class="list-item-header">
                        <tr>
                            <td class="list-item-title">{{ $sRow['name'] }}</td>
                            <td class="text-end" style="font-size: 9px; font-weight: bold; color: #0f172a;">
                                {{ number_format($sRow['count']) }} requests ({{ $share }}% total share)
                            </td>
                        </tr>
                    </table>
                    <div class="list-item-meta">
                        Estimated Segment Contribution: <strong>{!! $formatMoney($sRow['revenue']) !!}</strong>
                    </div>
                </div>
            @empty
                <div style="color: #64748b; font-size: 9px; padding: 4px 0;">No service demand metrics logged.</div>
            @endforelse
        </div>

        <div class="analysis-box">
            <div class="analysis-title">2. Operational Planning & Service Portfolio Strategy</div>
            <ul class="analysis-list">
                <li style="margin-bottom: 2px;"><strong>Core Revenue Drivers:</strong> The dominant service package is <strong>{{ $topService }}</strong>, capturing {{ $topServiceShare }}% of total job requests. Ensure bay consumables and assigned technicians are fully equipped for this package.</li>
                <li style="margin-bottom: 2px;"><strong>Cross-Selling Opportunities:</strong> Secondary services showing growth should be bundled alongside high-volume washing or detailing tasks to boost ticket size.</li>
                <li><strong>Inventory Optimization:</strong> Chemical inventories and cleaning supplies should be aligned directly with the demand percentage of each top-ranking service line.</li>
            </ul>
        </div>

    <!-- ========================================================= -->
    <!-- 4. VEHICLE SEGMENT REPORT                                 -->
    <!-- ========================================================= -->
    @elseif($isVehicle)

        @php
            $vehGroups = $transactions->groupBy(function($item) use ($getVehicleDetails) {
                return $getVehicleDetails($item);
            });

            $topVehicleSegment = $vehGroups->sortByDesc(fn($g) => $g->count())->keys()->first() ?? 'N/A';
            $uniqueSegmentsCount = $vehGroups->count();

            $typeCounts = $transactions->groupBy(function($item) {
                $trxObj = is_array($item) ? (object)$item : $item;
                return trim($trxObj->vehicle_type ?? 'Sedan');
            });
            $dominantType = $typeCounts->sortByDesc(fn($g) => $g->count())->keys()->first() ?? 'N/A';
        @endphp

        <div class="summary-text-bar">
            <strong>Vehicle Demographics:</strong> Distribution breakdown by body class, manufacturer models, segment volume, and acquired services.
        </div>

        <div class="section-header">1. Vehicle Categorization & Demographics Analysis</div>

        <p style="color: #475569; margin-bottom: 10px;">
            This evaluation examines the vehicle types, body classes, manufacturers, models, and year configurations serviced at SpeedLane AutoSpa. A cumulative total of <strong>{{ number_format($totalJobsCount) }} vehicle entries</strong> were processed across <strong>{{ $uniqueSegmentsCount }} unique vehicle configurations</strong>.
        </p>

        <div class="list-container">
            <div class="list-title">Vehicle Class, Brand, Model & Year Distribution</div>
            @forelse($vehGroups as $vSegment => $vJobs)
                @php
                    $vCount = $vJobs->count();
                    $vCompleted = $vJobs->where('status', 'Completed')->count();
                    $vShare = round(($vCount / max($totalJobsCount, 1)) * 100, 1);
                    $vRevenue = $vJobs->sum('total_cost');
                    $vServices = $vJobs->flatMap(fn($j) => $parseServices($j))->unique()->values()->all();
                @endphp
                <div class="list-item">
                    <table class="list-item-header">
                        <tr>
                            <td class="list-item-title">{{ $vSegment }}</td>
                            <td class="text-end" style="font-size: 9px; font-weight: bold; color: #0f172a;">
                                {{ $vCount }} Serviced ({{ $vShare }}% of fleet)
                            </td>
                        </tr>
                    </table>
                    <div class="list-item-meta">
                        Status: <strong>{{ $vCompleted }} Completed</strong> | 
                        Realized Revenue: <strong>{!! $formatMoney($vRevenue) !!}</strong>
                    </div>
                    <div class="list-item-meta" style="margin-top: 2px;">
                        Services Acquired: <strong>{{ !empty($vServices) ? implode(', ', $vServices) : 'None' }}</strong>
                    </div>
                </div>
            @empty
                <div style="color: #64748b; font-size: 9px; padding: 4px 0;">No vehicle segment records recorded.</div>
            @endforelse
        </div>

        <div class="analysis-box">
            <div class="analysis-title">2. Bay Allocation & Equipment Insights</div>
            <ul class="analysis-list">
                <li style="margin-bottom: 2px;"><strong>Facility Sizing:</strong> <strong>{{ $dominantType }}</strong> vehicles make up the majority of shop entries. Service bay dimensions and lift equipment should remain optimized for standard and oversized body frames.</li>
                <li style="margin-bottom: 2px;"><strong>Segment Pricing Strategy:</strong> Larger vehicle categories (SUVs, Crossovers, Pickups) require higher labor and material expenditure. Ensure tiered pricing reflects vehicle size accurately.</li>
                <li><strong>Resource Management:</strong> Track turnaround times per vehicle segment to ensure larger chassis do not create operational bottlenecks in washing and detailing bays.</li>
            </ul>
        </div>

    <!-- ========================================================= -->
    <!-- 5. TECHNICIAN PERFORMANCE REPORT                          -->
    <!-- ========================================================= -->
    @elseif($isTechnician)

        @php
            $techGroups = $transactions->groupBy(function($item) use ($getMechanicName) {
                return trim($getMechanicName($item));
            });
            $activeTechs = $techGroups->count();
            $totalAssigned = $transactions->count();
            $totalCompleted = $transactions->where('status', 'Completed')->count();
            $avgCompletionRate = $totalAssigned > 0 ? round(($totalCompleted / $totalAssigned) * 100, 1) : 0;
        @endphp

        <div class="summary-text-bar">
            <strong>Technician Productivity:</strong> Staff workload balance, assigned job fulfillment, and performance tracking.
        </div>

        <div class="section-header">Technician Productivity & Workload Distribution</div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Technician Name</th>
                    <th class="text-center">Assigned Jobs</th>
                    <th class="text-center">Completed Jobs</th>
                    <th class="text-center">Completion Rate</th>
                    <th class="text-end">Revenue Generated</th>
                </tr>
            </thead>
            <tbody>
                @forelse($techGroups as $techName => $jobs)
                    @php
                        $assigned = $jobs->count();
                        $completed = $jobs->where('status', 'Completed')->count();
                        $rate = $assigned > 0 ? round(($completed / $assigned) * 100, 1) : 0;
                        $techRev = $jobs->where('status', 'Completed')->sum('total_cost');
                    @endphp
                    <tr>
                        <td class="fw-bold">{{ $techName }}</td>
                        <td class="text-center">{{ $assigned }}</td>
                        <td class="text-center fw-bold">{{ $completed }}</td>
                        <td class="text-center font-mono">{{ $rate }}%</td>
                        <td class="text-end font-mono fw-bold">{!! $formatMoney($techRev) !!}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">No technician records found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="analysis-box">
            <div class="analysis-title">Strategic Staffing & Throughput Assessment</div>
            <ul class="analysis-list">
                <li style="margin-bottom: 2px;"><strong>Performance Output:</strong> Staff achieved an overall completion rate of {{ $avgCompletionRate }}% during this operational window.</li>
                <li><strong>Workload Balancing:</strong> Monitor high-volume technician schedules to prevent fatigue and preserve high-quality service standards across detailing bays.</li>
            </ul>
        </div>

    <!-- ========================================================= -->
    <!-- 6. DEFAULT / OPERATIONS QUEUE / SERVICE AUDIT REPORT       -->
    <!-- ========================================================= -->
    @else

        @php
            $completionRate = $totalJobsCount > 0 ? round(($completedJobs / $totalJobsCount) * 100, 1) : 0;
        @endphp

        <div class="summary-text-bar">
            <strong>Operational Queue & Service Audit Log:</strong> Daily activity feed, service details, bay assignments, and ticket turnaround records.
        </div>

        <div class="section-header">1. Operational Queue & Service Activity Feed</div>

        <p style="color: #475569; margin-bottom: 10px;">
            This log details daily operational throughput, services performed, bay assignments, and mechanic fulfillment rates. A total of <strong>{{ number_format($totalJobsCount) }} work tickets</strong> were created during this operational window, achieving a turnaround fulfillment rate of <strong>{{ $completionRate }}%</strong>.
        </p>

        <div class="list-container">
            <div class="list-title">Logged Activity & Service Audit Breakdown</div>
            @forelse($transactions as $trx)
                @php 
                    $trxObj = is_array($trx) ? (object)$trx : $trx; 
                    $qServices = $parseServices($trx);
                @endphp
                <div class="list-item">
                    <table class="list-item-header">
                        <tr>
                            <td class="font-mono fw-bold" style="font-size: 10px; color: #0f172a;">{{ $trxObj->tracking_code }}</td>
                            <td class="text-end fw-bold">{{ $trxObj->status }}</td>
                        </tr>
                    </table>
                    <div style="font-weight: 600; color: #0f172a; margin-top: 2px;">
                        Client: {{ $getCustomerName($trx) }} | Vehicle: {{ $getVehicleDetails($trx) }} | Plate: {{ $trxObj->plate_number ?? 'N/A' }}
                    </div>
                    <div class="list-item-meta" style="margin-top: 2px;">
                        Services Rendered: <strong>{{ !empty($qServices) ? implode(', ', $qServices) : 'N/A' }}</strong>
                    </div>
                    <div class="list-item-meta">
                        Assigned Staff: <strong>{{ $getMechanicName($trx) }}</strong> | 
                        Registered: <strong>{{ $getDateRegistered($trx) }}</strong> | 
                        Completed: <strong>{{ $getDateCompleted($trx) }}</strong>
                    </div>
                </div>
            @empty
                <div style="color: #64748b; font-size: 9px; padding: 4px 0;">No operational queue records found.</div>
            @endforelse
        </div>

        <div class="analysis-box">
            <div class="analysis-title">2. Operational Efficiency & Capacity Assessment</div>
            <ul class="analysis-list">
                <li style="margin-bottom: 2px;"><strong>Turnaround Rate:</strong> With {{ $completedJobs }} out of {{ $totalJobsCount }} jobs completed ({{ $completionRate }}%), bay throughput is operating at standard capacity.</li>
                <li style="margin-bottom: 2px;"><strong>Active Queue:</strong> Currently, {{ $inProgressJobs }} jobs remain in active/pending status. Staffing allocation should be balanced to clear open queues prior to peak arrival hours.</li>
                <li><strong>Technician Load Balancing:</strong> Ensure service assignments are distributed evenly among mechanics to minimize idle bay time and maintain consistent service quality.</li>
            </ul>
        </div>

    @endif

    <!-- Footer -->
    <div class="footer">
        SpeedLane AutoSpa Operational Intelligence Document • Internal Business Management System
    </div>

</body>
</html>