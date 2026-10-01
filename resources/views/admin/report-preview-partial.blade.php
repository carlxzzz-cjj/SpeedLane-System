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

<style>
    .peso { font-family: 'DejaVu Sans', sans-serif !important; }
    @media print, pdf {
        .row { display: table !important; width: 100% !important; table-layout: fixed !important; }
        .col-6 { display: table-cell !important; width: 50% !important; vertical-align: top !important; }
        .col-md-3, .col-6.col-md-3 { display: table-cell !important; width: 25% !important; vertical-align: top !important; }
        .col-md-4 { display: table-cell !important; width: 33.33% !important; vertical-align: top !important; }
        .d-flex { display: table !important; width: 100% !important; }
        .d-flex > div, .d-flex > span { display: table-cell !important; vertical-align: middle !important; }
        .justify-content-between > div:last-child, .justify-content-between > span:last-child { text-align: right !important; }
        .text-end { text-align: right !important; }
        .table { width: 100% !important; border-collapse: collapse !important; }
        .table th, .table td { padding: 6px 8px !important; }
    }
</style>

<div class="p-4 bg-white text-dark text-start" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 13.5px; color: #1e293b; line-height: 1.6;">

    <!-- Document Header Letterhead -->
    <div class="d-flex justify-content-between align-items-end border-bottom pb-3 mb-4" style="border-color: #cbd5e1 !important;">
        <div>
            <h3 class="fw-bold text-uppercase mb-1 d-flex align-items-center gap-2" style="letter-spacing: -0.5px; color: #0f172a;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-car-front-fill me-1" viewBox="0 0 16 16">
                    <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c.969 0 1.838.567 2.298 1.515l.792 1.628c.08.164.248.272.43.272h.3c.552 0 1 .448 1 1v2c0 .28-.112.534-.293.719C16.452 9.387 16 10.138 16 11v1a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1v-1H3v1a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1v-1c0-.862-.452-1.613-.654-1.881A1.002 1.002 0 0 1 0 8V6c0-.552.448-1 1-1h.3c.182 0 .35-.108.43-.272l.79-1.628zM4 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm8 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zM3.82 4l-.5 1h9.36l-.5-1H3.82z"/>
                </svg>
                SpeedLane AutoSpa
            </h3>
            <span class="text-muted small text-uppercase fw-semibold" style="letter-spacing: 0.5px;">
                {{ $isFinancial ? 'Executive Financial Summary' : 'Executive Business & Intelligence Analytics' }}
            </span>
        </div>
        <div class="text-end small text-secondary">
            <div><span class="fw-semibold text-dark">Generated:</span> {{ $generatedAt ?? date('M d, Y h:i A') }}</div>
            <div><span class="fw-semibold text-dark">Timeframe:</span> {{ $periodLabel ?? 'All Time' }}</div>
            <div><span class="fw-semibold text-dark">Status Scope:</span> {{ strtoupper($statusFilter ?? 'All Statuses') }}</div>
        </div>
    </div>

    <!-- Category Document Header -->
    <div class="mb-4">
        <h5 class="fw-bold text-uppercase mb-1" style="color: #0f172a; font-size: 14px;">
            Subject: {{ strtoupper($title ?? ($reportType . ' Executive Report')) }}
        </h5>
        <span class="text-muted extra-small">SpeedLane Management & Operational Decision Support Document</span>
    </div>

    <!-- ========================================================= -->
    <!-- 1. FINANCIAL & REVENUE REPORT                             -->
    <!-- ========================================================= -->
    @if($isFinancial)

        <div class="p-2 px-3 mb-4 bg-light border-start border-3 border-dark text-secondary small rounded-1">
            <strong class="text-dark">Financial Overview:</strong> Detailed transaction ledger and revenue distribution records for the selected period.
        </div>

        <div class="mb-4">
            <h6 class="fw-bold text-uppercase text-dark mb-3 pb-1 border-bottom" style="font-size: 12px; border-color: #cbd5e1 !important;">
                Financial Transaction Ledger
            </h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle small border-bottom mb-0">
                    <thead class="table-light text-uppercase extra-small text-muted">
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
                                <td class="font-monospace fw-bold text-dark">{{ $trxObj->tracking_code }}</td>
                                <td class="fw-semibold text-dark">{{ $getCustomerName($trx) }}</td>
                                <td>{{ $getVehicleDetails($trx) }}</td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ !empty($sList) ? implode(', ', $sList) : 'N/A' }}</span>
                                </td>
                                <td class="fw-semibold text-dark">{{ $trxObj->status }}</td>
                                <td class="extra-small text-dark">{{ $getDateRegistered($trx) }}</td>
                                <td class="extra-small text-dark">{{ $getDateCompleted($trx) }}</td>
                                <td class="text-muted extra-small">{{ $trxObj->price_adjustment_note ?? '-' }}</td>
                                <td class="text-end font-monospace fw-bold text-dark">{!! $formatMoney($trxObj->total_cost ?? 0) !!}</td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="text-center py-4 text-muted">No financial records match the criteria.</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold bg-light">
                            <td colspan="8" class="text-end text-uppercase extra-small text-dark">Total Realized Revenue:</td>
                            <td class="text-end font-monospace text-dark">{!! $formatMoney($grossRevenue) !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="pt-3 border-top mb-4" style="border-color: #cbd5e1 !important;">
            <h6 class="fw-bold text-uppercase text-dark mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Executive Revenue Summary & Strategic Analysis</h6>
            <p class="text-secondary extra-small mb-2">
                During this period, SpeedLane AutoSpa generated a total realized gross revenue of <strong class="text-dark">{!! $formatMoney($grossRevenue) !!}</strong> across <strong class="text-dark">{{ number_format($totalJobsCount) }}</strong> completed and processed service sessions. The average ticket value per vehicle stood firmly at <strong class="text-dark">{!! $formatMoney($avgOrderValue) !!}</strong>.
            </p>
            <p class="text-secondary extra-small mb-0">
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

        <div class="p-2 px-3 mb-4 bg-light border-start border-3 border-dark text-secondary small rounded-1">
            <strong class="text-dark">Customer Intelligence:</strong> Client retention, visit logs, vehicle count, acquired services, and key account profiles overview.
        </div>

        <div class="mb-4">
            <h6 class="fw-bold text-uppercase text-dark mb-3 pb-1 border-bottom" style="font-size: 12px; border-color: #cbd5e1 !important;">
                1. Customer Loyalty & Profile Summary
            </h6>

            <p class="text-secondary mb-3">
                This evaluation analyzes client engagement and return frequency across SpeedLane AutoSpa services. Out of <strong class="text-dark">{{ number_format($uniqueCustomersCount) }} total unique clients</strong> recorded, <strong class="text-dark">{{ number_format($repeatCustomersCount) }} clients</strong> have returned for multiple service sessions, representing a customer retention rate of <strong class="text-dark">{{ $repeatRate }}%</strong>.
            </p>

            <div class="ps-3 border-start border-3 border-dark my-3 py-1">
                <div class="fw-bold text-dark mb-3 text-uppercase extra-small" style="letter-spacing: 0.5px;">Client Loyalty Breakdown & Key Account Profiles</div>

                @forelse($custGroups as $cName => $cJobs)
                    @php
                        $lastJob = $cJobs->sortByDesc('created_at')->first();
                        $visitCount = $cJobs->count();
                        $clientRevenue = $cJobs->sum('total_cost');
                        $cVehicles = $cJobs->map(fn($j) => $getVehicleDetails($j))->unique();
                        $vehicleCount = $cVehicles->count();
                        $cServices = $cJobs->flatMap(fn($j) => $parseServices($j))->unique()->values()->all();
                    @endphp
                    <div class="py-3 border-bottom" style="border-color: #e2e8f0 !important;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-dark" style="font-size: 13.5px;">{{ $cName }}</span>
                            <span class="extra-small fw-bold text-dark">
                                {{ $visitCount }} {{ \Illuminate\Support\Str::plural('Visit', $visitCount) }} &bull; {{ $vehicleCount }} {{ \Illuminate\Support\Str::plural('Vehicle', $vehicleCount) }} &bull; Cumulative Spend: {!! $formatMoney($clientRevenue) !!}
                            </span>
                        </div>
                        <div class="text-secondary extra-small" style="line-height: 1.6;">
                            <div class="mb-1">
                                <strong class="text-dark">Vehicles Serviced:</strong> <span class="text-dark">{{ $cVehicles->implode(' | ') }}</span>
                            </div>
                            <div class="mb-1">
                                <strong class="text-dark">Contact:</strong> <span class="text-dark me-3">{{ $getContactPhone($lastJob) }}</span>
                                <strong class="text-dark">Last Registered:</strong> <span class="text-dark">{{ $getDateRegistered($lastJob) }}</span>
                            </div>
                            <div>
                                <strong class="text-dark">Services Acquired:</strong> <span class="text-dark">{{ !empty($cServices) ? implode(', ', $cServices) : 'None' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-muted extra-small py-2">No client profiles available for the selected parameters.</div>
                @endforelse
            </div>
        </div>

        <div class="pt-3 border-top mb-4" style="border-color: #cbd5e1 !important;">
            <h6 class="fw-bold text-uppercase text-dark mb-2" style="font-size: 11px; letter-spacing: 0.5px;">2. Retention Insights & Executive Recommendations</h6>
            <ul class="text-secondary extra-small ps-3 mb-0" style="line-height: 1.6;">
                <li class="mb-1"><strong>Retention Efficiency:</strong> A retention rate of {{ $repeatRate }}% indicates strong organic client satisfaction. Repeat customers account for higher lifetime customer value (LTV) and significantly reduce acquisition costs.</li>
                <li class="mb-1"><strong>VIP Accounts:</strong> Clients with more than 2 visits represent the backbone of recurring revenue. Special loyalty benefits or routine service reminder notifications (SMS/Email) should be prioritized for this tier.</li>
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

        <div class="p-2 px-3 mb-4 bg-light border-start border-3 border-dark text-secondary small rounded-1">
            <strong class="text-dark">Service Demand Analysis:</strong> Overview of package preferences, demand ranking, and line item activity.
        </div>

        <div class="mb-4">
            <h6 class="fw-bold text-uppercase text-dark mb-3 pb-1 border-bottom" style="font-size: 12px; border-color: #cbd5e1 !important;">
                1. Service Demand Breakdown & Package Performance
            </h6>

            <p class="text-secondary mb-3">
                This analysis outlines client service preferences and operational volume across all offered packages. A total of <strong class="text-dark">{{ number_format($totalSvcRequests) }} individual service procedures</strong> were rendered across the evaluated time period.
            </p>

            <div class="ps-3 border-start border-3 border-dark my-3 py-1">
                <div class="fw-bold text-dark mb-2 text-uppercase extra-small" style="letter-spacing: 0.5px;">Service Popularity & Volume Ranking</div>

                @forelse($sortedServices as $sRow)
                    @php
                        $share = round(($sRow['count'] / $totalSvcRequests) * 100, 1);
                    @endphp
                    <div class="py-2 border-bottom border-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-dark" style="font-size: 13px;">{{ $sRow['name'] }}</span>
                            <span class="extra-small fw-semibold text-dark">
                                {{ number_format($sRow['count']) }} requests ({{ $share }}% total share)
                            </span>
                        </div>
                        <div class="text-muted extra-small">
                            Estimated Segment Contribution: <span class="text-dark fw-semibold">{!! $formatMoney($sRow['revenue']) !!}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-muted extra-small py-2">No service demand metrics logged.</div>
                @endforelse
            </div>
        </div>

        <div class="pt-3 border-top mb-4" style="border-color: #cbd5e1 !important;">
            <h6 class="fw-bold text-uppercase text-dark mb-2" style="font-size: 11px; letter-spacing: 0.5px;">2. Operational Planning & Service Portfolio Strategy</h6>
            <ul class="text-secondary extra-small ps-3 mb-0" style="line-height: 1.6;">
                <li class="mb-1"><strong>Core Revenue Drivers:</strong> The dominant service package is <strong class="text-dark">{{ $topService }}</strong>, capturing {{ $topServiceShare }}% of total job requests. Ensure bay consumables and assigned technicians are fully equipped for this package.</li>
                <li class="mb-1"><strong>Cross-Selling Opportunities:</strong> Secondary services showing growth should be bundled alongside high-volume washing or detailing tasks to boost ticket size.</li>
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

        <div class="p-2 px-3 mb-4 bg-light border-start border-3 border-dark text-secondary small rounded-1">
            <strong class="text-dark">Vehicle Demographics:</strong> Distribution breakdown by body class, manufacturer models, segment volume, and acquired services.
        </div>

        <div class="mb-4">
            <h6 class="fw-bold text-uppercase text-dark mb-3 pb-1 border-bottom" style="font-size: 12px; border-color: #cbd5e1 !important;">
                1. Vehicle Categorization & Demographics Analysis
            </h6>

            <p class="text-secondary mb-3">
                This evaluation examines the vehicle types, body classes, manufacturers, models, and year configurations serviced at SpeedLane AutoSpa. A cumulative total of <strong class="text-dark">{{ number_format($totalJobsCount) }} vehicle entries</strong> were processed across <strong class="text-dark">{{ $uniqueSegmentsCount }} unique vehicle configurations</strong>.
            </p>

            <div class="ps-3 border-start border-3 border-dark my-3 py-1">
                <div class="fw-bold text-dark mb-2 text-uppercase extra-small" style="letter-spacing: 0.5px;">Vehicle Class, Brand, Model & Year Distribution</div>

                @forelse($vehGroups as $vSegment => $vJobs)
                    @php
                        $vCount = $vJobs->count();
                        $vCompleted = $vJobs->where('status', 'Completed')->count();
                        $vShare = round(($vCount / max($totalJobsCount, 1)) * 100, 1);
                        $vRevenue = $vJobs->sum('total_cost');
                        $vServices = $vJobs->flatMap(fn($j) => $parseServices($j))->unique()->values()->all();
                    @endphp
                    <div class="py-2 border-bottom border-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-dark" style="font-size: 13px;">{{ $vSegment }}</span>
                            <span class="extra-small fw-semibold text-dark">
                                {{ $vCount }} Serviced ({{ $vShare }}% of fleet)
                            </span>
                        </div>
                        <div class="text-muted extra-small">
                            Status: <span class="text-dark">{{ $vCompleted }} Completed</span> | 
                            Realized Revenue: <span class="text-dark fw-semibold">{!! $formatMoney($vRevenue) !!}</span>
                        </div>
                        <div class="text-muted extra-small mt-1">
                            Services Acquired: <span class="text-dark fw-semibold">{{ !empty($vServices) ? implode(', ', $vServices) : 'None' }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-muted extra-small py-2">No vehicle segment records recorded.</div>
                @endforelse
            </div>
        </div>

        <div class="pt-3 border-top mb-4" style="border-color: #cbd5e1 !important;">
            <h6 class="fw-bold text-uppercase text-dark mb-2" style="font-size: 11px; letter-spacing: 0.5px;">2. Bay Allocation & Equipment Insights</h6>
            <ul class="text-secondary extra-small ps-3 mb-0" style="line-height: 1.6;">
                <li class="mb-1"><strong>Facility Sizing:</strong> <strong class="text-dark">{{ $dominantType }}</strong> vehicles make up the majority of shop entries. Service bay dimensions and lift equipment should remain optimized for standard and oversized body frames.</li>
                <li class="mb-1"><strong>Segment Pricing Strategy:</strong> Larger vehicle categories (SUVs, Crossovers, Pickups) require higher labor and material expenditure. Ensure tiered pricing reflects vehicle size accurately.</li>
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

        <div class="p-2 px-3 mb-4 bg-light border-start border-3 border-dark text-secondary small rounded-1">
            <strong class="text-dark">Technician Productivity:</strong> Staff workload balance, assigned job fulfillment, and performance tracking.
        </div>

        <div class="mb-4">
            <h6 class="fw-bold text-uppercase text-dark mb-3 pb-1 border-bottom" style="font-size: 12px; border-color: #cbd5e1 !important;">
                Technician Productivity & Workload Distribution
            </h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle small border-bottom mb-0">
                    <thead class="table-light text-uppercase extra-small text-muted">
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
                                <td class="fw-bold text-dark">{{ $techName }}</td>
                                <td class="text-center text-dark">{{ $assigned }}</td>
                                <td class="text-center fw-bold text-dark">{{ $completed }}</td>
                                <td class="text-center font-monospace text-dark">{{ $rate }}%</td>
                                <td class="text-end font-monospace fw-bold text-dark">{!! $formatMoney($techRev) !!}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">No technician records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pt-3 border-top mb-4" style="border-color: #cbd5e1 !important;">
            <h6 class="fw-bold text-uppercase text-dark mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Strategic Staffing & Throughput Assessment</h6>
            <ul class="text-secondary extra-small ps-3 mb-0" style="line-height: 1.6;">
                <li class="mb-1"><strong>Performance Output:</strong> Staff achieved an overall completion rate of {{ $avgCompletionRate }}% during this operational window.</li>
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

        <div class="p-2 px-3 mb-4 bg-light border-start border-3 border-dark text-secondary small rounded-1">
            <strong class="text-dark">Operational Queue & Service Audit Log:</strong> Daily activity feed, service details, bay assignments, and ticket turnaround records.
        </div>

        <div class="mb-4">
            <h6 class="fw-bold text-uppercase text-dark mb-3 pb-1 border-bottom" style="font-size: 12px; border-color: #cbd5e1 !important;">
                1. Operational Queue & Service Activity Feed
            </h6>

            <p class="text-secondary mb-3">
                This log details daily operational throughput, services performed, bay assignments, and mechanic fulfillment rates. A total of <strong class="text-dark">{{ number_format($totalJobsCount) }} work tickets</strong> were created during this operational window, achieving a turnaround fulfillment rate of <strong class="text-dark">{{ $completionRate }}%</strong>.
            </p>

            <div class="ps-3 border-start border-3 border-dark my-3 py-1">
                <div class="fw-bold text-dark mb-2 text-uppercase extra-small" style="letter-spacing: 0.5px;">Logged Activity & Service Audit Breakdown</div>

                @forelse($transactions as $trx)
                    @php 
                        $trxObj = is_array($trx) ? (object)$trx : $trx; 
                        $qServices = $parseServices($trx);
                    @endphp
                    <div class="py-2 border-bottom border-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="font-monospace fw-bold text-dark">{{ $trxObj->tracking_code }}</span>
                            <span class="fw-semibold text-dark extra-small">{{ $trxObj->status }}</span>
                        </div>
                        <div class="fw-semibold text-dark extra-small mt-1">
                            Client: {{ $getCustomerName($trx) }} | Vehicle: {{ $getVehicleDetails($trx) }} | Plate: {{ $trxObj->plate_number ?? 'N/A' }}
                        </div>
                        <div class="text-muted extra-small mt-1">
                            Services Rendered: <span class="text-dark fw-semibold">{{ !empty($qServices) ? implode(', ', $qServices) : 'N/A' }}</span>
                        </div>
                        <div class="text-muted extra-small">
                            Assigned Staff: <span class="text-dark fw-semibold">{{ $getMechanicName($trx) }}</span> | 
                            Registered: <span class="text-dark">{{ $getDateRegistered($trx) }}</span> | 
                            Completed: <span class="text-dark">{{ $getDateCompleted($trx) }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-muted extra-small py-2">No operational queue records found.</div>
                @endforelse
            </div>
        </div>

        <div class="pt-3 border-top mb-4" style="border-color: #cbd5e1 !important;">
            <h6 class="fw-bold text-uppercase text-dark mb-2" style="font-size: 11px; letter-spacing: 0.5px;">2. Operational Efficiency & Capacity Assessment</h6>
            <ul class="text-secondary extra-small ps-3 mb-0" style="line-height: 1.6;">
                <li class="mb-1"><strong>Turnaround Rate:</strong> With {{ $completedJobs }} out of {{ $totalJobsCount }} jobs completed ({{ $completionRate }}%), bay throughput is operating at standard capacity.</li>
                <li class="mb-1"><strong>Active Queue:</strong> Currently, {{ $inProgressJobs }} jobs remain in active/pending status. Staffing allocation should be balanced to clear open queues prior to peak arrival hours.</li>
                <li><strong>Technician Load Balancing:</strong> Ensure service assignments are distributed evenly among mechanics to minimize idle bay time and maintain consistent service quality.</li>
            </ul>
        </div>

    @endif

    <!-- Document Footer -->
    <div class="pt-3 border-top text-center text-muted extra-small" style="border-color: #e2e8f0 !important;">
        SpeedLane AutoSpa Operational Intelligence Document • Internal Business Management System
    </div>
</div>