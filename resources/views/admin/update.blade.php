<!-- ========================================================================= -->
<!-- FILE LOCATION: resources/views/admin/update.blade.php                      -->
<!-- ========================================================================= -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SpeedLane - Service Progress Updates</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="bg-light">

   <!-- Top Navigation Header -->
<header class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 py-2 sticky-top shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('admin.dashboard') }}">
            <div class="bg-primary text-white p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="bi bi-car-front-fill fs-6"></i>
            </div>
            <div>
                <span class="fw-bold text-primary fs-5 d-block lh-1">SpeedLane</span>
                <span class="text-muted fs-7">Admin Panel</span>
            </div>
        </a>

        <!-- Right Nav Alignment -->
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
                    <a class="nav-link admin-nav-link text-dark rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                    <a class="nav-link admin-nav-link text-dark rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.register-service') }}">
                        <i class="bi bi-plus-circle"></i> Register Service
                    </a>
                    <a class="nav-link admin-nav-link active rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.update') }}">
                        <i class="bi bi-arrow-repeat"></i> Update Service Status
                    </a>
                    <a class="nav-link admin-nav-link text-dark rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.transactions') }}">
                        <i class="bi bi-file-earmark-text"></i> Transaction Records
                    </a>

                    @if(auth()->check() && auth()->user()->isSuperAdmin())
                        <a class="nav-link admin-nav-link text-dark rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.manage-services.index') }}">
                            <i class="bi bi-gear-fill"></i> Manage Services
                        </a>
                    @endif
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="col-md-9 col-lg-10 p-4">
                
                <!-- Page Title Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="fw-bold text-dark mb-1">Update Service Status</h3>
                        <p class="text-muted mb-0">Track active customer services, edit stage progress, and archive completed services.</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Search and Filter Bar Card (Matching Transactions Blade) -->
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-4">
                    <form method="GET" action="{{ route('admin.update') }}">
                        <div class="row g-2">
                            <!-- Search Input (Customer Name, Tracking Code, Vehicle) -->
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold text-muted mb-1">Search Keywords</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                                    <input type="text" name="search" id="serviceSearchInput" class="form-control bg-light border-start-0" placeholder="Customer name, tracking code, plate..." value="{{ request('search') }}">
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

                            <!-- Date Filter -->
                            <div class="col-md-2">
                                <label class="form-label small fw-semibold text-muted mb-1">Date</label>
                                <input type="date" name="date" class="form-control form-control-sm bg-light" value="{{ request('date') }}">
                            </div>

                            <!-- Filter & Reset Action Buttons -->
                            <div class="col-md-2 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary btn-sm rounded-3 w-100 fw-semibold">
                                    <i class="bi bi-funnel"></i> Search
                                </button>
                                <a href="{{ route('admin.update') }}" class="btn btn-outline-secondary btn-sm rounded-3 px-3" title="Reset Filters">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Main Service Table Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <div class="table-responsive">
                        <table class="table align-middle custom-admin-table mb-0" id="servicesTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Tracking Code</th>
                                    <th>Customer Name</th>
                                    <th>Contact</th>
                                    <th>Vehicle Summary</th>
                                    <th>Plate Number</th>
                                    <th>Mechanic</th>
                                    <th>Date Registered</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($services as $service)
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
                                                $vehicleSummary .= ' (+' . ($vehiclesList->count() - 1) . ' more)';
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

                                        $parseProp = function($prop) {
                                            if (is_string($prop)) {
                                                $decoded = json_decode($prop, true);
                                                return is_array($decoded) ? $decoded : [];
                                            }
                                            return is_array($prop) ? $prop : [];
                                        };

                                        $rawSelectedServices = $parseProp($service->selected_services);
                                        $rawPrices = $parseProp($service->selected_services_prices);

                                        $normalizeServiceItems = function($servicesArr) {
                                            $items = [];
                                            foreach ($servicesArr as $srv) {
                                                if (is_array($srv)) {
                                                    $items[] = [
                                                        'name'   => $srv['name'] ?? $srv['service_name'] ?? 'Service',
                                                        'status' => $srv['status'] ?? 'Pending Queue',
                                                        'note'   => $srv['note'] ?? $srv['status_note'] ?? ''
                                                    ];
                                                } else {
                                                    $items[] = [
                                                        'name'   => (string)$srv,
                                                        'status' => 'Pending Queue',
                                                        'note'   => ''
                                                    ];
                                                }
                                            }
                                            return $items;
                                        };

                                        $normalizePricesMap = function($servicesArr, $pricesArr) {
                                            if (empty($servicesArr)) return (object)[];
                                            if (!is_array($pricesArr)) return (object)[];
                                            if (count($pricesArr) > 0 && array_keys($pricesArr) !== range(0, count($pricesArr) - 1)) {
                                                return $pricesArr;
                                            }
                                            $mapped = [];
                                            foreach ($servicesArr as $idx => $srv) {
                                                $name = is_array($srv) ? ($srv['name'] ?? $srv['service_name'] ?? '') : (string)$srv;
                                                if ($name !== '') {
                                                    $mapped[trim($name)] = floatval($pricesArr[$idx] ?? 0);
                                                }
                                            }
                                            return $mapped;
                                        };

                                        $calcTotal = function($servicesArr, $pricesMap, $dbTotal) {
                                            if (floatval($dbTotal) > 0) return floatval($dbTotal);
                                            $sum = 0;
                                            foreach ($servicesArr as $srv) {
                                                $name = is_array($srv) ? ($srv['name'] ?? $srv['service_name'] ?? '') : (string)$srv;
                                                $sum += floatval($pricesMap[trim($name)] ?? 0);
                                            }
                                            return $sum;
                                        };

                                        $formattedVehicles = [];
                                        if ($vehiclesList->count() > 0) {
                                            foreach ($vehiclesList as $v) {
                                                $vRawServices = $parseProp($v->selected_services);
                                                $vServiceItems = $normalizeServiceItems($vRawServices);
                                                $vPricesRaw = $parseProp($v->selected_services_prices);
                                                $vPricesMap = $normalizePricesMap($vRawServices, $vPricesRaw);

                                                $formattedVehicles[] = [
                                                    'plate_number'           => $v->plate_number ?? 'N/A',
                                                    'vehicle_make'           => $v->vehicle_brand ?? $v->brand ?? $v->vehicle_make ?? '',
                                                    'vehicle_model'          => $v->vehicle_model ?? $v->model ?? '',
                                                    'vehicle_type'           => $v->vehicle_type ?? $v->type ?? '',
                                                    'vehicle_year'           => $v->vehicle_year ?? $v->year ?? '',
                                                    'mechanic_assigned'      => $v->mechanic_assigned ?? 'Unassigned',
                                                    'service_items'          => $vServiceItems,
                                                    'selected_services_prices' => $vPricesMap,
                                                    'price_adjustment_note'  => $v->price_adjustment_note ?? '',
                                                    'total_cost'             => $calcTotal($vRawServices, $vPricesMap, $v->total_cost ?? 0)
                                                ];
                                            }
                                        } else {
                                            $rootPricesMap = $normalizePricesMap($rawSelectedServices, $rawPrices);
                                            $formattedVehicles[] = [
                                                'plate_number'           => $plates,
                                                'vehicle_make'           => $service->vehicle_make ?? '',
                                                'vehicle_model'          => $service->vehicle_model ?? '',
                                                'vehicle_type'           => $service->vehicle_type ?? '',
                                                'vehicle_year'           => $service->vehicle_year ?? '',
                                                'mechanic_assigned'      => $mechanics,
                                                'service_items'          => $normalizeServiceItems($rawSelectedServices),
                                                'selected_services_prices' => $rootPricesMap,
                                                'price_adjustment_note'  => $service->price_adjustment_note ?? '',
                                                'total_cost'             => $calcTotal($rawSelectedServices, $rootPricesMap, $service->total_cost ?? 0)
                                            ];
                                        }

                                        $overallGrandTotal = $calcTotal($rawSelectedServices, $normalizePricesMap($rawSelectedServices, $rawPrices), $service->total_cost ?? 0);
                                        $formattedDate = \Carbon\Carbon::parse($service->created_at)->format('M d, Y h:i A');

                                        // Calculate Overall Simplified Status Badge for UI
                                        $allStatuses = [];
                                        foreach ($formattedVehicles as $vData) {
                                            foreach ($vData['service_items'] as $sItem) {
                                                $allStatuses[] = strtolower($sItem['status']);
                                            }
                                        }

                                        $isAllPending = !empty($allStatuses) && array_reduce($allStatuses, function($carry, $item) {
                                            return $carry && (str_contains($item, 'pending') || str_contains($item, 'queue'));
                                        }, true);

                                        $isAllCompleted = !empty($allStatuses) && array_reduce($allStatuses, function($carry, $item) {
                                            return $carry && (str_contains($item, 'completed') || str_contains($item, 'ready'));
                                        }, true);

                                        if ($isAllPending) {
                                            $statusLabel = 'Queued';
                                            $statusBadgeClass = 'bg-warning text-dark';
                                        } elseif ($isAllCompleted) {
                                            $statusLabel = 'Completed';
                                            $statusBadgeClass = 'bg-success text-white';
                                        } else {
                                            $statusLabel = 'In Progress';
                                            $statusBadgeClass = 'bg-primary text-white';
                                        }
                                    @endphp

                                    <tr data-order-json="{{ json_encode([
                                        'id'                => $service->id,
                                        'tracking_code'     => $service->tracking_code,
                                        'customer_name'     => $service->customer_name,
                                        'contact_number'    => $contactPhone,
                                        'date_registered'   => $formattedDate,
                                        'plate_number'      => $plates,
                                        'mechanic_assigned' => $mechanics,
                                        'total_cost'        => $overallGrandTotal,
                                        'vehicles'          => $formattedVehicles
                                    ]) }}">
                                        <td class="fw-bold text-primary">{{ $service->tracking_code }}</td>
                                        <td class="fw-semibold text-dark">{{ $service->customer_name }}</td>
                                        <td>{{ $contactPhone }}</td>
                                        <td>{{ $vehicleSummary }}</td>
                                        <td><span class="badge bg-light text-dark border">{{ $plates }}</span></td>
                                        <td>{{ $mechanics ?: 'Unassigned' }}</td>
                                        <td>
                                            <div>{{ \Carbon\Carbon::parse($service->created_at)->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($service->created_at)->format('h:i A') }}</small>
                                        </td>

                                        <!-- Clean Simplified Overall Status Display -->
                                        <td>
                                            <span class="badge {{ $statusBadgeClass }} px-2 py-1 fs-7">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>

                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-1">
                                                <!-- View Details Action Button -->
                                                <button class="btn btn-outline-primary btn-sm px-2 open-info-btn" title="View Full Record Info">
                                                    <i class="bi bi-eye-fill"></i> View Info
                                                </button>

                                                <!-- Update Status Action Button -->
                                                <button class="btn btn-primary btn-sm px-2" data-bs-toggle="modal" data-bs-target="#updateModal{{ $service->id }}" title="Update Progress">
                                                    <i class="bi bi-pencil-square"></i> Update
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal: Update Service Progress Stages & Complete Transaction -->
                                    <div class="modal fade" id="updateModal{{ $service->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title fw-bold">
                                                        <i class="bi bi-arrow-repeat me-2"></i>Update Progress: {{ $service->tracking_code }}
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.update-status', $service->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body p-4">
                                                        
                                                        <div class="alert alert-info py-2 px-3 small rounded-3 mb-3 d-flex align-items-center gap-2">
                                                            <i class="bi bi-info-circle-fill fs-5"></i>
                                                            <span>Customer: <strong>{{ $service->customer_name }}</strong> | Tracking Code: <strong>{{ $service->tracking_code }}</strong></span>
                                                        </div>

                                                        @foreach($formattedVehicles as $vIdx => $vData)
                                                            <div class="border rounded-3 p-3 mb-3 bg-light">
                                                                <div class="fw-bold text-dark mb-2 d-flex justify-content-between align-items-center">
                                                                    <span><i class="bi bi-car-front text-primary me-1"></i> Vehicle: {{ implode(' ', array_filter([$vData['vehicle_make'], $vData['vehicle_model']])) }}</span>
                                                                    <span class="badge bg-dark">{{ $vData['plate_number'] }}</span>
                                                                </div>

                                                                @foreach($vData['service_items'] as $sIdx => $item)
                                                                    @php
                                                                        $sName = $item['name'];
                                                                        $lowerName = strtolower($sName);

                                                                        if (str_contains($lowerName, 'coating') || str_contains($lowerName, 'ceramic') || str_contains($lowerName, 'graphene')) {
                                                                            $stages = [
                                                                                'Pending Queue',
                                                                                'Decontamination & Wash Prep',
                                                                                'Paint Correction & Polishing',
                                                                                'Coating Layer Application',
                                                                                'Curing Process',
                                                                                'Final Inspection',
                                                                                'Completed & Ready for Pickup'
                                                                            ];
                                                                        } elseif (str_contains($lowerName, 'detail') || str_contains($lowerName, 'interior') || str_contains($lowerName, 'exterior')) {
                                                                            $stages = [
                                                                                'Pending Queue',
                                                                                'Exterior Wash & Clay Bar',
                                                                                'Interior Vacuum & Steam Clean',
                                                                                'Leather & Plastic Conditioning',
                                                                                'Exterior Machine Polish',
                                                                                'Final Inspection',
                                                                                'Completed & Ready for Pickup'
                                                                            ];
                                                                        } else {
                                                                            $stages = [
                                                                                'Pending Queue',
                                                                                'Under Inspection & Diagnostics',
                                                                                'Awaiting Parts / Approval',
                                                                                'Repair In Progress',
                                                                                'Quality Testing',
                                                                                'Completed & Ready for Pickup'
                                                                            ];
                                                                        }
                                                                    @endphp

                                                                    <div class="card p-3 mb-2 bg-white border-0 shadow-sm rounded-3">
                                                                        <div class="fw-bold text-dark mb-2">{{ $sName }}</div>

                                                                        <input type="hidden" name="services[{{ $vIdx }}][{{ $sIdx }}][name]" value="{{ $sName }}">

                                                                        <div class="mb-2">
                                                                            <label class="form-label small text-muted mb-1">Status Stage <span class="text-danger">*</span></label>
                                                                            <select name="services[{{ $vIdx }}][{{ $sIdx }}][status]" class="form-select form-select-sm status-stage-select" required>
                                                                                @foreach($stages as $st)
                                                                                    <option value="{{ $st }}" {{ $item['status'] === $st ? 'selected' : '' }}>
                                                                                        {{ $st }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div>
                                                                            <label class="form-label small text-muted mb-1">Progress Note / Remarks</label>
                                                                            <textarea name="services[{{ $vIdx }}][{{ $sIdx }}][note]" class="form-control form-control-sm" rows="2" placeholder="Enter findings, updates, or notes...">{{ $item['note'] }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endforeach

                                                        <!-- Transaction Completion Control Switch -->
                                                        <div class="border border-success bg-success bg-opacity-10 p-3 rounded-3 mt-3">
                                                            <div class="form-check form-switch m-0">
                                                                <input class="form-check-input complete-switch-input" type="checkbox" name="mark_as_completed" id="markCompleted{{ $service->id }}" value="1">
                                                                <label class="form-check-label fw-bold text-success" for="markCompleted{{ $service->id }}">
                                                                    <i class="bi bi-check-circle-fill me-1"></i> Mark entire service as Fully Completed & Move to Transaction Records
                                                                </label>
                                                            </div>
                                                            <small class="text-muted d-block mt-1">
                                                                Checking this option moves this active job to <strong>Transaction Records</strong> so it no longer clutters your active view.
                                                            </small>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">
                                                            <i class="bi bi-check2-circle me-1"></i> Save Changes
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5 text-muted">
                                            <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                            No active service records found in queue.
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

    <!-- Modal: View Detailed Service Information (Notes and individual service breakdown render exclusively here) -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-info-circle text-primary me-2"></i>Service Record Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" id="receiptModalBody">
                    <!-- Dynamic details populated via JavaScript -->
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
            const modalBody = document.getElementById('receiptModalBody');

            // 1. Live Table Search Filter
            const searchInput = document.getElementById('serviceSearchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const filter = this.value.toLowerCase().trim();
                    const rows = document.querySelectorAll('#servicesTable tbody tr');
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(filter) ? '' : 'none';
                    });
                });
            }

            // 2. Auto-check "Move to Transaction Records" switch when "Completed & Ready for Pickup" is selected
            document.querySelectorAll('.modal').forEach(modal => {
                const stageSelects = modal.querySelectorAll('.status-stage-select');
                const completeSwitch = modal.querySelector('.complete-switch-input');

                if (stageSelects.length > 0 && completeSwitch) {
                    stageSelects.forEach(select => {
                        select.addEventListener('change', function() {
                            let allCompleted = true;
                            stageSelects.forEach(s => {
                                if (!s.value.includes('Completed') && !s.value.includes('Ready for Pickup')) {
                                    allCompleted = false;
                                }
                            });
                            if (allCompleted) {
                                completeSwitch.checked = true;
                            }
                        });
                    });
                }
            });

            // 3. Resolve price mappings
            function resolvePrice(srvName, pricesObj) {
                if (!pricesObj || typeof pricesObj !== 'object') return 0;
                const cleanName = String(srvName).trim();
                const baseName = cleanName.replace(/\s*\(.*\)$/, '').trim();

                if (pricesObj[cleanName] !== undefined && pricesObj[cleanName] !== null) {
                    return parseFloat(pricesObj[cleanName]);
                }
                if (pricesObj[baseName] !== undefined && pricesObj[baseName] !== null) {
                    return parseFloat(pricesObj[baseName]);
                }

                const lowerClean = cleanName.toLowerCase();
                const lowerBase = baseName.toLowerCase();
                for (const key in pricesObj) {
                    const lowerKey = String(key).toLowerCase().trim();
                    if (lowerKey === lowerClean || lowerKey === lowerBase) {
                        return parseFloat(pricesObj[key]);
                    }
                }
                return 0;
            }

            // 4. Stage badge styling helper
            function getBadgeStyle(stage) {
                const s = String(stage).toLowerCase();
                if (s.includes('pending') || s.includes('queue')) return 'bg-warning text-dark';
                if (s.includes('curing') || s.includes('parts') || s.includes('waiting')) return 'bg-secondary text-white';
                if (s.includes('inspection') || s.includes('decontamination') || s.includes('diagnostics')) return 'bg-info text-white';
                if (s.includes('progress') || s.includes('application') || s.includes('repair') || s.includes('clean')) return 'bg-primary text-white';
                if (s.includes('ready') || s.includes('completed') || s.includes('finished')) return 'bg-success text-white';
                return 'bg-dark text-white';
            }

            // 5. Open Info Modal with structured breakdown and notes
            function openModalWithData(rowElement) {
                const dataRaw = rowElement.getAttribute('data-order-json');
                if (!dataRaw) return;

                const data = JSON.parse(dataRaw);

                let html = `
                    <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                        <div class="col-md-6">
                            <span class="text-muted small d-block">TRACKING CODE</span>
                            <span class="fw-bold text-primary fs-5">${data.tracking_code}</span>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <span class="text-muted small d-block">DATE REGISTERED</span>
                            <span class="fw-semibold text-dark">${data.date_registered || 'N/A'}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted small d-block">CUSTOMER NAME</span>
                            <span class="fw-semibold text-dark">${data.customer_name}</span>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <span class="text-muted small d-block">CONTACT NUMBER</span>
                            <span class="fw-semibold text-dark">${data.contact_number}</span>
                        </div>
                    </div>

                    <h6 class="fw-bold border-bottom pb-2 mb-3">
                        <i class="bi bi-list-check me-1 text-primary"></i> Service Breakdown & Progress Details
                    </h6>
                `;

                if (data.vehicles && data.vehicles.length > 0) {
                    data.vehicles.forEach((v, idx) => {
                        const vehInfo = [v.vehicle_make, v.vehicle_model, v.vehicle_type, v.vehicle_year].filter(Boolean).join(' ');

                        html += `
                            <div class="card p-3 mb-3 border bg-light shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold mb-0 text-dark">Vehicle #${idx + 1}: ${vehInfo || 'Vehicle Information'}</h6>
                                    <span class="badge bg-dark">${v.plate_number}</span>
                                </div>
                                <div class="text-muted small mb-3">
                                    Assigned Mechanic: <strong class="text-dark">${v.mechanic_assigned || 'Unassigned'}</strong>
                                </div>

                                <table class="table table-sm bg-white border align-middle mb-2 rounded">
                                    <thead>
                                        <tr class="table-light">
                                            <th>Service Name</th>
                                            <th>Current Stage</th>
                                            <th>Progress Note / Findings</th>
                                            <th class="text-end">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

                        if (v.service_items && v.service_items.length > 0) {
                            v.service_items.forEach(srvItem => {
                                const srvName = srvItem.name;
                                const price = resolvePrice(srvName, v.selected_services_prices);
                                const badgeClass = getBadgeStyle(srvItem.status);

                                html += `
                                    <tr>
                                        <td class="fw-semibold">${srvName}</td>
                                        <td>
                                            <span class="badge ${badgeClass}">${srvItem.status || 'Pending Queue'}</span>
                                        </td>
                                        <td class="small text-dark">
                                            ${srvItem.note ? `<i class="bi bi-card-text text-primary me-1"></i>${srvItem.note}` : '<em class="text-muted">No progress notes recorded</em>'}
                                        </td>
                                        <td class="text-end fw-semibold">₱${price.toFixed(2)}</td>
                                    </tr>`;
                            });
                        } else {
                            html += `<tr><td colspan="4" class="text-center text-muted py-2">No services recorded</td></tr>`;
                        }

                        html += `
                                    </tbody>
                                </table>`;

                        if (v.price_adjustment_note) {
                            html += `
                                <div class="alert alert-warning py-1 px-2 small mb-2">
                                    <strong>Note:</strong> ${v.price_adjustment_note}
                                </div>`;
                        }

                        html += `
                                <div class="text-end fw-bold text-primary">
                                    Subtotal: ₱${parseFloat(v.total_cost || 0).toFixed(2)}
                                </div>
                            </div>`;
                    });
                }

                html += `
                    <div class="d-flex justify-content-between align-items-center p-3 bg-white border rounded-3 mt-3 shadow-sm">
                        <span class="fw-bold fs-5">Total Estimated Cost:</span>
                        <span class="fw-bold fs-4 text-primary">₱${parseFloat(data.total_cost || 0).toFixed(2)}</span>
                    </div>
                `;

                modalBody.innerHTML = html;
                receiptModal.show();
            }

            document.querySelectorAll('.open-info-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const row = this.closest('tr');
                    openModalWithData(row);
                });
            });
        });
    </script>
</body>
</html>