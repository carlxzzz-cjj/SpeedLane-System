<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedLane - Manage Services & Staff</title>

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

        /* Dark Theme Toggle Button */
        #theme-toggle-btn {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.25s ease;
        }

        #theme-toggle-btn:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }

        /* Role & Status Badges - Dark Mode Defaults */
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

        .badge-staff {
            background-color: rgba(255, 255, 255, 0.08) !important;
            color: #cbd5e1 !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-single-select {
            background-color: rgba(0, 162, 255, 0.18) !important;
            color: #99dbff !important;
            border: 1px solid rgba(0, 162, 255, 0.5) !important;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-multi-select {
            background-color: rgba(244, 37, 130, 0.18) !important;
            color: #ffb3d9 !important;
            border: 1px solid rgba(244, 37, 130, 0.5) !important;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-flat-rate {
            background-color: rgba(255, 255, 255, 0.08) !important;
            color: #cbd5e1 !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-status-active {
            background-color: rgba(40, 167, 69, 0.18) !important;
            color: #75b798 !important;
            border: 1px solid rgba(40, 167, 69, 0.4) !important;
            font-weight: 600;
        }

        .badge-status-disabled {
            background-color: rgba(255, 255, 255, 0.08) !important;
            color: #cbd5e1 !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            font-weight: 600;
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

        html.light-theme h2,
        html.light-theme h3,
        html.light-theme h4,
        html.light-theme h5,
        html.light-theme h6,
        html.light-theme .text-white {
            color: #0f172a !important;
        }

        html.light-theme .text-secondary {
            color: #64748b !important;
        }

        /* Light Mode Badges */
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

        html.light-theme .badge-staff,
        html.light-theme .badge-flat-rate {
            background-color: #f1f5f9 !important;
            color: #334155 !important;
            border: 1px solid #cbd5e1 !important;
            font-weight: 600 !important;
        }

        html.light-theme .badge-single-select {
            background-color: #e0f2fe !important;
            color: #0369a1 !important;
            border: 1px solid #38bdf8 !important;
            font-weight: 600 !important;
        }

        html.light-theme .badge-multi-select {
            background-color: #fce7f3 !important;
            color: #be185d !important;
            border: 1px solid #f472b6 !important;
            font-weight: 600 !important;
        }

        html.light-theme .badge-status-active {
            background-color: #dcfce7 !important;
            color: #15803d !important;
            border: 1px solid #86efac !important;
        }

        html.light-theme .badge-status-disabled {
            background-color: #f1f5f9 !important;
            color: #64748b !important;
            border: 1px solid #cbd5e1 !important;
        }

        /* Light Mode Logout Button */
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

        /* Light Mode Navigation Tabs */
        html.light-theme #manageTab .nav-link {
            color: #64748b;
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
        }

        html.light-theme #manageTab .nav-link:hover {
            background-color: #e2e8f0;
            color: #0f172a;
        }

        html.light-theme #manageTab .nav-link.active {
            background: linear-gradient(90deg, rgba(244, 37, 130, 0.15) 0%, rgba(0, 162, 255, 0.15) 100%) !important;
            color: #0f172a !important;
            border: 1px solid rgba(244, 37, 130, 0.4) !important;
            font-weight: 700;
        }

        /* Light Mode Service Cards & Options */
        html.light-theme .service-option-card {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
        }

        html.light-theme .service-option-card:hover {
            background-color: #f1f5f9;
            border-color: var(--speed-blue);
        }

        html.light-theme .bg-black.bg-opacity-40 {
            background-color: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
        }

        /* Light Mode Inputs & Dropdowns */
        html.light-theme .form-control-dark,
        html.light-theme .form-select-dark {
            background-color: #f1f5f9 !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
        }

        html.light-theme .form-control-dark:focus,
        html.light-theme .form-select-dark:focus {
            border-color: var(--speed-blue) !important;
            box-shadow: 0 0 12px rgba(0, 162, 255, 0.25) !important;
            color: #0f172a !important;
        }

        html.light-theme .form-control-dark::placeholder {
            color: #94a3b8 !important;
        }

        html.light-theme .input-group-text-dark {
            background-color: #e2e8f0 !important;
            border: 1px solid #cbd5e1 !important;
            border-right: none !important;
            color: #475569 !important;
        }

        /* Light Mode Tables */
        html.light-theme .table-dark-custom {
            --bs-table-color: #1e293b;
            border-color: #e2e8f0;
        }

        html.light-theme .table-dark-custom thead {
            background-color: #f1f5f9;
            border-bottom: 1px solid #cbd5e1;
        }

        html.light-theme .table-dark-custom th {
            color: #475569;
            border-bottom-width: 1px;
        }

        html.light-theme .table-dark-custom td {
            border-bottom: 1px solid #e2e8f0;
            color: #1e293b;
        }

        /* Light Mode Modals */
        html.light-theme .modal-content-dark {
            background-color: #ffffff !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            color: #0f172a !important;
        }

        html.light-theme .modal-content-dark .modal-header,
        html.light-theme .modal-content-dark .modal-footer {
            border-color: #e2e8f0 !important;
        }

        html.light-theme .btn-dark-cancel {
            background-color: #f1f5f9 !important;
            border: 1px solid #cbd5e1 !important;
            color: #334155 !important;
        }

        html.light-theme .btn-dark-cancel:hover {
            background-color: #e2e8f0 !important;
            color: #0f172a !important;
        }

        html.light-theme .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(50%);
        }

        html.light-theme .alert-dark {
            background-color: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
        }

        /* Light Mode Action Buttons */
        html.light-theme .btn-outline-info-custom {
            color: #0284c7 !important;
            border: 1px solid #38bdf8 !important;
            background: #f0f9ff !important;
        }

        html.light-theme .btn-outline-info-custom:hover {
            background: #e0f2fe !important;
            color: #0369a1 !important;
            border-color: #0284c7 !important;
        }

        html.light-theme .btn-outline-warning-custom {
            color: #d97706 !important;
            border: 1px solid #fcd34d !important;
            background: #fffbeb !important;
        }

        html.light-theme .btn-outline-warning-custom:hover {
            background: #fef3c7 !important;
            color: #b45309 !important;
            border-color: #d97706 !important;
        }

        html.light-theme .btn-outline-success-custom {
            color: #16a34a !important;
            border: 1px solid #86efac !important;
            background: #f0fdf4 !important;
        }

        html.light-theme .btn-outline-success-custom:hover {
            background: #dcfce7 !important;
            color: #15803d !important;
            border-color: #16a34a !important;
        }

        html.light-theme .btn-outline-danger-custom {
            color: #dc2626 !important;
            border: 1px solid #fca5a5 !important;
            background: #fef2f2 !important;
        }

        html.light-theme .btn-outline-danger-custom:hover {
            background: #fee2e2 !important;
            color: #991b1b !important;
            border-color: #dc2626 !important;
        }

        /* Header Navigation */
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

        /* Form Inputs & Dropdowns */
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

        /* High Visibility Logout Button */
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

        /* Manage Navigation Tabs */
        #manageTab .nav-link {
            color: #94a3b8;
            background-color: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--speed-card-border);
            transition: all 0.2s ease-in-out;
        }

        #manageTab .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.08);
            color: #ffffff;
        }

        #manageTab .nav-link.active {
            background: linear-gradient(90deg, rgba(244, 37, 130, 0.2) 0%, rgba(0, 162, 255, 0.2) 100%) !important;
            color: #ffffff !important;
            border: 1px solid rgba(244, 37, 130, 0.4) !important;
            box-shadow: 0 0 12px rgba(244, 37, 130, 0.2);
        }

        /* Service Cards & Pricing Options */
        .service-card {
            transition: all 0.2s ease-in-out;
        }

        .service-option-card {
            background-color: #06080d;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: border-color 0.15s ease-in-out, background-color 0.15s ease-in-out;
        }

        .service-option-card:hover {
            background-color: #0f1322;
            border-color: var(--speed-blue);
        }

        /* Dark Tables Custom Styling */
        .table-dark-custom {
            --bs-table-bg: transparent;
            --bs-table-color: #e2e8f0;
            border-color: rgba(255, 255, 255, 0.08);
        }

        .table-dark-custom thead {
            background-color: #06080d;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .table-dark-custom th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #94a3b8;
            padding: 0.85rem 1rem;
            border-bottom-width: 1px;
        }

        .table-dark-custom td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: #e2e8f0;
        }

        /* Dark Modals Styling */
        .modal-content-dark {
            background-color: var(--speed-card-bg) !important;
            border: 1px solid var(--speed-card-border) !important;
            color: #e2e8f0 !important;
        }

        .modal-content-dark .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        .modal-content-dark .modal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        /* Button Styling - Clean, high contrast & comfortable to read */
        .btn-speed-gradient {
            background: linear-gradient(90deg, #d61f72 0%, #0088dd 100%);
            border: none;
            color: #ffffff !important;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(214, 31, 114, 0.25);
        }

        .btn-speed-gradient:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 136, 221, 0.35);
        }

        .btn-dark-cancel {
            background-color: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #cbd5e1 !important;
        }

        .btn-dark-cancel:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: #ffffff !important;
        }

        /* Outline Buttons on Dark Background */
        .btn-outline-info-custom {
            color: #40b5ff !important;
            border: 1px solid rgba(0, 162, 255, 0.4) !important;
            background: rgba(0, 162, 255, 0.08);
            transition: all 0.25s ease;
        }

        .btn-outline-info-custom:hover {
            background: rgba(0, 162, 255, 0.22) !important;
            color: #ffffff !important;
            border-color: #00a2ff !important;
        }

        .btn-outline-warning-custom {
            color: #ffda6a !important;
            border: 1px solid rgba(255, 193, 7, 0.4) !important;
            background: rgba(255, 193, 7, 0.08);
            transition: all 0.25s ease;
        }

        .btn-outline-warning-custom:hover {
            background: rgba(255, 193, 7, 0.22) !important;
            color: #ffffff !important;
            border-color: #ffc107 !important;
        }

        .btn-outline-success-custom {
            color: #75b798 !important;
            border: 1px solid rgba(40, 167, 69, 0.4) !important;
            background: rgba(40, 167, 69, 0.08);
            transition: all 0.25s ease;
        }

        .btn-outline-success-custom:hover {
            background: rgba(40, 167, 69, 0.22) !important;
            color: #ffffff !important;
            border-color: #28a745 !important;
        }

        .btn-outline-danger-custom {
            color: #ff7597 !important;
            border: 1px solid rgba(255, 77, 109, 0.4) !important;
            background: rgba(255, 77, 109, 0.08);
            transition: all 0.25s ease;
        }

        .btn-outline-danger-custom:hover {
            background: rgba(255, 77, 109, 0.22) !important;
            color: #ffffff !important;
            border-color: #ff4d6d !important;
        }

        .extra-small {
            font-size: 11px;
        }

        .letter-spacing-otp {
            letter-spacing: 0.5rem;
        }
           body {
    zoom: 80%; /* Adjusts the render scale across modern browsers */
  }
    </style>
</head>
<body>

    <!-- TOP NAVIGATION HEADER BAR -->
    <header class="navbar navbar-expand-lg navbar-dark navbar-speed px-4 py-2 sticky-top" style="z-index: 1020;">
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
                    <span class="brand-subtext d-block">ADMIN OVERVIEW</span>
                </div>
            </a>

            <!-- Right Nav Alignment -->
            <div class="d-flex align-items-center gap-3 ms-auto">
                
                {{-- ROLE BADGE --}}
                @if(auth()->check() && auth()->user()->isSuperAdmin())
                    <span class="badge badge-super-admin px-3 py-2 rounded-pill">
                        <i class="bi bi-shield-check me-1"></i> Super Admin
                    </span>
                @else
                    <span class="badge badge-admin px-3 py-2 rounded-pill">
                        <i class="bi bi-person-badge me-1"></i> Admin
                    </span>
                @endif

                <!-- Logout Action Form -->
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
                    <a class="nav-link admin-nav-link rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.register-service') }}">
                        <i class="bi bi-plus-circle text-speed-blue"></i> Register Service
                    </a>
                    <a class="nav-link admin-nav-link rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.update') }}">
                        <i class="bi bi-arrow-repeat text-warning"></i> Update Service Status
                    </a>
                    <a class="nav-link admin-nav-link rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.transactions') }}">
                        <i class="bi bi-file-earmark-text text-info"></i> Transaction Records
                    </a>
                    
                    @if(auth()->user()->isSuperAdmin())
                        <a class="nav-link admin-nav-link active rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.manage-services.index') }}">
                            <i class="bi bi-gear-fill text-speed-pink"></i> Manage Services
                        </a>
                    @endif
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 p-4">
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <i class="bi bi-shield-lock text-speed-pink fs-3"></i>
                        <h2 class="fw-bold text-white mb-0">Manage Services & Staff</h2>
                    </div>
                    <p class="text-secondary mb-0">Super admin only — edit service types, pricing options, technician roster, and staff accounts.</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 bg-success bg-opacity-20 text-white border-success" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 bg-danger bg-opacity-20 text-white border-danger" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 bg-danger bg-opacity-20 text-white border-danger" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errors->first() }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Navigation Tabs -->
                <div class="d-flex align-items-center gap-2 mb-4">
                    <ul class="nav nav-pills gap-2 mb-0" id="manageTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active rounded-pill px-3 py-1.5 fw-semibold small" id="services-tab" data-bs-toggle="pill" data-bs-target="#services-panel" type="button" role="tab" aria-selected="true">
                                <i class="bi bi-tag me-1"></i> Service Catalog ({{ $services->count() }})
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link rounded-pill px-3 py-1.5 fw-semibold small" id="technicians-tab" data-bs-toggle="pill" data-bs-target="#technicians-panel" type="button" role="tab" aria-selected="false">
                                <i class="bi bi-people me-1"></i> Technicians ({{ $technicians->count() }})
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link rounded-pill px-3 py-1.5 fw-semibold small" id="staff-tab" data-bs-toggle="pill" data-bs-target="#staff-panel" type="button" role="tab" aria-selected="false">
                                <i class="bi bi-person-badge me-1"></i> Staff ({{ $staffs->count() }})
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="manageTabContent">
                    <!-- TAB 1: SERVICE CATALOG -->
                    <div class="tab-pane fade show active" id="services-panel" role="tabpanel">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                            <div>
                                <h4 class="fw-bold text-white mb-1">
                                    <i class="bi bi-tools text-speed-blue me-2"></i>Service Catalog
                                </h4>
                                <p class="text-secondary mb-0 fs-6">Manage service packages, pricing structures, and vehicle classifications.</p>
                            </div>
                            <button class="btn btn-speed-gradient rounded-3 px-4 py-2 fw-bold shadow-sm d-flex align-items-center gap-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                                <i class="bi bi-plus-lg fs-6"></i> Add New Service
                            </button>
                        </div>

                        <!-- SEARCH & VEHICLE FILTER BAR -->
                        <div class="card speed-card border-0 shadow-sm rounded-4 p-3 mb-4">
                            <div class="row g-2">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text-dark rounded-start-3">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input type="text" id="serviceSearchInput" class="form-control form-control-dark rounded-end-3" placeholder="Search service name, sub-services, or price (e.g. Wash, Sedan, 500)...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <select id="vehicleFilterSelect" class="form-select form-select-dark rounded-3">
                                        <option value="">Filter by Vehicle: All Types</option>
                                        <option value="Sedan">Sedan</option>
                                        <option value="Hatchback">Hatchback</option>
                                        <option value="Crossover">Crossover</option>
                                        <option value="MPV">MPV</option>
                                        <option value="SUV">SUV</option>
                                        <option value="Pickup">Pickup Truck</option>
                                        <option value="Van">Van</option>
                                        <option value="Sports Car">Sports Car</option>
                                        <option value="Supercar">Supercar</option>
                                        <option value="All">All Vehicles Only</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-4 mb-5" id="servicesContainer">
                            @forelse($services as $service)
                                <div class="card speed-card service-card service-item border-0 shadow-sm rounded-4 p-4" data-vehicle="{{ strtolower($service->vehicle_type ?? 'all') }}">
                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-3 pb-3 border-bottom border-secondary border-opacity-25">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                                                <h3 class="fw-bold text-white mb-0 fs-4">{{ $service->name }}</h3>
                                                
                                                <!-- Main Service Vehicle Type Badge -->
                                                <span class="badge badge-flat-rate px-3 py-2 rounded-pill fw-semibold fs-6">
                                                    <i class="bi bi-car-front me-1"></i>{{ $service->vehicle_type ?? 'All Vehicles' }}
                                                </span>

                                                <!-- Selection Type Badge -->
                                                @if($service->selection_type === 'multi')
                                                    <span class="badge badge-multi-select px-3 py-2 rounded-pill fw-semibold fs-6">
                                                        <i class="bi bi-check2-square me-1"></i> Multi-Select
                                                    </span>
                                                @elseif($service->selection_type === 'single')
                                                    <span class="badge badge-single-select px-3 py-2 rounded-pill fw-semibold fs-6">
                                                        <i class="bi bi-ui-radios me-1"></i> Single-Select
                                                    </span>
                                                @else
                                                    <span class="badge badge-flat-rate px-3 py-2 rounded-pill fw-semibold fs-6">
                                                        <i class="bi bi-tag-fill me-1"></i> Flat-Rate
                                                    </span>
                                                @endif
                                            </div>

                                            @if($service->description)
                                                <p class="text-secondary mb-2 fs-6 lh-base">{{ $service->description }}</p>
                                            @endif

                                            @if($service->notice)
                                                <div class="p-2.5 px-3 bg-warning bg-opacity-10 border border-warning border-opacity-25 text-warning rounded-3 fs-6 d-inline-flex align-items-center gap-2 mt-1">
                                                    <i class="bi bi-exclamation-circle-fill text-warning fs-5"></i>
                                                    <span>{{ $service->notice }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="d-flex align-items-center gap-2 self-md-start">
                                            <button class="btn btn-outline-info-custom rounded-3 px-3 py-1.5 fw-semibold d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $service->id }}">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            <form action="{{ route('admin.manage-services.destroy-service', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger-custom rounded-3 px-3 py-1.5 fw-semibold d-flex align-items-center gap-1">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Sub-services / Pricing Options Grid -->
                                    <div>
                                        <span class="text-uppercase fw-bold text-secondary small tracking-wide mb-2 d-block">
                                            <i class="bi bi-list-task me-1"></i> Available Sub-services & Pricing Options
                                        </span>

                                        @if($service->selection_type === 'flat')
                                            <div class="p-3 rounded-3 bg-black bg-opacity-40 border border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                                                <span class="fw-bold text-white fs-6">
                                                    <i class="bi bi-tag-fill me-2 text-speed-pink"></i>Standard Flat Rate
                                                </span>
                                                <span class="fw-bold text-speed-blue fs-4 font-monospace">₱{{ number_format($service->flat_price, 2) }}</span>
                                            </div>
                                        @else
                                            @if($service->options->count() > 0)
                                                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2.5">
                                                    @foreach($service->options as $opt)
                                                        <div class="col">
                                                            <div class="service-option-card p-3 rounded-3 d-flex justify-content-between align-items-center h-100">
                                                                <div class="d-flex align-items-center gap-2 me-2">
                                                                    <i class="bi bi-circle-fill text-speed-pink" style="font-size: 8px;"></i>
                                                                    <div>
                                                                        <span class="fw-semibold text-white fs-6 d-block">{{ $opt->name }}</span>
                                                                    </div>
                                                                </div>
                                                                <span class="fw-bold text-speed-blue fs-5 font-monospace ms-auto">₱{{ number_format($opt->price, 2) }}</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @elseif($service->flat_price !== null)
                                                <div class="p-3 rounded-3 bg-black bg-opacity-40 border border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                                                    <span class="fw-bold text-white fs-6">
                                                        <i class="bi bi-tag-fill me-2 text-speed-pink"></i>Base / Service Price
                                                    </span>
                                                    <span class="fw-bold text-speed-blue fs-4 font-monospace">₱{{ number_format($service->flat_price, 2) }}</span>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                <!-- EDIT SERVICE MODAL -->
                                <div class="modal fade" id="editServiceModal{{ $service->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content modal-content-dark rounded-4 shadow">
                                            <form action="{{ route('admin.manage-services.update-service', $service->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold text-white"><i class="bi bi-pencil-square text-speed-blue me-2"></i>Edit Service</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold text-secondary">Service Name <span class="text-speed-pink">*</span></label>
                                                        <input type="text" name="name" class="form-control form-control-dark" value="{{ $service->name }}" required>
                                                    </div>
                                                    
                                                    <!-- Service Vehicle Type -->
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold text-secondary">Service Vehicle Type</label>
                                                        <select name="vehicle_type" class="form-select form-select-dark">
                                                            <option value="All" {{ ($service->vehicle_type ?? 'All') === 'All' ? 'selected' : '' }}>All Vehicle Types</option>
                                                            <option value="Sedan" {{ ($service->vehicle_type ?? '') === 'Sedan' ? 'selected' : '' }}>Sedan</option>
                                                            <option value="Hatchback" {{ ($service->vehicle_type ?? '') === 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
                                                            <option value="Crossover" {{ ($service->vehicle_type ?? '') === 'Crossover' ? 'selected' : '' }}>Crossover</option>
                                                            <option value="MPV" {{ ($service->vehicle_type ?? '') === 'MPV' ? 'selected' : '' }}>MPV</option>
                                                            <option value="SUV" {{ ($service->vehicle_type ?? '') === 'SUV' ? 'selected' : '' }}>SUV</option>
                                                            <option value="Pickup Truck" {{ ($service->vehicle_type ?? '') === 'Pickup Truck' ? 'selected' : '' }}>Pickup Truck</option>
                                                            <option value="Van" {{ ($service->vehicle_type ?? '') === 'Van' ? 'selected' : '' }}>Van</option>
                                                            <option value="Sports Car" {{ ($service->vehicle_type ?? '') === 'Sports Car' ? 'selected' : '' }}>Sports Car</option>
                                                            <option value="Supercar" {{ ($service->vehicle_type ?? '') === 'Supercar' ? 'selected' : '' }}>Supercar</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold text-secondary">Description</label>
                                                        <textarea name="description" class="form-control form-control-dark" rows="2">{{ $service->description }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold text-secondary">Notice / Disclaimer Note</label>
                                                        <input type="text" name="notice" class="form-control form-control-dark" value="{{ $service->notice }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold text-secondary">Selection Type</label>
                                                        <select name="selection_type" class="form-select form-select-dark" onchange="toggleServiceFields('{{ $service->id }}', this.value)">
                                                            <option value="single" {{ $service->selection_type === 'single' ? 'selected' : '' }}>Single Select</option>
                                                            <option value="multi" {{ $service->selection_type === 'multi' ? 'selected' : '' }}>Multi Select</option>
                                                            <option value="flat" {{ $service->selection_type === 'flat' ? 'selected' : '' }}>Flat Rate</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3" id="flatPriceBox{{ $service->id }}" style="display: {{ ($service->selection_type === 'flat' || $service->selection_type === 'single') ? 'block' : 'none' }};">
                                                        <label class="form-label small fw-semibold text-secondary">Flat / Base Price (₱)</label>
                                                        <input type="number" step="0.01" name="flat_price" class="form-control form-control-dark" value="{{ $service->flat_price }}">
                                                    </div>

                                                    <div class="mb-3" id="optionsBox{{ $service->id }}" style="display: {{ $service->selection_type !== 'flat' ? 'block' : 'none' }};">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <label class="form-label small fw-semibold text-secondary mb-0">Pricing Options & Sub-services</label>
                                                            <button type="button" class="btn btn-sm btn-outline-info-custom rounded-3" onclick="addOptionRow('editOptionsContainer{{ $service->id }}')">
                                                                <i class="bi bi-plus-lg me-1"></i> Add Sub-service / Rate
                                                            </button>
                                                        </div>
                                                        <div id="editOptionsContainer{{ $service->id }}">
                                                            @foreach($service->options as $index => $option)
                                                                <div class="row g-2 mb-2 option-row">
                                                                    <div class="col-7">
                                                                        <input type="text" name="options[{{ $index }}][name]" class="form-control form-control-sm form-control-dark rounded-2" value="{{ $option->name }}" placeholder="Option Name (e.g. Standard Package)" required>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <input type="number" step="0.01" name="options[{{ $index }}][price]" class="form-control form-control-sm form-control-dark rounded-2" value="{{ $option->price }}" placeholder="Price (₱)" required>
                                                                    </div>
                                                                    <div class="col-1 text-center">
                                                                        <button type="button" class="btn btn-sm btn-outline-danger-custom w-100 rounded-2" onclick="removeOptionRow(this)"><i class="bi bi-trash"></i></button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-dark-cancel rounded-3" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-speed-gradient rounded-3 px-4 fw-semibold">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5 speed-card rounded-4">
                                    <i class="bi bi-inbox text-secondary fs-1 d-block mb-2"></i>
                                    <p class="text-secondary fw-semibold mb-0">No services configured yet. Click "Add New Service" above to populate your catalog.</p>
                                </div>
                            @endforelse

                            <!-- Dynamic No Results Message for Search -->
                            <div id="noSearchResults" class="text-center py-5 speed-card rounded-4 d-none">
                                <i class="bi bi-search text-secondary fs-1 d-block mb-2"></i>
                                <h5 class="fw-bold text-white mb-1">No services matched your search</h5>
                                <p class="text-secondary small mb-0">Try searching for a different keyword or change the vehicle filter.</p>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 2: TECHNICIANS ROSTER -->
                    <div class="tab-pane fade" id="technicians-panel" role="tabpanel">
                        <div class="card speed-card border-0 shadow-sm rounded-4 p-4 mb-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
                                <div>
                                    <h5 class="fw-bold text-white mb-0">Technicians Roster</h5>
                                    <small class="text-secondary">Manage staff members available for vehicle service assignments.</small>
                                </div>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <!-- ADD TECHNICIAN FORM -->
                                    <form action="{{ route('admin.manage-services.store-technician') }}" method="POST" class="d-flex gap-2">
                                        @csrf
                                        <input type="text" name="name" class="form-control form-control-dark rounded-3" placeholder="Enter Technician Name" required>
                                        <button class="btn btn-speed-gradient text-nowrap fw-semibold rounded-3 px-3">
                                            <i class="bi bi-plus-lg me-1"></i> Add Technician
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-dark-custom align-middle mb-0">
                                    <thead>
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
                                                    <span class="{{ !$technician->is_active ? 'text-secondary text-decoration-line-through' : 'fw-semibold text-white' }}">
                                                        {{ $technician->name }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-secondary">
                                                    {{ $technician->created_at ? $technician->created_at->format('M d, Y') : 'N/A' }}
                                                </td>
                                                <td class="align-middle text-secondary small">
                                                    @if(!$technician->is_active)
                                                        {{ $technician->disabled_at ? \Carbon\Carbon::parse($technician->disabled_at)->format('M d, Y') : ($technician->updated_at ? $technician->updated_at->format('M d, Y') : 'N/A') }}
                                                    @else
                                                        <span class="text-secondary">—</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if($technician->is_active)
                                                        <span class="badge badge-status-active px-2.5 py-1.5 rounded-2">Active</span>
                                                    @else
                                                        <span class="badge badge-status-disabled px-2.5 py-1.5 rounded-2">Disabled</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-end">
                                                    <form action="{{ route('admin.manage-services.toggle-technician-status', $technician->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        @if($technician->is_active)
                                                            <button type="submit" class="btn btn-outline-warning-custom btn-sm px-3 rounded-2 fw-semibold">
                                                                <i class="bi bi-slash-circle me-1"></i> Disable
                                                            </button>
                                                        @else
                                                            <button type="submit" class="btn btn-outline-success-custom btn-sm px-3 rounded-2 fw-semibold">
                                                                <i class="bi bi-check-circle me-1"></i> Enable
                                                            </button>
                                                        @endif
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4 text-secondary">No technicians registered yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 3: STAFF & ADMIN ROSTER -->
                    <div class="tab-pane fade" id="staff-panel" role="tabpanel">
                        <div class="card speed-card border-0 shadow-sm rounded-4 p-4 mb-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
                                <div>
                                    <h5 class="fw-bold text-white mb-0">Staff & Admin Roster</h5>
                                    <small class="text-secondary">Manage registered staff, edit details, update passwords via Gmail OTP, and manage active status.</small>
                                </div>
                                
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <button type="button" class="btn btn-speed-gradient rounded-3 px-3 py-2 fw-semibold d-flex align-items-center gap-1 shadow-sm" data-bs-toggle="modal" data-bs-target="#createStaffModal">
                                        <i class="bi bi-person-plus-fill"></i> Add Staff
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-dark-custom align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Email</th>
                                            <th>Contact Number</th>
                                            <th>Date Registered</th>
                                            <th>Date Resigned</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($staffs as $staff)
                                            <tr>
                                                <td class="align-middle">
                                                    <i class="bi bi-person-circle text-secondary me-2"></i>
                                                    <span class="{{ (isset($staff->is_active) && !$staff->is_active) ? 'text-secondary text-decoration-line-through' : 'fw-semibold text-white' }}">
                                                        {{ $staff->name }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">{{ $staff->username }}</td>
                                                <td class="align-middle">
                                                    @if(method_exists($staff, 'isSuperAdmin') && $staff->isSuperAdmin())
                                                        <span class="badge badge-super-admin px-3 py-1.5 rounded-pill">Super Admin</span>
                                                    @elseif(isset($staff->role) && strtolower($staff->role) === 'admin')
                                                        <span class="badge badge-admin px-3 py-1.5 rounded-pill">Admin</span>
                                                    @else
                                                        <span class="badge badge-staff px-3 py-1.5 rounded-pill">
                                                            {{ ucfirst($staff->role ?? 'Staff') }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="align-middle font-monospace text-speed-blue small">{{ $staff->email }}</td>
                                                <td class="align-middle">{{ $staff->contact_number }}</td>
                                                <td class="align-middle text-secondary small">{{ $staff->created_at ? $staff->created_at->format('M d, Y') : 'N/A' }}</td>
                                                <td class="align-middle text-secondary small">
                                                    @if(isset($staff->is_active) && !$staff->is_active)
                                                        {{ $staff->disabled_at ? \Carbon\Carbon::parse($staff->disabled_at)->format('M d, Y') : ($staff->updated_at ? $staff->updated_at->format('M d, Y') : 'N/A') }}
                                                    @else
                                                        <span class="text-secondary">—</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if(!isset($staff->is_active) || $staff->is_active)
                                                        <span class="badge badge-status-active px-2.5 py-1.5 rounded-2">Active</span>
                                                    @else
                                                        <span class="badge badge-status-disabled px-2.5 py-1.5 rounded-2">Disabled</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-end">
                                                    <div class="d-inline-flex gap-1 align-items-center">
                                                        
                                                        <!-- Edit Password via Gmail OTP Button -->
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-warning-custom rounded-3 fw-semibold d-flex align-items-center gap-1" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#resetPasswordModal"
                                                                data-user-id="{{ $staff->id }}"
                                                                data-user-name="{{ $staff->name }}"
                                                                data-user-username="{{ $staff->username }}"
                                                                data-user-email="{{ $staff->email }}">
                                                            <i class="bi bi-key-fill"></i> Reset Password
                                                        </button>

                                                        @if(!method_exists($staff, 'isSuperAdmin') || !$staff->isSuperAdmin())
                                                            <!-- Edit Staff Details Button -->
                                                            <button class="btn btn-sm btn-outline-info-custom rounded-3 fw-semibold d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#editStaffModal{{ $staff->id }}">
                                                                <i class="bi bi-pencil"></i> Edit
                                                            </button>

                                                            <!-- Disable / Enable Toggle Form -->
                                                            <form action="{{ route('admin.manage-services.toggle-staff-status', $staff->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                @if(!isset($staff->is_active) || $staff->is_active)
                                                                    <button type="submit" class="btn btn-sm btn-outline-warning-custom rounded-3 fw-semibold d-flex align-items-center gap-1" onclick="return confirm('Are you sure you want to disable this staff account?');">
                                                                        <i class="bi bi-slash-circle"></i> Disable
                                                                    </button>
                                                                @else
                                                                    <button type="submit" class="btn btn-sm btn-outline-success-custom rounded-3 fw-semibold d-flex align-items-center gap-1">
                                                                        <i class="bi bi-check-circle"></i> Enable
                                                                    </button>
                                                                @endif
                                                            </form>
                                                        @endif
                                                    </div>

                                                    @if(!method_exists($staff, 'isSuperAdmin') || !$staff->isSuperAdmin())
                                                        <!-- EDIT STAFF MODAL -->
                                                        <div class="modal fade" id="editStaffModal{{ $staff->id }}" tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content modal-content-dark rounded-4 shadow">
                                                                    <form action="{{ route('admin.manage-services.update-staff', $staff->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title fw-bold text-white"><i class="bi bi-person-gear text-speed-pink me-2"></i>Edit Staff Details</h5>
                                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                                        </div>
                                                                        <div class="modal-body p-4 text-start">
                                                                            <div class="mb-3">
                                                                                <label class="form-label small fw-semibold text-secondary">Full Name</label>
                                                                                <input type="text" name="name" class="form-control form-control-dark" value="{{ $staff->name }}" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label small fw-semibold text-secondary">Username</label>
                                                                                <input type="text" name="username" class="form-control form-control-dark" value="{{ $staff->username }}" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label small fw-semibold text-secondary">Email Address</label>
                                                                                <input type="email" name="email" class="form-control form-control-dark" value="{{ $staff->email }}" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label small fw-semibold text-secondary">Contact Number</label>
                                                                                <input type="text" name="contact_number" class="form-control form-control-dark" value="{{ $staff->contact_number }}" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-dark-cancel rounded-3" data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit" class="btn btn-speed-gradient rounded-3 px-4 fw-semibold">Save Changes</button>
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
                                                <td colspan="9" class="text-center py-4 text-secondary">No staff or admin accounts registered yet.</td>
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
            <div class="modal-content modal-content-dark rounded-4 shadow">
                <form action="{{ route('admin.manage-services.store-service') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold text-white"><i class="bi bi-plus-circle text-speed-pink me-2"></i>Add New Service</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Service Name <span class="text-speed-pink">*</span></label>
                            <input type="text" name="name" class="form-control form-control-dark" placeholder="e.g., Ceramic Coating Treatment" required>
                        </div>

                        <!-- Service Vehicle Type -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Service Vehicle Type <span class="text-speed-pink">*</span></label>
                            <select name="vehicle_type" class="form-select form-select-dark" required>
                                <option value="All" selected>All Vehicle Types</option>
                                <option value="Sedan">Sedan</option>
                                <option value="Hatchback">Hatchback</option>
                                <option value="Crossover">Crossover</option>
                                <option value="MPV">MPV</option>
                                <option value="SUV">SUV</option>
                                <option value="Pickup Truck">Pickup Truck</option>
                                <option value="Van">Van</option>
                                <option value="Sports Car">Sports Car</option>
                                <option value="Supercar">Supercar</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Description</label>
                            <textarea name="description" class="form-control form-control-dark" rows="2" placeholder="Brief service description..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Notice / Disclaimer Note</label>
                            <input type="text" name="notice" class="form-control form-control-dark" placeholder="e.g., Select appropriate package for your vehicle.">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Selection Type <span class="text-speed-pink">*</span></label>
                            <select name="selection_type" class="form-select form-select-dark" id="selectionTypeSelect" onchange="toggleAddServiceFields(this.value)">
                                <option value="single">Single Select (Radio Buttons)</option>
                                <option value="multi">Multi Select (Checkboxes)</option>
                                <option value="flat">Flat Rate (Single Fixed Price)</option>
                            </select>
                        </div>

                        <div class="mb-3" id="flatPriceBox" style="display: block;">
                            <label class="form-label small fw-semibold text-secondary">Flat / Base Price (₱)</label>
                            <input type="number" step="0.01" name="flat_price" class="form-control form-control-dark" placeholder="3500.00">
                        </div>

                        <div class="mb-3" id="optionsBox">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label small fw-semibold text-secondary mb-0">Pricing Options & Sub-services</label>
                                <button type="button" class="btn btn-sm btn-outline-info-custom rounded-3" onclick="addOptionRow('addOptionsContainer')">
                                    <i class="bi bi-plus-lg me-1"></i> Add Sub-service / Rate
                                </button>
                            </div>
                            <div id="addOptionsContainer">
                                <div class="row g-2 mb-2 option-row">
                                    <div class="col-7">
                                        <input type="text" name="options[0][name]" class="form-control form-control-sm form-control-dark rounded-2" placeholder="Option Name (e.g. Basic Wash)">
                                    </div>
                                    <div class="col-4">
                                        <input type="number" step="0.01" name="options[0][price]" class="form-control form-control-sm form-control-dark rounded-2" placeholder="Price (₱)">
                                    </div>
                                    <div class="col-1 text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger-custom w-100 rounded-2" onclick="removeOptionRow(this)"><i class="bi bi-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark-cancel rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-speed-gradient rounded-3 px-4 fw-semibold">Save Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CREATE ADMIN MODAL -->
    <div class="modal fade" id="createStaffModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-dark rounded-4 shadow">
                <form action="{{ route('admin.manage-services.store-staff') }}" method="POST">
                    @csrf
                    
                    <!-- FORCE ROLE TO ADMIN -->
                    <input type="hidden" name="role" value="admin">

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold text-white"><i class="bi bi-person-plus text-speed-pink me-2"></i>Add Admin Account</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Full Name <span class="text-speed-pink">*</span></label>
                            <input type="text" name="name" class="form-control form-control-dark" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Username <span class="text-speed-pink">*</span></label>
                            <input type="text" name="username" class="form-control form-control-dark" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Email Address <span class="text-speed-pink">*</span></label>
                            <input type="email" name="email" class="form-control form-control-dark" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Contact Number <span class="text-speed-pink">*</span></label>
                            <input type="text" name="contact_number" class="form-control form-control-dark" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Password <span class="text-speed-pink">*</span></label>
                            <input type="password" name="password" class="form-control form-control-dark" required minlength="8">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark-cancel rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-speed-gradient rounded-3 px-4 fw-semibold">Create Admin Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- GMAIL OTP PASSWORD RESET MODAL -->
    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-dark rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                        <i class="bi bi-shield-lock-fill text-speed-pink"></i> Edit Admin Password
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="{{ route('admin.reset-password-otp') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" id="reset_user_id">
                    <input type="hidden" name="username" id="reset_user_username">
                    <input type="hidden" name="email" id="reset_user_email_input">

                    <div class="modal-body p-4">
                        <div class="alert alert-dark border border-secondary border-opacity-25 rounded-3 p-3 mb-3">
                            <span class="text-secondary small d-block mb-1">Target Account:</span>
                            <strong id="reset_user_name" class="text-white d-block fs-6"></strong>
                            <span id="reset_user_email" class="text-speed-blue small font-monospace"></span>
                        </div>

                        <!-- Step 1: Send OTP -->
                        <div class="mb-3">
                            <button type="button" id="sendOtpBtn" class="btn btn-outline-info-custom btn-sm w-100 rounded-3 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-envelope-at-fill"></i> Send Verification Code to Gmail
                            </button>
                            <div id="otpStatusMessage" class="mt-2 text-center small fw-semibold"></div>
                        </div>

                        <hr class="my-3 border-secondary border-opacity-25">

                        <!-- Step 2: Enter Code & Password -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">6-Digit Gmail OTP Code</label>
                            <input type="text" name="otp" class="form-control form-control-dark font-monospace text-center letter-spacing-otp fs-5" maxlength="6" placeholder="000000" required autocomplete="off">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">New Password</label>
                            <input type="password" name="password" class="form-control form-control-dark" placeholder="Minimum 8 characters" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-dark" placeholder="Re-enter new password" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark-cancel rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-speed-gradient rounded-3 px-4 fw-semibold">
                            <i class="bi bi-check-circle me-1"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

   <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Light Mode Toggle JS -->
    <script src="{{ asset('js/theme-toggle.js') }}"></script>

    <script>
        function toggleAddServiceFields(value) {
            const flatBox = document.getElementById('flatPriceBox');
            const optionsBox = document.getElementById('optionsBox');

            if (value === 'flat') {
                flatBox.style.display = 'block';
                optionsBox.style.display = 'none';
            } else if (value === 'single') {
                flatBox.style.display = 'block';
                optionsBox.style.display = 'block';
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
            } else if (value === 'single') {
                flatBox.style.display = 'block';
                optionsBox.style.display = 'block';
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
                    <input type="text" name="options[${index}][name]" class="form-control form-control-sm form-control-dark rounded-2" placeholder="Option Name (e.g. Standard Package)">
                </div>
                <div class="col-4">
                    <input type="number" step="0.01" name="options[${index}][price]" class="form-control form-control-sm form-control-dark rounded-2" placeholder="Price (₱)">
                </div>
                <div class="col-1 text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger-custom w-100 rounded-2" onclick="removeOptionRow(this)"><i class="bi bi-trash"></i></button>
                </div>
            `;
            container.appendChild(row);
        }

        function removeOptionRow(btn) {
            const row = btn.closest('.option-row');
            if (row) row.remove();
        }

        document.addEventListener('DOMContentLoaded', function () {
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

            const resetPasswordModal = document.getElementById('resetPasswordModal');
            const sendOtpBtn = document.getElementById('sendOtpBtn');
            const otpStatusMessage = document.getElementById('otpStatusMessage');

            if (resetPasswordModal && sendOtpBtn) {
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