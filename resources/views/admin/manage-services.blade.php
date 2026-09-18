<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedLane - Manage Services & Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="bg-light">

    <!-- Header Navigation -->
    <header class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 py-2 sticky-top shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                <div class="bg-primary text-white p-2 rounded-3 d-flex align-items-center justify-content-center" style="width:36px; height:36px;">
                    <i class="bi bi-car-front-fill"></i>
                </div>
                <div>
                    <span class="fw-bold text-primary fs-5 d-block lh-1">SpeedLane</span>
                    <span class="text-muted extra-small">Admin Panel</span>
                </div>
            </a>

            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2 px-3 py-1 border rounded-3 bg-light">
                    <i class="bi bi-shield-check text-primary fs-5"></i>
                    <div class="lh-1 text-start">
                        <small class="d-block text-primary fw-bold" style="font-size: 10px;">Super Admin</small>
                        <span class="fw-semibold text-primary" style="font-size: 12px;">Super Admin</span>
                    </div>
                </div>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm px-3 rounded-3 d-flex align-items-center gap-1">
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

                <!-- Navigation Tabs -->
                <div class="d-flex align-items-center gap-2 mb-4">
                    <ul class="nav nav-pills gap-2 mb-0" id="manageTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active rounded-pill border px-3 py-1 fw-semibold small" id="services-tab" data-bs-toggle="pill" data-bs-target="#services-panel" type="button">
                                <i class="bi bi-tag me-1"></i> Service Types ({{ $services->count() }})
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
                    <!-- TAB 1: SERVICE TYPES -->
                    <div class="tab-pane fade show active" id="services-panel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Service Catalog</h5>
                                <small class="text-muted">These services appear in the Register Service form for admins.</small>
                            </div>
                            <button class="btn btn-primary rounded-3 px-3 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                                <i class="bi bi-plus-lg me-1"></i> Add Service
                            </button>
                        </div>

                        <div class="d-flex flex-column gap-3 mb-5">
                            @forelse($services as $service)
                                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <h5 class="fw-bold mb-0 text-dark">{{ $service->name }}</h5>
                                                @if($service->selection_type === 'multi')
                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">Multi-select</span>
                                                @elseif($service->selection_type === 'single')
                                                    <span class="badge bg-light text-secondary border rounded-pill">Single-select</span>
                                                @else
                                                    <span class="badge bg-light text-secondary border rounded-pill">Flat-rate</span>
                                                @endif
                                            </div>
                                            <p class="text-muted small mb-2">{{ $service->description }}</p>
                                            @if($service->notice)
                                                <div class="text-warning-emphasis small mb-3">
                                                    <i class="bi bi-info-circle me-1 text-warning"></i> <em>{{ $service->notice }}</em>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-primary rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $service->id }}">
                                                <i class="bi bi-pencil me-1"></i> Edit
                                            </button>
                                            <form action="{{ route('admin.manage-services.destroy-service', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-3">
                                                    <i class="bi bi-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2 pt-2 border-top">
                                        @if($service->selection_type === 'flat')
                                            <span class="badge bg-light text-dark border px-3 py-2 fw-normal rounded-3">
                                                Flat Price <strong class="text-primary ms-1">₱{{ number_format($service->flat_price, 2) }}</strong>
                                            </span>
                                        @else
                                            @foreach($service->options as $opt)
                                                <span class="badge bg-light text-dark border px-3 py-2 fw-normal rounded-3">
                                                    {{ $opt->name }} <strong class="text-primary ms-1">₱{{ number_format($opt->price, 2) }}</strong>
                                                </span>
                                            @endforeach
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
                                                        <label class="form-label small fw-semibold">Service Name</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $service->name }}" required>
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
                                                            <label class="form-label small fw-semibold mb-0">Service Options & Prices</label>
                                                            <button type="button" class="btn btn-sm btn-outline-primary rounded-3" onclick="addOptionRow('editOptionsContainer{{ $service->id }}')">
                                                                <i class="bi bi-plus-lg me-1"></i> Add Option Price
                                                            </button>
                                                        </div>
                                                        <div id="editOptionsContainer{{ $service->id }}">
                                                            @foreach($service->options as $index => $option)
                                                                <div class="row g-2 mb-2 option-row">
                                                                    <div class="col-7">
                                                                        <input type="text" name="options[{{ $index }}][name]" class="form-control form-control-sm rounded-2" value="{{ $option->name }}" required>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <input type="number" step="0.01" name="options[{{ $index }}][price]" class="form-control form-control-sm rounded-2" value="{{ $option->price }}" required>
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
                                <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                                    <p class="text-muted mb-0">No services configured. Click "Add Service" above to populate the catalog.</p>
                                </div>
                            @endforelse
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
                                                <td colspan="4" class="text-center py-4 text-muted">No technicians registered yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 3: STAFF ROSTER -->
                    <div class="tab-pane fade" id="staff-panel">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
                                <div>
                                    <h5 class="fw-bold text-dark mb-0">Staff Roster</h5>
                                    <small class="text-muted">Manage registered staff accounts.</small>
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
                                                    @if(method_exists($staff, 'isSuperAdmin') && $staff->isSuperAdmin())
                                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill ms-1" style="font-size: 10px;">Super Admin</span>
                                                    @endif
                                                </td>
                                                <td>{{ $staff->username }}</td>
                                                <td>{{ $staff->email }}</td>
                                                <td>{{ $staff->contact_number }}</td>
                                                <td class="text-muted small">{{ $staff->created_at->format('M d, Y') }}</td>
                                                <td class="text-end">
                                                    @if(!method_exists($staff, 'isSuperAdmin') || !$staff->isSuperAdmin())
                                                        <div class="d-inline-flex gap-1">
                                                            <button class="btn btn-sm btn-outline-primary rounded-3" data-bs-toggle="modal" data-bs-target="#editStaffModal{{ $staff->id }}">
                                                                <i class="bi bi-pencil me-1"></i> Edit
                                                            </button>
                                                            <form action="{{ route('admin.manage-services.destroy-staff', $staff->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this staff account?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-outline-danger rounded-3"><i class="bi bi-trash me-1"></i> Delete</button>
                                                            </form>
                                                        </div>

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
                                                    @else
                                                        <span class="text-muted small italic">Protected</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">No staff accounts registered yet.</td>
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
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Brief service description..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Notice / Disclaimer Note</label>
                            <input type="text" name="notice" class="form-control" placeholder="e.g., Prices shown are for standard sedan.">
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
                                <label class="form-label small fw-semibold mb-0">Service Options & Prices <span class="text-danger">*</span></label>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-3" onclick="addOptionRow('addOptionsContainer')">
                                    <i class="bi bi-plus-lg me-1"></i> Add Option Price
                                </button>
                            </div>
                            <div id="addOptionsContainer">
                                <div class="row g-2 mb-2 option-row">
                                    <div class="col-7">
                                        <input type="text" name="options[0][name]" class="form-control form-control-sm rounded-2" placeholder="Option Name" required>
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

    <!-- CREATE STAFF MODAL -->
    <div class="modal fade" id="createStaffModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="{{ route('admin.manage-services.store-staff') }}" method="POST">
                    @csrf
                    <div class="modal-header border-bottom">
                        <h5 class="modal-title fw-bold text-dark"><i class="bi bi-person-plus text-primary me-2"></i>Add Staff Account</h5>
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
                        <button type="submit" class="btn btn-primary rounded-3 px-4 fw-semibold">Create Staff Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
                    <input type="text" name="options[${index}][name]" class="form-control form-control-sm rounded-2" placeholder="Option Name" required>
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
    </script>
</body>
</html>