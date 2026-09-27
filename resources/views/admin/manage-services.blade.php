<!-- ========================================================================= -->
<!-- FILE LOCATION: resources/views/admin/manage-service.blade.php            -->
<!-- ========================================================================= -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedLane - Manage Services & Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .service-card {
            transition: all 0.2s ease-in-out;
        }
        .service-option-card {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            transition: border-color 0.15s ease-in-out, background-color 0.15s ease-in-out;
        }
        .service-option-card:hover {
            background-color: #ffffff;
            border-color: #0d6efd;
            box-shadow: 0 0.125rem 0.25rem rgba(13, 110, 253, 0.08);
        }
        .extra-small {
            font-size: 11px;
        }
        .letter-spacing-otp {
            letter-spacing: 0.5rem;
        }
    </style>
</head>
<body class="bg-light">

    <!-- TOP NAVIGATION HEADER BAR -->
    <header class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 py-2 sticky-top shadow-sm">
        <div class="container-fluid">
            
            <!-- Brand Logo & App Subtitle -->
            <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('admin.dashboard') }}">
                <div class="bg-primary text-white p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="bi bi-car-front-fill fs-6"></i>
                </div>
                <div>
                    <span class="fw-bold text-primary fs-5 d-block lh-1">SpeedLane</span>
                    <span class="text-muted extra-small">Admin Panel</span>
                </div>
            </a>

            <!-- Right Nav Alignment -->
            <div class="d-flex align-items-center gap-3 ms-auto">
                
                {{-- ROLE BADGE --}}
                @if(auth()->check() && auth()->user()->isSuperAdmin())
                    <span class="badge bg-light text-primary border border-primary px-3 py-2 rounded-pill">
                        <i class="bi bi-shield-check me-1"></i> Super Admin
                    </span>
                @else
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                        <i class="bi bi-person-badge text-primary me-1"></i> Admin
                    </span>
                @endif

                <!-- Logout Action Form -->
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
                    <a class="nav-link text-dark fw-semibold px-3 py-2" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-fill me-2"></i> Dashboard</a>
                    <a class="nav-link text-dark fw-semibold px-3 py-2" href="{{ route('admin.register-service') }}"><i class="bi bi-plus-circle me-2"></i> Register Service</a>
                    <a class="nav-link text-dark fw-semibold px-3 py-2" href="{{ route('admin.update') }}"><i class="bi bi-arrow-repeat me-2"></i> Update Service Status</a>
                    <a class="nav-link text-dark fw-semibold px-3 py-2" href="{{ route('admin.transactions') }}"><i class="bi bi-file-earmark-text me-2"></i> Transaction Records</a>
                    
                    @if(auth()->user()->isSuperAdmin())
                        <a class="nav-link active bg-primary text-white rounded-3 fw-semibold px-3 py-2" href="{{ route('admin.manage-services.index') }}">
                            <i class="bi bi-gear-fill me-2"></i> Manage Services
                        </a>
                    @endif
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 p-4">
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <i class="bi bi-shield-lock text-primary fs-3"></i>
                        <h2 class="fw-bold text-dark mb-0">Manage Services & Staff</h2>
                    </div>
                    <p class="text-muted mb-0">Super admin only — edit service types, pricing options, and staff roster.</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Navigation Tabs -->
                <div class="d-flex align-items-center gap-2 mb-4">
                    <ul class="nav nav-pills gap-2 mb-0" id="manageTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active rounded-pill border px-3 py-1 fw-semibold small" id="services-tab" data-bs-toggle="pill" data-bs-target="#services-panel" type="button">
                                <i class="bi bi-tag me-1"></i> Service Catalog ({{ $services->count() }})
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link rounded-pill border px-3 py-1 fw-semibold text-dark bg-white small" id="technicians-tab" data-bs-toggle="pill" data-bs-target="#technicians-panel" type="button">
                                <i class="bi bi-people me-1"></i> Technicians ({{ $technicians->count() }})
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link rounded-pill border px-3 py-1 fw-semibold text-dark bg-white small" id="staff-tab" data-bs-toggle="pill" data-bs-target="#staff-panel" type="button">
                                <i class="bi bi-person-badge me-1"></i> Staff ({{ $staffs->count() }})
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="manageTabContent">
                    <!-- TAB 1: SERVICE CATALOG -->
                    <div class="tab-pane fade show active" id="services-panel">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                            <div>
                                <h4 class="fw-bold text-dark mb-1">
                                    <i class="bi bi-tools text-primary me-2"></i>Service Catalog
                                </h4>
                                <p class="text-secondary mb-0 fs-6">Manage service packages, pricing structures, and vehicle classifications.</p>
                            </div>
                            <button class="btn btn-primary rounded-3 px-4 py-2 fw-bold shadow-sm d-flex align-items-center gap-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                                <i class="bi bi-plus-lg fs-6"></i> Add New Service
                            </button>
                        </div>

                        <!-- SEARCH & VEHICLE FILTER BAR -->
                        <div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
                            <div class="row g-2">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input type="text" id="serviceSearchInput" class="form-control bg-light border-start-0 rounded-end-3" placeholder="Search service name, sub-services, or price (e.g. Wash, Sedan, 500)...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <select id="vehicleFilterSelect" class="form-select bg-light rounded-3">
                                        <option value="">Filter by Vehicle: All Types</option>
                                        <option value="Sedan">Sedan</option>
                                        <option value="SUV">SUV</option>
                                        <option value="Pickup Truck">Pickup Truck</option>
                                        <option value="Van">Van</option>
                                        <option value="All">All Vehicles Only</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-4 mb-5" id="servicesContainer">
                            @forelse($services as $service)
                                <div class="card service-card service-item border-0 shadow-sm rounded-4 p-4 bg-white" data-vehicle="{{ strtolower($service->vehicle_type ?? 'all') }}">
                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-3 pb-3 border-bottom">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                                                <h3 class="fw-bold text-dark mb-0 fs-4">{{ $service->name }}</h3>
                                                
                                                <!-- Main Service Vehicle Type Badge -->
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 rounded-pill fw-semibold fs-6">
                                                    <i class="bi bi-car-front me-1"></i>{{ $service->vehicle_type ?? 'All Vehicles' }}
                                                </span>

                                                <!-- Selection Type Badge -->
                                                @if($service->selection_type === 'multi')
                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fw-semibold fs-6">
                                                        <i class="bi bi-check2-square me-1"></i> Multi-Select
                                                    </span>
                                                @elseif($service->selection_type === 'single')
                                                    <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle px-3 py-2 rounded-pill fw-semibold fs-6">
                                                        <i class="bi bi-ui-radios me-1"></i> Single-Select
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 rounded-pill fw-semibold fs-6">
                                                        <i class="bi bi-tag-fill me-1"></i> Flat-Rate
                                                    </span>
                                                @endif
                                            </div>

                                            @if($service->description)
                                                <p class="text-dark opacity-75 mb-2 fs-6 lh-base">{{ $service->description }}</p>
                                            @endif

                                            @if($service->notice)
                                                <div class="p-2.5 px-3 bg-warning-subtle border border-warning-subtle text-warning-emphasis rounded-3 fs-6 d-inline-flex align-items-center gap-2 mt-1">
                                                    <i class="bi bi-exclamation-circle-fill text-warning fs-5"></i>
                                                    <span>{{ $service->notice }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="d-flex align-items-center gap-2 self-md-start">
                                            <button class="btn btn-outline-primary rounded-3 px-3 py-1.5 fw-semibold d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $service->id }}">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            <form action="{{ route('admin.manage-services.destroy-service', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger rounded-3 px-3 py-1.5 fw-semibold d-flex align-items-center gap-1">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Sub-services / Pricing Options Grid -->
                                    <div>
                                        <span class="text-uppercase fw-bold text-muted small tracking-wide mb-2 d-block">
                                            <i class="bi bi-list-task me-1"></i> Available Sub-services & Pricing Options
                                        </span>

                                        @if($service->selection_type === 'flat')
                                            <div class="p-3 rounded-3 bg-primary-subtle border border-primary-subtle d-flex justify-content-between align-items-center">
                                                <span class="fw-bold text-primary-emphasis fs-6">
                                                    <i class="bi bi-tag-fill me-2"></i>Standard Flat Rate
                                                </span>
                                                <span class="fw-bold text-primary fs-4 font-monospace">₱{{ number_format($service->flat_price, 2) }}</span>
                                            </div>
                                        @else
                                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2.5">
                                                @foreach($service->options as $opt)
                                                    <div class="col">
                                                        <div class="service-option-card p-3 rounded-3 d-flex justify-content-between align-items-center h-100">
                                                            <div class="d-flex align-items-center gap-2 me-2">
                                                                <i class="bi bi-circle-fill text-primary" style="font-size: 8px;"></i>
                                                                <div>
                                                                    <span class="fw-semibold text-dark fs-6 d-block">{{ $opt->name }}</span>
                                                                </div>
                                                            </div>
                                                            <span class="fw-bold text-primary fs-5 font-monospace ms-auto">₱{{ number_format($opt->price, 2) }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- EDIT SERVICE MODAL -->
                                <div class="modal fade" id="editServiceModal{{ $service->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <form action="{{ route('admin.manage-services.update-service', $service->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header border-bottom">
                                                    <h5 class="modal-title fw-bold text-dark"><i class="bi bi-pencil-square text-primary me-2"></i>Edit Service</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Service Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="name" class="form-control" value="{{ $service->name }}" required>
                                                    </div>
                                                    
                                                    <!-- Service Vehicle Type -->
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Service Vehicle Type</label>
                                                        <select name="vehicle_type" class="form-select">
                                                            <option value="All" {{ ($service->vehicle_type ?? 'All') === 'All' ? 'selected' : '' }}>All Vehicle Types</option>
                                                            <option value="Sedan" {{ ($service->vehicle_type ?? '') === 'Sedan' ? 'selected' : '' }}>Sedan</option>
                                                            <option value="SUV" {{ ($service->vehicle_type ?? '') === 'SUV' ? 'selected' : '' }}>SUV</option>
                                                            <option value="Pickup Truck" {{ ($service->vehicle_type ?? '') === 'Pickup Truck' ? 'selected' : '' }}>Pickup Truck</option>
                                                            <option value="Van" {{ ($service->vehicle_type ?? '') === 'Van' ? 'selected' : '' }}>Van</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Description</label>
                                                        <textarea name="description" class="form-control" rows="2">{{ $service->description }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Notice / Disclaimer Note</label>
                                                        <input type="text" name="notice" class="form-control" value="{{ $service->notice }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Selection Type</label>
                                                        <select name="selection_type" class="form-select" onchange="toggleServiceFields('{{ $service->id }}', this.value)">
                                                            <option value="single" {{ $service->selection_type === 'single' ? 'selected' : '' }}>Single Select</option>
                                                            <option value="multi" {{ $service->selection_type === 'multi' ? 'selected' : '' }}>Multi Select</option>
                                                            <option value="flat" {{ $service->selection_type === 'flat' ? 'selected' : '' }}>Flat Rate</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3" id="flatPriceBox{{ $service->id }}" style="display: {{ $service->selection_type === 'flat' ? 'block' : 'none' }};">
                                                        <label class="form-label small fw-semibold">Flat Price (₱)</label>
                                                        <input type="number" step="0.01" name="flat_price" class="form-control" value="{{ $service->flat_price }}">
                                                    </div>

                                                    <div class="mb-3" id="optionsBox{{ $service->id }}" style="display: {{ $service->selection_type !== 'flat' ? 'block' : 'none' }};">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <label class="form-label small fw-semibold mb-0">Pricing Options & Sub-services</label>
                                                            <button type="button" class="btn btn-sm btn-outline-primary rounded-3" onclick="addOptionRow('editOptionsContainer{{ $service->id }}')">
                                                                <i class="bi bi-plus-lg me-1"></i> Add Sub-service / Rate
                                                            </button>
                                                        </div>
                                                        <div id="editOptionsContainer{{ $service->id }}">
                                                            @foreach($service->options as $index => $option)
                                                                <div class="row g-2 mb-2 option-row">
                                                                    <div class="col-7">
                                                                        <input type="text" name="options[{{ $index }}][name]" class="form-control form-control-sm rounded-2" value="{{ $option->name }}" placeholder="Option Name (e.g. Standard Package)" required>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <input type="number" step="0.01" name="options[{{ $index }}][price]" class="form-control form-control-sm rounded-2" value="{{ $option->price }}" placeholder="Price (₱)" required>
                                                                    </div>
                                                                    <div class="col-1 text-center">
                                                                        <button type="button" class="btn btn-sm btn-outline-danger w-100 rounded-2" onclick="removeOptionRow(this)"><i class="bi bi-trash"></i></button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top">
                                                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary rounded-3 px-4 fw-semibold">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5 bg-white rounded-4 shadow-sm border">
                                    <i class="bi bi-inbox text-muted fs-1 d-block mb-2"></i>
                                    <p class="text-muted fw-semibold mb-0">No services configured yet. Click "Add New Service" above to populate your catalog.</p>
                                </div>
                            @endforelse

                            <!-- Dynamic No Results Message for Search -->
                            <div id="noSearchResults" class="text-center py-5 bg-white rounded-4 shadow-sm border d-none">
                                <i class="bi bi-search text-muted fs-1 d-block mb-2"></i>
                                <h5 class="fw-bold text-dark mb-1">No services matched your search</h5>
                                <p class="text-muted small mb-0">Try searching for a different keyword or change the vehicle filter.</p>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 2: TECHNICIANS ROSTER -->
                    <div class="tab-pane fade" id="technicians-panel">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
                                <div>
                                    <h5 class="fw-bold text-dark mb-0">Technicians Roster</h5>
                                    <small class="text-muted">Manage staff members available for vehicle service assignments.</small>
                                </div>
                                <form action="{{ route('admin.manage-services.store-technician') }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    <input type="text" name="name" class="form-control form-control-sm rounded-3" placeholder="Enter Technician Name" required>
                                    <button class="btn btn-sm btn-primary text-nowrap fw-semibold rounded-3 px-3">
                                        <i class="bi bi-plus-lg me-1"></i> Add Technician
                                    </button>
                                </form>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Technician Name</th>
                                            <th>Date Added</th>
                                            <th>Date Disabled / Resigned</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($technicians as $technician)
                                            <tr>
                                                <td class="align-middle">
                                                    <i class="bi bi-person-circle text-secondary me-2"></i>
                                                    <span class="{{ !$technician->is_active ? 'text-muted text-decoration-line-through' : 'fw-semibold text-dark' }}">
                                                        {{ $technician->name }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-muted">
                                                    {{ $technician->created_at ? $technician->created_at->format('M d, Y') : 'N/A' }}
                                                </td>
                                                <td class="align-middle text-muted small">
                                                    @if(!$technician->is_active)
                                                        {{ $technician->disabled_at ? \Carbon\Carbon::parse($technician->disabled_at)->format('M d, Y') : ($technician->updated_at ? $technician->updated_at->format('M d, Y') : 'N/A') }}
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if($technician->is_active)
                                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-2">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 rounded-2">Disabled</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-end">
                                                    <form action="{{ route('admin.manage-services.toggle-technician-status', $technician->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        @if($technician->is_active)
                                                            <button type="submit" class="btn btn-outline-warning btn-sm px-3 rounded-2 fw-semibold">
                                                                <i class="bi bi-slash-circle me-1"></i> Disable
                                                            </button>
                                                        @else
                                                            <button type="submit" class="btn btn-outline-success btn-sm px-3 rounded-2 fw-semibold">
                                                                <i class="bi bi-check-circle me-1"></i> Enable
                                                            </button>
                                                        @endif
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4 text-muted">No technicians registered yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 3: STAFF & ADMIN ROSTER -->
                    <div class="tab-pane fade" id="staff-panel">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
                                <div>
                                    <h5 class="fw-bold text-dark mb-0">Staff & Admin Roster</h5>
                                    <small class="text-muted">Manage registered staff and edit passwords for Super Admin & Admin accounts via Gmail OTP.</small>
                                </div>
                                <button type="button" class="btn btn-sm btn-primary rounded-3 px-3 fw-semibold d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#createStaffModal">
                                    <i class="bi bi-person-plus-fill"></i> Add Staff
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Email</th>
                                            <th>Contact Number</th>
                                            <th>Date Registered</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($staffs as $staff)
                                            <tr>
                                                <td class="fw-semibold text-dark">
                                                    <i class="bi bi-person-circle text-secondary me-2"></i> {{ $staff->name }}
                                                </td>
                                                <td>{{ $staff->username }}</td>
                                                <td>
                                                    @if(method_exists($staff, 'isSuperAdmin') && $staff->isSuperAdmin())
                                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">Super Admin</span>
                                                    @else
                                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">
                                                            {{ ucfirst($staff->role ?? 'Staff') }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="font-monospace text-primary small">{{ $staff->email }}</td>
                                                <td>{{ $staff->contact_number }}</td>
                                                <td class="text-muted small">{{ $staff->created_at->format('M d, Y') }}</td>
                                                <td class="text-end">
                                                    <div class="d-inline-flex gap-1 align-items-center">
                                                        
                                                        <!-- Edit Password via Gmail OTP Button for Super Admin and Admin -->
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-warning rounded-3 fw-semibold d-flex align-items-center gap-1" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#resetPasswordModal"
                                                                data-user-id="{{ $staff->id }}"
                                                                data-user-name="{{ $staff->name }}"
                                                                data-user-username="{{ $staff->username }}"
                                                                data-user-email="{{ $staff->email }}">
                                                            <i class="bi bi-key-fill"></i> Reset Password
                                                        </button>

                                                        @if(!method_exists($staff, 'isSuperAdmin') || !$staff->isSuperAdmin())
                                                            <button class="btn btn-sm btn-outline-primary rounded-3" data-bs-toggle="modal" data-bs-target="#editStaffModal{{ $staff->id }}">
                                                                <i class="bi bi-pencil me-1"></i> Edit
                                                            </button>
                                                            <form action="{{ route('admin.manage-services.destroy-staff', $staff->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this staff account?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-outline-danger rounded-3"><i class="bi bi-trash me-1"></i> Delete</button>
                                                            </form>
                                                        @endif
                                                    </div>

                                                    @if(!method_exists($staff, 'isSuperAdmin') || !$staff->isSuperAdmin())
                                                        <!-- EDIT STAFF MODAL -->
                                                        <div class="modal fade" id="editStaffModal{{ $staff->id }}" tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content rounded-4 border-0 shadow">
                                                                    <form action="{{ route('admin.manage-services.update-staff', $staff->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-header border-bottom">
                                                                            <h5 class="modal-title fw-bold text-dark"><i class="bi bi-person-gear text-primary me-2"></i>Edit Staff Details</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                        </div>
                                                                        <div class="modal-body p-4 text-start">
                                                                            <div class="mb-3">
                                                                                <label class="form-label small fw-semibold">Full Name</label>
                                                                                <input type="text" name="name" class="form-control" value="{{ $staff->name }}" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label small fw-semibold">Username</label>
                                                                                <input type="text" name="username" class="form-control" value="{{ $staff->username }}" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label small fw-semibold">Email Address</label>
                                                                                <input type="email" name="email" class="form-control" value="{{ $staff->email }}" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label small fw-semibold">Contact Number</label>
                                                                                <input type="text" name="contact_number" class="form-control" value="{{ $staff->contact_number }}" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer border-top">
                                                                            <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit" class="btn btn-primary rounded-3 px-4 fw-semibold">Save Changes</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4 text-muted">No staff or admin accounts registered yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- ADD SERVICE MODAL -->
    <div class="modal fade" id="addServiceModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="{{ route('admin.manage-services.store-service') }}" method="POST">
                    @csrf
                    <div class="modal-header border-bottom">
                        <h5 class="modal-title fw-bold text-dark"><i class="bi bi-plus-circle text-primary me-2"></i>Add New Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Service Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., Ceramic Coating Treatment" required>
                        </div>

                        <!-- Service Vehicle Type -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Service Vehicle Type <span class="text-danger">*</span></label>
                            <select name="vehicle_type" class="form-select" required>
                                <option value="All" selected>All Vehicle Types</option>
                                <option value="Sedan">Sedan</option>
                                <option value="SUV">SUV</option>
                                <option value="Pickup Truck">Pickup Truck</option>
                                <option value="Van">Van</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Brief service description..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Notice / Disclaimer Note</label>
                            <input type="text" name="notice" class="form-control" placeholder="e.g., Select appropriate package for your vehicle.">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Selection Type <span class="text-danger">*</span></label>
                            <select name="selection_type" class="form-select" id="selectionTypeSelect" onchange="toggleAddServiceFields(this.value)">
                                <option value="single">Single Select (Radio Buttons)</option>
                                <option value="multi">Multi Select (Checkboxes)</option>
                                <option value="flat">Flat Rate (Single Fixed Price)</option>
                            </select>
                        </div>

                        <div class="mb-3" id="flatPriceBox" style="display: none;">
                            <label class="form-label small fw-semibold">Flat Price (₱) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="flat_price" class="form-control" placeholder="3500.00">
                        </div>

                        <div class="mb-3" id="optionsBox">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label small fw-semibold mb-0">Pricing Options & Sub-services <span class="text-danger">*</span></label>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-3" onclick="addOptionRow('addOptionsContainer')">
                                    <i class="bi bi-plus-lg me-1"></i> Add Sub-service / Rate
                                </button>
                            </div>
                            <div id="addOptionsContainer">
                                <div class="row g-2 mb-2 option-row">
                                    <div class="col-7">
                                        <input type="text" name="options[0][name]" class="form-control form-control-sm rounded-2" placeholder="Option Name (e.g. Basic Wash)" required>
                                    </div>
                                    <div class="col-4">
                                        <input type="number" step="0.01" name="options[0][price]" class="form-control form-control-sm rounded-2" placeholder="Price (₱)" required>
                                    </div>
                                    <div class="col-1 text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger w-100 rounded-2" onclick="removeOptionRow(this)"><i class="bi bi-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-3 px-4 fw-semibold">Save Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CREATE ADMIN MODAL -->
    <div class="modal fade" id="createStaffModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="{{ route('admin.manage-services.store-staff') }}" method="POST">
                    @csrf
                    
                    <!-- FORCE ROLE TO ADMIN -->
                    <input type="hidden" name="role" value="admin">

                    <div class="modal-header border-bottom">
                        <h5 class="modal-title fw-bold text-dark"><i class="bi bi-person-plus text-primary me-2"></i>Add Admin Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" name="contact_number" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required minlength="8">
                        </div>
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-3 px-4 fw-semibold">Create Admin Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- GMAIL OTP PASSWORD RESET MODAL -->
    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-shield-lock-fill text-primary"></i> Edit Admin Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="{{ route('admin.reset-password-otp') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" id="reset_user_id">
                    <input type="hidden" name="username" id="reset_user_username">
                    <input type="hidden" name="email" id="reset_user_email_input">

                    <div class="modal-body p-4">
                        <div class="alert alert-light border rounded-3 p-3 mb-3">
                            <span class="text-muted small d-block mb-1">Target Account:</span>
                            <strong id="reset_user_name" class="text-dark d-block fs-6"></strong>
                            <span id="reset_user_email" class="text-primary small font-monospace"></span>
                        </div>

                        <!-- Step 1: Send OTP -->
                        <div class="mb-3">
                            <button type="button" id="sendOtpBtn" class="btn btn-outline-primary btn-sm w-100 rounded-3 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-envelope-at-fill"></i> Send Verification Code to Gmail
                            </button>
                            <div id="otpStatusMessage" class="mt-2 text-center small fw-semibold"></div>
                        </div>

                        <hr class="my-3">

                        <!-- Step 2: Enter Code & Password -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">6-Digit Gmail OTP Code</label>
                            <input type="text" name="otp" class="form-control font-monospace text-center letter-spacing-otp fs-5" maxlength="6" placeholder="000000" required autocomplete="off">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimum 8 characters" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter new password" required>
                        </div>
                    </div>

                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-3 px-4 fw-semibold">
                            <i class="bi bi-check-circle me-1"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Form field dynamic toggling
        function toggleAddServiceFields(value) {
            const flatBox = document.getElementById('flatPriceBox');
            const optionsBox = document.getElementById('optionsBox');

            if (value === 'flat') {
                flatBox.style.display = 'block';
                optionsBox.style.display = 'none';
            } else {
                flatBox.style.display = 'none';
                optionsBox.style.display = 'block';
            }
        }

        function toggleServiceFields(id, value) {
            const flatBox = document.getElementById('flatPriceBox' + id);
            const optionsBox = document.getElementById('optionsBox' + id);

            if (value === 'flat') {
                flatBox.style.display = 'block';
                optionsBox.style.display = 'none';
            } else {
                flatBox.style.display = 'none';
                optionsBox.style.display = 'block';
            }
        }

        function addOptionRow(containerId) {
            const container = document.getElementById(containerId);
            const index = container.children.length;
            const row = document.createElement('div');
            row.className = 'row g-2 mb-2 option-row';
            row.innerHTML = `
                <div class="col-7">
                    <input type="text" name="options[${index}][name]" class="form-control form-control-sm rounded-2" placeholder="Option Name (e.g. Standard Package)" required>
                </div>
                <div class="col-4">
                    <input type="number" step="0.01" name="options[${index}][price]" class="form-control form-control-sm rounded-2" placeholder="Price (₱)" required>
                </div>
                <div class="col-1 text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger w-100 rounded-2" onclick="removeOptionRow(this)"><i class="bi bi-trash"></i></button>
                </div>
            `;
            container.appendChild(row);
        }

        function removeOptionRow(btn) {
            const row = btn.closest('.option-row');
            if (row) row.remove();
        }

        // Service Search, Vehicle Filtering, and Gmail OTP Logic
        document.addEventListener('DOMContentLoaded', function () {
            
            // --- Service Search & Filter ---
            const searchInput = document.getElementById('serviceSearchInput');
            const vehicleFilter = document.getElementById('vehicleFilterSelect');
            const serviceItems = document.querySelectorAll('.service-item');
            const noResultsMsg = document.getElementById('noSearchResults');

            function filterServices() {
                const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
                const selectedVehicle = vehicleFilter ? vehicleFilter.value.toLowerCase().trim() : '';
                let visibleCount = 0;

                serviceItems.forEach(card => {
                    const cardText = card.textContent.toLowerCase();
                    const cardVehicle = (card.getAttribute('data-vehicle') || 'all').toLowerCase();

                    const matchesQuery = !query || cardText.includes(query);
                    const matchesVehicle = !selectedVehicle || 
                                           cardVehicle === selectedVehicle || 
                                           cardVehicle === 'all' || 
                                           selectedVehicle === 'all';

                    if (matchesQuery && matchesVehicle) {
                        card.classList.remove('d-none');
                        visibleCount++;
                    } else {
                        card.classList.add('d-none');
                    }
                });

                if (noResultsMsg) {
                    if (visibleCount === 0 && serviceItems.length > 0) {
                        noResultsMsg.classList.remove('d-none');
                    } else {
                        noResultsMsg.classList.add('d-none');
                    }
                }
            }

            if (searchInput) searchInput.addEventListener('input', filterServices);
            if (vehicleFilter) vehicleFilter.addEventListener('change', filterServices);

            // --- Gmail OTP AJAX Logic ---
            const resetPasswordModal = document.getElementById('resetPasswordModal');
            const sendOtpBtn = document.getElementById('sendOtpBtn');
            const otpStatusMessage = document.getElementById('otpStatusMessage');

            if (resetPasswordModal && sendOtpBtn) {
                
                // Populate Modal details on show
                resetPasswordModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const userId = button.getAttribute('data-user-id');
                    const userName = button.getAttribute('data-user-name');
                    const userUsername = button.getAttribute('data-user-username');
                    const userEmail = button.getAttribute('data-user-email');

                    document.getElementById('reset_user_id').value = userId || '';
                    document.getElementById('reset_user_username').value = userUsername || '';
                    document.getElementById('reset_user_email_input').value = userEmail || '';
                    document.getElementById('reset_user_name').textContent = userName || '';
                    document.getElementById('reset_user_email').textContent = userEmail || '';
                    
                    otpStatusMessage.textContent = '';
                    otpStatusMessage.className = 'mt-2 text-center small fw-semibold';
                    sendOtpBtn.disabled = false;
                    sendOtpBtn.innerHTML = `<i class="bi bi-envelope-at-fill me-1"></i> Send Verification Code to Gmail`;
                });

                // Trigger AJAX OTP mail request
                sendOtpBtn.addEventListener('click', function () {
                    const userId = document.getElementById('reset_user_id').value;
                    const username = document.getElementById('reset_user_username').value;
                    const email = document.getElementById('reset_user_email_input').value;
                    
                    sendOtpBtn.disabled = true;
                    sendOtpBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Sending Code...`;
                    otpStatusMessage.textContent = '';

                    fetch("{{ route('admin.send-otp') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ 
                            user_id: userId,
                            username: username,
                            email: email 
                        })
                    })
                    .then(async response => {
                        const data = await response.json();
                        if (!response.ok) {
                            throw new Error(data.message || `Server Error (${response.status})`);
                        }
                        return data;
                    })
                    .then(data => {
                        otpStatusMessage.className = "mt-2 text-center small fw-semibold text-success";
                        otpStatusMessage.textContent = "✓ " + (data.message || 'Verification code sent!');
                        sendOtpBtn.innerHTML = `<i class="bi bi-arrow-clockwise me-1"></i> Resend Verification Code`;
                        sendOtpBtn.disabled = false;
                    })
                    .catch(error => {
                        otpStatusMessage.className = "mt-2 text-center small fw-semibold text-danger";
                        otpStatusMessage.textContent = "✕ " + error.message;
                        sendOtpBtn.disabled = false;
                        sendOtpBtn.innerHTML = `<i class="bi bi-envelope-at-fill me-1"></i> Send Verification Code to Gmail`;
                    });
                });
            }
        });
    </script>
</body>
</html>