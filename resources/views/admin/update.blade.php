<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SpeedLane - Update Service Status</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    
    <!-- Custom Admin External CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <style>
        .clickable-row {
            cursor: pointer;
            transition: background-color 0.15s ease-in-out;
        }
        .clickable-row:hover {
            background-color: #f8f9fa !important;
        }
        .extra-small {
            font-size: 0.75rem;
        }
        .badge-vehicle-num {
            background-color: #0d6efd;
            color: #fff;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
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
                    <span class="text-muted extra-small">Admin Overview</span>
                </div>
            </a>

            <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm px-3 rounded-3 d-flex align-items-center gap-1">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
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

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 p-4">
                
                <div class="mb-4">
                    <h2 class="fw-bold text-dark mb-1">Update Service Status</h2>
                    <p class="text-muted mb-0">Click any row to view complete itemized vehicle breakdown receipt.</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div id="alertContainer"></div>

                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold text-dark mb-4">Active Service Records</h5>

                    <div class="table-responsive">
                        <table class="table align-middle custom-admin-table mb-0">
                            <thead>
                                <tr>
                                    <th>Tracking Code</th>
                                    <th>Name</th>
                                    <th>Contact Number</th>
                                    <th>Vehicle (Brand/Model/Type/Year)</th>
                                    <th>Mechanic</th>
                                    <th>Plate Number</th>
                                    <th>Service Types</th>
                                    <th>Date Registered</th>
                                    <th>Status</th>
                                    <th class="text-end pe-3">Actions</th>
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

                                        $statusClass = match($service->status) {
                                            'Pending' => 'bg-warning text-dark',
                                            'Inspection' => 'bg-info text-white',
                                            'Repair In Progress' => 'bg-primary text-white',
                                            'Quality Check' => 'bg-info text-white',
                                            'Ready for Pickup' => 'bg-success text-white',
                                            'Completed' => 'bg-secondary text-white',
                                            default => 'bg-light text-dark'
                                        };

                                        $parseProp = function($prop) {
                                            if (is_string($prop)) {
                                                $decoded = json_decode($prop, true);
                                                return is_array($decoded) ? $decoded : [];
                                            }
                                            return is_array($prop) ? $prop : [];
                                        };

                                        $rootServices = $parseProp($service->selected_services);
                                        $rawPrices = $parseProp($service->selected_services_prices);

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

                                        $rootPricesMap = $normalizePricesMap($rootServices, $rawPrices);

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
                                                $vServices = $parseProp($v->selected_services);
                                                $vPricesRaw = $parseProp($v->selected_services_prices);
                                                $vPricesMap = $normalizePricesMap($vServices, $vPricesRaw);

                                                $formattedVehicles[] = [
                                                    'plate_number'           => $v->plate_number ?? 'N/A',
                                                    'vehicle_make'           => $v->vehicle_brand ?? $v->brand ?? $v->vehicle_make ?? '',
                                                    'vehicle_model'          => $v->vehicle_model ?? $v->model ?? '',
                                                    'vehicle_type'           => $v->vehicle_type ?? $v->type ?? '',
                                                    'vehicle_year'           => $v->vehicle_year ?? $v->year ?? '',
                                                    'mechanic_assigned'      => $v->mechanic_assigned ?? 'Unassigned',
                                                    'selected_services'      => $vServices,
                                                    'selected_services_prices' => $vPricesMap,
                                                    'price_adjustment_note'  => $v->price_adjustment_note ?? '',
                                                    'total_cost'             => $calcTotal($vServices, $vPricesMap, $v->total_cost ?? 0)
                                                ];
                                            }
                                        } else {
                                            $formattedVehicles[] = [
                                                'plate_number'           => $plates,
                                                'vehicle_make'           => $service->vehicle_make ?? '',
                                                'vehicle_model'          => $service->vehicle_model ?? '',
                                                'vehicle_type'           => $service->vehicle_type ?? '',
                                                'vehicle_year'           => $service->vehicle_year ?? '',
                                                'mechanic_assigned'      => $mechanics,
                                                'selected_services'      => $rootServices,
                                                'selected_services_prices' => $rootPricesMap,
                                                'price_adjustment_note'  => $service->price_adjustment_note ?? '',
                                                'total_cost'             => $calcTotal($rootServices, $rootPricesMap, $service->total_cost ?? 0)
                                            ];
                                        }

                                        $overallGrandTotal = $calcTotal($rootServices, $rootPricesMap, $service->total_cost ?? 0);
                                    @endphp

                                    <tr class="clickable-row" data-order-json="{{ json_encode([
                                        'id'                        => $service->id,
                                        'tracking_code'             => $service->tracking_code,
                                        'customer_name'             => $service->customer_name,
                                        'contact_number'            => $contactPhone,
                                        'vehicle_make'              => $service->vehicle_make ?? '',
                                        'vehicle_model'             => $service->vehicle_model ?? '',
                                        'vehicle_type'              => $service->vehicle_type ?? '',
                                        'vehicle_year'              => $service->vehicle_year ?? '',
                                        'plate_number'              => $plates,
                                        'mechanic_assigned'         => $mechanics,
                                        'selected_services'         => $rootServices,
                                        'selected_services_prices'  => $rootPricesMap,
                                        'price_adjustment_note'     => $service->price_adjustment_note ?? null,
                                        'total_cost'                => $overallGrandTotal,
                                        'vehicles'                  => $formattedVehicles
                                    ]) }}">
                                        <td class="fw-bold text-primary font-monospace">{{ $service->tracking_code }}</td>
                                        <td class="fw-medium text-dark">{{ $service->customer_name }}</td>
                                        <td class="text-secondary small font-monospace">{{ $contactPhone }}</td>
                                        <td class="fw-medium text-dark small">({{ $vehicleSummary }})</td>
                                        <td class="small">{{ $mechanics ?: 'Unassigned' }}</td>
                                        <td class="fw-semibold text-secondary font-monospace small">{{ $plates }}</td>
                                        <td class="small text-truncate" style="max-width: 150px;">
                                            @if(count($rootServices) > 0)
                                                {{ implode(', ', $rootServices) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="text-secondary small">
                                            {{ \Carbon\Carbon::parse($service->created_at)->format('M d, Y') }}
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill px-3 py-2 status-badge {{ $statusClass }}">
                                                {{ $service->status }}
                                            </span>
                                        </td>
                                        <td class="text-end action-cell">
                                            <div class="d-flex justify-content-end gap-1">
                                                <button class="btn btn-primary btn-sm rounded-3 px-3 py-1.5 fw-semibold" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#updateModal{{ $service->id }}">
                                                    <i class="bi bi-pencil-square me-1"></i> Update Status
                                                </button>
                                                <button class="btn btn-success btn-sm rounded-3 px-3 py-1.5 fw-semibold" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#addServiceModal{{ $service->id }}">
                                                    <i class="bi bi-plus-lg me-1"></i> Add Service
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Update Status Modal -->
                                    <div class="modal fade" id="updateModal{{ $service->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 rounded-4 shadow">
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title fw-bold text-dark">Update Service Status</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.update-status', $service->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body py-3">
                                                        <p class="text-muted small mb-3">Updating status for <strong>{{ $service->tracking_code }}</strong> (Plate: {{ $service->plate_number }})</p>
                                                        <div class="mb-3">
                                                            <label for="statusSelect{{ $service->id }}" class="form-label fw-semibold small">Service Status</label>
                                                            <select name="status" id="statusSelect{{ $service->id }}" class="form-select rounded-3">
                                                                @foreach(['Pending', 'Inspection', 'Repair In Progress', 'Quality Check', 'Ready for Pickup', 'Completed'] as $st)
                                                                    <option value="{{ $st }}" {{ $service->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0 pt-0">
                                                        <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary rounded-3 px-4 fw-semibold">Save Status</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Add Additional Service Modal -->
                                    <div class="modal fade" id="addServiceModal{{ $service->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 rounded-4 shadow">
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title fw-bold text-dark">Add Additional Service</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.add-additional', $service->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body py-3">
                                                        <p class="text-muted small mb-3">Adding service for vehicle <strong>{{ $service->plate_number }}</strong></p>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold small">Service Name</label>
                                                            <input type="text" name="new_service" class="form-control rounded-3" placeholder="e.g., Brake Fluid Replacement" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold small">Price</label>
                                                            <input type="number" step="0.01" min="0" name="price" class="form-control rounded-3" placeholder="0.00">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0 pt-0">
                                                        <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-success rounded-3 px-4 fw-semibold">Add Service</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-4 text-muted">No active service records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Dynamic Receipt Breakdown Modal -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-window-sidebar text-primary"></i> Service Breakdown Receipt
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" id="receiptModalBody">
                    <!-- Dynamic Receipt Content Generated via JavaScript -->
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const clickableRows = document.querySelectorAll('.clickable-row');
            const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
            const modalBody = document.getElementById('receiptModalBody');

            // Price Lookup Utility
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

            clickableRows.forEach(row => {
                row.addEventListener('click', function(e) {
                    if (e.target.closest('.action-cell') || e.target.closest('.btn')) {
                        return;
                    }

                    const dataRaw = this.getAttribute('data-order-json');
                    if (!dataRaw) return;

                    const data = JSON.parse(dataRaw);
                    
                    let html = `
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="text-muted small d-block mb-1">Tracking Code</span>
                                <span class="fs-5 fw-bold text-primary font-monospace">${data.tracking_code}</span>
                            </div>
                            <div class="text-end">
                                <span class="text-muted small d-block mb-1">Customer Name</span>
                                <span class="fw-bold text-dark d-block">${data.customer_name}</span>
                                <span class="text-muted small font-monospace">${data.contact_number}</span>
                            </div>
                        </div>
                        <hr class="my-3 text-muted opacity-25">
                    `;

                    if (data.vehicles && data.vehicles.length > 0) {
                        data.vehicles.forEach((v, idx) => {
                            const vehInfo = [v.vehicle_make, v.vehicle_model, v.vehicle_type, v.vehicle_year].filter(Boolean).join(' ');
                            
                            html += `
                                <div class="card border rounded-3 mb-4 p-3 bg-white shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="fw-bold text-dark mb-0">Vehicle #${idx + 1}: ${vehInfo || 'Vehicle Record'}</h6>
                                        <span class="badge bg-secondary font-monospace px-2 py-1">${v.plate_number}</span>
                                    </div>
                                    <div class="text-muted small mb-3">
                                        Assigned Mechanic: <strong class="text-dark">${v.mechanic_assigned || 'Unassigned'}</strong>
                                    </div>

                                    <table class="table table-sm table-borderless align-middle mb-3">
                                        <thead>
                                            <tr class="border-bottom text-secondary small">
                                                <th class="fw-semibold">Service</th>
                                                <th class="fw-semibold text-end">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;

                            if (v.selected_services && v.selected_services.length > 0) {
                                v.selected_services.forEach(srv => {
                                    const srvName = typeof srv === 'object' ? (srv.name || srv.service_name) : String(srv);
                                    const price = resolvePrice(srvName, v.selected_services_prices);

                                    html += `
                                        <tr>
                                            <td class="small text-dark py-1.5">${srvName}</td>
                                            <td class="small text-dark text-end font-monospace py-1.5">₱${price.toFixed(2)}</td>
                                        </tr>`;
                                });
                            } else {
                                html += `
                                    <tr><td colspan="2" class="small text-muted py-2">No services recorded</td></tr>`;
                            }

                            html += `
                                        </tbody>
                                    </table>`;

                            if (v.price_adjustment_note) {
                                html += `
                                    <div class="alert alert-warning py-2 px-3 small border-0 mb-3" style="background-color: #fff3cd; color: #856404;">
                                        <strong>Note:</strong> ${v.price_adjustment_note}
                                    </div>`;
                            } else {
                                html += `
                                    <div class="alert alert-warning py-2 px-3 small border-0 mb-3" style="background-color: #fff3cd; color: #856404;">
                                        <strong>Note:</strong> it vary depending on the vehicle's condition, size, or the amount of work required. total will cost are just estimated price
                                    </div>`;
                            }

                            html += `
                                    <div class="text-end fw-bold text-primary fs-6 border-top pt-2">
                                        Subtotal: ₱${parseFloat(v.total_cost || 0).toFixed(2)}
                                    </div>
                                </div>`;
                        });
                    }

                    html += `
                        <div class="p-3 rounded-3 d-flex justify-content-between align-items-center mb-1" style="background-color: #e8f1ff;">
                            <span class="fw-bold text-dark fs-5">Grand Total</span>
                            <span class="fs-3 fw-bold text-primary">₱${parseFloat(data.total_cost || 0).toFixed(2)}</span>
                        </div>
                    `;

                    modalBody.innerHTML = html;
                    receiptModal.show();
                });
            });
        });
    </script>
</body>
</html>