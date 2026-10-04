<!-- ========================================================================= -->
<!-- FILE LOCATION: resources/views/admin/register-service.blade.php           -->
<!-- ========================================================================= -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedLane - Register Vehicle Service</title>

    <!-- Early Theme Check Script -->
    <script>
        const savedTheme = localStorage.getItem('speedlane_theme');
        if (savedTheme !== 'dark') {
            document.documentElement.classList.add('light-theme');
        } else {
            document.documentElement.classList.remove('light-theme');
        }
    </script>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <!-- Custom Admin External Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <!-- Light Mode Toggle CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme-toggle.css') }}">

    <style>
        :root {
            --speed-pink: #f42582;
            --speed-blue: #00a2ff;
            --speed-dark-bg: #07090e;
            --speed-card-bg: #0e111a;
            --speed-card-border: rgba(255, 255, 255, 0.08);
            --speed-sidebar-bg: #0a0d16;
        }

        /* Dark Theme Default */
        body {
            background-color: var(--speed-dark-bg) !important;
            color: #e2e8f0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            background: radial-gradient(circle at 50% 0%, #121624 0%, #07090e 75%) !important;
            background-attachment: fixed;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Color Utility Classes */
        .text-speed-pink { color: var(--speed-pink) !important; }
        .text-speed-blue { color: var(--speed-blue) !important; }
        .bg-speed-pink { background-color: var(--speed-pink) !important; }
        .bg-speed-blue { background-color: var(--speed-blue) !important; }

        /* Dark Theme Role Badges */
        .badge-super-admin {
            background-color: rgba(244, 37, 130, 0.18) !important;
            color: #ffb3d9 !important;
            border: 1px solid rgba(244, 37, 130, 0.5) !important;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-admin {
            background-color: rgba(0, 162, 255, 0.18) !important;
            color: #99dbff !important;
            border: 1px solid rgba(0, 162, 255, 0.5) !important;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-vehicle-type {
            background-color: rgba(0, 162, 255, 0.18) !important;
            color: #99dbff !important;
            border: 1px solid rgba(0, 162, 255, 0.5) !important;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        /* Dark Theme Logout Button */
        .btn-logout {
            color: #ff6b81 !important;
            border: 1px solid rgba(255, 107, 129, 0.4) !important;
            background: rgba(255, 107, 129, 0.05);
            transition: all 0.25s ease;
            font-weight: 600;
        }

        .btn-logout:hover {
            background: rgba(255, 107, 129, 0.2) !important;
            color: #ffffff !important;
            border-color: #ff6b81 !important;
        }

        /* Dark Theme Toggle Button */
        #theme-toggle-btn {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.25s ease;
        }

        #theme-toggle-btn:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }

        /* Top Navigation Header */
        .navbar-speed {
            background: rgba(7, 9, 14, 0.95);
            border-bottom: 1px solid var(--speed-card-border);
            backdrop-filter: blur(10px);
        }

        .brand-logo-text {
            font-size: 1.35rem;
            font-weight: 900;
            letter-spacing: 0.8px;
            font-style: italic;
            line-height: 1;
        }

        .brand-subtext {
            font-size: 0.65rem;
            letter-spacing: 1.5px;
            color: #94a3b8;
            font-weight: 700;
        }

        /* Sidebar Styling */
        .admin-sidebar {
            background-color: var(--speed-sidebar-bg) !important;
            border-right: 1px solid var(--speed-card-border) !important;
        }

        .admin-nav-link {
            color: #94a3b8 !important;
            font-weight: 500;
            transition: all 0.25s ease;
            border: 1px solid transparent;
        }

        .admin-nav-link:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.08);
        }

        .admin-nav-link.active {
            background: linear-gradient(90deg, rgba(244, 37, 130, 0.15) 0%, rgba(0, 162, 255, 0.15) 100%) !important;
            color: #ffffff !important;
            border: 1px solid rgba(244, 37, 130, 0.3) !important;
            box-shadow: 0 0 15px rgba(244, 37, 130, 0.15);
        }

        /* Speed Card Theme */
        .speed-card {
            background-color: var(--speed-card-bg) !important;
            border: 1px solid var(--speed-card-border) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        /* Gradient Action Buttons */
        .btn-speed-gradient {
            background: linear-gradient(90deg, var(--speed-pink) 0%, var(--speed-blue) 100%);
            border: none;
            color: #ffffff !important;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(244, 37, 130, 0.3);
        }

        .btn-speed-gradient:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 162, 255, 0.4);
            color: #ffffff !important;
        }

        /* Inputs & Dropdowns */
        .form-control-dark, .form-select-dark {
            background-color: #06080d !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            transition: all 0.25s ease;
        }

        .form-control-dark:focus, .form-select-dark:focus {
            border-color: var(--speed-blue) !important;
            box-shadow: 0 0 12px rgba(0, 162, 255, 0.25) !important;
            color: #ffffff !important;
        }

        .form-control-dark::placeholder {
            color: #475569 !important;
        }

        .input-group-text-dark {
            background-color: #090c14 !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-right: none !important;
            color: #94a3b8 !important;
        }

        .input-group .form-control-dark {
            border-left: none !important;
        }

        /* Service Registration Specific Styles */
        .service-card-item {
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            transition: all 0.2s ease-in-out;
            background-color: rgba(6, 8, 13, 0.6);
        }

        .service-card-item:hover {
            border-color: rgba(0, 162, 255, 0.4);
        }

        .subservice-option-item {
            font-size: 0.925rem;
            padding: 0.65rem 0.85rem;
            background-color: #06080d;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #e2e8f0;
            transition: background-color 0.15s ease, border-color 0.15s ease;
        }

        .subservice-option-item:hover {
            background-color: #0f1322;
            border-color: var(--speed-blue);
        }

        .subservice-title {
            font-size: 0.8rem;
            letter-spacing: 0.04em;
        }

        .tracking-code-container {
            display: flex;
            align-items: center;
            gap: 12px;
            background-color: var(--speed-card-bg);
            padding: 1rem;
            border-radius: 12px;
            border: 1px solid var(--speed-card-border);
        }

        .btn-generate {
            background: linear-gradient(90deg, var(--speed-pink) 0%, var(--speed-blue) 100%);
            color: #ffffff !important;
            border: none;
            padding: 0.5rem 1.1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            white-space: nowrap;
            box-shadow: 0 4px 15px rgba(244, 37, 130, 0.3);
            transition: all 0.3s ease;
        }

        .btn-generate:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 162, 255, 0.4);
            color: #ffffff !important;
        }

        .code-box {
            font-family: monospace;
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--speed-blue);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.4rem 0.75rem;
            border-radius: 8px;
            background-color: #06080d;
            width: auto;
            max-width: 200px;
        }

        .vehicle-collapse-trigger {
            cursor: pointer;
            user-select: none;
        }

        .vehicle-collapse-trigger .collapse-icon {
            transition: transform 0.2s ease;
        }

        .vehicle-collapse-trigger[aria-expanded="true"] .collapse-icon {
            transform: rotate(180deg);
        }

        .service-note-wrapper {
            max-width: 480px;
        }

        @media (min-width: 992px) {
            .sticky-receipt-wrapper {
                position: sticky;
                top: 80px;
                max-height: calc(100vh - 100px);
                overflow-y: auto;
            }
        }

        /* ========================================================================= */
        /* LIGHT MODE HIGH-CONTRAST OVERRIDES                                       */
        /* ========================================================================= */
        html.light-theme {
            --speed-dark-bg: #f8fafc;
            --speed-card-bg: #ffffff;
            --speed-card-border: rgba(0, 0, 0, 0.08);
            --speed-sidebar-bg: #f8fafc;
        }

        html.light-theme body {
            background: #f8fafc !important;
            color: #1e293b !important;
        }

        html.light-theme .navbar-speed {
            background: rgba(255, 255, 255, 0.95) !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        html.light-theme h3,
        html.light-theme h4,
        html.light-theme h5,
        html.light-theme h6 {
            color: #0f172a !important;
        }

        html.light-theme .text-white {
            color: #0f172a !important;
        }

        html.light-theme .btn-speed-gradient,
        html.light-theme .btn-generate,
        html.light-theme .badge.bg-speed-pink,
        html.light-theme .bg-speed-pink.text-white {
            color: #ffffff !important;
        }

        html.light-theme .badge-super-admin {
            background-color: #fce7f3 !important;
            color: #be185d !important;
            border: 1px solid #f472b6 !important;
            font-weight: 700 !important;
        }

        html.light-theme .badge-admin {
            background-color: #e0f2fe !important;
            color: #0369a1 !important;
            border: 1px solid #38bdf8 !important;
            font-weight: 700 !important;
        }

        html.light-theme .badge-vehicle-type {
            background-color: #e0f2fe !important;
            color: #0369a1 !important;
            border: 1px solid #38bdf8 !important;
            font-weight: 700 !important;
        }

        html.light-theme .btn-logout {
            color: #e11d48 !important;
            border: 1px solid #fda4af !important;
            background: #fff1f2 !important;
            font-weight: 600;
        }

        html.light-theme .btn-logout:hover {
            background: #ffe4e6 !important;
            color: #9f1239 !important;
            border-color: #f43f5e !important;
        }

        html.light-theme #theme-toggle-btn {
            background-color: #e2e8f0 !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
        }

        html.light-theme #theme-toggle-btn:hover {
            background-color: #cbd5e1 !important;
        }

        html.light-theme .admin-sidebar {
            background-color: #f8fafc !important;
            border-right: 1px solid rgba(0, 0, 0, 0.08) !important;
        }

        html.light-theme .admin-nav-link {
            color: #475569 !important;
            font-weight: 600;
        }

        html.light-theme .admin-nav-link:hover {
            color: #0f172a !important;
            background: #e2e8f0 !important;
            border-color: #cbd5e1 !important;
        }

        html.light-theme .admin-nav-link.active {
            background: linear-gradient(90deg, rgba(244, 37, 130, 0.12) 0%, rgba(0, 162, 255, 0.12) 100%) !important;
            color: #0f172a !important;
            border: 1px solid rgba(244, 37, 130, 0.4) !important;
            font-weight: 700 !important;
        }

        html.light-theme .speed-card {
            background-color: #ffffff !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04) !important;
        }

        html.light-theme .form-control-dark,
        html.light-theme .form-select-dark {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
        }

        html.light-theme .form-control-dark:focus,
        html.light-theme .form-select-dark:focus {
            border-color: var(--speed-blue) !important;
            color: #0f172a !important;
            box-shadow: 0 0 12px rgba(0, 162, 255, 0.2) !important;
        }

        html.light-theme .form-control-dark::placeholder {
            color: #64748b !important;
        }

        html.light-theme .input-group-text-dark {
            background-color: #f1f5f9 !important;
            border: 1px solid #cbd5e1 !important;
            border-right: none !important;
            color: #475569 !important;
        }

        html.light-theme .service-card-item {
            background-color: #ffffff !important;
            border-color: #e2e8f0 !important;
        }

        html.light-theme .subservice-option-item {
            background-color: #ffffff !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
        }

        html.light-theme .subservice-option-item:hover {
            background-color: #f1f5f9 !important;
            border-color: var(--speed-blue) !important;
        }

        html.light-theme .service-options-panel {
            background-color: #f1f5f9 !important;
            border-color: #e2e8f0 !important;
        }

        html.light-theme .vehicle-type-placeholder {
            background-color: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
        }

        html.light-theme .tracking-code-container {
            background-color: #ffffff !important;
            border-color: #e2e8f0 !important;
        }

        html.light-theme .code-box {
            background-color: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
            color: #0284c7 !important;
        }

        html.light-theme #previewVehiclesContainer .card {
            background-color: #f8fafc !important;
            border-color: #e2e8f0 !important;
        }

        html.light-theme #previewCode {
            background-color: #e2e8f0 !important;
            color: #0284c7 !important;
            border-color: #cbd5e1 !important;
        }

        html.light-theme .alert-success {
            background-color: #dcfce7 !important;
            color: #15803d !important;
            border-color: #86efac !important;
        }

        html.light-theme .alert-danger {
            background-color: #fee2e2 !important;
            color: #b91c1c !important;
            border-color: #fca5a5 !important;
        }

        html.light-theme .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(50%);
       }
        body {
            zoom: 80%;
        }

        /* FIX: Remove black/grayish modal backdrop shadow */
        .modal-backdrop {
            background-color: transparent !important;
            opacity: 0 !important;
        }
    </style>
</head>

<body>

    <!-- Header Navigation -->
    <header class="navbar navbar-expand-lg navbar-dark navbar-speed px-4 py-2 sticky-top" style="z-index: 1020;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('admin.dashboard') }}">
                <div class="bg-speed-pink text-white p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="bi bi-car-front-fill fs-6"></i>
                </div>
                <div>
                    <span class="brand-logo-text d-block">
                        <span class="text-speed-pink">SPEED</span><span class="text-speed-blue">LANE</span>
                    </span>
                    <span class="brand-subtext d-block">REGISTER SERVICE</span>
                </div>
            </a>

               <div class="d-flex align-items-center gap-3 ms-auto">
                @if(auth()->check())
                    @if(method_exists(auth()->user(), 'isSuperAdmin') && auth()->user()->isSuperAdmin())
                        <span class="badge badge-super-admin px-3 py-2 rounded-pill d-flex align-items-center gap-1">
                            <i class="bi bi-shield-check me-1"></i>
                            <span>{{ auth()->user()->name }}</span>
                            <span class="ms-1" style="font-size: 0.85em;">(Super Admin)</span>
                        </span>
                    @else
                        <span class="badge badge-admin px-3 py-2 rounded-pill d-flex align-items-center gap-1">
                            <i class="bi bi-person-badge me-1"></i>
                            <span>{{ auth()->user()->name }}</span>
                            <span class="ms-1" style="font-size: 0.85em;">(Admin)</span>
                        </span>
                    @endif
                @endif

                <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-logout btn-sm px-3 rounded-3 d-flex align-items-center gap-1">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>

                <!-- Light / Dark Mode Toggle Button -->
                <button id="theme-toggle-btn" type="button" class="btn d-flex align-items-center justify-content-center rounded-circle p-2" style="width: 40px; height: 40px;" title="Toggle Light/Dark Mode" aria-label="Toggle Light/Dark Mode" onclick="toggleSpeedLaneTheme()">
                    <i id="theme-toggle-icon" class="bi bi-sun-fill text-warning"></i>
                </button>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar Navigation -->
            <aside class="col-md-3 col-lg-2 admin-sidebar min-vh-100 p-3">
                <nav class="nav flex-column gap-2">
                    <a class="nav-link admin-nav-link rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-grid-fill text-speed-pink"></i> Dashboard
                    </a>

                    <a class="nav-link admin-nav-link active rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.register-service') }}">
                        <i class="bi bi-plus-circle text-speed-blue"></i> Register Service
                    </a>

                    <a class="nav-link admin-nav-link rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.update') }}">
                        <i class="bi bi-arrow-repeat text-warning"></i> Update Service Status
                    </a>

                    <a class="nav-link admin-nav-link rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.transactions') }}">
                        <i class="bi bi-file-earmark-text text-info"></i> Transaction Records
                    </a>

                    @if(auth()->check() && auth()->user()->isSuperAdmin())
                        <a class="nav-link admin-nav-link rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.manage-services.index') }}">
                            <i class="bi bi-gear-fill text-speed-pink"></i> Manage Services
                        </a>
                    @endif
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="col-md-9 col-lg-10 p-4">

                <div class="mb-4">
                    <h3 class="fw-bold text-white mb-1">Register Vehicle Service</h3>
                    <p class="text-secondary mb-0 small">
                        Select services and vehicle-specific options to dynamically update live service totals on the receipt.
                    </p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 bg-success bg-opacity-20 text-white border-success" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 bg-danger bg-opacity-20 text-white border-danger" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 bg-danger bg-opacity-20 text-white border-danger" role="alert">
                        <div class="fw-semibold mb-1">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Please review error details:
                        </div>
                        <ul class="mb-0 ps-3 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('services.store') }}" method="POST" id="serviceRegistrationForm">
                    @csrf

                    <div class="row g-4">

                        <!-- LEFT COLUMN: Form Steps -->
                        <div class="col-lg-7 col-xl-8">

                            <!-- 1. Customer Information Card -->
                            <div class="card speed-card p-4 rounded-4 mb-4">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <i class="bi bi-person-lines-fill text-speed-pink fs-5"></i>
                                    <h6 class="fw-bold mb-0 text-white fs-6">Customer Information</h6>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small text-secondary fw-semibold">Customer Name <span class="text-speed-pink">*</span></label>
                                        <input type="text" name="customer_name" id="customer_name" class="form-control form-control-dark" placeholder="e.g., Juan Dela Cruz" value="{{ old('customer_name') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-secondary fw-semibold">Phone Number <span class="text-speed-pink">*</span></label>
                                        <input type="text" name="contact_number" id="customer_phone" class="form-control form-control-dark" placeholder="e.g., 09123456789" value="{{ old('contact_number') }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Vehicles Container Header -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-car-front text-speed-blue fs-5"></i>
                                    <h5 class="fw-bold mb-0 text-white fs-6">Vehicles</h5>
                                    <span class="text-secondary small" id="vehiclesHeaderSummary">
                                        (1 vehicle)
                                    </span>
                                </div>

                                <button type="button" class="btn btn-outline-info btn-sm px-3 rounded-3 d-flex align-items-center gap-1 fw-semibold" id="addVehicleBtn">
                                    <i class="bi bi-plus-lg"></i> Add Vehicle
                                </button>
                            </div>

                            <!-- Dynamic Vehicles Container -->
                            <div id="vehiclesContainer">

                                <!-- Vehicle Card Item #0 -->
                                <div class="card speed-card p-3 p-md-4 mb-3 rounded-4 vehicle-card" data-vehicle-index="0">

                                    <input type="hidden" name="vehicles[0][total_cost]" class="vehicle-total-cost-input" value="0.00">

                                    <!-- Collapsible Header -->
                                    <div class="d-flex justify-content-between align-items-center vehicle-header pb-2">
                                        <div class="d-flex align-items-center gap-2 vehicle-collapse-trigger flex-grow-1" data-bs-toggle="collapse" data-bs-target="#vehicleCollapse_0" aria-expanded="true" aria-controls="vehicleCollapse_0">
                                            <span class="badge bg-speed-pink rounded-circle px-2.5 py-1.5 vehicle-number-badge text-white">1</span>
                                            <span class="fw-semibold text-secondary small vehicle-status-label">Not yet filled</span>
                                            <i class="bi bi-chevron-down text-secondary small ms-1 collapse-icon"></i>
                                        </div>

                                        <button type="button" class="btn btn-link text-danger text-decoration-none p-0 small remove-vehicle-btn d-none fw-semibold ms-2">
                                            <i class="bi bi-trash me-1"></i> Remove Vehicle
                                        </button>
                                    </div>

                                    <!-- Collapsible Card Content -->
                                    <div class="collapse show vehicle-collapse-body pt-3 border-top border-secondary border-opacity-25 mt-2" id="vehicleCollapse_0">
                                        
                                        <!-- Vehicle Form Fields -->
                                        <div class="row g-3 mb-4">
                                            <!-- Plate Number -->
                                            <div class="col-md-6 col-xl-4">
                                                <label class="form-label small text-secondary fw-semibold">Plate Number / CS No. <span class="text-speed-pink">*</span></label>
                                                <input type="text" name="vehicles[0][plate_number]" class="form-control form-control-dark text-uppercase plate-input" placeholder="e.g., ABC 1234" required>
                                            </div>

                                            <!-- Brand -->
                                            <div class="col-md-6 col-xl-4">
                                                <label class="form-label small text-secondary fw-semibold">Brand <span class="text-speed-pink">*</span></label>
                                                <select name="vehicles[0][vehicle_make]" class="form-select form-select-dark brand-select" required>
                                                    <option value="" disabled selected>Select Brand</option>
                                                    @if(isset($vehicleModels) && count($vehicleModels) > 0)
                                                        @php
                                                            $uniqueBrands = [];
                                                            foreach ($vehicleModels as $key => $val) {
                                                                if (is_array($val) || $val instanceof \Illuminate\Support\Collection) {
                                                                    $uniqueBrands[] = $key;
                                                                } elseif (is_object($val) && isset($val->brand)) {
                                                                    $uniqueBrands[] = $val->brand;
                                                                }
                                                            }
                                                            $uniqueBrands = array_unique($uniqueBrands);
                                                        @endphp
                                                        @foreach($uniqueBrands as $bName)
                                                            <option value="{{ $bName }}">{{ $bName }}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="Toyota">Toyota</option>
                                                        <option value="Porsche">Porsche</option>
                                                        <option value="Ford">Ford</option>
                                                        <option value="Chevrolet">Chevrolet</option>
                                                        <option value="Dodge">Dodge</option>
                                                        <option value="Nissan">Nissan</option>
                                                        <option value="Honda">Honda</option>
                                                        <option value="Subaru">Subaru</option>
                                                        <option value="Mazda">Mazda</option>
                                                        <option value="BMW">BMW</option>
                                                        <option value="Mercedes-Benz">Mercedes-Benz</option>
                                                        <option value="Audi">Audi</option>
                                                        <option value="Ferrari">Ferrari</option>
                                                        <option value="Lamborghini">Lamborghini</option>
                                                        <option value="Jeep">Jeep</option>
                                                        <option value="Land Rover">Land Rover</option>
                                                        <option value="BYD">BYD</option>
                                                        <option value="Tesla">Tesla</option>
                                                        <option value="Mitsubishi">Mitsubishi</option>
                                                        <option value="Hyundai">Hyundai</option>
                                                        <option value="Isuzu">Isuzu</option>
                                                        <option value="Suzuki">Suzuki</option>
                                                    @endif
                                                </select>
                                            </div>

                                            <!-- Model -->
                                            <div class="col-md-6 col-xl-4">
                                                <label class="form-label small text-secondary fw-semibold">Model <span class="text-speed-pink">*</span></label>
                                                <select name="vehicles[0][vehicle_model]" class="form-select form-select-dark model-select" required disabled>
                                                    <option value="" disabled selected>Select Brand First</option>
                                                </select>
                                            </div>

                                            <!-- Vehicle Type -->
                                            <div class="col-md-6 col-xl-4">
                                                <label class="form-label small text-secondary fw-semibold">Vehicle Type <span class="text-speed-pink">*</span></label>
                                                <select name="vehicles[0][vehicle_type]" class="form-select form-select-dark type-select" required>
                                                    <option value="" disabled selected>Select Vehicle Type</option>
                                                    <option value="Sedan">Sedan</option>
                                                    <option value="Hatchback">Hatchback</option>
                                                    <option value="Crossover">Crossover</option>
                                                    <option value="SUV">SUV</option>
                                                    <option value="MPV">MPV</option>
                                                    <option value="Pickup Truck">Pickup Truck</option>
                                                    <option value="Van">Van</option>
                                                    <option value="Sports Car">Sports Car</option>
                                                    <option value="Supercar">Supercar</option>
                                                </select>
                                            </div>

                                            <!-- Year -->
                                            <div class="col-md-4 col-xl-3">
                                                <label class="form-label small text-secondary fw-semibold">Year <span class="text-speed-pink">*</span></label>
                                                <select name="vehicles[0][vehicle_year]" class="form-select form-select-dark year-select" required disabled>
                                                    <option value="" disabled selected>Select Model First</option>
                                                </select>
                                            </div>

                                            <!-- Mechanic Assigned -->
                                            <div class="col-md-8 col-xl-5">
                                                <label class="form-label small text-secondary fw-semibold">Mechanic Assigned <span class="text-speed-pink">*</span></label>
                                                <select name="vehicles[0][mechanic_assigned]" class="form-select form-select-dark mechanic-select" required>
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
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label class="form-label small text-secondary fw-semibold mb-0">
                                                    Services & Options <span class="text-speed-pink">*</span>
                                                </label>
                                                <span class="fw-bold text-speed-blue fs-6 vehicle-total-display">Total: ₱0.00</span>
                                            </div>

                                            <!-- Search Bar for Services -->
                                            <div class="mb-3">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text input-group-text-dark">
                                                        <i class="bi bi-search"></i>
                                                    </span>
                                                    <input type="text" class="form-control form-control-dark service-search-input" placeholder="Search services or options (e.g., Wash, Oil Change, Sports Car)...">
                                                </div>
                                            </div>

                                            <!-- Placeholder notice shown when NO vehicle type is selected -->
                                            <div class="p-3 text-center border border-secondary border-opacity-25 rounded-3 bg-black bg-opacity-40 vehicle-type-placeholder">
                                                <i class="bi bi-info-circle text-speed-blue me-1 fs-6"></i>
                                                <span class="small text-secondary fw-semibold">Please select a <strong>Vehicle Type</strong> above to view available services.</span>
                                            </div>

                                            <div class="d-flex flex-column gap-3 service-list-container">
                                                @if(isset($services) && count($services) > 0)
                                                    @foreach($services as $service)
                                                        @php
                                                            $flatPrice = (float) ($service->flat_price ?? 0);
                                                            $hasOptions = isset($service->options) && $service->options->count() > 0;
                                                        @endphp
                                                        
                                                        <div class="service-card-item rounded-3 overflow-hidden" 
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
                                                                        <span class="fw-bold text-white d-block fs-6 lh-sm">{{ $service->name }}</span>
                                                                        @if($service->description)
                                                                            <span class="text-secondary small d-block mt-0.5">{{ $service->description }}</span>
                                                                        @endif
                                                                        @if($service->notice)
                                                                            <span class="text-warning small d-block mt-1">
                                                                                <i class="bi bi-info-circle me-1"></i>{{ $service->notice }}
                                                                            </span>
                                                                        @endif
                                                                    </label>
                                                                </div>

                                                                <!-- Price Tag Display -->
                                                                <div class="text-end text-nowrap">
                                                                    @if($flatPrice > 0)
                                                                        <span class="text-secondary small d-block">Base Price</span>
                                                                        <span class="fw-bold text-speed-blue fs-6">₱{{ number_format($flatPrice, 2) }}</span>
                                                                    @else
                                                                        <span class="text-secondary small d-block">Price Varies</span>
                                                                        <span class="badge badge-vehicle-type rounded-pill">By Vehicle Type</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Options Panel -->
                                                            @if($hasOptions)
                                                                <div class="service-options-panel p-3 border-top border-secondary border-opacity-25 bg-black bg-opacity-30 d-none">
                                                                    <span class="text-uppercase fw-bold text-secondary subservice-title d-block mb-2">
                                                                        Select Coverage / Vehicle Pricing:
                                                                    </span>
                                                                    <div class="d-flex flex-column gap-2">
                                                                        @foreach($service->options as $option)
                                                                            @php
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
                                                                                        <span class="fw-medium text-white d-block lh-1">{{ $option->name }}</span>
                                                                                        <span class="badge bg-secondary bg-opacity-25 text-secondary mt-1" style="font-size: 10px;">
                                                                                            <i class="bi bi-car-front me-1"></i>{{ $optVehicleType }}
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                                <span class="fw-bold text-speed-blue font-monospace fs-6">₱{{ number_format($option->price, 2) }}</span>
                                                                            </label>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="p-3 text-center text-secondary small border border-secondary border-opacity-25 rounded-3 bg-black bg-opacity-40">
                                                        No services found in database.
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Service Note Box -->
                                        <div class="pt-3 border-top border-secondary border-opacity-25 mt-3">
                                            <div class="service-note-wrapper">
                                                <label class="form-label small text-secondary fw-semibold mb-1">
                                                    Service Note <span class="text-secondary fw-normal">(Optional)</span>
                                                </label>
                                                <textarea name="vehicles[0][price_adjustment_note]" 
                                                          rows="2" 
                                                          class="form-control form-control-dark price-adjustment-note-input" 
                                                          placeholder="Add any specific service notes, client requests, or vehicle conditions..."></textarea>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- Tracking Code Bar -->
                            <div class="tracking-code-container mb-4">
                                <button type="button" class="btn-generate" id="generateCodeBtn">
                                    <i class="bi bi-arrow-repeat me-1"></i> Generate Tracking Code
                                </button>
                                <input type="text" id="trackingCodeInput" name="tracking_code" readonly value="{{ old('tracking_code') }}" placeholder="" class="code-box" />
                            </div>

                        </div>

                        <!-- RIGHT COLUMN: Sticky Receipt Sidebar -->
                        <div class="col-lg-5 col-xl-4">
                            <div class="sticky-receipt-wrapper">

                                <div class="card speed-card border-0 shadow-sm rounded-4 p-4 mb-3">
                                    <div class="d-flex justify-content-between align-items-center border-bottom border-secondary border-opacity-25 pb-3 mb-3">
                                        <h5 class="fw-bold mb-0 text-white d-flex align-items-center gap-2 fs-6">
                                            <i class="bi bi-receipt text-speed-pink fs-5"></i> Service Receipt
                                        </h5>
                                        <span class="badge bg-black bg-opacity-50 text-speed-blue font-monospace border border-secondary border-opacity-25 px-2.5 py-1.5 fs-6" id="previewCode">{{ old('tracking_code', '---') }}</span>
                                    </div>

                                    <div class="mb-3 pb-2 border-bottom border-secondary border-opacity-25">
                                        <span class="text-secondary small fw-bold text-uppercase d-block mb-1">Customer Info</span>
                                        <div class="fs-6 fw-bold text-white" id="previewCustomer">---</div>
                                        <div class="small text-secondary font-monospace" id="previewPhone">---</div>
                                    </div>

                                    <div id="previewVehiclesContainer" class="d-flex flex-column gap-3 mb-3" style="max-height: 380px; overflow-y: auto;">
                                        <p class="text-secondary small mb-0">No vehicle details or services selected yet.</p>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center pt-3 border-top border-secondary border-opacity-25">
                                        <span class="fw-bold text-white fs-6">Total Estimated Cost:</span>
                                        <span class="fw-bold fs-4 text-speed-pink font-monospace" id="previewTotal">₱0.00</span>
                                    </div>
                                </div>

                                <div class="card speed-card p-3 shadow-sm rounded-4">
                                    <button type="submit" class="btn btn-speed-gradient w-100 fs-6 d-flex justify-content-center align-items-center gap-2 py-3 rounded-3" id="saveOrderBtn">
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
    // --- LIGHT / DARK MODE THEME TOGGLE ---
    window.toggleSpeedLaneTheme = function() {
        const isLight = document.documentElement.classList.toggle('light-theme');
        localStorage.setItem('speedlane_theme', isLight ? 'light' : 'dark');
        updateThemeIcon(isLight);
    };

    function updateThemeIcon(isLight) {
        const icon = document.getElementById('theme-toggle-icon');
        if (icon) {
            if (isLight) {
                icon.className = 'bi bi-moon-stars-fill text-warning';
            } else {
                icon.className = 'bi bi-sun-fill text-warning';
            }
        }
    }

    // Initialize theme icon on load
    updateThemeIcon(document.documentElement.classList.contains('light-theme'));

    // Default Vehicle Models mapped exactly according to vehicle_models.sql structure
    const DEFAULT_MODELS = {
        "Toyota": [
            { name: "Vios", vehicle_type: "Sedan", year_start: 2013, year_end: 2026 },
            { name: "Corolla Altis", vehicle_type: "Sedan", year_start: 2014, year_end: 2026 },
            { name: "Camry", vehicle_type: "Sedan", year_start: 2015, year_end: 2026 },
            { name: "Wigo", vehicle_type: "Hatchback", year_start: 2014, year_end: 2026 },
            { name: "Yaris Cross", vehicle_type: "Crossover", year_start: 2023, year_end: 2026 },
            { name: "Avanza", vehicle_type: "MPV", year_start: 2012, year_end: 2026 },
            { name: "Veloz", vehicle_type: "MPV", year_start: 2022, year_end: 2026 },
            { name: "Innova", vehicle_type: "MPV", year_start: 2016, year_end: 2026 },
            { name: "Innova Zenix", vehicle_type: "MPV", year_start: 2023, year_end: 2026 },
            { name: "Fortuner", vehicle_type: "SUV", year_start: 2016, year_end: 2026 },
            { name: "RAV4", vehicle_type: "SUV", year_start: 2019, year_end: 2026 },
            { name: "Corolla Cross", vehicle_type: "Crossover", year_start: 2020, year_end: 2026 },
            { name: "Land Cruiser Prado", vehicle_type: "SUV", year_start: 2010, year_end: 2026 },
            { name: "Land Cruiser 300", vehicle_type: "SUV", year_start: 2021, year_end: 2026 },
            { name: "Hilux", vehicle_type: "Pickup Truck", year_start: 2015, year_end: 2026 },
            { name: "Hiace Commuter", vehicle_type: "Van", year_start: 2014, year_end: 2026 },
            { name: "Hiace GL Grandia", vehicle_type: "Van", year_start: 2019, year_end: 2026 },
            { name: "Super Grandia", vehicle_type: "Van", year_start: 2019, year_end: 2026 },
            { name: "Alphard", vehicle_type: "Van", year_start: 2015, year_end: 2026 },
            { name: "GR Supra", vehicle_type: "Sports Car", year_start: 2019, year_end: 2026 },
            { name: "GR86", vehicle_type: "Sports Car", year_start: 2022, year_end: 2026 },
            { name: "GR Yaris", vehicle_type: "Sports Car", year_start: 2021, year_end: 2026 }
        ],
        "Porsche": [
            { name: "911 Carrera / GT3", vehicle_type: "Sports Car", year_start: 2012, year_end: 2026 },
            { name: "718 Cayman", vehicle_type: "Sports Car", year_start: 2016, year_end: 2026 },
            { name: "718 Boxster", vehicle_type: "Sports Car", year_start: 2016, year_end: 2026 },
            { name: "Taycan", vehicle_type: "Sports Car", year_start: 2020, year_end: 2026 },
            { name: "Panamera", vehicle_type: "Sedan", year_start: 2017, year_end: 2026 },
            { name: "Macan", vehicle_type: "SUV", year_start: 2015, year_end: 2026 },
            { name: "Cayenne", vehicle_type: "SUV", year_start: 2011, year_end: 2026 }
        ],
        "Ford": [
            { name: "Mustang", vehicle_type: "Sports Car", year_start: 2015, year_end: 2026 },
            { name: "Territory", vehicle_type: "Crossover", year_start: 2020, year_end: 2026 },
            { name: "Everest", vehicle_type: "SUV", year_start: 2015, year_end: 2026 },
            { name: "Ranger", vehicle_type: "Pickup Truck", year_start: 2015, year_end: 2026 },
            { name: "Ranger Raptor", vehicle_type: "Pickup Truck", year_start: 2018, year_end: 2026 },
            { name: "Explorer", vehicle_type: "SUV", year_start: 2016, year_end: 2026 },
            { name: "Expedition", vehicle_type: "SUV", year_start: 2018, year_end: 2026 }
        ],
        "Chevrolet": [
            { name: "Corvette C8", vehicle_type: "Sports Car", year_start: 2020, year_end: 2026 },
            { name: "Camaro", vehicle_type: "Sports Car", year_start: 2016, year_end: 2026 },
            { name: "Trailblazer", vehicle_type: "SUV", year_start: 2017, year_end: 2026 },
            { name: "Tracker", vehicle_type: "Crossover", year_start: 2021, year_end: 2026 },
            { name: "Suburban", vehicle_type: "SUV", year_start: 2015, year_end: 2026 },
            { name: "Tahoe", vehicle_type: "SUV", year_start: 2021, year_end: 2026 }
        ],
        "Dodge": [
            { name: "Challenger SRT / Hellcat", vehicle_type: "Sports Car", year_start: 2015, year_end: 2026 },
            { name: "Charger", vehicle_type: "Sports Car", year_start: 2015, year_end: 2026 },
            { name: "Durango", vehicle_type: "SUV", year_start: 2014, year_end: 2026 }
        ],
        "Nissan": [
            { name: "GT-R (R35)", vehicle_type: "Supercar", year_start: 2008, year_end: 2026 },
            { name: "Z", vehicle_type: "Sports Car", year_start: 2023, year_end: 2026 },
            { name: "Almera", vehicle_type: "Sedan", year_start: 2015, year_end: 2026 },
            { name: "Kicks e-POWER", vehicle_type: "Crossover", year_start: 2022, year_end: 2026 },
            { name: "Terra", vehicle_type: "SUV", year_start: 2018, year_end: 2026 },
            { name: "Navara", vehicle_type: "Pickup Truck", year_start: 2015, year_end: 2026 },
            { name: "Urvan NV350", vehicle_type: "Van", year_start: 2015, year_end: 2026 },
            { name: "Patrol Royale", vehicle_type: "SUV", year_start: 2014, year_end: 2026 }
        ],
        "Honda": [
            { name: "Civic Type R (FL5 / FK8)", vehicle_type: "Sports Car", year_start: 2017, year_end: 2026 },
            { name: "NSX", vehicle_type: "Supercar", year_start: 2017, year_end: 2024 },
            { name: "City", vehicle_type: "Sedan", year_start: 2014, year_end: 2026 },
            { name: "City Hatchback", vehicle_type: "Hatchback", year_start: 2021, year_end: 2026 },
            { name: "Civic", vehicle_type: "Sedan", year_start: 2016, year_end: 2026 },
            { name: "Accord", vehicle_type: "Sedan", year_start: 2015, year_end: 2026 },
            { name: "Brio", vehicle_type: "Hatchback", year_start: 2014, year_end: 2026 },
            { name: "BR-V", vehicle_type: "MPV", year_start: 2016, year_end: 2026 },
            { name: "HR-V", vehicle_type: "Crossover", year_start: 2015, year_end: 2026 },
            { name: "CR-V", vehicle_type: "SUV", year_start: 2017, year_end: 2026 }
        ],
        "Subaru": [
            { name: "BRZ", vehicle_type: "Sports Car", year_start: 2013, year_end: 2026 },
            { name: "WRX / WRX STI", vehicle_type: "Sports Car", year_start: 2015, year_end: 2026 },
            { name: "XV / Crosstrek", vehicle_type: "Crossover", year_start: 2012, year_end: 2026 },
            { name: "Forester", vehicle_type: "SUV", year_start: 2014, year_end: 2026 },
            { name: "Outback", vehicle_type: "Crossover", year_start: 2015, year_end: 2026 }
        ],
        "Mazda": [
            { name: "MX-5 Miata", vehicle_type: "Sports Car", year_start: 2015, year_end: 2026 },
            { name: "Mazda 3", vehicle_type: "Sedan", year_start: 2014, year_end: 2026 },
            { name: "Mazda 6", vehicle_type: "Sedan", year_start: 2014, year_end: 2026 },
            { name: "CX-30", vehicle_type: "Crossover", year_start: 2020, year_end: 2026 },
            { name: "CX-5", vehicle_type: "SUV", year_start: 2013, year_end: 2026 },
            { name: "CX-60 / CX-90", vehicle_type: "SUV", year_start: 2023, year_end: 2026 },
            { name: "BT-50", vehicle_type: "Pickup Truck", year_start: 2013, year_end: 2026 }
        ],
        "BMW": [
            { name: "M3 / M4", vehicle_type: "Sports Car", year_start: 2015, year_end: 2026 },
            { name: "M2 / M5", vehicle_type: "Sports Car", year_start: 2016, year_end: 2026 },
            { name: "Z4 Roadster", vehicle_type: "Sports Car", year_start: 2019, year_end: 2026 },
            { name: "3 Series", vehicle_type: "Sedan", year_start: 2012, year_end: 2026 },
            { name: "5 Series", vehicle_type: "Sedan", year_start: 2010, year_end: 2026 },
            { name: "7 Series", vehicle_type: "Sedan", year_start: 2016, year_end: 2026 },
            { name: "X1 / X3", vehicle_type: "SUV", year_start: 2015, year_end: 2026 },
            { name: "X5 / X7", vehicle_type: "SUV", year_start: 2013, year_end: 2026 }
        ],
        "Mercedes-Benz": [
            { name: "AMG GT / SL Roadster", vehicle_type: "Sports Car", year_start: 2016, year_end: 2026 },
            { name: "C-Class / C63 AMG", vehicle_type: "Sedan", year_start: 2014, year_end: 2026 },
            { name: "E-Class", vehicle_type: "Sedan", year_start: 2016, year_end: 2026 },
            { name: "S-Class", vehicle_type: "Sedan", year_start: 2013, year_end: 2026 },
            { name: "GLA / GLC / GLE", vehicle_type: "SUV", year_start: 2015, year_end: 2026 },
            { name: "G-Class (G-Wagon)", vehicle_type: "SUV", year_start: 2013, year_end: 2026 }
        ],
        "Audi": [
            { name: "R8", vehicle_type: "Supercar", year_start: 2015, year_end: 2024 },
            { name: "TT / RS3", vehicle_type: "Sports Car", year_start: 2015, year_end: 2026 },
            { name: "A4 / A6", vehicle_type: "Sedan", year_start: 2016, year_end: 2026 },
            { name: "Q3 / Q5 / Q7 / Q8", vehicle_type: "SUV", year_start: 2015, year_end: 2026 }
        ],
        "Ferrari": [
            { name: "488 / F8 Tributo / 296 GTB", vehicle_type: "Supercar", year_start: 2016, year_end: 2026 },
            { name: "Roma / Portofino", vehicle_type: "Sports Car", year_start: 2018, year_end: 2026 },
            { name: "Purosangue", vehicle_type: "SUV", year_start: 2023, year_end: 2026 }
        ],
        "Lamborghini": [
            { name: "Huracan / Revuelto", vehicle_type: "Supercar", year_start: 2015, year_end: 2026 },
            { name: "Urus", vehicle_type: "SUV", year_start: 2018, year_end: 2026 }
        ],
        "Jeep": [
            { name: "Wrangler Rubicon", vehicle_type: "SUV", year_start: 2012, year_end: 2026 },
            { name: "Gladiator", vehicle_type: "Pickup Truck", year_start: 2020, year_end: 2026 },
            { name: "Grand Cherokee", vehicle_type: "SUV", year_start: 2015, year_end: 2026 }
        ],
        "Land Rover": [
            { name: "Defender 90/110/130", vehicle_type: "SUV", year_start: 2020, year_end: 2026 },
            { name: "Range Rover / Sport", vehicle_type: "SUV", year_start: 2014, year_end: 2026 },
            { name: "Evoque / Velar", vehicle_type: "SUV", year_start: 2015, year_end: 2026 }
        ],
        "BYD": [
            { name: "Seal", vehicle_type: "Sports Car", year_start: 2023, year_end: 2026 },
            { name: "Atto 3", vehicle_type: "Crossover", year_start: 2022, year_end: 2026 },
            { name: "Dolphin", vehicle_type: "Hatchback", year_start: 2023, year_end: 2026 },
            { name: "Han", vehicle_type: "Sedan", year_start: 2022, year_end: 2026 }
        ],
        "Tesla": [
            { name: "Model 3 / Performance", vehicle_type: "Sedan", year_start: 2017, year_end: 2026 },
            { name: "Model Y", vehicle_type: "Crossover", year_start: 2020, year_end: 2026 },
            { name: "Model S Plaid", vehicle_type: "Sports Car", year_start: 2016, year_end: 2026 },
            { name: "Model X", vehicle_type: "SUV", year_start: 2016, year_end: 2026 },
            { name: "Cybertruck", vehicle_type: "Pickup Truck", year_start: 2023, year_end: 2026 }
        ],
        "Mitsubishi": [
            { name: "Montero Sport", vehicle_type: "SUV", year_start: 2015, year_end: 2026 },
            { name: "Xpander", vehicle_type: "MPV", year_start: 2018, year_end: 2026 },
            { name: "Strada", vehicle_type: "Pickup Truck", year_start: 2015, year_end: 2026 },
            { name: "Mirage G4", vehicle_type: "Sedan", year_start: 2013, year_end: 2026 },
            { name: "L300", vehicle_type: "Van", year_start: 2010, year_end: 2026 },
            { name: "Pajero", vehicle_type: "SUV", year_start: 2008, year_end: 2021 }
        ],
        "Hyundai": [
            { name: "Tucson", vehicle_type: "SUV", year_start: 2015, year_end: 2026 },
            { name: "Creta", vehicle_type: "Crossover", year_start: 2022, year_end: 2026 },
            { name: "Stargazer", vehicle_type: "MPV", year_start: 2022, year_end: 2026 },
            { name: "Accent", vehicle_type: "Sedan", year_start: 2011, year_end: 2023 },
            { name: "H-100", vehicle_type: "Van", year_start: 2010, year_end: 2026 }
        ],
        "Isuzu": [
            { name: "D-Max", vehicle_type: "Pickup Truck", year_start: 2013, year_end: 2026 },
            { name: "mu-X", vehicle_type: "SUV", year_start: 2014, year_end: 2026 },
            { name: "N-Series", vehicle_type: "Van", year_start: 2010, year_end: 2026 }
        ],
        "Suzuki": [
            { name: "Ertiga", vehicle_type: "MPV", year_start: 2014, year_end: 2026 },
            { name: "Jimny", vehicle_type: "SUV", year_start: 2018, year_end: 2026 },
            { name: "Swift", vehicle_type: "Hatchback", year_start: 2011, year_end: 2026 },
            { name: "Dzire", vehicle_type: "Sedan", year_start: 2013, year_end: 2026 },
            { name: "XL7", vehicle_type: "MPV", year_start: 2020, year_end: 2026 },
            { name: "APV", vehicle_type: "Van", year_start: 2008, year_end: 2026 }
        ]
    };

    window.VEHICLE_MODELS = @json($vehicleModels ?? []);

    document.addEventListener('DOMContentLoaded', function () {
        const addVehicleBtn = document.getElementById('addVehicleBtn');
        const vehiclesContainer = document.getElementById('vehiclesContainer');
        const customerNameInput = document.getElementById('customer_name');
        const customerPhoneInput = document.getElementById('customer_phone');
        const generateCodeBtn = document.getElementById('generateCodeBtn');
        const trackingCodeInput = document.getElementById('trackingCodeInput');
        const previewCode = document.getElementById('previewCode');
        const serviceRegistrationForm = document.getElementById('serviceRegistrationForm');

        // --- VALIDATE THAT VEHICLE & SERVICE INFORMATION IS COMPLETED ---
        function validateVehicleServiceInfo() {
            const custName = (customerNameInput?.value || '').trim();
            const custPhone = (customerPhoneInput?.value || '').trim();

            if (!custName || !custPhone) {
                alert('Please fill out the Customer Name and Phone Number first.');
                if (!custName && customerNameInput) customerNameInput.focus();
                else if (customerPhoneInput) customerPhoneInput.focus();
                return false;
            }

            const vehicleCards = document.querySelectorAll('.vehicle-card');
            if (vehicleCards.length === 0) {
                alert('Please add at least one vehicle.');
                return false;
            }

            for (let i = 0; i < vehicleCards.length; i++) {
                const card = vehicleCards[i];
                const vehicleNum = i + 1;
                const plate = (card.querySelector('.plate-input')?.value || '').trim();
                const brand = (card.querySelector('.brand-select')?.value || '').trim();
                const model = (card.querySelector('.model-select')?.value || '').trim();
                const type = (card.querySelector('.type-select')?.value || '').trim();
                const year = (card.querySelector('.year-select')?.value || '').trim();
                const mechanic = (card.querySelector('.mechanic-select')?.value || '').trim();

                if (!plate || !brand || !model || !type || !year || !mechanic) {
                    alert(`Please complete all required vehicle details for Vehicle #${vehicleNum} (Plate, Brand, Model, Type, Year, Mechanic).`);
                    
                    const collapseBody = card.querySelector('.vehicle-collapse-body');
                    if (collapseBody && !collapseBody.classList.contains('show')) {
                        const bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapseBody);
                        bsCollapse.show();
                    }
                    return false;
                }

                const selectedServices = card.querySelectorAll('.service-checkbox:checked');
                if (selectedServices.length === 0) {
                    alert(`Please select at least one service for Vehicle #${vehicleNum}.`);

                    const collapseBody = card.querySelector('.vehicle-collapse-body');
                    if (collapseBody && !collapseBody.classList.contains('show')) {
                        const bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapseBody);
                        bsCollapse.show();
                    }
                    return false;
                }
            }

            return true;
        }

        // --- GENERATE SPECIFIC TRACKING CODE (FORMAT: SPDL26-GI45T) ---
        function generateTrackingCode() {
            const year = new Date().getFullYear().toString().slice(-2);

            const rawName = (customerNameInput?.value || '').trim().replace(/[^a-zA-Z]/g, '').toUpperCase();
            const nameLetters = rawName.length >= 2 ? rawName.substring(0, 2) : (rawName + 'XX').substring(0, 2);

            const firstVehicleCard = document.querySelector('.vehicle-card');
            const rawPlate = (firstVehicleCard?.querySelector('.plate-input')?.value || '').trim();
            const digitsOnly = rawPlate.replace(/[^0-9]/g, '');
            const plateDigits = digitsOnly.length >= 2 ? digitsOnly.slice(-2) : (digitsOnly + '00').slice(-2);

            const randomLetter = String.fromCharCode(65 + Math.floor(Math.random() * 26));

            return `SPDL${year}-${nameLetters}${plateDigits}${randomLetter}`;
        }

        // --- HELPER TO AUTO-SELECT VEHICLE TYPE DROPDOWN FROM MODEL DATA ---
        function setVehicleTypeSelect(typeSelect, targetType) {
            if (!typeSelect || !targetType) return;
            const targetLower = targetType.trim().toLowerCase();
            let matchedValue = '';

            for (let opt of typeSelect.options) {
                if (!opt.value) continue;
                const optValLower = opt.value.trim().toLowerCase();
                if (optValLower === targetLower || targetLower.includes(optValLower) || optValLower.includes(targetLower)) {
                    matchedValue = opt.value;
                    break;
                }
            }

            if (matchedValue) {
                typeSelect.value = matchedValue;
                typeSelect.dispatchEvent(new Event('change'));
            }
        }

        // --- FILTER SERVICES AND OPTIONS BY VEHICLE TYPE AND SEARCH QUERY ---
        function filterOptionsByVehicleType(vehicleCard) {
            const selectedType = (vehicleCard.querySelector('.type-select')?.value || '').toLowerCase().trim();
            const searchQuery = (vehicleCard.querySelector('.service-search-input')?.value || '').toLowerCase().trim();
            const placeholder = vehicleCard.querySelector('.vehicle-type-placeholder');

            if (!selectedType) {
                if (placeholder) placeholder.style.setProperty('display', 'block', 'important');

                vehicleCard.querySelectorAll('.service-card-item').forEach(serviceCard => {
                    serviceCard.style.setProperty('display', 'none', 'important');
                    const serviceCheckbox = serviceCard.querySelector('.service-checkbox');
                    if (serviceCheckbox && serviceCheckbox.checked) {
                        serviceCheckbox.checked = false;
                        const optionsPanel = serviceCard.querySelector('.service-options-panel');
                        if (optionsPanel) optionsPanel.classList.add('d-none');
                    }
                });

                calculateVehicleTotal(vehicleCard);
                calculateGrandTotal();
                return;
            }

            if (placeholder) placeholder.style.setProperty('display', 'none', 'important');

            vehicleCard.querySelectorAll('.service-card-item').forEach(serviceCard => {
                const serviceType = (serviceCard.getAttribute('data-vehicle-type') || 'all').toLowerCase().trim();
                const serviceName = (serviceCard.querySelector('.fw-bold')?.textContent || '').toLowerCase();
                const serviceDesc = (serviceCard.querySelector('.text-secondary.small')?.textContent || '').toLowerCase();
                const serviceNotice = (serviceCard.querySelector('.text-warning')?.textContent || '').toLowerCase();

                const serviceCheckbox = serviceCard.querySelector('.service-checkbox');
                let visibleOptionsCount = 0;
                let searchMatchedOptionsCount = 0;

                const optionItems = serviceCard.querySelectorAll('.subservice-option-item');

                optionItems.forEach(optionItem => {
                    const optionType = (optionItem.getAttribute('data-vehicle-type') || 'all').toLowerCase().trim();
                    const optionText = (optionItem.textContent || '').toLowerCase();
                    const input = optionItem.querySelector('.service-option-input');

                    // Option matches directly if vehicle type is 'all' OR matches selectedType specifically
                    const isOptionTypeMatch = optionType === 'all' || 
                                              optionType === '' || 
                                              optionType === selectedType || 
                                              optionType.includes(selectedType) || 
                                              selectedType.includes(optionType) ||
                                              optionText.includes(selectedType);

                    const isOptionSearchMatch = !searchQuery || optionText.includes(searchQuery) || serviceName.includes(searchQuery);

                    if (isOptionTypeMatch && isOptionSearchMatch) {
                        optionItem.style.setProperty('display', 'flex', 'important');
                        visibleOptionsCount++;
                        if (optionText.includes(searchQuery)) searchMatchedOptionsCount++;
                    } else {
                        optionItem.style.setProperty('display', 'none', 'important');
                        if (input && input.checked) {
                            input.checked = false;
                        }
                    }
                });

                const isServiceTypeMatch = serviceType === 'all' || 
                                             serviceType === '' || 
                                             serviceType === selectedType || 
                                             serviceType.includes(selectedType) || 
                                             selectedType.includes(serviceType);

                const isServiceSearchMatch = !searchQuery || 
                                             serviceName.includes(searchQuery) || 
                                             serviceDesc.includes(searchQuery) || 
                                             serviceNotice.includes(searchQuery) || 
                                             searchMatchedOptionsCount > 0;

                const hasOptions = optionItems.length > 0;
                const shouldShowService = isServiceTypeMatch && isServiceSearchMatch && (!hasOptions || visibleOptionsCount > 0);

                if (shouldShowService) {
                    serviceCard.style.setProperty('display', 'block', 'important');
                } else {
                    serviceCard.style.setProperty('display', 'none', 'important');
                    if (serviceCheckbox && serviceCheckbox.checked) {
                        serviceCheckbox.checked = false;
                        const optionsPanel = serviceCard.querySelector('.service-options-panel');
                        if (optionsPanel) optionsPanel.classList.add('d-none');
                    }
                }
            });

            calculateVehicleTotal(vehicleCard);
            calculateGrandTotal();
        }

        // --- CALCULATE INDIVIDUAL VEHICLE TOTAL ---
        function calculateVehicleTotal(vehicleCard) {
            let servicesSubtotal = 0;

            vehicleCard.querySelectorAll('.service-card-item').forEach(serviceCard => {
                const checkbox = serviceCard.querySelector('.service-checkbox');
                const priceInput = serviceCard.querySelector('.service-price-input');
                const optionsPanel = serviceCard.querySelector('.service-options-panel');
                const selectionType = serviceCard.getAttribute('data-selection-type');
                const flatPrice = parseFloat(serviceCard.getAttribute('data-flat-price')) || 0;

                if (checkbox && checkbox.checked) {
                    if (optionsPanel) optionsPanel.classList.remove('d-none');

                    let itemPrice = 0;
                    if (selectionType === 'flat') {
                        itemPrice = flatPrice;
                    } else if (selectionType === 'single') {
                        const checkedRadio = serviceCard.querySelector('.service-option-input:checked');
                        if (checkedRadio) {
                            itemPrice = parseFloat(checkedRadio.getAttribute('data-price')) || 0;
                        } else {
                            const visibleRadios = Array.from(serviceCard.querySelectorAll('.service-option-input'))
                                .filter(input => input.closest('.subservice-option-item').style.display !== 'none');
                            if (visibleRadios.length > 0) {
                                visibleRadios[0].checked = true;
                                itemPrice = parseFloat(visibleRadios[0].getAttribute('data-price')) || 0;
                            } else {
                                itemPrice = flatPrice;
                            }
                        }
                    } else if (selectionType === 'multi') {
                        let optionsSum = 0;
                        serviceCard.querySelectorAll('.service-option-input:checked').forEach(opt => {
                            optionsSum += parseFloat(opt.getAttribute('data-price')) || 0;
                        });
                        itemPrice = flatPrice + optionsSum;
                    } else {
                        itemPrice = flatPrice;
                    }

                    if (priceInput) priceInput.value = itemPrice.toFixed(2);
                    servicesSubtotal += itemPrice;
                } else {
                    if (optionsPanel) optionsPanel.classList.add('d-none');
                    if (priceInput) priceInput.value = '0.00';
                }
            });

            const totalCost = Math.max(0, servicesSubtotal);
            const hiddenTotalInput = vehicleCard.querySelector('.vehicle-total-cost-input');
            if (hiddenTotalInput) hiddenTotalInput.value = totalCost.toFixed(2);

            const totalDisplay = vehicleCard.querySelector('.vehicle-total-display');
            if (totalDisplay) {
                totalDisplay.textContent = 'Total: ₱' + totalCost.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }

            return totalCost;
        }

        // --- CALCULATE GRAND TOTAL AND UPDATE RECEIPT SIDEBAR PREVIEW ---
        function calculateGrandTotal() {
            let grandTotal = 0;
            const vehicleCards = document.querySelectorAll('.vehicle-card');
            const previewContainer = document.getElementById('previewVehiclesContainer');
            
            let receiptHTML = '';

            vehicleCards.forEach((card, index) => {
                const vehIndex = index + 1;
                const plate = (card.querySelector('.plate-input')?.value || '').trim().toUpperCase() || 'N/A';
                const brand = card.querySelector('.brand-select')?.value || '';
                const model = card.querySelector('.model-select')?.value || '';
                const type = card.querySelector('.type-select')?.value || '';
                const mechanic = card.querySelector('.mechanic-select')?.value || 'Unassigned';

                const vehTitle = [brand, model, type].filter(Boolean).join(' ') || `Vehicle #${vehIndex}`;
                const vTotal = calculateVehicleTotal(card);
                grandTotal += vTotal;

                const selectedServicesHTML = [];
                card.querySelectorAll('.service-card-item').forEach(serviceCard => {
                    const checkbox = serviceCard.querySelector('.service-checkbox');
                    if (checkbox && checkbox.checked) {
                        const name = serviceCard.querySelector('.fw-bold')?.textContent.trim() || 'Service';
                        const price = parseFloat(serviceCard.querySelector('.service-price-input')?.value || 0);
                        
                        let optionDetails = [];
                        serviceCard.querySelectorAll('.service-option-input:checked').forEach(opt => {
                            const label = opt.getAttribute('data-label');
                            if (label) optionDetails.push(label);
                        });

                        const optionText = optionDetails.length > 0 ? ` (${optionDetails.join(', ')})` : '';

                        selectedServicesHTML.push(`
                            <div class="d-flex justify-content-between align-items-center small py-1 border-bottom border-secondary border-opacity-10">
                                <span class="text-white">• ${name}${optionText}</span>
                                <span class="font-monospace text-speed-blue fw-bold">₱${price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span>
                            </div>
                        `);
                    }
                });

                const serviceNote = card.querySelector('.price-adjustment-note-input')?.value.trim();

                receiptHTML += `
                    <div class="card border border-secondary border-opacity-25 rounded-3 p-3 bg-black bg-opacity-40">
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom border-secondary border-opacity-25">
                            <div>
                                <h6 class="fw-bold text-white mb-0 fs-7"><i class="bi bi-car-front text-speed-pink me-1"></i> ${vehTitle}</h6>
                                <small class="text-secondary" style="font-size: 0.75rem;"><i class="bi bi-person me-1"></i>Tech: ${mechanic}</small>
                            </div>
                            <span class="badge bg-secondary bg-opacity-25 text-white font-monospace">${plate}</span>
                        </div>
                        <div class="mb-2">
                            ${selectedServicesHTML.length > 0 ? selectedServicesHTML.join('') : '<div class="small text-secondary italic">No services selected yet.</div>'}
                        </div>
                        ${serviceNote ? `
                            <div class="small text-info bg-info bg-opacity-10 border border-info border-opacity-20 p-2 rounded-2 my-2" style="font-size: 0.75rem; word-break: break-word;">
                                <i class="bi bi-info-circle me-1"></i>
                                <strong>Service Note:</strong> ${serviceNote}
                            </div>
                        ` : ''}
                        <div class="d-flex justify-content-between align-items-center pt-2 mt-1 border-top border-secondary border-opacity-25 small fw-bold">
                            <span class="text-secondary">Vehicle Total:</span>
                            <span class="text-speed-blue font-monospace fs-6">₱${vTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span>
                        </div>
                    </div>
                `;
            });

            if (previewContainer) {
                previewContainer.innerHTML = receiptHTML || '<p class="text-secondary small mb-0">No vehicle details or services selected yet.</p>';
            }

            const previewTotal = document.getElementById('previewTotal');
            if (previewTotal) {
                previewTotal.textContent = '₱' + grandTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }

            const vehiclesHeaderSummary = document.getElementById('vehiclesHeaderSummary');
            if (vehiclesHeaderSummary) {
                vehiclesHeaderSummary.textContent = `(${vehicleCards.length} vehicle${vehicleCards.length > 1 ? 's' : ''})`;
            }
        }

        // --- BRAND TO MODEL DROPDOWN POPULATOR BASED ON vehicle_models TABLE DATA ---
        function updateModelDropdown(brandSelect) {
            const card = brandSelect.closest('.vehicle-card');
            const modelSelect = card.querySelector('.model-select');
            const yearSelect = card.querySelector('.year-select');

            if (!modelSelect) return;

            const brand = brandSelect.value;
            modelSelect.innerHTML = '<option value="" disabled selected>Select Model</option>';

            // Reset Year Dropdown until a model is selected
            if (yearSelect) {
                yearSelect.innerHTML = '<option value="" disabled selected>Select Model First</option>';
                yearSelect.disabled = true;
            }

            let models = [];

            // Retrieve from DB data variable if available (supports both grouped and flat collection)
            if (window.VEHICLE_MODELS) {
                if (Array.isArray(window.VEHICLE_MODELS) && window.VEHICLE_MODELS.length > 0) {
                    models = window.VEHICLE_MODELS.filter(m => m.brand === brand);
                } else if (typeof window.VEHICLE_MODELS === 'object' && window.VEHICLE_MODELS[brand]) {
                    models = window.VEHICLE_MODELS[brand];
                }
            }

            // Fallback to DEFAULT_MODELS if empty
            if ((!models || models.length === 0) && DEFAULT_MODELS[brand]) {
                models = DEFAULT_MODELS[brand];
            }

            if (models && models.length > 0) {
                models.forEach(m => {
                    const opt = document.createElement('option');
                    let name = typeof m === 'object' ? (m.name || m.vehicle_model || '') : m;
                    let vType = typeof m === 'object' ? (m.vehicle_type || m.type || '') : '';
                    let yStart = typeof m === 'object' ? (m.year_start || m.start_year || 1990) : 1990;
                    let yEnd = typeof m === 'object' ? (m.year_end || m.end_year || new Date().getFullYear()) : new Date().getFullYear();

                    opt.value = name;
                    opt.textContent = name;
                    if (vType) opt.setAttribute('data-type', vType);
                    opt.setAttribute('data-year-start', yStart);
                    opt.setAttribute('data-year-end', yEnd);

                    modelSelect.appendChild(opt);
                });
                modelSelect.disabled = false;
            } else {
                const opt = document.createElement('option');
                opt.value = 'Other';
                opt.textContent = 'Other / Custom';
                modelSelect.appendChild(opt);
                modelSelect.disabled = false;
            }
        }

        // --- CUSTOMER INFORMATION PREVIEW ---
        function updateCustomerPreview() {
            const custName = customerNameInput?.value.trim() || '---';
            const custPhone = customerPhoneInput?.value.trim() || '---';
            
            const previewCustomer = document.getElementById('previewCustomer');
            const previewPhone = document.getElementById('previewPhone');

            if (previewCustomer) previewCustomer.textContent = custName;
            if (previewPhone) previewPhone.textContent = custPhone;
        }

        if (customerNameInput) customerNameInput.addEventListener('input', updateCustomerPreview);
        if (customerPhoneInput) customerPhoneInput.addEventListener('input', updateCustomerPreview);

        // --- TRACKING CODE GENERATOR BUTTON WITH VALIDATION ---
        if (generateCodeBtn) {
            generateCodeBtn.addEventListener('click', function() {
                if (!validateVehicleServiceInfo()) {
                    return;
                }

                const newCode = generateTrackingCode();
                if (trackingCodeInput) trackingCodeInput.value = newCode;
                if (previewCode) previewCode.textContent = newCode;
            });
        }

        // --- FORM SUBMIT INTERCEPTOR TO VALIDATE AND ENABLE DISABLED FIELDS ---
        if (serviceRegistrationForm) {
            serviceRegistrationForm.addEventListener('submit', function(e) {
                if (!validateVehicleServiceInfo()) {
                    e.preventDefault();
                    return false;
                }

                // Auto-generate tracking code if empty
                if (trackingCodeInput && !trackingCodeInput.value.trim()) {
                    const newCode = generateTrackingCode();
                    trackingCodeInput.value = newCode;
                    if (previewCode) previewCode.textContent = newCode;
                }

                // Enable all disabled selects inside vehicle cards so HTML posts their values
                document.querySelectorAll('.vehicle-card select:disabled').forEach(s => {
                    s.disabled = false;
                });
            });
        }

        // --- UPDATE CARD HEADER DISPLAY ---
        function updateVehicleCardHeader(card) {
            const plate = (card.querySelector('.plate-input')?.value || '').trim().toUpperCase();
            const brand = card.querySelector('.brand-select')?.value || '';
            const model = card.querySelector('.model-select')?.value || '';
            const statusLabel = card.querySelector('.vehicle-status-label');

            if (statusLabel) {
                const titleParts = [brand, model, plate].filter(Boolean);
                if (titleParts.length > 0) {
                    statusLabel.textContent = titleParts.join(' · ');
                    statusLabel.classList.remove('text-secondary');
                    statusLabel.classList.add('text-speed-blue', 'fw-bold');
                } else {
                    statusLabel.textContent = 'Not yet filled';
                    statusLabel.classList.remove('text-speed-blue', 'fw-bold');
                    statusLabel.classList.add('text-secondary');
                }
            }
        }

        // --- REINDEX FORM INPUT ATTRIBUTES AND COLLAPSE TARGETS ---
        function reindexVehicleCards() {
            const cards = document.querySelectorAll('.vehicle-card');
            cards.forEach((card, index) => {
                card.setAttribute('data-vehicle-index', index);
                
                const badge = card.querySelector('.vehicle-number-badge');
                if (badge) badge.textContent = index + 1;

                const removeBtn = card.querySelector('.remove-vehicle-btn');
                if (removeBtn) {
                    if (cards.length > 1) {
                        removeBtn.classList.remove('d-none');
                    } else {
                        removeBtn.classList.add('d-none');
                    }
                }

                const collapseTrigger = card.querySelector('.vehicle-collapse-trigger');
                const collapseBody = card.querySelector('.vehicle-collapse-body');
                const targetId = `vehicleCollapse_${index}`;

                if (collapseTrigger && collapseBody) {
                    collapseBody.setAttribute('id', targetId);
                    collapseTrigger.setAttribute('data-bs-target', `#${targetId}`);
                    collapseTrigger.setAttribute('aria-controls', targetId);
                }

                card.querySelectorAll('[name]').forEach(input => {
                    const oldName = input.getAttribute('name');
                    if (oldName) {
                        const newName = oldName.replace(/vehicles\[\d+\]/, `vehicles[${index}]`);
                        input.setAttribute('name', newName);
                    }
                });

                card.querySelectorAll('[id]').forEach(elem => {
                    const oldId = elem.getAttribute('id');
                    if (oldId && oldId.startsWith('v') && !elem.classList.contains('vehicle-collapse-body')) {
                        const newId = oldId.replace(/^v\d+_/, `v${index}_`);
                        elem.setAttribute('id', newId);
                    }
                });

                card.querySelectorAll('label[for]').forEach(elem => {
                    const oldFor = elem.getAttribute('for');
                    if (oldFor && oldFor.startsWith('v')) {
                        const newFor = oldFor.replace(/^v\d+_/, `v${index}_`);
                        elem.setAttribute('for', newFor);
                    }
                });
            });
        }

        // --- ATTACH ALL DOM EVENTS TO A VEHICLE CARD ---
        function attachVehicleEvents(card) {
            const typeSelect = card.querySelector('.type-select');
            const brandSelect = card.querySelector('.brand-select');
            const modelSelect = card.querySelector('.model-select');
            const yearSelect = card.querySelector('.year-select');
            const plateInput = card.querySelector('.plate-input');
            const mechanicSelect = card.querySelector('.mechanic-select');
            const searchInput = card.querySelector('.service-search-input');
            const serviceNoteInput = card.querySelector('.price-adjustment-note-input');

            if (typeSelect) {
                typeSelect.addEventListener('change', function() {
                    filterOptionsByVehicleType(card);
                    updateVehicleCardHeader(card);
                });
            }

            if (brandSelect) {
                brandSelect.addEventListener('change', function() {
                    updateModelDropdown(brandSelect);
                    updateVehicleCardHeader(card);
                    calculateGrandTotal();
                });
            }

            // AUTO-SELECT VEHICLE TYPE & POPULATE ACCURATE YEARS WHEN MODEL IS SELECTED
            if (modelSelect) {
                modelSelect.addEventListener('change', function() {
                    const selectedOpt = modelSelect.options[modelSelect.selectedIndex];
                    const autoType = selectedOpt ? selectedOpt.getAttribute('data-type') : null;

                    if (autoType && typeSelect) {
                        setVehicleTypeSelect(typeSelect, autoType);
                    }

                    // Dynamically update Year dropdown based on model range from vehicle_models schema
                    if (yearSelect && selectedOpt) {
                        const yStart = parseInt(selectedOpt.getAttribute('data-year-start')) || 1990;
                        const yEnd = parseInt(selectedOpt.getAttribute('data-year-end')) || new Date().getFullYear();

                        yearSelect.innerHTML = '<option value="" disabled selected>Select Year</option>';
                        for (let y = yEnd; y >= yStart; y--) {
                            const opt = document.createElement('option');
                            opt.value = y;
                            opt.textContent = y;
                            yearSelect.appendChild(opt);
                        }
                        yearSelect.disabled = false;
                    }

                    updateVehicleCardHeader(card);
                    calculateGrandTotal();
                });
            }

            if (plateInput) {
                plateInput.addEventListener('input', function() {
                    updateVehicleCardHeader(card);
                    calculateGrandTotal();
                });
            }

            if (mechanicSelect) {
                mechanicSelect.addEventListener('change', function() {
                    calculateGrandTotal();
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    filterOptionsByVehicleType(card);
                });
            }

            if (serviceNoteInput) {
                serviceNoteInput.addEventListener('input', function() {
                    calculateGrandTotal();
                });
            }

            // Sync parent service checkbox when toggling checkbox directly
            card.querySelectorAll('.service-checkbox').forEach(cb => {
                cb.addEventListener('change', function() {
                    const parentServiceCard = cb.closest('.service-card-item');
                    if (parentServiceCard && !cb.checked) {
                        parentServiceCard.querySelectorAll('.service-option-input').forEach(opt => {
                            opt.checked = false;
                        });
                    }
                    calculateVehicleTotal(card);
                    calculateGrandTotal();
                });
            });

            // Auto-check parent service checkbox when selecting a subservice option
            card.querySelectorAll('.service-option-input').forEach(opt => {
                opt.addEventListener('change', function() {
                    const parentServiceCard = opt.closest('.service-card-item');
                    if (parentServiceCard) {
                        const parentCb = parentServiceCard.querySelector('.service-checkbox');
                        if (parentCb && !parentCb.checked) {
                            parentCb.checked = true;
                        }
                    }
                    calculateVehicleTotal(card);
                    calculateGrandTotal();
                });
            });

            const removeBtn = card.querySelector('.remove-vehicle-btn');
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    card.remove();
                    reindexVehicleCards();
                    calculateGrandTotal();
                });
            }
        }

        // --- DYNAMIC ADD VEHICLE CARD BUTTON ---
        if (addVehicleBtn) {
            addVehicleBtn.addEventListener('click', function() {
                const firstCard = document.querySelector('.vehicle-card');
                if (!firstCard) return;

                document.querySelectorAll('.vehicle-card').forEach(existingCard => {
                    const collapseBody = existingCard.querySelector('.vehicle-collapse-body');
                    if (collapseBody && collapseBody.classList.contains('show')) {
                        const bsCollapse = bootstrap.Collapse.getInstance(collapseBody) || new bootstrap.Collapse(collapseBody, { toggle: false });
                        bsCollapse.hide();
                    }
                });

                const newCard = firstCard.cloneNode(true);

                newCard.querySelectorAll('input[type="text"], input[type="number"], textarea').forEach(input => {
                    if (input.classList.contains('service-price-input') || input.classList.contains('vehicle-total-cost-input')) {
                        input.value = '0.00';
                    } else {
                        input.value = '';
                    }
                });

                const newPlateInput = newCard.querySelector('.plate-input');
                if (newPlateInput) newPlateInput.value = '';

                newCard.querySelectorAll('select').forEach(select => {
                    select.selectedIndex = 0;
                    if (select.classList.contains('model-select')) {
                        select.disabled = true;
                        select.innerHTML = '<option value="" disabled selected>Select Brand First</option>';
                    }
                    if (select.classList.contains('year-select')) {
                        select.disabled = true;
                        select.innerHTML = '<option value="" disabled selected>Select Model First</option>';
                    }
                });

                newCard.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(chk => {
                    chk.checked = false;
                });

                newCard.querySelectorAll('.service-options-panel').forEach(panel => {
                    panel.classList.add('d-none');
                });

                const statusLabel = newCard.querySelector('.vehicle-status-label');
                if (statusLabel) {
                    statusLabel.textContent = 'Not yet filled';
                    statusLabel.classList.remove('text-speed-blue', 'fw-bold');
                    statusLabel.classList.add('text-secondary');
                }

                const newCollapseBody = newCard.querySelector('.vehicle-collapse-body');
                if (newCollapseBody) {
                    newCollapseBody.classList.add('show');
                }

                vehiclesContainer.appendChild(newCard);

                reindexVehicleCards();
                attachVehicleEvents(newCard);
                filterOptionsByVehicleType(newCard);
                calculateGrandTotal();

                newCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        }

        // --- INITIALIZATION ON PAGE LOAD ---
        document.querySelectorAll('.vehicle-card').forEach(card => {
            attachVehicleEvents(card);
            filterOptionsByVehicleType(card);
        });

        updateCustomerPreview();
        calculateGrandTotal();
    });
</script>
</body>
</html>