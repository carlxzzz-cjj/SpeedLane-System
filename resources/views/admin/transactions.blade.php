<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedLane - Transaction Records</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .stat-card { border-radius: 12px; border: 1px solid #e9ecef; }
        .stat-icon { width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body class="bg-light">

    <!-- Header Navigation -->
    <header class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 py-2 sticky-top shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('admin.dashboard') }}">
                <div class="bg-primary text-white p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="bi bi-car-front-fill fs-6"></i>
                </div>
                <div>
                    <span class="fw-bold text-primary fs-5 d-block lh-1">SpeedLane</span>
                    <span class="text-muted small">Admin Panel</span>
                </div>
            </a>

            <div class="d-flex align-items-center gap-3 ms-auto">
                @if(auth()->check() && auth()->user()->isSuperAdmin())
                    <span class="badge bg-light text-primary border border-primary px-3 py-2 rounded-pill">
                        <i class="bi bi-shield-check me-1"></i> Super Admin
                    </span>
                @else
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                        <i class="bi bi-person-badge text-primary me-1"></i> Admin
                    </span>
                @endif

                <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm px-3 rounded-3 d-flex align-items-center gap-1">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            
            <!-- Sidebar Navigation -->
            <aside class="col-md-3 col-lg-2 bg-white border-end min-vh-100 p-3">
                <nav class="nav flex-column gap-2">
                    <a class="nav-link text-dark rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                    <a class="nav-link text-dark rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.register-service') }}">
                        <i class="bi bi-plus-circle"></i> Register Service
                    </a>
                    <a class="nav-link text-dark rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.update') }}">
                        <i class="bi bi-arrow-repeat"></i> Update Service Status
                    </a>
                    <a class="nav-link active bg-primary text-white rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.transactions') }}">
                        <i class="bi bi-file-earmark-text"></i> Transaction Records
                    </a>

                    @if(auth()->check() && auth()->user()->isSuperAdmin())
                        <a class="nav-link text-dark rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.manage-services.index') }}">
                            <i class="bi bi-gear-fill"></i> Manage Services
                        </a>
                    @endif
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="col-md-9 col-lg-10 p-4">
                
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">Transaction Records</h2>
                        <p class="text-muted mb-0">View all completed service transactions, search records, and generate reports.</p>
                    </div>

                    <!-- Reports Action Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-primary rounded-3 px-3 py-2 fw-semibold d-flex align-items-center gap-2 dropdown-toggle shadow-sm" type="button" id="reportsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-file-earmark-bar-graph"></i> Generate Report
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-2" aria-labelledby="reportsDropdown">
                            <li>
                                <button class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#weeklyReportModal">
                                    <i class="bi bi-calendar-week text-primary"></i> Weekly Report
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#monthlyReportModal">
                                    <i class="bi bi-calendar-month text-success"></i> Monthly Report
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#yearlyReportModal">
                                    <i class="bi bi-calendar3 text-warning"></i> Yearly Report
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Stats Overview Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card stat-card p-3 bg-white shadow-sm d-flex flex-row justify-content-between align-items-center">
                            <div>
                                <span class="text-muted small d-block mb-1">Completed Transactions</span>
                                <h3 class="fw-bold text-dark mb-0">{{ $completedCount ?? $completedTransactions ?? $transactions->count() }}</h3>
                            </div>
                            <div class="stat-icon bg-primary-subtle text-primary fs-4">
                                <i class="bi bi-file-earmark-text-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card p-3 bg-white shadow-sm d-flex flex-row justify-content-between align-items-center">
                            <div>
                                <span class="text-muted small d-block mb-1">Status</span>
                                <h3 class="fw-bold text-success mb-0">All Completed</h3>
                            </div>
                            <div class="stat-icon bg-success-subtle text-success fs-4">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card p-3 bg-white shadow-sm d-flex flex-row justify-content-between align-items-center">
                            <div>
                                <span class="text-muted small d-block mb-1">Total Revenue</span>
                                <h3 class="fw-bold text-primary mb-0">₱{{ number_format($totalRevenue ?? $transactions->sum('total_cost') ?? 0, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter Bar Card -->
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-4">
                    <form method="GET" action="{{ route('admin.transactions') }}">
                        <div class="row g-2">
                            <!-- Search Input (Customer Name, Tracking Code, Vehicle) -->
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold text-muted mb-1">Search Keywords</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                                    <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Customer name, tracking code, vehicle model..." value="{{ request('search') }}">
                                </div>
                            </div>

                            <!-- Vehicle Type Filter -->
                            <div class="col-md-2">
                                <label class="form-label small fw-semibold text-muted mb-1">Vehicle Type</label>
                                <select name="vehicle_type" class="form-select form-select-sm bg-light">
                                    <option value="">All Vehicles</option>
                                    <option value="Sedan" {{ request('vehicle_type') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                                    <option value="SUV" {{ request('vehicle_type') == 'SUV' ? 'selected' : '' }}>SUV</option>
                                    <option value="Pickup / Truck" {{ request('vehicle_type') == 'Pickup / Truck' ? 'selected' : '' }}>Pickup / Truck</option>
                                    <option value="Van / MPV" {{ request('vehicle_type') == 'Van / MPV' ? 'selected' : '' }}>Van / MPV</option>
                                </select>
                            </div>

                            <!-- Service Type Filter -->
                            <div class="col-md-2">
                                <label class="form-label small fw-semibold text-muted mb-1">Service Type</label>
                                <select name="service_type" class="form-select form-select-sm bg-light">
                                    <option value="">All Services</option>
                                    @if(isset($availableServices))
                                        @foreach($availableServices as $srv)
                                            <option value="{{ $srv->name ?? $srv }}" {{ request('service_type') == ($srv->name ?? $srv) ? 'selected' : '' }}>
                                                {{ $srv->name ?? $srv }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <!-- Date Range Filter -->
                            <div class="col-md-2">
                                <label class="form-label small fw-semibold text-muted mb-1">Date</label>
                                <input type="date" name="date" class="form-control form-control-sm bg-light" value="{{ request('date') }}">
                            </div>

                            <!-- Filter & Reset Action Buttons -->
                            <div class="col-md-2 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary btn-sm rounded-3 w-100 fw-semibold">
                                    <i class="bi bi-funnel"></i> Search
                                </button>
                                <a href="{{ route('admin.transactions') }}" class="btn btn-outline-secondary btn-sm rounded-3 px-3" title="Reset Filters">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Completed Transactions Table Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-file-earmark-text text-primary"></i> Completed Transactions
                        </h5>
                        <span class="badge bg-light text-muted border px-3 py-2 rounded-pill small">
                            Showing {{ $transactions->count() }} record(s)
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle custom-admin-table mb-0">
                            <thead>
                                <tr class="text-secondary small border-bottom">
                                    <th>Tracking Code</th>
                                    <th>Customer Name</th>
                                    <th>Contact Number</th>
                                    <th>Vehicle (Brand/Model/Type/Year)</th>
                                    <th>Technician</th>
                                    <th>Plate Number</th>
                                    <th>Service Types</th>
                                    <th>Date Registered</th>
                                    <th>Date Completed</th>
                                    <th>Total Cost</th>
                                    <th class="text-center pe-3">Receipt</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $service)
                                    @php
                                        // Dynamic Contact Phone Resolution
                                        $contactPhone = $service->contact_number 
                                            ?? $service->phone_number 
                                            ?? $service->customer_phone 
                                            ?? $service->phone 
                                            ?? $service->contact 
                                            ?? 'N/A';

                                        // Dynamic Vehicle Resolution (Brand/Model/Type/Year)
                                        $vehiclesList = $service->vehicles ?? collect();

                                        $formatVeh = function($v) {
                                            $brand = $v->vehicle_brand ?? $v->brand ?? $v->vehicle_make ?? '';
                                            $model = $v->vehicle_model ?? $v->model ?? '';
                                            $brandModel = trim($brand . ' ' . $model);

                                            $type = $v->vehicle_type ?? $v->type ?? '';
                                            $year = $v->vehicle_year ?? $v->year ?? '';

                                            $parts = array_filter([$brandModel, $type, $year]);
                                            return count($parts) > 0 ? implode(' ', $parts) : 'N/A';
                                        };

                                        if ($vehiclesList->count() > 0) {
                                            $vehicleSummary = $formatVeh($vehiclesList->first());
                                            if ($vehiclesList->count() > 1) {
                                                $vehicleSummary .= ' (+ ' . ($vehiclesList->count() - 1) . ' more)';
                                            }
                                        } else {
                                            $vehicleSummary = $formatVeh($service);
                                        }

                                        $mechanics = $vehiclesList->count() > 0 
                                            ? $vehiclesList->pluck('mechanic_assigned')->filter()->unique()->implode(', ')
                                            : ($service->mechanic_assigned ?? 'Unassigned');

                                        $plates = $vehiclesList->count() > 0 
                                            ? $vehiclesList->pluck('plate_number')->filter()->implode(', ')
                                            : ($service->plate_number ?? 'N/A');

                                        // Dynamic service parsing
                                        $servicesArr = is_array($service->selected_services) 
                                            ? $service->selected_services 
                                            : json_decode($service->selected_services ?? '[]', true);

                                        if (!is_array($servicesArr)) {
                                            $servicesArr = array_filter(explode(', ', (string)$service->selected_services));
                                        }
                                    @endphp
                                    <tr>
                                        <!-- Tracking Code -->
                                        <td class="fw-bold font-monospace text-primary small">{{ $service->tracking_code }}</td>

                                        <!-- Customer Name -->
                                        <td class="fw-semibold text-dark">{{ $service->customer_name }}</td>

                                        <!-- Contact Number -->
                                        <td class="text-secondary small font-monospace">{{ $contactPhone }}</td>

                                        <!-- Vehicle (Brand/Model/Type/Year) -->
                                        <td class="fw-medium text-dark small">({{ $vehicleSummary }})</td>

                                        <!-- Technician -->
                                        <td class="small">{{ $mechanics ?: 'Unassigned' }}</td>

                                        <!-- Plate Number -->
                                        <td class="font-monospace text-uppercase small text-secondary">{{ $plates }}</td>

                                        <!-- Service Types -->
                                        <td class="small text-truncate" style="max-width: 200px;">
                                            @php
                                                $serviceNames = array_map(function($item) {
                                                    return is_array($item) ? ($item['name'] ?? '') : $item;
                                                }, $servicesArr ?? []);
                                                $serviceNames = array_filter($serviceNames);
                                            @endphp
                                            {{ count($serviceNames) > 0 ? implode(', ', $serviceNames) : 'N/A' }}
                                        </td>

                                        <!-- Date Registered -->
                                        <td class="small text-muted">
                                            {{ \Carbon\Carbon::parse($service->created_at)->format('M d, Y') }}
                                        </td>

                                        <!-- Date Completed -->
                                        <td class="small text-muted">
                                            {{ \Carbon\Carbon::parse($service->updated_at ?? $service->created_at)->format('M d, Y') }}
                                        </td>

                                        <!-- Total Cost -->
                                        <td class="fw-bold font-monospace text-dark">
                                            ₱{{ number_format((float)($service->total_cost ?? 0), 2) }}
                                        </td>

                                        <!-- Actions -->
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <button type="button" 
                                                        class="btn btn-outline-primary btn-sm rounded-2 px-2 py-1 d-flex align-items-center gap-1" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#viewModal{{ $service->id }}">
                                                    <i class="bi bi-eye"></i> View
                                                </button>
                                                <a href="{{ route('admin.transactions.pdf', $service->id) }}" 
                                                   class="btn btn-success btn-sm rounded-2 px-2 py-1 d-flex align-items-center gap-1">
                                                    <i class="bi bi-download"></i> PDF
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-5 text-muted">
                                            <i class="bi bi-inbox fs-2 text-secondary d-block mb-2"></i>
                                            No completed transactions found matching your search criteria.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- REPORT PREVIEW & DOWNLOAD MODALS -->

    <!-- 1. WEEKLY REPORT MODAL -->
    <div class="modal fade" id="weeklyReportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-calendar-week text-primary"></i> Weekly Transaction Report
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.transactions.reports.download') }}" method="GET" target="_blank">
                        <input type="hidden" name="type" value="weekly">
                        
                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Select Week / Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d', strtotime('monday this week')) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted">Report Summary Period</label>
                                <div class="p-2 bg-light border rounded-3 small fw-bold text-primary">
                                    Current Week Performance Overview
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light">
                                    <span class="text-muted small d-block">Weekly Jobs Completed</span>
                                    <strong class="fs-4 text-dark">{{ $weeklyCount ?? 0 }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light">
                                    <span class="text-muted small d-block">Weekly Total Revenue</span>
                                    <strong class="fs-4 text-success">₱{{ number_format($weeklyRevenue ?? 0, 2) }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info border-0 rounded-3 small mb-0">
                            <i class="bi bi-info-circle me-1"></i> Downloading will generate an official PDF containing the full list of transactions and revenue stats for the selected week.
                        </div>

                        <div class="modal-footer border-top mt-4 px-0 pb-0">
                            <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary rounded-3 px-4 fw-semibold d-flex align-items-center gap-1">
                                <i class="bi bi-file-earmark-pdf"></i> Download Weekly PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. MONTHLY REPORT MODAL -->
    <div class="modal fade" id="monthlyReportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-calendar-month text-success"></i> Monthly Transaction Report
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.transactions.reports.download') }}" method="GET" target="_blank">
                        <input type="hidden" name="type" value="monthly">
                        
                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Select Month & Year</label>
                                <input type="month" name="month_year" class="form-control" value="{{ date('Y-m') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted">Report Scope</label>
                                <div class="p-2 bg-light border rounded-3 small fw-bold text-success">
                                    Full Monthly Financial & Service Audit
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light">
                                    <span class="text-muted small d-block">Monthly Jobs Completed</span>
                                    <strong class="fs-4 text-dark">{{ $monthlyCount ?? 0 }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light">
                                    <span class="text-muted small d-block">Monthly Total Revenue</span>
                                    <strong class="fs-4 text-success">₱{{ number_format($monthlyRevenue ?? 0, 2) }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info border-0 rounded-3 small mb-0">
                            <i class="bi bi-info-circle me-1"></i> Generating this report provides a detailed overview of monthly revenue breakdown by technician and service type.
                        </div>

                        <div class="modal-footer border-top mt-4 px-0 pb-0">
                            <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success rounded-3 px-4 fw-semibold d-flex align-items-center gap-1">
                                <i class="bi bi-file-earmark-pdf"></i> Download Monthly PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. YEARLY REPORT MODAL -->
    <div class="modal fade" id="yearlyReportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-calendar3 text-warning"></i> Yearly Transaction Report
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.transactions.reports.download') }}" method="GET" target="_blank">
                        <input type="hidden" name="type" value="yearly">
                        
                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Select Year</label>
                                <select name="year" class="form-select" required>
                                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted">Report Scope</label>
                                <div class="p-2 bg-light border rounded-3 small fw-bold text-warning">
                                    Annual Service & Financial Summary
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light">
                                    <span class="text-muted small d-block">Yearly Jobs Completed</span>
                                    <strong class="fs-4 text-dark">{{ $yearlyCount ?? 0 }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light">
                                    <span class="text-muted small d-block">Yearly Total Revenue</span>
                                    <strong class="fs-4 text-success">₱{{ number_format($yearlyRevenue ?? 0, 2) }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info border-0 rounded-3 small mb-0">
                            <i class="bi bi-info-circle me-1"></i> The yearly report summarizes overall shop performance, annual gross income, and high-demand service metrics.
                        </div>

                        <div class="modal-footer border-top mt-4 px-0 pb-0">
                            <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning rounded-3 px-4 fw-semibold text-dark d-flex align-items-center gap-1">
                                <i class="bi bi-file-earmark-pdf"></i> Download Yearly PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- INDIVIDUAL TRANSACTION RECEIPT MODALS -->
    @foreach($transactions as $service)
        @php
            $contactPhone = $service->contact_number 
                ?? $service->phone_number 
                ?? $service->customer_phone 
                ?? $service->phone 
                ?? $service->contact 
                ?? 'N/A';

            $vehiclesList = $service->vehicles ?? collect();

            $formatVeh = function($v) {
                $brand = $v->vehicle_brand ?? $v->brand ?? $v->vehicle_make ?? '';
                $model = $v->vehicle_model ?? $v->model ?? '';
                $brandModel = trim($brand . ' ' . $model);

                $type = $v->vehicle_type ?? $v->type ?? '';
                $year = $v->vehicle_year ?? $v->year ?? '';

                $parts = array_filter([$brandModel, $type, $year]);
                return count($parts) > 0 ? implode(' ', $parts) : 'N/A';
            };

            if ($vehiclesList->count() > 0) {
                $vehicleSummary = $formatVeh($vehiclesList->first());
                if ($vehiclesList->count() > 1) {
                    $vehicleSummary .= ' (+ ' . ($vehiclesList->count() - 1) . ' more)';
                }
            } else {
                $vehicleSummary = $formatVeh($service);
            }

            $mechanics = $vehiclesList->count() > 0 
                ? $vehiclesList->pluck('mechanic_assigned')->filter()->unique()->implode(', ')
                : ($service->mechanic_assigned ?? 'Unassigned');

            $plates = $vehiclesList->count() > 0 
                ? $vehiclesList->pluck('plate_number')->filter()->implode(', ')
                : ($service->plate_number ?? 'N/A');

            $servicesArr = is_array($service->selected_services) 
                ? $service->selected_services 
                : json_decode($service->selected_services ?? '[]', true);

            if (!is_array($servicesArr)) {
                $servicesArr = array_filter(explode(', ', (string)$service->selected_services));
            }

            $pricesMap = is_array($service->selected_services_prices) 
                ? $service->selected_services_prices 
                : json_decode($service->selected_services_prices ?? '[]', true);
            
            if (!is_array($pricesMap)) { $pricesMap = []; }
        @endphp

        <div class="modal fade" id="viewModal{{ $service->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $service->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 rounded-4 shadow">
                    <div class="modal-header border-bottom">
                        <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2" id="viewModalLabel{{ $service->id }}">
                            <i class="bi bi-receipt text-primary"></i> Receipt Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        
                        <div class="row mb-3 bg-light p-3 rounded-3 border g-2">
                            <div class="col-md-6">
                                <span class="text-muted small d-block">Tracking Code</span>
                                <span class="fs-5 fw-bold text-primary font-monospace">{{ $service->tracking_code }}</span>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <span class="text-muted small d-block">Date Registered</span>
                                <strong class="text-dark">{{ \Carbon\Carbon::parse($service->created_at)->format('M d, Y') }}</strong>
                            </div>
                            <div class="col-md-6 border-top pt-2">
                                <span class="text-muted small d-block">Customer Name</span>
                                <strong class="text-dark">{{ $service->customer_name }}</strong>
                                <span class="d-block text-secondary small font-monospace">{{ $contactPhone }}</span>
                            </div>
                            <div class="col-md-6 text-md-end border-top pt-2">
                                <span class="text-muted small d-block">Date Completed</span>
                                <strong class="text-dark">{{ \Carbon\Carbon::parse($service->updated_at)->format('M d, Y') }}</strong>
                            </div>
                            <div class="col-md-12 border-top pt-2">
                                <span class="text-muted small d-block">Vehicle Info & Plate Number</span>
                                <strong class="text-dark">({{ $vehicleSummary }})</strong>
                                <span class="d-block font-monospace text-uppercase text-secondary small">Plate: {{ $plates }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <span class="text-muted small d-block mb-1">Assigned Mechanic: <strong>{{ $mechanics ?: 'Unassigned' }}</strong></span>
                        </div>

                        <table class="table table-sm border align-middle mb-3">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-2 px-3">Service Name</th>
                                    <th class="py-2 px-3 text-end">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($servicesArr as $idx => $srv)
                                    @php
                                        $srvName = is_array($srv) ? ($srv['name'] ?? $srv['service_name'] ?? '') : (string)$srv;
                                        $srvTrim = trim($srvName);

                                        $itemPrice = $pricesMap[$srvTrim] 
                                            ?? $pricesMap[$srvName] 
                                            ?? $pricesMap[$idx] 
                                            ?? 0;
                                    @endphp
                                    <tr>
                                        <td class="py-2 px-3 text-dark small">{{ $srvName }}</td>
                                        <td class="py-2 px-3 text-end font-monospace text-success fw-semibold small">
                                            ₱{{ number_format((float)$itemPrice, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-2 text-muted small">No individual services listed.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="fw-bold text-dark fs-5">Total Estimated Cost:</span>
                            <span class="fw-bold text-success fs-4 font-monospace">₱{{ number_format((float)($service->total_cost ?? 0), 2) }}</span>
                        </div>

                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal">Close</button>
                        <a href="{{ route('admin.transactions.pdf', $service->id) }}" class="btn btn-success rounded-3 px-4 d-flex align-items-center gap-1">
                            <i class="bi bi-download"></i> Download PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>