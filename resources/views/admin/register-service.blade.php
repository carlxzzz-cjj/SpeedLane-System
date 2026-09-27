<!-- ========================================================================= -->
<!-- FILE LOCATION: resources/views/admin/register-service.blade.php           -->
<!-- ========================================================================= -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedLane - Register Vehicle Service</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <!-- Custom Admin External Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <style>
        .card-figma {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .service-card-item {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            transition: all 0.2s ease-in-out;
        }

        .service-card-item:hover {
            border-color: #cbd5e1;
        }

        .subservice-option-item {
            font-size: 0.925rem;
            padding: 0.65rem 0.85rem;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            transition: background-color 0.15s ease, border-color 0.15s ease;
        }

        .subservice-option-item:hover {
            background-color: #f8fafc;
            border-color: #cbd5e1;
        }

        .subservice-title {
            font-size: 0.8rem;
            letter-spacing: 0.04em;
        }

        .tracking-code-container {
            display: flex;
            align-items: center;
            gap: 12px;
            background-color: #ffffff;
            padding: 1rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .btn-generate {
            background-color: #0d6efd;
            color: #ffffff;
            border: none;
            padding: 0.5rem 1.1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            white-space: nowrap;
        }

        .btn-generate:hover {
            background-color: #0b5ed7;
        }

        .code-box {
            font-family: monospace;
            font-weight: 700;
            font-size: 1.05rem;
            color: #0d6efd;
            border: 1px solid #cbd5e1;
            padding: 0.4rem 0.75rem;
            border-radius: 8px;
            background-color: #f8fafc;
            width: auto;
            max-width: 180px;
        }

        .btn-save-order {
            background-color: #0d6efd;
            color: #fff;
            font-weight: 700;
            padding: 0.85rem;
            border-radius: 10px;
            border: none;
        }

        .btn-save-order:hover {
            background-color: #0b5ed7;
            color: #fff;
        }

        @media (min-width: 992px) {
            .sticky-receipt-wrapper {
                position: sticky;
                top: 80px;
                max-height: calc(100vh - 100px);
                overflow-y: auto;
            }
        }
    </style>
</head>

<body class="bg-light">

   <!-- Header Navigation -->
<header class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 py-2 sticky-top shadow-sm" style="z-index: 1020;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('admin.dashboard') }}">
            <div class="bg-primary text-white p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="bi bi-car-front-fill fs-6"></i>
            </div>
            <div>
                <span class="fw-bold text-primary fs-5 d-block lh-1">SpeedLane</span>
                <span class="text-muted small">Admin Overview</span>
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

                    <a class="nav-link admin-nav-link active rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.register-service') }}">
                        <i class="bi bi-plus-circle"></i> Register Service
                    </a>

                    <a class="nav-link admin-nav-link text-dark rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.update') }}">
                        <i class="bi bi-arrow-repeat"></i> Update Service Status
                    </a>

                    <a class="nav-link admin-nav-link text-dark rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.transactions') }}">
                        <i class="bi bi-file-earmark-text"></i> Transaction Records
                    </a>

                    @if(auth()->check() && auth()->user()->isSuperAdmin())
                        <a class="nav-link admin-nav-link text-dark rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.manage-services.index') }}">
                            <i class="bi bi-gear-fill text-primary"></i> Manage Services
                        </a>
                    @endif
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="col-md-9 col-lg-10 p-4">

                <div class="mb-4">
                    <h3 class="fw-bold text-dark mb-1">Register Vehicle Service</h3>
                    <p class="text-muted mb-0 small">
                        Select services and vehicle-specific options to dynamically update live service totals on the receipt.
                    </p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                        <div class="fw-semibold mb-1">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Please review error details:
                        </div>
                        <ul class="mb-0 ps-3 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('services.store') }}" method="POST" id="serviceRegistrationForm">
                    @csrf

                    <div class="row g-4">

                        <!-- LEFT COLUMN: Form Steps -->
                        <div class="col-lg-7 col-xl-8">

                            <!-- 1. Customer Information Card -->
                            <div class="card card-figma p-4 mb-4 bg-white">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <i class="bi bi-person-lines-fill text-primary fs-5"></i>
                                    <h6 class="fw-bold mb-0 text-dark fs-6">Customer Information</h6>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small text-secondary fw-semibold">Customer Name <span class="text-danger">*</span></label>
                                        <input type="text" name="customer_name" id="customer_name" class="form-control form-control-figma" placeholder="e.g., Juan Dela Cruz" value="{{ old('customer_name') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-secondary fw-semibold">Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" name="contact_number" id="customer_phone" class="form-control form-control-figma" placeholder="e.g., 09123456789" value="{{ old('contact_number') }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Vehicles Container Header -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-car-front text-primary fs-5"></i>
                                    <h5 class="fw-bold mb-0 text-dark fs-6">Vehicles</h5>
                                    <span class="text-muted small" id="vehiclesHeaderSummary">
                                        (1 vehicle · Grand Total: ₱0.00)
                                    </span>
                                </div>

                                <button type="button" class="btn btn-outline-primary btn-sm px-3 rounded-3 d-flex align-items-center gap-1 fw-semibold" id="addVehicleBtn">
                                    <i class="bi bi-plus-lg"></i> Add Vehicle
                                </button>
                            </div>

                            <!-- Dynamic Vehicles Container -->
                            <div id="vehiclesContainer">

                                <!-- Vehicle Card Item #0 -->
                                <div class="card card-figma p-4 mb-4 bg-white vehicle-card" data-vehicle-index="0">

                                    <input type="hidden" name="vehicles[0][total_cost]" class="vehicle-total-cost-input" value="0.00">

                                    <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-primary rounded-circle px-2.5 py-1.5 vehicle-number-badge">1</span>
                                            <span class="fw-semibold text-secondary small vehicle-status-label">Not yet filled</span>
                                        </div>

                                        <button type="button" class="btn btn-link text-danger text-decoration-none p-0 small remove-vehicle-btn d-none fw-semibold">
                                            <i class="bi bi-trash me-1"></i> Remove Vehicle
                                        </button>
                                    </div>

                                    <!-- Vehicle Form Fields -->
                                    <div class="row g-3 mb-4">
                                        <!-- Plate Number -->
                                        <div class="col-md-6 col-xl-4">
                                            <label class="form-label small text-secondary fw-semibold">Plate Number / CS No. <span class="text-danger">*</span></label>
                                            <input type="text" name="vehicles[0][plate_number]" class="form-control form-control-figma text-uppercase plate-input" placeholder="e.g., ABC 1234" required>
                                        </div>

                                        <!-- Brand -->
                                        <div class="col-md-6 col-xl-4">
                                            <label class="form-label small text-secondary fw-semibold">Brand <span class="text-danger">*</span></label>
                                            <select name="vehicles[0][vehicle_make]" class="form-select form-select-figma brand-select" required>
                                                <option value="" disabled selected>Select Brand</option>
                                                <option value="Toyota">Toyota</option>
                                                <option value="Mitsubishi">Mitsubishi</option>
                                                <option value="Honda">Honda</option>
                                                <option value="Ford">Ford</option>
                                                <option value="Nissan">Nissan</option>
                                                <option value="Hyundai">Hyundai</option>
                                                <option value="Isuzu">Isuzu</option>
                                                <option value="Suzuki">Suzuki</option>
                                            </select>
                                        </div>

                                        <!-- Model -->
                                        <div class="col-md-6 col-xl-4">
                                            <label class="form-label small text-secondary fw-semibold">Model <span class="text-danger">*</span></label>
                                            <select name="vehicles[0][vehicle_model]" class="form-select form-select-figma model-select" required disabled>
                                                <option value="" disabled selected>Select Brand First</option>
                                            </select>
                                        </div>

                                        <!-- Vehicle Type -->
                                        <div class="col-md-6 col-xl-4">
                                            <label class="form-label small text-secondary fw-semibold">Vehicle Type <span class="text-danger">*</span></label>
                                            <select name="vehicles[0][vehicle_type]" class="form-select form-select-figma type-select" required>
                                                <option value="" disabled selected>Select Vehicle Type</option>
                                                <option value="Sedan">Sedan</option>
                                                <option value="SUV">SUV</option>
                                                <option value="Pickup Truck">Pickup Truck</option>
                                                <option value="Van">Van</option>
                                            </select>
                                        </div>

                                        <!-- Year -->
                                        <div class="col-md-4 col-xl-3">
                                            <label class="form-label small text-secondary fw-semibold">Year <span class="text-danger">*</span></label>
                                            <select name="vehicles[0][vehicle_year]" class="form-select form-select-figma year-select" required>
                                                <option value="" disabled selected>Year</option>
                                                @for ($year = date('Y') + 1; $year >= 1990; $year--)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <!-- Mechanic Assigned -->
                                        <div class="col-md-8 col-xl-5">
                                            <label class="form-label small text-secondary fw-semibold">Mechanic Assigned <span class="text-danger">*</span></label>
                                            <select name="vehicles[0][mechanic_assigned]" class="form-select form-select-figma mechanic-select" required>
                                                <option value="" disabled selected>Select technician</option>
                                                @if(isset($technicians) && count($technicians) > 0)
                                                    @foreach($technicians as $tech)
                                                        <option value="{{ $tech->name }}">{{ $tech->name }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="John Mechanic">John Mechanic</option>
                                                    <option value="Mike Technician">Mike Technician</option>
                                                    <option value="Alex Senior Tech">Alex Senior Tech</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Services Selection List -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2.5">
                                            <label class="form-label small text-secondary fw-semibold mb-0">
                                                Services & Options
                                            </label>
                                            <span class="fw-bold text-primary fs-6 vehicle-total-display">Total: ₱0.00</span>
                                        </div>

                                        <!-- Placeholder notice shown when NO vehicle type is selected -->
                                        <div class="p-3 text-center border rounded-3 bg-light-subtle vehicle-type-placeholder">
                                            <i class="bi bi-info-circle text-primary me-1 fs-6"></i>
                                            <span class="small text-muted fw-semibold">Please select a <strong>Vehicle Type</strong> above to view available services.</span>
                                        </div>

                                        <div class="d-flex flex-column gap-3 service-list-container">
                                            @if(isset($services) && count($services) > 0)
                                                @foreach($services as $service)
                                                    @php
                                                        $flatPrice = (float) ($service->flat_price ?? 0);
                                                        $hasOptions = isset($service->options) && $service->options->count() > 0;
                                                    @endphp
                                                    
                                                    <div class="service-card-item rounded-3 border bg-white overflow-hidden" 
                                                         data-service-id="{{ $service->id }}"
                                                         data-selection-type="{{ $service->selection_type }}"
                                                         data-flat-price="{{ $flatPrice }}"
                                                         data-vehicle-type="{{ $service->vehicle_type ?? 'All' }}"
                                                         style="display: none !important;">
                                                        
                                                        <input type="hidden" name="vehicles[0][services][{{ $service->id }}][price]" class="service-price-input" value="0.00">

                                                        <!-- Service Checkbox Header -->
                                                        <div class="p-3 d-flex align-items-start justify-content-between service-header">
                                                            <div class="form-check m-0 pe-3">
                                                                <input class="form-check-input service-checkbox mt-1" 
                                                                       type="checkbox" 
                                                                       name="vehicles[0][services][{{ $service->id }}][selected]" 
                                                                       value="1" 
                                                                       id="v0_srv_{{ $service->id }}">
                                                                <label class="form-check-label ms-2 cursor-pointer" for="v0_srv_{{ $service->id }}">
                                                                    <span class="fw-bold text-dark d-block fs-6 lh-sm">{{ $service->name }}</span>
                                                                    @if($service->description)
                                                                        <span class="text-muted small d-block mt-0.5">{{ $service->description }}</span>
                                                                    @endif
                                                                    @if($service->notice)
                                                                        <span class="text-warning-emphasis small d-block mt-1">
                                                                            <i class="bi bi-info-circle me-1"></i>{{ $service->notice }}
                                                                        </span>
                                                                    @endif
                                                                </label>
                                                            </div>

                                                            <!-- Price Tag Display -->
                                                            <div class="text-end text-nowrap">
                                                                @if($flatPrice > 0)
                                                                    <span class="text-muted small d-block">Base Price</span>
                                                                    <span class="fw-bold text-primary fs-6">₱{{ number_format($flatPrice, 2) }}</span>
                                                                @else
                                                                    <span class="text-muted small d-block">Price Varies</span>
                                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">By Vehicle Type</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <!-- Options Panel -->
                                                        @if($hasOptions)
                                                            <div class="service-options-panel p-3 border-top bg-light-subtle d-none">
                                                                <span class="text-uppercase fw-bold text-secondary subservice-title d-block mb-2">
                                                                    Select Coverage / Vehicle Pricing:
                                                                </span>
                                                                <div class="d-flex flex-column gap-2">
                                                                    @foreach($service->options as $option)
                                                                        @php
                                                                            // Fallback to parent service vehicle type if option vehicle type is null or empty
                                                                            $optVehicleType = !empty($option->vehicle_type) ? $option->vehicle_type : (!empty($service->vehicle_type) ? $service->vehicle_type : 'All');
                                                                        @endphp
                                                                        <label class="d-flex justify-content-between align-items-center cursor-pointer subservice-option-item" 
                                                                               data-vehicle-type="{{ $optVehicleType }}">
                                                                            <div class="d-flex align-items-center gap-2">
                                                                                @if($service->selection_type === 'single')
                                                                                    <input type="radio" 
                                                                                           name="vehicles[0][services][{{ $service->id }}][option_id]" 
                                                                                           value="{{ $option->id }}" 
                                                                                           class="service-option-input form-check-input mt-0" 
                                                                                           data-price="{{ $option->price }}"
                                                                                           data-label="{{ $option->name }}"
                                                                                           data-vehicle-type="{{ $optVehicleType }}">
                                                                                @else
                                                                                    <input type="checkbox" 
                                                                                           name="vehicles[0][services][{{ $service->id }}][options][]" 
                                                                                           value="{{ $option->id }}" 
                                                                                           class="service-option-input form-check-input mt-0" 
                                                                                           data-price="{{ $option->price }}"
                                                                                           data-label="{{ $option->name }}"
                                                                                           data-vehicle-type="{{ $optVehicleType }}">
                                                                                @endif
                                                                                <div>
                                                                                    <span class="fw-medium text-dark d-block lh-1">{{ $option->name }}</span>
                                                                                    <span class="badge bg-secondary-subtle text-secondary mt-1" style="font-size: 10px;">
                                                                                        <i class="bi bi-car-front me-1"></i>{{ $optVehicleType }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <span class="fw-bold text-dark font-monospace fs-6">₱{{ number_format($option->price, 2) }}</span>
                                                                        </label>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif

                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="p-3 text-center text-muted small border rounded-3 bg-white">
                                                    No services found in database.
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Price Adjustment Note -->
                                    <div class="pt-2 border-top">
                                        <label class="form-label small text-secondary fw-semibold mb-1">
                                            Price Adjustment Note <span class="text-muted fw-normal">(Optional)</span>
                                        </label>
                                        <input type="text" name="vehicles[0][price_adjustment_note]" class="form-control form-control-figma" placeholder="Explain adjustments (e.g., custom discount, extra labor)">
                                    </div>

                                </div>

                            </div>

                            <!-- Tracking Code Bar -->
                            <div class="tracking-code-container mb-4">
                                <button type="button" class="btn-generate" id="generateCodeBtn">
                                    <i class="bi bi-arrow-repeat me-1"></i> Generate Tracking Code
                                </button>
                                <input type="text" id="trackingCodeInput" name="tracking_code" readonly value="SPD26-E2B3P4" class="code-box" />
                            </div>

                        </div>

                        <!-- RIGHT COLUMN: Sticky Receipt Sidebar -->
                        <div class="col-lg-5 col-xl-4">
                            <div class="sticky-receipt-wrapper">

                                <div class="card card-figma border-0 shadow-sm rounded-4 p-4 bg-white mb-3">
                                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                        <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2 fs-6">
                                            <i class="bi bi-receipt text-primary fs-5"></i> Service Receipt
                                        </h5>
                                        <span class="badge bg-light text-dark font-monospace border px-2.5 py-1.5 fs-6" id="previewCode">SPD26-E2B3P4</span>
                                    </div>

                                    <div class="mb-3 pb-2 border-bottom">
                                        <span class="text-secondary small fw-bold text-uppercase d-block mb-1">Customer Info</span>
                                        <div class="fs-6 fw-bold text-dark" id="previewCustomer">---</div>
                                        <div class="small text-muted font-monospace" id="previewPhone">---</div>
                                    </div>

                                    <div id="previewVehiclesContainer" class="d-flex flex-column gap-3 mb-3" style="max-height: 380px; overflow-y: auto;">
                                        <p class="text-muted small mb-0">No vehicle details or services selected yet.</p>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                        <span class="fw-bold text-dark fs-6">Grand Total Estimated Cost:</span>
                                        <span class="fw-bold fs-4 text-primary font-monospace" id="previewTotal">₱0.00</span>
                                    </div>
                                </div>

                                <div class="card card-figma p-3 bg-white shadow-sm">
                                    <button type="submit" class="btn btn-save-order w-100 fs-6 d-flex justify-content-center align-items-center gap-2" id="saveOrderBtn">
                                        <i class="bi bi-check-circle-fill"></i> Save Service Order
                                    </button>
                                </div>

                            </div>
                        </div>

                    </div>
                </form>

            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const DEFAULT_MODELS = {
            "Toyota": ["Vios", "Fortuner", "Hilux", "Innova", "Corolla Cross", "Wigo", "RAV4", "Avanza", "Hiace"],
            "Mitsubishi": ["Montero Sport", "Xpander", "Strada", "Mirage G4", "L300", "Pajero"],
            "Honda": ["Civic", "CR-V", "City", "HR-V", "BR-V", "Brio", "Accord"],
            "Ford": ["Ranger", "Everest", "Territory", "Explorer", "Mustang"],
            "Nissan": ["Navara", "Terra", "Almera", "Urvan", "Kicks", "Patrol"],
            "Hyundai": ["Tucson", "Creta", "Stargazer", "Accent", "H-100"],
            "Isuzu": ["D-Max", "mu-X", "N-Series"],
            "Suzuki": ["Ertiga", "Jimny", "Swift", "Dzire", "XL7", "APV"]
        };

        window.VEHICLE_MODELS = @json($vehicleModels ?? []);

        document.addEventListener('DOMContentLoaded', function () {
            let vehicleIndexCounter = 1;

            const addVehicleBtn = document.getElementById('addVehicleBtn');
            const vehiclesContainer = document.getElementById('vehiclesContainer');
            const customerNameInput = document.getElementById('customer_name');
            const customerPhoneInput = document.getElementById('customer_phone');
            const generateCodeBtn = document.getElementById('generateCodeBtn');
            const trackingCodeInput = document.getElementById('trackingCodeInput');
            const previewCode = document.getElementById('previewCode');

            // Initialize all vehicle cards on page load
            document.querySelectorAll('.vehicle-card').forEach(card => {
                filterOptionsByVehicleType(card);
            });

            updateCustomerPreview();
            calculateGrandTotal();

            // VEHICLE TYPE DYNAMIC FILTERING FUNCTION
            function filterOptionsByVehicleType(vehicleCard) {
                const selectedType = (vehicleCard.querySelector('.type-select')?.value || '').toLowerCase().trim();
                const placeholder = vehicleCard.querySelector('.vehicle-type-placeholder');

                // IF NO VEHICLE TYPE IS SELECTED: Hide all services and show placeholder
                if (!selectedType) {
                    if (placeholder) placeholder.style.setProperty('display', 'block', 'important');

                    vehicleCard.querySelectorAll('.service-card-item').forEach(serviceCard => {
                        serviceCard.style.setProperty('display', 'none', 'important');
                        const serviceCheckbox = serviceCard.querySelector('.service-checkbox');
                        if (serviceCheckbox && serviceCheckbox.checked) {
                            serviceCheckbox.checked = false; // Reset selection if type unselected
                            const optionsPanel = serviceCard.querySelector('.service-options-panel');
                            if (optionsPanel) optionsPanel.classList.add('d-none');
                        }
                    });

                    calculateGrandTotal();
                    return;
                }

                // VEHICLE TYPE IS SELECTED: Hide placeholder and reveal matching services
                if (placeholder) placeholder.style.setProperty('display', 'none', 'important');

                vehicleCard.querySelectorAll('.service-card-item').forEach(serviceCard => {
                    const serviceType = (serviceCard.getAttribute('data-vehicle-type') || 'all').toLowerCase().trim();
                    const serviceCheckbox = serviceCard.querySelector('.service-checkbox');
                    
                    let visibleOptionsCount = 0;
                    const optionItems = serviceCard.querySelectorAll('.subservice-option-item');

                    // Filter subservice options inside this service
                    optionItems.forEach(optionItem => {
                        const optionType = (optionItem.getAttribute('data-vehicle-type') || 'all').toLowerCase().trim();
                        const input = optionItem.querySelector('.service-option-input');

                        // Match option if option matches type, OR if option is 'all', OR if parent service matches
                        const isOptionMatch = optionType === 'all' || 
                                              optionType === selectedType || 
                                              serviceType === 'all' || 
                                              serviceType === selectedType;

                        if (isOptionMatch) {
                            optionItem.style.setProperty('display', 'flex', 'important');
                            visibleOptionsCount++;
                        } else {
                            optionItem.style.setProperty('display', 'none', 'important');
                            if (input && input.checked) {
                                input.checked = false; // Uncheck hidden options
                            }
                        }
                    });

                    // Filter Main Service Card
                    const isServiceMatch = serviceType === 'all' || serviceType === selectedType;
                    const hasOptions = optionItems.length > 0;
                    
                    // Show service if service matches AND (has no options OR has matching options)
                    const shouldShowService = isServiceMatch && (!hasOptions || visibleOptionsCount > 0);

                    if (shouldShowService) {
                        serviceCard.style.setProperty('display', 'block', 'important');
                    } else {
                        serviceCard.style.setProperty('display', 'none', 'important');
                        if (serviceCheckbox && serviceCheckbox.checked) {
                            serviceCheckbox.checked = false; // Uncheck service if hidden
                            const optionsPanel = serviceCard.querySelector('.service-options-panel');
                            if (optionsPanel) optionsPanel.classList.add('d-none');
                        }
                    }
                });

                calculateGrandTotal();
            }

            // ADD ANOTHER VEHICLE HANDLER
            if (addVehicleBtn && vehiclesContainer) {
                addVehicleBtn.addEventListener('click', function () {
                    const templateCard = vehiclesContainer.querySelector('.vehicle-card');
                    if (!templateCard) return;

                    const newCard = templateCard.cloneNode(true);
                    const index = vehicleIndexCounter++;

                    newCard.setAttribute('data-vehicle-index', index);

                    const badge = newCard.querySelector('.vehicle-number-badge');
                    if (badge) badge.textContent = index + 1;

                    const removeBtn = newCard.querySelector('.remove-vehicle-btn');
                    if (removeBtn) removeBtn.classList.remove('d-none');

                    newCard.querySelectorAll('input, select').forEach(input => {
                        if (input.name) {
                            input.name = input.name.replace(/vehicles\[\d+\]/, `vehicles[${index}]`);
                        }
                        if (input.id) {
                            input.id = input.id.replace(/v\d+_/, `v${index}_`);
                        }

                        if (input.type === 'checkbox' || input.type === 'radio') {
                            input.checked = false;
                        } else if (input.type === 'hidden') {
                            if (input.classList.contains('vehicle-total-cost-input') || input.classList.contains('service-price-input')) {
                                input.value = "0.00";
                            }
                        } else {
                            input.value = '';
                        }
                    });

                    newCard.querySelectorAll('label').forEach(label => {
                        if (label.getAttribute('for')) {
                            label.setAttribute('for', label.getAttribute('for').replace(/v\d+_/, `v${index}_`));
                        }
                    });

                    const modelSelect = newCard.querySelector('.model-select');
                    if (modelSelect) {
                        modelSelect.innerHTML = '<option value="" disabled selected>Select Brand First</option>';
                        modelSelect.disabled = true;
                    }

                    newCard.querySelectorAll('.service-options-panel').forEach(panel => panel.classList.add('d-none'));

                    const totalDisplay = newCard.querySelector('.vehicle-total-display');
                    if (totalDisplay) totalDisplay.textContent = 'Total: ₱0.00';

                    const statusLabel = newCard.querySelector('.vehicle-status-label');
                    if (statusLabel) {
                        statusLabel.textContent = 'Not yet filled';
                        statusLabel.className = 'fw-semibold text-secondary small vehicle-status-label';
                    }

                    vehiclesContainer.appendChild(newCard);
                    filterOptionsByVehicleType(newCard);
                    reindexVehicleCards();
                    calculateGrandTotal();
                });

                // REMOVE VEHICLE HANDLER
                vehiclesContainer.addEventListener('click', function (e) {
                    const removeBtn = e.target.closest('.remove-vehicle-btn');
                    if (removeBtn) {
                        const card = removeBtn.closest('.vehicle-card');
                        card.remove();
                        reindexVehicleCards();
                        calculateGrandTotal();
                    }
                });
            }

            function reindexVehicleCards() {
                const cards = vehiclesContainer.querySelectorAll('.vehicle-card');
                cards.forEach((card, idx) => {
                    const badge = card.querySelector('.vehicle-number-badge');
                    if (badge) badge.textContent = idx + 1;

                    const removeBtn = card.querySelector('.remove-vehicle-btn');
                    if (removeBtn) {
                        if (cards.length === 1) {
                            removeBtn.classList.add('d-none');
                        } else {
                            removeBtn.classList.remove('d-none');
                        }
                    }
                });
            }

            // DYNAMIC LISTENERS FOR BRAND, VEHICLE TYPE, OPTIONS
            document.addEventListener('change', function (e) {
                if (e.target.classList.contains('brand-select')) {
                    const card = e.target.closest('.vehicle-card');
                    const modelSelect = card.querySelector('.model-select');
                    const brand = e.target.value;

                    modelSelect.innerHTML = '<option value="" disabled selected>Select Model</option>';

                    let modelList = [];
                    if (window.VEHICLE_MODELS && window.VEHICLE_MODELS[brand]) {
                        modelList = window.VEHICLE_MODELS[brand].map(m => typeof m === 'object' ? m.model_name : m);
                    } else if (DEFAULT_MODELS[brand]) {
                        modelList = DEFAULT_MODELS[brand];
                    }

                    if (modelList.length > 0) {
                        modelList.forEach(model => {
                            const opt = document.createElement('option');
                            opt.value = model;
                            opt.textContent = model;
                            modelSelect.appendChild(opt);
                        });
                        modelSelect.disabled = false;
                    } else {
                        modelSelect.innerHTML = '<option value="" disabled selected>No models available</option>';
                        modelSelect.disabled = true;
                    }
                    updateVehicleStatus(card);
                    calculateGrandTotal();
                }

                // VEHICLE TYPE CHANGE: FILTER PRICING OPTIONS & SERVICES
                if (e.target.classList.contains('type-select')) {
                    const card = e.target.closest('.vehicle-card');
                    if (card) {
                        filterOptionsByVehicleType(card);
                        updateVehicleStatus(card);
                        calculateGrandTotal();
                    }
                }

                // SERVICE CHECKBOX TOGGLE
                if (e.target.classList.contains('service-checkbox')) {
                    const card = e.target.closest('.vehicle-card');
                    const serviceCard = e.target.closest('.service-card-item');
                    const optionsPanel = serviceCard.querySelector('.service-options-panel');

                    if (e.target.checked) {
                        if (optionsPanel) {
                            optionsPanel.classList.remove('d-none');
                            if (card) filterOptionsByVehicleType(card);
                        }
                    } else {
                        if (optionsPanel) {
                            optionsPanel.classList.add('d-none');
                            optionsPanel.querySelectorAll('.service-option-input').forEach(opt => opt.checked = false);
                        }
                    }
                    calculateGrandTotal();
                }

                // OPTION / FIELD CHANGES
                if (e.target.classList.contains('service-option-input') || 
                    e.target.classList.contains('model-select') || 
                    e.target.classList.contains('year-select') || 
                    e.target.classList.contains('mechanic-select')) {
                    const card = e.target.closest('.vehicle-card');
                    if (card) updateVehicleStatus(card);
                    calculateGrandTotal();
                }
            });

            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('plate-input')) {
                    const card = e.target.closest('.vehicle-card');
                    if (card) updateVehicleStatus(card);
                    calculateGrandTotal();
                }

                if (e.target.id === 'customer_name' || e.target.id === 'customer_phone') {
                    updateCustomerPreview();
                }
            });

            // CODE GENERATOR
            if (generateCodeBtn) {
                generateCodeBtn.addEventListener('click', function () {
                    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                    let code = 'SPD26-';
                    for (let i = 0; i < 6; i++) {
                        code += chars.charAt(Math.floor(Math.random() * chars.length));
                    }
                    if (trackingCodeInput) trackingCodeInput.value = code;
                    if (previewCode) previewCode.textContent = code;
                });
            }

            function updateCustomerPreview() {
                const previewCustomer = document.getElementById('previewCustomer');
                const previewPhone = document.getElementById('previewPhone');

                if (previewCustomer) {
                    previewCustomer.textContent = customerNameInput && customerNameInput.value.trim() !== '' 
                        ? customerNameInput.value.trim() 
                        : '---';
                }
                if (previewPhone) {
                    previewPhone.textContent = customerPhoneInput && customerPhoneInput.value.trim() !== '' 
                        ? customerPhoneInput.value.trim() 
                        : '---';
                }
            }

            function updateVehicleStatus(vehicleCard) {
                const plate = vehicleCard.querySelector('.plate-input')?.value.trim();
                const brand = vehicleCard.querySelector('.brand-select')?.value;
                const statusLabel = vehicleCard.querySelector('.vehicle-status-label');

                if (statusLabel) {
                    if (plate && brand) {
                        statusLabel.textContent = `${brand} (${plate.toUpperCase()})`;
                        statusLabel.className = 'fw-semibold text-success small vehicle-status-label';
                    } else if (plate) {
                        statusLabel.textContent = plate.toUpperCase();
                        statusLabel.className = 'fw-semibold text-primary small vehicle-status-label';
                    } else {
                        statusLabel.textContent = 'Not yet filled';
                        statusLabel.className = 'fw-semibold text-secondary small vehicle-status-label';
                    }
                }
            }

            // CALCULATION & RECEIPT RENDERER
            function calculateGrandTotal() {
                const vehicleCards = document.querySelectorAll('.vehicle-card');
                let grandTotal = 0;
                const receiptVehiclesContainer = document.getElementById('previewVehiclesContainer');
                let receiptHTML = '';

                vehicleCards.forEach((card, idx) => {
                    let vehicleTotal = 0;
                    const plate = card.querySelector('.plate-input')?.value.trim().toUpperCase() || 'UNREGISTERED';
                    const brand = card.querySelector('.brand-select')?.value || '';
                    const model = card.querySelector('.model-select')?.value || '';
                    const type = card.querySelector('.type-select')?.value || '';
                    const year = card.querySelector('.year-select')?.value || '';
                    const mechanic = card.querySelector('.mechanic-select')?.value || '';

                    let selectedServicesList = [];

                    card.querySelectorAll('.service-card-item').forEach(serviceCard => {
                        // Skip completely hidden services
                        if (window.getComputedStyle(serviceCard).display === 'none') {
                            return;
                        }

                        const checkbox = serviceCard.querySelector('.service-checkbox');
                        const flatPrice = parseFloat(serviceCard.getAttribute('data-flat-price')) || 0;
                        const priceInput = serviceCard.querySelector('.service-price-input');
                        const serviceName = serviceCard.querySelector('.fw-bold')?.textContent.trim() || 'Service';

                        let serviceTotal = 0;
                        let selectedOptionsText = [];

                        if (checkbox && checkbox.checked) {
                            serviceTotal += flatPrice;

                            // Only calculate options that are checked AND currently visible
                            const selectedOptions = serviceCard.querySelectorAll('.service-option-input:checked');
                            selectedOptions.forEach(opt => {
                                const optItem = opt.closest('.subservice-option-item');
                                if (optItem && window.getComputedStyle(optItem).display !== 'none') {
                                    const optPrice = parseFloat(opt.getAttribute('data-price')) || 0;
                                    const optLabel = opt.getAttribute('data-label') || '';
                                    serviceTotal += optPrice;
                                    if (optLabel) selectedOptionsText.push(`${optLabel} (₱${optPrice.toFixed(2)})`);
                                }
                            });

                            if (priceInput) priceInput.value = serviceTotal.toFixed(2);
                            vehicleTotal += serviceTotal;

                            let detailString = serviceName;
                            if (flatPrice > 0 && selectedOptionsText.length === 0) {
                                detailString += ` - ₱${flatPrice.toFixed(2)}`;
                            } else if (selectedOptionsText.length > 0) {
                                detailString += ` (${selectedOptionsText.join(', ')})`;
                            }

                            selectedServicesList.push({
                                name: detailString,
                                cost: serviceTotal
                            });
                        } else {
                            if (priceInput) priceInput.value = '0.00';
                        }
                    });

                    // Update Hidden Input & Total Display
                    const vehicleTotalInput = card.querySelector('.vehicle-total-cost-input');
                    if (vehicleTotalInput) vehicleTotalInput.value = vehicleTotal.toFixed(2);

                    const totalDisplay = card.querySelector('.vehicle-total-display');
                    if (totalDisplay) totalDisplay.textContent = `Total: ₱${vehicleTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

                    grandTotal += vehicleTotal;

                    // Receipt Item Render
                    const vehicleTitle = [brand, model, type, year].filter(Boolean).join(' ') || `Vehicle #${idx + 1}`;

                    receiptHTML += `
                        <div class="border rounded-3 p-3 bg-light-subtle">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-dark small">${idx + 1}. ${vehicleTitle}</span>
                                <span class="badge bg-secondary font-monospace">${plate}</span>
                            </div>
                            ${mechanic ? `<div class="small text-muted mb-2"><i class="bi bi-person-badge me-1"></i>Tech: ${mechanic}</div>` : ''}
                            
                            <div class="border-top pt-2 mt-1">
                                ${selectedServicesList.length > 0 ? selectedServicesList.map(s => `
                                    <div class="d-flex justify-content-between align-items-center small mb-1">
                                        <span class="text-secondary text-truncate me-2" style="max-width: 75%;">${s.name}</span>
                                        <span class="font-monospace fw-semibold text-dark">₱${s.cost.toFixed(2)}</span>
                                    </div>
                                `).join('') : '<div class="small text-muted fst-italic">No services selected</div>'}
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center pt-2 mt-2 border-top small fw-bold text-dark">
                                <span>Subtotal:</span>
                                <span class="text-primary font-monospace fs-6">₱${vehicleTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span>
                            </div>
                        </div>
                    `;
                });

                // Update Header Summary & Receipt Totals
                const vehiclesHeaderSummary = document.getElementById('vehiclesHeaderSummary');
                if (vehiclesHeaderSummary) {
                    vehiclesHeaderSummary.textContent = `(${vehicleCards.length} vehicle${vehicleCards.length > 1 ? 's' : ''} · Grand Total: ₱${grandTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })})`;
                }

                if (receiptVehiclesContainer) {
                    receiptVehiclesContainer.innerHTML = receiptHTML || '<p class="text-muted small mb-0">No vehicle details or services selected yet.</p>';
                }

                const previewTotal = document.getElementById('previewTotal');
                if (previewTotal) {
                    previewTotal.textContent = `₱${grandTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                }
            }
        });
    </script>
</body>
</html>