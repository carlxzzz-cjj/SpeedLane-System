<!-- ========================================================================= -->
<!-- FILE LOCATION: resources/views/admin/update.blade.php                      -->
<!-- ========================================================================= -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Early Theme Check Script (Defaults to Light Theme) -->
    <script>
        const savedTheme = localStorage.getItem('speedlane_theme');
        // Default to Light Mode unless explicitly set to 'dark'
        if (savedTheme !== 'dark') {
            document.documentElement.classList.add('light-theme');
        } else {
            document.documentElement.classList.remove('light-theme');
        }
    </script>

    <title>SpeedLane - Service Progress Updates</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    
    <!-- Custom Admin CSS -->
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

        /* Dedicated Plate Number Badge */
        .badge-plate {
            background-color: #0f172a !important;
            color: #ffffff !important;
            border: 1px solid #334155 !important;
            font-weight: 700;
            letter-spacing: 0.5px;
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            padding: 0.35em 0.65em;
            display: inline-block;
            border-radius: 0.375rem;
        }

        /* Role Badge Styling */
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

        /* Status Badge Styling (High-Contrast Theme Design) */
        .badge-queued {
            background-color: rgba(255, 193, 7, 0.18) !important;
            color: #ffda6a !important;
            border: 1px solid rgba(255, 193, 7, 0.5) !important;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-completed {
            background-color: rgba(25, 135, 84, 0.18) !important;
            color: #75b798 !important;
            border: 1px solid rgba(25, 135, 84, 0.5) !important;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-in-progress {
            background-color: rgba(0, 162, 255, 0.18) !important;
            color: #99dbff !important;
            border: 1px solid rgba(0, 162, 255, 0.5) !important;
            font-weight: 600;
            letter-spacing: 0.3px;
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

        /* Gradient Submit / Action Buttons */
        .btn-speed-gradient {
            background: linear-gradient(90deg, var(--speed-pink) 0%, var(--speed-blue) 100%);
            border: none;
            color: #ffffff !important;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(244, 37, 130, 0.3);
        }

        .btn-speed-gradient * {
            color: #ffffff !important;
        }

        .btn-speed-gradient:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 162, 255, 0.4);
            color: #ffffff !important;
        }

        /* Form Controls Dark & Label Styling */
        .filter-label {
            color: #cbd5e1 !important;
            font-size: 0.8rem;
            font-weight: 600;
        }

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

        .form-control-dark[readonly], .form-control-dark:disabled, .form-select-dark:disabled {
            background-color: rgba(255, 255, 255, 0.03) !important;
            color: #64748b !important;
            border-color: rgba(255, 255, 255, 0.05) !important;
        }

        .input-group-text-dark {
            background-color: #090c14 !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-right: none !important;
            color: #94a3b8 !important;
        }

        .input-group .form-control-dark, .input-group .form-select-dark {
            border-left: none !important;
        }

        /* Modal Content Dark */
        .modal-content-dark {
            background-color: var(--speed-card-bg);
            border: 1px solid var(--speed-card-border);
            color: #e2e8f0;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.85);
        }

        /* Custom Dark Table Styling */
        .table-dark-custom {
            --bs-table-bg: transparent;
            --bs-table-color: #e2e8f0;
            --bs-table-hover-bg: rgba(255, 255, 255, 0.02);
            --bs-table-border-color: rgba(255, 255, 255, 0.08);
        }

        .table-dark-custom thead th {
            background-color: #06080d;
            color: #94a3b8;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--speed-card-border);
            padding: 1rem 0.75rem;
        }

        .table-dark-custom td {
            padding: 0.85rem 0.75rem;
            border-bottom: 1px solid var(--speed-card-border);
        }

        /* Nested Dark Cards */
        .card-dark-nested {
            background-color: #06080d !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        .card-dark-item {
            background-color: #0c0f18 !important;
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
        }

        /* Logout Button */
        .btn-logout {
            color: #ff6b81 !important;
            border: 1px solid rgba(255, 107, 129, 0.4) !important;
            background: rgba(255, 107, 129, 0.05);
            transition: all 0.25s ease;
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

        /* LIGHT MODE HIGH-CONTRAST OVERRIDES */
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

        /* Clear Readable Badges in Light Mode */
        html.light-theme .badge-queued {
            background-color: #fef3c7 !important;
            color: #b45309 !important;
            border: 1px solid #fde68a !important;
            font-weight: 700 !important;
        }

        html.light-theme .badge-completed {
            background-color: #dcfce7 !important;
            color: #15803d !important;
            border: 1px solid #86efac !important;
            font-weight: 700 !important;
        }

        html.light-theme .badge-in-progress {
            background-color: #e0f2fe !important;
            color: #0369a1 !important;
            border: 1px solid #7dd3fc !important;
            font-weight: 700 !important;
        }

        html.light-theme .badge-plate {
            background-color: #0f172a !important;
            color: #ffffff !important;
            border: 1px solid #334155 !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12);
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

        /* Action Buttons High Contrast in Light Mode */
        html.light-theme .btn-speed-gradient,
        html.light-theme .btn-speed-gradient * {
            color: #ffffff !important;
        }

        html.light-theme .btn-speed-gradient {
            box-shadow: 0 4px 14px rgba(244, 37, 130, 0.3) !important;
        }

        html.light-theme .btn-outline-info {
            color: #0284c7 !important;
            border-color: #0284c7 !important;
            background-color: rgba(2, 132, 199, 0.08) !important;
            font-weight: 600 !important;
        }

        html.light-theme .btn-outline-info:hover {
            background-color: #0284c7 !important;
            color: #ffffff !important;
        }

        html.light-theme .btn-outline-info:hover * {
            color: #ffffff !important;
        }

        /* Clear Readable Logout Button in Light Mode */
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

        /* Clear Readable Theme Toggle Button in Light Mode */
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

        html.light-theme .filter-label {
            color: #334155 !important;
            opacity: 1 !important;
        }

        html.light-theme .form-control-dark, 
        html.light-theme .form-select-dark {
            background-color: #f1f5f9 !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
        }

        html.light-theme .input-group-text-dark {
            background-color: #e2e8f0 !important;
            border: 1px solid #cbd5e1 !important;
            border-right: none !important;
            color: #475569 !important;
        }

        html.light-theme .modal-content-dark {
            background-color: #ffffff !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            color: #0f172a !important;
        }

        html.light-theme .modal-title {
            color: #0f172a !important;
        }

        html.light-theme .table-dark-custom {
            --bs-table-color: #0f172a;
            --bs-table-hover-bg: rgba(0, 0, 0, 0.02);
            --bs-table-border-color: rgba(0, 0, 0, 0.08);
        }

        html.light-theme .table-dark-custom thead th {
            background-color: #f1f5f9;
            color: #475569;
        }

        html.light-theme .card-dark-nested {
            background-color: #f8fafc !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
        }

        html.light-theme .card-dark-item {
            background-color: #ffffff !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
        }

        html.light-theme h3,
        html.light-theme h4,
        html.light-theme h5,
        html.light-theme h6,
        html.light-theme .modal-title {
            color: #0f172a !important;
        }

        html.light-theme .table-dark-custom td.text-white,
        html.light-theme .table-dark-custom td .text-white,
        html.light-theme .modal-body .text-white,
        html.light-theme .card-dark-nested .text-white {
            color: #0f172a !important;
        }

        /* Explicitly keep white text for gradient buttons, plate badges, and brand icons in light mode */
        html.light-theme .btn-speed-gradient,
        html.light-theme .btn-speed-gradient *,
        html.light-theme .badge-plate,
        html.light-theme .badge-plate *,
        html.light-theme .bg-speed-pink,
        html.light-theme .bg-speed-pink * {
            color: #ffffff !important;
        }

        html.light-theme .btn-outline-secondary {
            color: #475569 !important;
            border-color: #cbd5e1 !important;
        }

        html.light-theme .btn-outline-secondary:hover {
            background-color: #e2e8f0 !important;
            color: #0f172a !important;
        }

        html.light-theme .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(50%);
        }
    </style>
</head>
<body>

    <!-- Top Navigation Header -->
    <header class="navbar navbar-expand-lg navbar-dark navbar-speed px-4 py-2 sticky-top">
        <div class="container-fluid">
            
            <!-- Brand Logo & App Subtitle -->
            <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('admin.dashboard') }}">
                <div class="bg-speed-pink text-white p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="bi bi-car-front-fill fs-6"></i>
                </div>
                <div>
                    <span class="brand-logo-text d-block">
                        <span class="text-speed-pink">SPEED</span><span class="text-speed-blue">LANE</span>
                    </span>
                    <span class="brand-subtext d-block">SERVICE UPDATES</span>
                </div>
            </a>

            <!-- Right Nav Alignment -->
            <div class="d-flex align-items-center gap-3 ms-auto">
                @if(auth()->check() && auth()->user()->isSuperAdmin())
                    <span class="badge badge-super-admin px-3 py-2 rounded-pill">
                        <i class="bi bi-shield-check me-1"></i> Super Admin
                    </span>
                @else
                    <span class="badge badge-admin px-3 py-2 rounded-pill">
                        <i class="bi bi-person-badge me-1"></i> Admin
                    </span>
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
            
            <!-- Sidebar Navigation Menu -->
            <aside class="col-md-3 col-lg-2 admin-sidebar min-vh-100 p-3">
                <nav class="nav flex-column gap-2">
                    <a class="nav-link admin-nav-link rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-grid-fill text-speed-pink"></i> Dashboard
                    </a>
                    <a class="nav-link admin-nav-link rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.register-service') }}">
                        <i class="bi bi-plus-circle text-speed-blue"></i> Register Service
                    </a>
                    <a class="nav-link admin-nav-link active rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.update') }}">
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
                
                <!-- Page Title Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="fw-bold text-white mb-1">Update Service Status</h3>
                        <p class="text-secondary mb-0">Track active customer services, edit stage progress & prices, and archive completed services.</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 bg-success bg-opacity-20 text-white border-success" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @php
                    // Dynamic extraction of Vehicle Types, Vehicle Brands, and Services from active queue records combined with full defaults
                    $extractedTypes = collect();
                    $extractedBrands = collect();
                    $extractedServices = collect();

                    if (isset($services)) {
                        foreach ($services as $srvItem) {
                            $vList = $srvItem->vehicles ?? collect();
                            if ($vList->count() > 0) {
                                foreach ($vList as $vObj) {
                                    $t = $vObj->vehicle_type ?? $vObj->type ?? '';
                                    if (!empty($t)) $extractedTypes->push($t);

                                    $b = $vObj->vehicle_brand ?? $vObj->brand ?? $vObj->vehicle_make ?? '';
                                    if (!empty($b)) $extractedBrands->push($b);

                                    $sRaw = is_array($vObj->selected_services) ? $vObj->selected_services : (is_string($vObj->selected_services) ? json_decode($vObj->selected_services, true) : []);
                                    if (is_array($sRaw)) {
                                        foreach ($sRaw as $sr) {
                                            $sName = is_array($sr) ? ($sr['name'] ?? $sr['service_name'] ?? '') : (string)$sr;
                                            if (!empty($sName)) $extractedServices->push($sName);
                                        }
                                    }
                                }
                            } else {
                                $t = $srvItem->vehicle_type ?? $srvItem->type ?? '';
                                if (!empty($t)) $extractedTypes->push($t);

                                $b = $srvItem->vehicle_brand ?? $srvItem->brand ?? $srvItem->vehicle_make ?? '';
                                if (!empty($b)) $extractedBrands->push($b);

                                $sRaw = is_array($srvItem->selected_services) ? $srvItem->selected_services : (is_string($srvItem->selected_services) ? json_decode($srvItem->selected_services, true) : []);
                                if (is_array($sRaw)) {
                                    foreach ($sRaw as $sr) {
                                        $sName = is_array($sr) ? ($sr['name'] ?? $sr['service_name'] ?? '') : (string)$sr;
                                        if (!empty($sName)) $extractedServices->push($sName);
                                    }
                                }
                            }
                        }
                    }

                    $defaultTypes = ['Hatchback', 'Sedan', 'Coupe', 'Crossover', 'MPV', 'Wagon', 'SUV', 'Pickup Truck', 'Sports Car', 'Van', 'Supercar'];
                    $defaultBrands = ['Toyota', 'Honda', 'Mitsubishi', 'Nissan', 'Ford', 'Hyundai', 'Suzuki', 'Isuzu', 'Mazda', 'BMW', 'Mercedes-Benz', 'Audi', 'Lexus', 'Porsche', 'Chevrolet', 'Kia', 'Subaru', 'Volkswagen', 'Jeep', 'Land Rover', 'Dodge', 'Tesla', 'Geely', 'MG', 'Changan', 'BYD'];
                    $defaultServices = ['Ceramic Coating', 'Graphene Coating', 'PPF', 'Interior Detailing', 'Exterior Detailing', 'Washover', 'Undercoat', 'Engine Bay Detailing', 'Glass Detailing', 'Headlight Restoration', 'Paint Correction', 'Basic Wash', 'Premium Wash', 'Wheel & Rim Detailing'];

                    $vTypesList = (isset($vehicleTypes) && count($vehicleTypes) > 0) 
                        ? $vehicleTypes 
                        : $extractedTypes->merge($defaultTypes)->unique()->filter()->values();

                    $vBrandsList = (isset($vehicleBrands) && count($vehicleBrands) > 0) 
                        ? $vehicleBrands 
                        : ((isset($brands) && count($brands) > 0) ? $brands : $extractedBrands->merge($defaultBrands)->unique()->filter()->values());

                    $vServicesList = (isset($availableServices) && count($availableServices) > 0) 
                        ? $availableServices 
                        : $extractedServices->merge($defaultServices)->unique()->filter()->values();
                @endphp

                <!-- Dynamic Search and Filter Bar -->
                <div class="card speed-card rounded-4 p-3 mb-4">
                    <form method="GET" action="{{ route('admin.update') }}" id="searchFilterForm">
                        <div class="row g-2">
                            <div class="col-md-3">
                                <label class="form-label filter-label mb-1">Search Records</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text input-group-text-dark text-secondary"><i class="bi bi-search"></i></span>
                                    <input type="text" name="search" id="transactionSearchInput" class="form-control form-control-sm form-control-dark" placeholder="Customer, mechanic, plate, code..." value="{{ request('search') }}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label filter-label mb-1">Vehicle Type</label>
                                <select name="vehicle_type" id="filterVehicleType" class="form-select form-select-sm form-select-dark">
                                    <option value="">All Vehicles</option>
                                    @foreach($vTypesList as $vType)
                                        @php 
                                            $vTypeName = is_object($vType) ? ($vType->vehicle_type ?? $vType->name ?? '') : (is_array($vType) ? ($vType['vehicle_type'] ?? $vType['name'] ?? '') : $vType); 
                                        @endphp
                                        @if(!empty(trim($vTypeName)))
                                            <option value="{{ $vTypeName }}" {{ request('vehicle_type') == $vTypeName ? 'selected' : '' }}>{{ $vTypeName }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label filter-label mb-1">Vehicle Brand</label>
                                <select name="brand" id="filterBrand" class="form-select form-select-sm form-select-dark">
                                    <option value="">All Brands</option>
                                    @foreach($vBrandsList as $b)
                                        @php 
                                            $bName = is_object($b) ? ($b->brand ?? $b->name ?? '') : (is_array($b) ? ($b['brand'] ?? $b['name'] ?? '') : $b); 
                                        @endphp
                                        @if(!empty(trim($bName)))
                                            <option value="{{ $bName }}" {{ (request('brand') == $bName || request('vehicle_brand') == $bName) ? 'selected' : '' }}>{{ $bName }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label filter-label mb-1">Service Type</label>
                                <select name="service_type" id="filterServiceType" class="form-select form-select-sm form-select-dark">
                                    <option value="">All Services</option>
                                    @foreach($vServicesList as $srv)
                                        @php $srvName = is_object($srv) ? ($srv->name ?? '') : (is_array($srv) ? ($srv['name'] ?? '') : $srv); @endphp
                                        @if(!empty(trim($srvName)))
                                            <option value="{{ $srvName }}" {{ request('service_type') == $srvName ? 'selected' : '' }}>
                                                {{ $srvName }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-1">
                                <label class="form-label filter-label mb-1">Date</label>
                                <input type="date" name="date" id="filterDate" class="form-control form-control-sm form-control-dark" value="{{ request('date') }}">
                            </div>

                            <div class="col-md-2 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-speed-gradient btn-sm rounded-3 w-100 fw-semibold">
                                    <i class="bi bi-funnel"></i> Filter
                                </button>
                                <a href="{{ route('admin.update') }}" id="resetFilterBtn" class="btn btn-outline-light btn-sm rounded-3 px-3" title="Reset Filters">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Main Service Table Card -->
                <div class="card speed-card rounded-4 p-4">
                    <div class="table-responsive">
                        <table class="table align-middle table-dark-custom mb-0" id="servicesTable">
                            <thead>
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
                                            if (is_array($prop)) return $prop;
                                            if (is_string($prop) && !empty($prop)) {
                                                $decoded = json_decode($prop, true);
                                                return is_array($decoded) ? $decoded : [];
                                            }
                                            return [];
                                        };

                                        $rawSelectedServices = $parseProp($service->selected_services);
                                        $rawPrices = $parseProp($service->selected_services_prices);

                                        $normalizeServiceItems = function($servicesArr) {
                                            $items = [];
                                            if (!is_array($servicesArr)) return $items;
                                            foreach ($servicesArr as $srv) {
                                                if (is_array($srv)) {
                                                    $items[] = [
                                                        'name'   => trim($srv['name'] ?? $srv['service_name'] ?? 'Service'),
                                                        'status' => trim($srv['status'] ?? 'Pending Queue'),
                                                        'note'   => trim($srv['note'] ?? $srv['status_note'] ?? '')
                                                    ];
                                                } elseif (is_string($srv) && !empty($srv)) {
                                                    $items[] = [
                                                        'name'   => trim($srv),
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
                                                $vTotalCost = $calcTotal($vRawServices, $vPricesMap, $v->total_cost ?? 0);

                                                $vPriceAdj = floatval($v->price_adjustment ?? $v->price_adjustment_amount ?? $service->price_adjustment ?? $service->price_adjustment_amount ?? 0);
                                                if ($vPriceAdj == 0 && !empty($vPricesMap)) {
                                                    $rawSum = array_sum(array_map('floatval', (array)$vPricesMap));
                                                    if ($rawSum > 0 && $vTotalCost > 0 && abs($rawSum - $vTotalCost) > 0.001) {
                                                        $vPriceAdj = $vTotalCost - $rawSum;
                                                    }
                                                }

                                                $formattedVehicles[] = [
                                                    'plate_number'           => $v->plate_number ?? 'N/A',
                                                    'vehicle_make'           => $v->vehicle_brand ?? $v->brand ?? $v->vehicle_make ?? '',
                                                    'vehicle_model'          => $v->vehicle_model ?? $v->model ?? '',
                                                    'vehicle_type'           => $v->vehicle_type ?? $v->type ?? '',
                                                    'vehicle_year'           => $v->vehicle_year ?? $v->year ?? '',
                                                    'mechanic_assigned'      => $v->mechanic_assigned ?? 'Unassigned',
                                                    'service_items'          => $vServiceItems,
                                                    'selected_services_prices' => $vPricesMap,
                                                    'price_adjustment_note'  => $v->price_adjustment_note ?? $service->price_adjustment_note ?? '',
                                                    'price_adjustment'       => $vPriceAdj,
                                                    'total_cost'             => $vTotalCost
                                                ];
                                            }
                                        } else {
                                            $rootPricesMap = $normalizePricesMap($rawSelectedServices, $rawPrices);
                                            $rootTotalCost = $calcTotal($rawSelectedServices, $rootPricesMap, $service->total_cost ?? 0);

                                            $rootPriceAdj = floatval($service->price_adjustment ?? $service->price_adjustment_amount ?? 0);
                                            if ($rootPriceAdj == 0 && !empty($rootPricesMap)) {
                                                $rawSum = array_sum(array_map('floatval', (array)$rootPricesMap));
                                                if ($rawSum > 0 && $rootTotalCost > 0 && abs($rawSum - $rootTotalCost) > 0.001) {
                                                    $rootPriceAdj = $rootTotalCost - $rawSum;
                                                }
                                            }

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
                                                'price_adjustment'       => $rootPriceAdj,
                                                'total_cost'             => $rootTotalCost
                                            ];
                                        }

                                        $overallGrandTotal = $calcTotal($rawSelectedServices, $normalizePricesMap($rawSelectedServices, $rawPrices), $service->total_cost ?? 0);
                                        $formattedDate = \Carbon\Carbon::parse($service->created_at)->format('M d, Y h:i A');

                                        // Status calculation logic
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
                                            $statusBadgeClass = 'badge-queued';
                                        } elseif ($isAllCompleted) {
                                            $statusLabel = 'Completed';
                                            $statusBadgeClass = 'badge-completed';
                                        } else {
                                            $statusLabel = 'In Progress';
                                            $statusBadgeClass = 'badge-in-progress';
                                        }

                                        // Data values for row-level filtering
                                        $rowTypesArr = [];
                                        $rowBrandsArr = [];
                                        $rowServicesArr = [];

                                        foreach ($formattedVehicles as $fVeh) {
                                            if (!empty($fVeh['vehicle_type'])) $rowTypesArr[] = $fVeh['vehicle_type'];
                                            if (!empty($fVeh['vehicle_make'])) $rowBrandsArr[] = $fVeh['vehicle_make'];
                                            foreach ($fVeh['service_items'] as $fSrv) {
                                                if (!empty($fSrv['name'])) $rowServicesArr[] = $fSrv['name'];
                                            }
                                        }

                                        $rowTypesStr = implode('||', array_unique($rowTypesArr));
                                        $rowBrandsStr = implode('||', array_unique($rowBrandsArr));
                                        $rowServicesStr = implode('||', array_unique($rowServicesArr));
                                        $rowDateYmd = \Carbon\Carbon::parse($service->created_at)->format('Y-m-d');
                                    @endphp

                                    <tr class="service-table-row"
                                        data-vehicle-types="{{ strtolower($rowTypesStr) }}"
                                        data-brands="{{ strtolower($rowBrandsStr) }}"
                                        data-service-types="{{ strtolower($rowServicesStr) }}"
                                        data-date="{{ $rowDateYmd }}"
                                        data-order-json="{{ json_encode([
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
                                        <td class="fw-bold text-speed-blue">{{ $service->tracking_code }}</td>
                                        <td class="fw-semibold text-white">{{ $service->customer_name }}</td>
                                        <td class="text-secondary">{{ $contactPhone }}</td>
                                        <td class="text-secondary">{{ $vehicleSummary }}</td>
                                        <td><span class="badge badge-plate">{{ $plates }}</span></td>
                                        <td class="text-secondary">{{ $mechanics ?: 'Unassigned' }}</td>
                                        <td>
                                            <div class="text-white">{{ \Carbon\Carbon::parse($service->created_at)->format('M d, Y') }}</div>
                                            <small class="text-secondary">{{ \Carbon\Carbon::parse($service->created_at)->format('h:i A') }}</small>
                                        </td>

                                        <td>
                                            <span class="badge {{ $statusBadgeClass }} px-2.5 py-1.5 fs-7">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>

                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-1">
                                                <!-- View Details Action Button -->
                                                <button class="btn btn-outline-info btn-sm px-2 open-info-btn" title="View Full Record Info">
                                                    <i class="bi bi-eye-fill me-1"></i> View Info
                                                </button>

                                                <!-- Update Status Action Button -->
                                                <button class="btn btn-speed-gradient btn-sm px-2" data-bs-toggle="modal" data-bs-target="#updateModal{{ $service->id }}" title="Update Progress & Final Price">
                                                    <i class="bi bi-pencil-square me-1"></i> Update
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal: Update Service Progress Stages & Costs -->
                                    <div class="modal fade update-service-modal" id="updateModal{{ $service->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content modal-content-dark rounded-4">
                                                <div class="modal-header border-bottom-0 pb-2">
                                                    <h5 class="modal-title fw-bold text-white">
                                                        <i class="bi bi-arrow-repeat text-speed-pink me-2"></i>Update Progress: <span class="text-speed-blue">{{ $service->tracking_code }}</span>
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.update-status', $service->id) }}" method="POST" class="update-service-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body p-4">
                                                        
                                                        <div class="alert alert-info py-2 px-3 small rounded-3 mb-3 bg-info bg-opacity-10 text-info border border-info border-opacity-25 d-flex align-items-center gap-2">
                                                            <i class="bi bi-info-circle-fill fs-5"></i>
                                                            <span>Customer: <strong>{{ $service->customer_name }}</strong> | Tracking Code: <strong>{{ $service->tracking_code }}</strong></span>
                                                        </div>

                                                        @foreach($formattedVehicles as $vIdx => $vData)
                                                            <div class="card-dark-nested rounded-3 p-3 mb-3">
                                                                <div class="fw-bold text-white mb-2 d-flex justify-content-between align-items-center">
                                                                    <span><i class="bi bi-car-front text-speed-blue me-1"></i> Vehicle: {{ implode(' ', array_filter([$vData['vehicle_make'], $vData['vehicle_model']])) }}</span>
                                                                    <span class="badge badge-plate">{{ $vData['plate_number'] }}</span>
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
                                                                                'Completed & Ready for Pick Up'
                                                                            ];
                                                                        } elseif (str_contains($lowerName, 'detail') || str_contains($lowerName, 'interior') || str_contains($lowerName, 'exterior')) {
                                                                            $stages = [
                                                                                'Pending Queue',
                                                                                'Exterior Wash & Clay Bar',
                                                                                'Interior Vacuum & Steam Clean',
                                                                                'Leather & Plastic Conditioning',
                                                                                'Exterior Machine Polish',
                                                                                'Final Inspection',
                                                                                'Completed & Ready for Pick Up'
                                                                            ];
                                                                        } else {
                                                                            $stages = [
                                                                                'Pending Queue',
                                                                                'Under Inspection & Diagnostics',
                                                                                'Awaiting Parts / Approval',
                                                                                'Repair In Progress',
                                                                                'Quality Testing',
                                                                                'Completed & Ready for Pick Up'
                                                                            ];
                                                                        }

                                                                        $currentStage = trim($item['status'] ?? 'Pending Queue');
                                                                        if ($currentStage !== '' && !in_array($currentStage, $stages)) {
                                                                            array_splice($stages, count($stages) - 1, 0, $currentStage);
                                                                        }

                                                                        $isItemCompletedInDb = (
                                                                            str_contains(strtolower($currentStage), 'completed') || 
                                                                            str_contains(strtolower($currentStage), 'ready for pick up') || 
                                                                            str_contains(strtolower($currentStage), 'ready for pickup')
                                                                        );

                                                                        $rawSrvPrice = $vData['selected_services_prices'][$sName] 
                                                                            ?? $vData['selected_services_prices'][trim($sName)] 
                                                                            ?? 0;

                                                                        $itemCount = count($vData['service_items']);
                                                                        $vAdj = floatval($vData['price_adjustment'] ?? 0);

                                                                        if ($vAdj != 0 && $itemCount > 0) {
                                                                            $srvPrice = floatval($rawSrvPrice) + ($vAdj / $itemCount);
                                                                        } else {
                                                                            $srvPrice = floatval($rawSrvPrice);
                                                                        }
                                                                        $formattedInitialPrice = number_format((float)$srvPrice, 2, '.', '');
                                                                    @endphp

                                                                    <div class="card p-3 mb-2 card-dark-item rounded-3 service-item-card">
                                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                                            <div class="fw-bold text-white">{{ $sName }}</div>
                                                                            @if($isItemCompletedInDb)
                                                                                <span class="badge badge-completed">
                                                                                    <i class="bi bi-lock-fill me-1"></i>Completed & Locked
                                                                                </span>
                                                                            @endif
                                                                        </div>

                                                                        <input type="hidden" name="services[{{ $vIdx }}][{{ $sIdx }}][name]" value="{{ $sName }}">

                                                                        @if($isItemCompletedInDb)
                                                                            <!-- Hidden input ensures form post submits completed status when select is disabled -->
                                                                            <input type="hidden" class="locked-status-value" name="services[{{ $vIdx }}][{{ $sIdx }}][status]" value="{{ $currentStage }}">
                                                                        @endif

                                                                        <div class="row g-2 mb-2">
                                                                            <!-- Status Stage Selection -->
                                                                            <div class="col-md-7">
                                                                                <label class="form-label small text-secondary mb-1">Status Stage <span class="text-speed-pink">*</span></label>
                                                                                <select name="services[{{ $vIdx }}][{{ $sIdx }}][status]" class="form-select form-select-sm form-select-dark status-stage-select" required {{ $isItemCompletedInDb ? 'disabled' : '' }}>
                                                                                    @foreach($stages as $st)
                                                                                        <option value="{{ $st }}" {{ trim($item['status']) === trim($st) ? 'selected' : '' }}>
                                                                                            {{ $st }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @if($isItemCompletedInDb)
                                                                                    <small class="text-secondary d-block mt-1" style="font-size: 0.72rem;">
                                                                                        <i class="bi bi-shield-lock-fill text-success me-1"></i>Status is locked and cannot be reverted once completed.
                                                                                    </small>
                                                                                @endif
                                                                            </div>

                                                                            <!-- Service Final Cost / Price Edit Input -->
                                                                            <div class="col-md-5">
                                                                                <label class="form-label small text-secondary mb-1 d-flex justify-content-between align-items-center">
                                                                                    <span>Final Service Cost (₱) <span class="text-speed-pink">*</span></span>
                                                                                </label>
                                                                                <div class="input-group input-group-sm">
                                                                                    <span class="input-group-text input-group-text-dark fw-bold text-speed-pink">₱</span>
                                                                                    <input type="number" 
                                                                                           step="0.01" 
                                                                                           min="0" 
                                                                                           name="services[{{ $vIdx }}][{{ $sIdx }}][price]" 
                                                                                           class="form-control form-control-sm form-control-dark text-end fw-bold text-speed-blue service-cost-input" 
                                                                                           value="{{ $formattedInitialPrice }}" 
                                                                                           data-initial-price="{{ $formattedInitialPrice }}" 
                                                                                           placeholder="0.00" 
                                                                                           required 
                                                                                           {{ $isItemCompletedInDb ? 'readonly' : 'readonly' }}>
                                                                                </div>
                                                                                <small class="text-secondary d-block mt-1 cost-editable-hint" style="font-size: 0.72rem;">
                                                                                    @if($isItemCompletedInDb)
                                                                                        <i class="bi bi-lock-fill text-success me-1"></i>Locked (Completed)
                                                                                    @else
                                                                                        <i class="bi bi-lock-fill me-1"></i>Editable when "Completed & Ready for Pick Up"
                                                                                    @endif
                                                                                </small>
                                                                            </div>
                                                                        </div>

                                                                        <div>
                                                                            <label class="form-label small text-secondary mb-1 d-flex align-items-center gap-1">
                                                                                <span>Progress Note / Remarks</span>
                                                                                <span class="note-required-badge badge bg-danger bg-opacity-20 text-danger border border-danger border-opacity-50 d-none" style="font-size: 0.68rem;">
                                                                                    Required (Cost Changed)
                                                                                </span>
                                                                            </label>
                                                                            <textarea name="services[{{ $vIdx }}][{{ $sIdx }}][note]" class="form-control form-control-sm form-control-dark service-note-input" rows="2" placeholder="Enter findings, updates, or notes..." {{ $isItemCompletedInDb ? 'readonly' : '' }}>{{ $item['note'] }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                @endforeach

                                                                <!-- Price Adjustment Note per Vehicle -->
                                                                <div class="mt-2">
                                                                    <label class="form-label small text-secondary mb-1"><i class="bi bi-pencil-square me-1"></i>Registration Note</label>
                                                                    <input type="text" name="vehicles[{{ $vIdx }}][price_adjustment_note]" class="form-control form-control-sm form-control-dark" value="{{ $vData['price_adjustment_note'] ?? '' }}" placeholder="e.g., Applied 10% loyalty discount or added extra cleaning fee...">
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                        <!-- Overall Progress Status & Overall Estimated Cost Summary Card -->
                                                        <div class="card border-0 card-dark-nested p-3 rounded-3 mb-3 shadow-sm">
                                                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                                                <div>
                                                                    <span class="text-uppercase text-secondary fw-bold small d-block" style="font-size: 0.75rem;">Overall Progress Status</span>
                                                                    <span class="badge modal-overall-status-badge fs-6 px-3 py-2 mt-1 {{ $statusBadgeClass }}">
                                                                        {{ $statusLabel }}
                                                                    </span>
                                                                </div>
                                                                <div class="text-end">
                                                                    <span class="text-uppercase text-secondary fw-bold small d-block" style="font-size: 0.75rem;">Overall Estimated Cost</span>
                                                                    <span class="fw-bold text-speed-pink fs-4 font-monospace modal-overall-cost-display">
                                                                        ₱{{ number_format((float)$overallGrandTotal, 2) }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Transaction Completion Control Switch -->
                                                        <div class="border border-success border-opacity-50 bg-success bg-opacity-10 p-3 rounded-3 mt-3">
                                                            <div class="form-check form-switch m-0">
                                                                <input class="form-check-input complete-switch-input" type="checkbox" name="mark_as_completed" id="markCompleted{{ $service->id }}" value="1">
                                                                <label class="form-check-label fw-bold text-success" for="markCompleted{{ $service->id }}">
                                                                    <i class="bi bi-check-circle-fill me-1"></i> Mark entire service as Fully Completed & Move to Transaction Records
                                                                </label>
                                                            </div>
                                                            <small class="text-secondary d-block mt-1">
                                                                Checking this option moves this active job to <strong>Transaction Records</strong>, archiving the final verified costs so it shows as <strong>Total Cost</strong> (instead of estimated cost).
                                                            </small>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer border-top-0 pt-0">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm px-3 rounded-3 border-secondary border-opacity-50" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-speed-gradient btn-sm px-4 fw-bold rounded-3">
                                                            <i class="bi bi-check2-circle me-1"></i> Save Changes
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5 text-secondary">
                                            <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary opacity-50"></i>
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

    <!-- Modal: View Detailed Service Information -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content modal-content-dark border-0 rounded-4">
                <div class="modal-header border-bottom-0 pb-2">
                    <h5 class="modal-title fw-bold text-white">
                        <i class="bi bi-info-circle text-speed-blue me-2"></i>Service Record Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" id="receiptModalBody">
                    <!-- Dynamic details populated via JavaScript -->
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm px-4 rounded-3 border-secondary border-opacity-50" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Light Mode Toggle JS -->
    <script src="{{ asset('js/theme-toggle.js') }}"></script>

    <!-- Interactive Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Live table search and dropdown filter logic
            const searchInput = document.getElementById('transactionSearchInput') || document.getElementById('serviceSearchInput');
            const vehicleTypeSelect = document.getElementById('filterVehicleType');
            const brandSelect = document.getElementById('filterBrand');
            const serviceTypeSelect = document.getElementById('filterServiceType');
            const dateInput = document.getElementById('filterDate');
            const filterForm = document.getElementById('searchFilterForm');
            const resetFilterBtn = document.getElementById('resetFilterBtn');

            function applyTableFilters() {
                const searchText = searchInput ? searchInput.value.toLowerCase().trim() : '';
                const selectedType = vehicleTypeSelect ? vehicleTypeSelect.value.toLowerCase().trim() : '';
                const selectedBrand = brandSelect ? brandSelect.value.toLowerCase().trim() : '';
                const selectedService = serviceTypeSelect ? serviceTypeSelect.value.toLowerCase().trim() : '';
                const selectedDate = dateInput ? dateInput.value.trim() : '';

                const rows = document.querySelectorAll('#servicesTable tbody tr.service-table-row');
                let visibleCount = 0;

                rows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    const rowTypes = (row.getAttribute('data-vehicle-types') || '').toLowerCase();
                    const rowBrands = (row.getAttribute('data-brands') || '').toLowerCase();
                    const rowServices = (row.getAttribute('data-service-types') || '').toLowerCase();
                    const rowDate = row.getAttribute('data-date') || '';

                    const matchesSearch = !searchText || rowText.includes(searchText);
                    const matchesType = !selectedType || rowTypes.includes(selectedType);
                    const matchesBrand = !selectedBrand || rowBrands.includes(selectedBrand);
                    const matchesService = !selectedService || rowServices.includes(selectedService);
                    const matchesDate = !selectedDate || rowDate === selectedDate;

                    if (matchesSearch && matchesType && matchesBrand && matchesService && matchesDate) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Display dynamic empty filter row if all rows are hidden
                let noMatchRow = document.getElementById('noMatchingFilterRow');
                if (visibleCount === 0 && rows.length > 0) {
                    if (!noMatchRow) {
                        noMatchRow = document.createElement('tr');
                        noMatchRow.id = 'noMatchingFilterRow';
                        noMatchRow.innerHTML = `
                            <td colspan="9" class="text-center py-5 text-secondary">
                                <i class="bi bi-funnel fs-2 d-block mb-2 text-secondary opacity-50"></i>
                                No active service records match your selected search/filter criteria.
                            </td>
                        `;
                        document.querySelector('#servicesTable tbody').appendChild(noMatchRow);
                    } else {
                        noMatchRow.style.display = '';
                    }
                } else if (noMatchRow) {
                    noMatchRow.style.display = 'none';
                }
            }

            // Attach event listeners for real-time live filtering
            if (searchInput) searchInput.addEventListener('input', applyTableFilters);
            if (vehicleTypeSelect) vehicleTypeSelect.addEventListener('change', applyTableFilters);
            if (brandSelect) brandSelect.addEventListener('change', applyTableFilters);
            if (serviceTypeSelect) serviceTypeSelect.addEventListener('change', applyTableFilters);
            if (dateInput) dateInput.addEventListener('change', applyTableFilters);

            if (filterForm) {
                filterForm.addEventListener('submit', function(e) {
                    applyTableFilters();
                });
            }

            if (resetFilterBtn) {
                resetFilterBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (searchInput) searchInput.value = '';
                    if (vehicleTypeSelect) vehicleTypeSelect.selectedIndex = 0;
                    if (brandSelect) brandSelect.selectedIndex = 0;
                    if (serviceTypeSelect) serviceTypeSelect.selectedIndex = 0;
                    if (dateInput) dateInput.value = '';

                    if (window.history.pushState) {
                        window.history.pushState(null, '', window.location.pathname);
                    }
                    applyTableFilters();
                });
            }

            // Initial execution on load
            applyTableFilters();

            // Function to sync cost editable state & required remarks per card
            function syncCardState(card) {
                const stageSelect = card.querySelector('.status-stage-select');
                const costInput = card.querySelector('.service-cost-input');
                const noteInput = card.querySelector('.service-note-input');
                const noteBadge = card.querySelector('.note-required-badge');
                const costHint = card.querySelector('.cost-editable-hint');

                if (!stageSelect || !costInput || !noteInput) return;

                // If stage select is disabled (item is locked as completed from DB)
                if (stageSelect.disabled) {
                    costInput.setAttribute('readonly', 'readonly');
                    costInput.classList.add('bg-transparent');
                    if (costHint) {
                        costHint.innerHTML = `<i class="bi bi-lock-fill text-success me-1"></i>Locked (Completed)`;
                        costHint.className = 'text-success d-block mt-1 cost-editable-hint';
                    }
                    return;
                }

                const selectedVal = stageSelect.value.trim().toLowerCase();
                const isCompleted = selectedVal.includes('completed') || selectedVal.includes('ready for pick up') || selectedVal.includes('ready for pickup');

                // 1. Enable / Disable cost input based on "Completed & Ready for Pick Up"
                if (isCompleted) {
                    costInput.removeAttribute('readonly');
                    costInput.classList.remove('bg-transparent');
                    if (costHint) {
                        costHint.innerHTML = `<i class="bi bi-unlock-fill text-success me-1"></i>Editable`;
                        costHint.className = 'text-success d-block mt-1 cost-editable-hint';
                    }
                } else {
                    costInput.setAttribute('readonly', 'readonly');
                    costInput.classList.add('bg-transparent');
                    if (costHint) {
                        costHint.innerHTML = `<i class="bi bi-lock-fill me-1"></i>Editable when "Completed & Ready for Pick Up"`;
                        costHint.className = 'text-secondary d-block mt-1 cost-editable-hint';
                    }
                    if (costInput.dataset.initialPrice !== undefined) {
                        costInput.value = costInput.dataset.initialPrice;
                    }
                }

                // 2. Check if Final Service Cost changed from initial
                const initialVal = parseFloat(costInput.dataset.initialPrice || 0);
                const currentVal = parseFloat(costInput.value || 0);
                const isCostModified = Math.abs(currentVal - initialVal) > 0.001;

                if (isCostModified) {
                    noteInput.setAttribute('required', 'required');
                    if (noteBadge) noteBadge.classList.remove('d-none');
                } else {
                    noteInput.removeAttribute('required');
                    if (noteBadge) noteBadge.classList.add('d-none');
                }
            }

            // Function to recalculate modal Overall Estimated Cost and Progress Status
            function syncModalSummary(modal) {
                if (!modal) return;

                let totalCost = 0;
                let allStatuses = [];

                const cards = modal.querySelectorAll('.service-item-card');
                cards.forEach(card => {
                    // Calculate cost
                    const costInput = card.querySelector('.service-cost-input');
                    if (costInput) {
                        const val = parseFloat(costInput.value);
                        if (!isNaN(val)) {
                            totalCost += val;
                        }
                    }

                    // Get status stage (from locked hidden input if disabled, or select value)
                    const stageSelect = card.querySelector('.status-stage-select');
                    const lockedStatus = card.querySelector('.locked-status-value');
                    let statusVal = '';
                    if (lockedStatus && lockedStatus.value) {
                        statusVal = lockedStatus.value;
                    } else if (stageSelect && stageSelect.value) {
                        statusVal = stageSelect.value;
                    }

                    if (statusVal) {
                        allStatuses.push(statusVal.trim().toLowerCase());
                    }
                });

                // Update Overall Cost
                const costDisplay = modal.querySelector('.modal-overall-cost-display');
                if (costDisplay) {
                    costDisplay.textContent = '₱' + totalCost.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }

                // Update Overall Status Badge
                let isAllPending = allStatuses.length > 0 && allStatuses.every(st => st.includes('pending') || st.includes('queue'));
                let isAllCompleted = allStatuses.length > 0 && allStatuses.every(st => st.includes('completed') || st.includes('ready'));

                const statusBadge = modal.querySelector('.modal-overall-status-badge');
                if (statusBadge) {
                    if (isAllCompleted) {
                        statusBadge.className = 'badge badge-completed fs-6 px-3 py-2 mt-1 modal-overall-status-badge';
                        statusBadge.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Completed';
                    } else if (isAllPending) {
                        statusBadge.className = 'badge badge-queued fs-6 px-3 py-2 mt-1 modal-overall-status-badge';
                        statusBadge.innerHTML = '<i class="bi bi-clock-history me-1"></i> Queued';
                    } else {
                        statusBadge.className = 'badge badge-in-progress fs-6 px-3 py-2 mt-1 modal-overall-status-badge';
                        statusBadge.innerHTML = '<i class="bi bi-gear-wide-connected me-1"></i> In Progress';
                    }
                }
            }

            // Initialize all update modals state & attach listeners
            document.querySelectorAll('.update-service-modal').forEach(modal => {
                const cards = modal.querySelectorAll('.service-item-card');

                cards.forEach(card => {
                    const stageSelect = card.querySelector('.status-stage-select');
                    const costInput = card.querySelector('.service-cost-input');

                    syncCardState(card);

                    if (stageSelect) {
                        stageSelect.addEventListener('change', function() {
                            syncCardState(card);
                            syncModalSummary(modal);
                        });
                    }

                    if (costInput) {
                        costInput.addEventListener('input', function() {
                            syncCardState(card);
                            syncModalSummary(modal);
                        });
                        costInput.addEventListener('change', function() {
                            syncCardState(card);
                            syncModalSummary(modal);
                        });
                    }
                });

                syncModalSummary(modal);

                modal.addEventListener('shown.bs.modal', function() {
                    cards.forEach(card => syncCardState(card));
                    syncModalSummary(modal);
                });
            });

            // Mark as completed switch auto-selects completed stage for non-disabled selects
            document.querySelectorAll('.complete-switch-input').forEach(switchInput => {
                switchInput.addEventListener('change', function() {
                    if (this.checked) {
                        const modal = this.closest('.modal');
                        if (modal) {
                            modal.querySelectorAll('.status-stage-select:not([disabled])').forEach(select => {
                                let found = false;
                                for (let i = 0; i < select.options.length; i++) {
                                    if (select.options[i].value.toLowerCase().includes('completed')) {
                                        select.selectedIndex = i;
                                        found = true;
                                        break;
                                    }
                                }
                                if (!found && select.options.length > 0) {
                                    select.selectedIndex = select.options.length - 1;
                                }
                                select.dispatchEvent(new Event('change'));
                            });
                        }
                    }
                });
            });

            // Selecting "Completed & Ready for Pick Up" automatically checks the completion switch
            document.querySelectorAll('.status-stage-select').forEach(select => {
                select.addEventListener('change', function() {
                    const modal = this.closest('.modal');
                    if (!modal) return;

                    const switchInput = modal.querySelector('.complete-switch-input');
                    if (!switchInput) return;

                    const cards = modal.querySelectorAll('.service-item-card');
                    const allCompleted = Array.from(cards).every(card => {
                        const stageSel = card.querySelector('.status-stage-select');
                        const lockedVal = card.querySelector('.locked-status-value');
                        const val = (lockedVal && lockedVal.value) ? lockedVal.value : (stageSel ? stageSel.value : '');
                        return val.toLowerCase().includes('completed') || val.toLowerCase().includes('ready');
                    });

                    if (allCompleted) {
                        switchInput.checked = true;
                    } else {
                        switchInput.checked = false;
                    }
                });
            });

            // View Detailed Service Information Modal handler
            document.querySelectorAll('.open-info-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const jsonAttr = row.getAttribute('data-order-json');
                    if (!jsonAttr) return;

                    try {
                        const order = JSON.parse(jsonAttr);
                        const modalBody = document.getElementById('receiptModalBody');
                        if (!modalBody) return;

                        let vehiclesHTML = '';
                        if (order.vehicles && order.vehicles.length > 0) {
                            order.vehicles.forEach((v, vIdx) => {
                                const vehTitle = [v.vehicle_make, v.vehicle_model, v.vehicle_type, v.vehicle_year].filter(Boolean).join(' ') || `Vehicle #${vIdx + 1}`;
                                
                                let servicesHTML = '';
                                if (v.service_items && v.service_items.length > 0) {
                                    v.service_items.forEach(s => {
                                        const sPrice = (v.selected_services_prices && (v.selected_services_prices[s.name] !== undefined ? v.selected_services_prices[s.name] : v.selected_services_prices[s.name.trim()])) || 0;
                                        
                                        let stClass = 'badge-in-progress';
                                        const stLower = (s.status || '').toLowerCase();
                                        if (stLower.includes('pending') || stLower.includes('queue')) {
                                            stClass = 'badge-queued';
                                        } else if (stLower.includes('completed') || stLower.includes('ready')) {
                                            stClass = 'badge-completed';
                                        }

                                        servicesHTML += `
                                            <div class="border-bottom border-secondary border-opacity-25 py-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fw-semibold text-white">${s.name}</span>
                                                    <span class="badge ${stClass}">${s.status || 'Pending Queue'}</span>
                                                </div>
                                                ${s.note ? `<div class="small text-secondary mt-1"><i class="bi bi-chat-left-text me-1"></i>Note: ${s.note}</div>` : ''}
                                                <div class="small font-monospace text-end text-speed-pink fw-bold mt-1">₱${parseFloat(sPrice).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                                            </div>
                                        `;
                                    });
                                } else {
                                    servicesHTML = '<div class="small text-secondary italic py-2">No services recorded.</div>';
                                }

                                const adjVal = parseFloat(v.price_adjustment || 0);
                                let adjText = '';
                                if (adjVal !== 0) {
                                    adjText = ` (Adjustment: ₱${adjVal < 0 ? '-' : '+'}${Math.abs(adjVal).toFixed(2)})`;
                                }
                                const noteLabel = v.price_adjustment_note ? v.price_adjustment_note : 'Price Adjustment';

                                vehiclesHTML += `
                                    <div class="card card-dark-nested rounded-3 p-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom border-secondary border-opacity-25">
                                            <div>
                                                <h6 class="fw-bold text-white mb-0"><i class="bi bi-car-front text-speed-blue me-1"></i> ${vehTitle}</h6>
                                                <small class="text-secondary"><i class="bi bi-person-badge me-1"></i>Tech: ${v.mechanic_assigned || 'Unassigned'}</small>
                                            </div>
                                            <span class="badge badge-plate font-monospace">${v.plate_number || 'N/A'}</span>
                                        </div>
                                        <div class="mb-2">
                                            <span class="text-uppercase text-secondary fw-bold small d-block mb-1" style="font-size: 0.75rem;">Services & Status</span>
                                            ${servicesHTML}
                                        </div>
                                        ${(v.price_adjustment_note || adjVal !== 0) ? `
                                            <div class="small text-info bg-info bg-opacity-10 p-2 rounded-2 mt-2 border border-info border-opacity-25">
                                                <i class="bi bi-info-circle me-1"></i><strong>Note:</strong> ${noteLabel}${adjText}
                                            </div>
                                        ` : ''}
                                        <div class="d-flex justify-content-between align-items-center pt-2 mt-2 border-top border-secondary border-opacity-25 small fw-bold">
                                            <span class="text-secondary">Vehicle Subtotal:</span>
                                            <span class="text-speed-blue font-monospace fs-6">₱${parseFloat(v.total_cost || 0).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                                        </div>
                                    </div>
                                `;
                            });
                        }

                        modalBody.innerHTML = `
                            <div class="alert alert-info py-2 px-3 small rounded-3 mb-3 bg-info bg-opacity-10 text-info border border-info border-opacity-25 d-flex align-items-center justify-content-between">
                                <div>
                                    <i class="bi bi-info-circle-fill me-1"></i> Customer: <strong>${order.customer_name}</strong> (${order.contact_number})
                                </div>
                                <span class="badge bg-speed-blue text-dark font-monospace">${order.tracking_code}</span>
                            </div>

                            <div class="row g-3 card-dark-nested p-3 rounded-3 border mb-3">
                                <div class="col-md-6">
                                    <span class="text-secondary small d-block">Tracking Code</span>
                                    <span class="fs-5 fw-bold text-speed-blue font-monospace">${order.tracking_code}</span>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <span class="text-secondary small d-block">Date Registered</span>
                                    <strong class="text-white">${order.date_registered}</strong>
                                </div>
                                <div class="col-md-6 border-top border-secondary border-opacity-25 pt-2">
                                    <span class="text-secondary small d-block">Customer Name</span>
                                    <strong class="text-white">${order.customer_name}</strong>
                                    <span class="d-block text-secondary small font-monospace">${order.contact_number}</span>
                                </div>
                                <div class="col-md-6 text-md-end border-top border-secondary border-opacity-25 pt-2">
                                    <span class="text-secondary small d-block">Assigned Technician(s)</span>
                                    <strong class="text-white">${order.mechanic_assigned || 'Unassigned'}</strong>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span class="fw-bold text-white d-block mb-2"><i class="bi bi-journal-text text-speed-pink me-1"></i> Service Items Breakdown</span>
                                ${vehiclesHTML}
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-3 border-top border-secondary border-opacity-25">
                                <span class="fw-bold text-white fs-5">Overall Estimated Cost:</span>
                                <span class="fw-bold text-speed-pink fs-4 font-monospace">₱${parseFloat(order.total_cost || 0).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                            </div>
                        `;

                        const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
                        receiptModal.show();
                    } catch (e) {
                        console.error('Error parsing order JSON:', e);
                    }
                });
            });
        });
    </script>
</body>
</html>