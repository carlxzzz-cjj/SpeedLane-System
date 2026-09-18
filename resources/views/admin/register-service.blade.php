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
                    <span class="text-muted extra-small">Admin Overview</span>
                </div>
            </a>

            <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
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
                        Select services and sub-options to automatically calculate total service pricing.
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

                    <!-- 1. Customer Information Card -->
                    <div class="card card-figma p-4 mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-card-text text-primary"></i>
                            <h6 class="fw-bold mb-0 text-dark">Customer Information</h6>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small text-secondary fw-medium">Customer Name</label>
                                <input type="text" name="customer_name" id="customer_name" class="form-control form-control-figma" placeholder="e.g., Juan Dela Cruz" value="{{ old('customer_name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-secondary fw-medium">Phone Number</label>
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

                        <button type="button" class="btn btn-outline-primary btn-sm px-3 rounded-3 d-flex align-items-center gap-1" id="addVehicleBtn">
                            <i class="bi bi-plus-lg"></i> Add Another Vehicle
                        </button>
                    </div>

                    <!-- Dynamic Vehicles List Container -->
                    <div id="vehiclesContainer">

                        <!-- Vehicle Card Item #0 -->
                        <div class="card card-figma p-4 mb-4 vehicle-card" data-vehicle-index="0">

                            <input type="hidden" name="vehicles[0][total_cost]" class="vehicle-total-cost-input" value="0.00">

                            <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge-vehicle-num vehicle-number-badge">1</span>
                                    <span class="fw-semibold text-secondary small vehicle-status-label">Not yet filled</span>
                                </div>

                                <button type="button" class="btn btn-link text-danger text-decoration-none p-0 small remove-vehicle-btn d-none">
                                    <i class="bi bi-trash me-1"></i> Remove Vehicle
                                </button>
                            </div>

                            <!-- Vehicle Details Form -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-medium">Plate Number / CS No.</label>
                                    <input type="text" name="vehicles[0][plate_number]" class="form-control form-control-figma text-uppercase plate-input" placeholder="e.g., ABC 1234" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-medium">Brand</label>
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

                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-medium">Model</label>
                                    <select name="vehicles[0][vehicle_model]" class="form-select form-select-figma model-select" required disabled>
                                        <option value="" disabled selected>Select Brand First</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-medium">Vehicle Type</label>
                                    <select name="vehicles[0][vehicle_type]" class="form-select form-select-figma type-select" required>
                                        <option value="" disabled selected>Select Vehicle Type</option>
                                        <option value="Hatchback">Hatchback</option>
                                        <option value="Sedan">Sedan</option>
                                        <option value="Coupe">Coupe</option>
                                        <option value="Crossover">Crossover</option>
                                        <option value="MPV">MPV / AUV</option>
                                        <option value="SUV">SUV</option>
                                        <option value="Pickup Truck">Pickup Truck</option>
                                        <option value="Van">Van / Minibus</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-medium">Year</label>
                                    <select name="vehicles[0][vehicle_year]" class="form-select form-select-figma year-select" required>
                                        <option value="" disabled selected>Select Year</option>
                                        @for ($year = date('Y') + 1; $year >= 1990; $year--)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-medium">Mechanic Assigned</label>
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

                            <!-- Services List -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label small text-secondary fw-medium mb-0">
                                        Services & Options
                                        <span class="text-muted fw-normal">(Check service to view price or sub-options)</span>
                                    </label>
                                    <span class="fw-bold text-primary small vehicle-total-display">Total: ₱0.00</span>
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
                                                 data-flat-price="{{ $flatPrice }}">
                                                
                                                <input type="hidden" name="vehicles[0][services][{{ $service->id }}][price]" class="service-price-input" value="0.00">

                                                <!-- Service Header with Base/Flat Price -->
                                                <div class="p-3 d-flex align-items-start justify-content-between service-header">
                                                    <div class="form-check m-0 pe-3">
                                                        <input class="form-check-input service-checkbox mt-1" 
                                                               type="checkbox" 
                                                               name="vehicles[0][services][{{ $service->id }}][selected]" 
                                                               value="1" 
                                                               id="v0_srv_{{ $service->id }}">
                                                        <label class="form-check-label ms-1 cursor-pointer" for="v0_srv_{{ $service->id }}">
                                                            <span class="fw-bold text-dark d-block fs-6 lh-sm">{{ $service->name }}</span>
                                                            @if($service->description)
                                                                <span class="text-muted small d-block mt-0.5">{{ $service->description }}</span>
                                                            @endif
                                                            @if($service->notice)
                                                                <span class="text-warning-emphasis extra-small d-block mt-1">
                                                                    <i class="bi bi-info-circle me-1"></i>{{ $service->notice }}
                                                                </span>
                                                            @endif
                                                        </label>
                                                    </div>

                                                    <!-- Display Flat / Base Price -->
                                                    @if($flatPrice > 0)
                                                        <div class="text-end text-nowrap">
                                                            <span class="text-muted extra-small d-block">Base Price</span>
                                                            <span class="fw-bold text-primary fs-6">₱{{ number_format($flatPrice, 2) }}</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Sub-Options Accordion Panel -->
                                                @if($hasOptions)
                                                    <div class="service-options-panel p-3 border-top bg-light-subtle d-none">
                                                        <span class="text-secondary extra-small fw-bold text-uppercase d-block mb-2">
                                                            Select Coverage / Sub-Option Choice:
                                                        </span>
                                                        <div class="d-flex flex-column gap-2 ps-2">
                                                            @foreach($service->options as $option)
                                                                <label class="d-flex justify-content-between align-items-center cursor-pointer small border-bottom pb-1">
                                                                    <div>
                                                                        @if($service->selection_type === 'single')
                                                                            <input type="radio" 
                                                                                   name="vehicles[0][services][{{ $service->id }}][option_id]" 
                                                                                   value="{{ $option->id }}" 
                                                                                   class="service-option-input me-2" 
                                                                                   data-price="{{ $option->price }}"
                                                                                   data-label="{{ $option->name }}">
                                                                        @else
                                                                            <input type="checkbox" 
                                                                                   name="vehicles[0][services][{{ $service->id }}][options][]" 
                                                                                   value="{{ $option->id }}" 
                                                                                   class="service-option-input me-2" 
                                                                                   data-price="{{ $option->price }}"
                                                                                   data-label="{{ $option->name }}">
                                                                        @endif
                                                                        {{ $option->name }}
                                                                    </div>
                                                                    <span class="fw-bold text-dark font-monospace">₱{{ number_format($option->price, 2) }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        @endforeach
                                    @else
                                        <div class="p-3 text-center text-muted small border rounded-3 bg-white">
                                            No services found in database. Please configure services in "Manage Services".
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Optional Note -->
                            <div>
                                <label class="form-label small text-secondary fw-medium mb-1">
                                    Price Adjustment Note <span class="text-muted fw-normal">(Optional)</span>
                                </label>
                                <input type="text" name="vehicles[0][price_adjustment_note]" class="form-control form-control-figma" placeholder="Explain price adjustments (e.g., custom discount, extra labor)">
                            </div>

                        </div>

                    </div>

                    <!-- 3. Tracking Code Container -->
                    <div class="tracking-code-container mb-4">
                         <button type="button" class="btn-generate" id="generateCodeBtn">Generate Tracking Code</button>
                         <input type="text" id="trackingCodeInput" name="tracking_code" readonly value="SPD26-E2B3P4" class="code-box" />
                    </div>

                    <!-- 4. Dynamic Receipt Card -->
                    <div class="card card-figma border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2 fs-6">
                                <i class="bi bi-receipt text-primary fs-5"></i> Service Order Receipt
                            </h5>
                            <span class="badge bg-light text-dark font-monospace border" id="previewCode">SPD26-E2B3P4</span>
                        </div>

                        <div class="mb-3 pb-2 border-bottom">
                            <span class="text-secondary extra-small fw-bold text-uppercase d-block mb-1">Customer Info</span>
                            <div class="fs-6 fw-bold text-dark" id="previewCustomer">---</div>
                            <div class="small text-muted font-monospace" id="previewPhone">---</div>
                        </div>

                        <div id="previewVehiclesContainer" class="d-flex flex-column gap-3 mb-3">
                            <p class="text-muted small mb-0">No vehicle details or services selected yet.</p>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <span class="fw-bold text-dark fs-6">Grand Total Estimated Cost:</span>
                            <span class="fw-bold fs-4 text-primary" id="previewTotal">₱0.00</span>
                        </div>
                    </div>

                    <!-- 5. Submit Panel -->
                    <div class="card card-figma p-4 mb-4">
                        <button type="submit" class="btn btn-save-order w-100 fs-6 shadow-sm d-flex justify-content-center align-items-center gap-2" id="saveOrderBtn">
                            Save Service Order
                        </button>
                    </div>

                </form>

            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Interactive Model Populating & Dynamic Calculation Scripts -->
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

            updateCustomerPreview();
            calculateGrandTotal();

            // 1. ADD ANOTHER VEHICLE BUTTON HANDLER
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
                    reindexVehicleCards();
                    calculateGrandTotal();
                });

                // REMOVE VEHICLE HANDLER (DELEGATED)
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

            // 2. DYNAMIC MODEL POPULATING & CHANGE EVENT LISTENERS
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

                if (e.target.classList.contains('service-checkbox')) {
                    const serviceCard = e.target.closest('.service-card-item');
                    const optionsPanel = serviceCard.querySelector('.service-options-panel');

                    if (e.target.checked) {
                        if (optionsPanel) optionsPanel.classList.remove('d-none');
                    } else {
                        if (optionsPanel) {
                            optionsPanel.classList.add('d-none');
                            optionsPanel.querySelectorAll('.service-option-input').forEach(opt => opt.checked = false);
                        }
                    }
                    calculateGrandTotal();
                }

                if (e.target.classList.contains('service-option-input') || 
                    e.target.classList.contains('model-select') || 
                    e.target.classList.contains('type-select') || 
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

            // 3. TRACKING CODE GENERATOR
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

            // 4. HELPER & PREVIEW FUNCTIONS
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
                        const checkbox = serviceCard.querySelector('.service-checkbox');
                        const flatPrice = parseFloat(serviceCard.getAttribute('data-flat-price')) || 0;
                        const priceInput = serviceCard.querySelector('.service-price-input');
                        const serviceName = serviceCard.querySelector('.fw-bold')?.textContent.trim() || 'Service';

                        let serviceTotal = 0;
                        let selectedOptionsText = [];

                        if (checkbox && checkbox.checked) {
                            serviceTotal += flatPrice;

                            const selectedOptions = serviceCard.querySelectorAll('.service-option-input:checked');
                            selectedOptions.forEach(opt => {
                                const optPrice = parseFloat(opt.getAttribute('data-price')) || 0;
                                const optLabel = opt.getAttribute('data-label') || '';
                                serviceTotal += optPrice;
                                if (optLabel) selectedOptionsText.push(`${optLabel} (₱${optPrice.toFixed(2)})`);
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

                    // Update Vehicle Hidden Total Input & Card Display
                    const vehicleTotalInput = card.querySelector('.vehicle-total-cost-input');
                    if (vehicleTotalInput) vehicleTotalInput.value = vehicleTotal.toFixed(2);

                    const totalDisplay = card.querySelector('.vehicle-total-display');
                    if (totalDisplay) totalDisplay.textContent = `Total: ₱${vehicleTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

                    grandTotal += vehicleTotal;

                    // Render Receipt Preview for this vehicle
                    const vehicleTitle = [brand, model, type, year].filter(Boolean).join(' ') || `Vehicle #${idx + 1}`;

                    receiptHTML += `
                        <div class="border rounded-3 p-3 bg-light-subtle">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-dark small">${idx + 1}. ${vehicleTitle}</span>
                                <span class="badge bg-secondary font-monospace">${plate}</span>
                            </div>
                            ${mechanic ? `<div class="extra-small text-muted mb-2"><i class="bi bi-person-badge me-1"></i>Tech: ${mechanic}</div>` : ''}
                            
                            <div class="border-top pt-2 mt-1">
                                ${selectedServicesList.length > 0 ? selectedServicesList.map(s => `
                                    <div class="d-flex justify-content-between align-items-center small mb-1">
                                        <span class="text-secondary text-truncate me-2" style="max-width: 80%;">${s.name}</span>
                                        <span class="font-monospace fw-semibold text-dark">₱${s.cost.toFixed(2)}</span>
                                    </div>
                                `).join('') : '<div class="extra-small text-muted fst-italic">No services selected</div>'}
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center pt-2 mt-2 border-top extra-small fw-bold text-dark">
                                <span>Vehicle Subtotal:</span>
                                <span class="text-primary font-monospace fs-6">₱${vehicleTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span>
                            </div>
                        </div>
                    `;
                });

                // Update Header Summary & Receipt Grand Total
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