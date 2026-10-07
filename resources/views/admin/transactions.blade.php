<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedLane - Transaction Records & Reports</title>

    <!-- Early Theme Check Script (Defaults to Light Theme) -->
    <script>
        const savedTheme = localStorage.getItem('speedlane_theme');
        if (savedTheme !== 'dark') {
            document.documentElement.classList.add('light-theme');
        } else {
            document.documentElement.classList.remove('light-theme');
        }
    </script>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
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

        .text-speed-pink { color: var(--speed-pink) !important; }
        .text-speed-blue { color: var(--speed-blue) !important; }
        .bg-speed-pink { background-color: var(--speed-pink) !important; }
        .bg-speed-blue { background-color: var(--speed-blue) !important; }

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

        .badge-mechanic {
            background-color: rgba(0, 162, 255, 0.18) !important;
            color: #7dd3fc !important;
            border: 1px solid rgba(0, 162, 255, 0.4) !important;
            font-weight: 600;
            letter-spacing: 0.3px;
            box-shadow: 0 0 10px rgba(0, 162, 255, 0.1);
        }

        /* High-Contrast "PAID" Badges */
        .badge-paid-view {
            background-color: #15803d !important;
            color: #ffffff !important;
            border: 1px solid #166534 !important;
            font-weight: 700 !important;
            letter-spacing: 0.5px;
        }

        .badge-paid-pdf {
            background-color: #15803d !important;
            color: #ffffff !important;
            border: 1px solid #166534 !important;
            font-weight: 700 !important;
            letter-spacing: 0.5px;
        }

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

        .speed-card {
            background-color: var(--speed-card-bg) !important;
            border: 1px solid var(--speed-card-border) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

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
        }

        .form-control-dark, .form-select-dark {
            background-color: #06080d !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #ffffff !important;
            transition: all 0.25s ease;
        }

        .form-control-dark:focus, .form-select-dark:focus {
            border-color: var(--speed-blue) !important;
            box-shadow: 0 0 12px rgba(0, 162, 255, 0.25) !important;
            color: #ffffff !important;
        }

        .form-control-dark::placeholder {
            color: #64748b !important;
        }

        .input-group-text-dark {
            background-color: #090c14 !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            border-right: none !important;
            color: var(--speed-blue) !important;
        }

        .input-group .form-control-dark {
            border-left: none !important;
        }

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

        #theme-toggle-btn {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.25s ease;
            color: #ffffff;
        }

        #theme-toggle-btn:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }

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

        html.light-theme .text-white {
            color: #0f172a !important;
        }

        html.light-theme .text-secondary {
            color: #475569 !important;
        }

        html.light-theme .text-light {
            color: #334155 !important;
        }

        html.light-theme .text-muted {
            color: #64748b !important;
        }

        html.light-theme .opacity-75 {
            opacity: 1 !important;
        }

        html.light-theme .bg-black,
        html.light-theme [class*="bg-black"] {
            background-color: #f1f5f9 !important;
            color: #1e293b !important;
        }

        html.light-theme .border-secondary,
        html.light-theme [class*="border-secondary"] {
            border-color: #cbd5e1 !important;
        }

        html.light-theme .border-end-md {
            border-color: #cbd5e1 !important;
        }

        html.light-theme .badge.bg-black,
        html.light-theme .badge.bg-secondary,
        html.light-theme .badge.text-secondary {
            background-color: #e2e8f0 !important;
            color: #334155 !important;
            border: 1px solid #cbd5e1 !important;
        }

        html.light-theme .navbar-speed {
            background: rgba(255, 255, 255, 0.95) !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
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

        html.light-theme .badge-mechanic {
            background-color: #e0f2fe !important;
            color: #0284c7 !important;
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

        html.light-theme .speed-card h2,
        html.light-theme .speed-card h3,
        html.light-theme .speed-card h4,
        html.light-theme .speed-card h5,
        html.light-theme .speed-card h6 {
            color: #0f172a !important;
        }

        html.light-theme main h3 {
            color: #0f172a !important;
        }

        html.light-theme .form-control-dark, 
        html.light-theme .form-select-dark {
            background-color: #f1f5f9 !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
        }

        html.light-theme .form-control-dark::placeholder {
            color: #94a3b8 !important;
        }

        html.light-theme .input-group-text-dark {
            background-color: #e2e8f0 !important;
            border: 1px solid #cbd5e1 !important;
            border-right: none !important;
        }

        html.light-theme .modal-content-dark {
            background-color: #ffffff !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            color: #0f172a !important;
        }

        html.light-theme .modal-header,
        html.light-theme .modal-footer {
            border-color: #e2e8f0 !important;
        }

        html.light-theme .modal-title {
            color: #0f172a !important;
        }

        html.light-theme .modal-body {
            background-color: #f8fafc !important;
            color: #0f172a !important;
        }

        html.light-theme .report-card-option {
            background-color: #ffffff !important;
            border-color: #cbd5e1 !important;
        }

        html.light-theme .report-card-option strong {
            color: #0f172a !important;
        }

        html.light-theme .custom-admin-table {
            color: #1e293b !important;
        }

        html.light-theme .custom-admin-table th {
            background-color: #f1f5f9 !important;
            color: #334155 !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }

        html.light-theme .custom-admin-table td {
            color: #1e293b !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }

        html.light-theme .custom-admin-table tfoot td {
            color: #0f172a !important;
        }

        html.light-theme .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(50%);
        }

        html.light-theme .btn-outline-light {
            color: #334155 !important;
            border-color: #cbd5e1 !important;
        }

        html.light-theme .btn-outline-light:hover {
            background-color: #e2e8f0 !important;
            color: #0f172a !important;
        }

        /* High-Contrast Pagination Styling for Light and Dark Modes */
        .pagination .page-link {
            background-color: #1e293b !important;
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
            font-weight: 600 !important;
            transition: all 0.2s ease-in-out;
        }

        .pagination .page-link:hover {
            background-color: var(--speed-blue) !important;
            color: #ffffff !important;
            border-color: var(--speed-blue) !important;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(90deg, var(--speed-pink) 0%, var(--speed-blue) 100%) !important;
            color: #ffffff !important;
            border-color: transparent !important;
            font-weight: 700 !important;
            box-shadow: 0 2px 8px rgba(244, 37, 130, 0.3);
        }

        .pagination .page-item.disabled .page-link {
            background-color: #0f172a !important;
            color: #94a3b8 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            opacity: 0.85;
        }

        html.light-theme .pagination .page-link {
            background-color: #ffffff !important;
            color: #0f172a !important;
            border-color: #cbd5e1 !important;
        }

        html.light-theme .pagination .page-link:hover {
            background-color: #00a2ff !important;
            color: #ffffff !important;
            border-color: #00a2ff !important;
        }

        html.light-theme .pagination .page-item.active .page-link {
            background: linear-gradient(90deg, var(--speed-pink) 0%, var(--speed-blue) 100%) !important;
            color: #ffffff !important;
            border-color: transparent !important;
        }

        html.light-theme .pagination .page-item.disabled .page-link {
            background-color: #f1f5f9 !important;
            color: #64748b !important;
            border-color: #cbd5e1 !important;
            opacity: 0.85;
        }

        .custom-admin-table {
            color: #e2e8f0;
        }
        .custom-admin-table th {
            background-color: rgba(6, 8, 13, 0.8) !important;
            color: #cbd5e1 !important;
            border-bottom: 1px solid var(--speed-card-border) !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 12px 16px;
            white-space: nowrap;
        }
        .custom-admin-table td {
            background-color: transparent !important;
            color: #e2e8f0 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            padding: 14px 16px;
            vertical-align: middle;
        }
        .custom-admin-table tr:hover td {
            background-color: rgba(255, 255, 255, 0.02) !important;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .extra-small { font-size: 0.75rem; }

        .report-card-option {
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background-color: #06080d;
        }
        .report-card-option:hover {
            border-color: var(--speed-blue);
            box-shadow: 0 4px 15px rgba(0, 162, 255, 0.15);
            transform: translateY(-1px);
        }
        .form-check-input:checked + .report-card-label .report-card-option {
            border-color: var(--speed-pink) !important;
            background-color: rgba(244, 37, 130, 0.08) !important;
            box-shadow: 0 0 15px rgba(244, 37, 130, 0.2);
        }

        .modal-content-dark {
            background-color: var(--speed-card-bg) !important;
            border: 1px solid var(--speed-card-border) !important;
            color: #e2e8f0;
        }

        .printable-area {
            height: auto !important;
            max-height: none !important;
            overflow: visible !important;
        }

        /* Prevent currency symbols and amounts from line-wrapping & PDF overlay issues */
        .text-nowrap, td.text-nowrap, th.text-nowrap {
            white-space: nowrap !important;
        }

        .peso-symbol, span.peso-symbol {
            font-family: 'DejaVu Sans', Arial, sans-serif !important;
            display: inline !important;
            margin-right: 2px;
            white-space: nowrap !important;
        }

        /* Direct Print Formatting Styles */
        @media print {
            @page {
                size: portrait;
                margin: 10mm;
            }

            tfoot {
                display: table-row-group !important;
            }

            *, *::before, *::after {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            html, body {
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important;
                color: #000000 !important;
                height: auto !important;
                min-height: 0 !important;
                overflow: visible !important;
                zoom: 100% !important;
            }

            body * { 
                visibility: hidden !important; 
            }

            .print-active, 
            .print-active * { 
                visibility: visible !important; 
            }

            .print-active { 
                position: absolute !important; 
                left: 0 !important; 
                top: 0 !important; 
                width: 100% !important; 
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important; 
                transform: none !important;
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
                overflow: visible !important;
                height: auto !important;
                min-height: 0 !important;
            }

            .printable-area {
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                background: #ffffff !important;
            }

            .table-responsive {
                overflow: visible !important;
            }

            table {
                page-break-inside: auto !important;
                break-inside: auto !important;
            }

            tr, blockquote, img, svg {
                page-break-inside: avoid;
                break-inside: avoid;
            }
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
                    <span class="brand-subtext d-block">ADMIN OVERVIEW</span>
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
                    <a class="nav-link admin-nav-link active rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.transactions') }}">
                        <i class="bi bi-file-earmark-text text-speed-blue"></i> Transaction Records
                    </a>

                    @if(auth()->check() && method_exists(auth()->user(), 'isSuperAdmin') && auth()->user()->isSuperAdmin())
                        <a class="nav-link admin-nav-link rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.manage-services.index') }}">
                            <i class="bi bi-gear-fill text-speed-pink"></i> Manage Services
                        </a>
                    @endif
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="col-md-9 col-lg-10 p-4">
                
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                    <div>
                        <h3 class="fw-bold text-white mb-1">Transaction Records & Executive Reports</h3>
                        <p class="text-secondary mb-0 small">View transaction history, analyze technician performance, and generate business decision reports.</p>
                    </div>

                    <button class="btn btn-speed-gradient rounded-3 px-3 py-2 fw-semibold d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#generateReportModal">
                        <i class="bi bi-bar-chart-line-fill"></i> Generate Business Report
                    </button>
                </div>

                <!-- Stats Overview Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card speed-card p-3 rounded-4 d-flex flex-row justify-content-between align-items-center">
                            <div>
                                <span class="text-secondary small d-block mb-1">Completed Services</span>
                                <h3 class="fw-bold text-white mb-0">{{ $completedCount ?? (method_exists($transactions, 'total') ? $transactions->total() : $transactions->count()) }}</h3>
                            </div>
                            <div class="stat-icon bg-speed-pink text-white fs-4 shadow-sm">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card speed-card p-3 rounded-4 d-flex flex-row justify-content-between align-items-center">
                            <div>
                                <span class="text-secondary small d-block mb-1">Status Scope</span>
                                <h3 class="fw-bold mb-0" style="color: #4ade80 !important;">Completed Only</h3>
                            </div>
                            <div class="stat-icon bg-success bg-opacity-20 fs-4 border border-success border-opacity-25" style="color: #4ade80 !important;">
                                <i class="bi bi-shield-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card speed-card p-3 rounded-4 d-flex flex-row justify-content-between align-items-center">
                            <div>
                                <span class="text-secondary small d-block mb-1">Total Revenue</span>
                                <h3 class="fw-bold text-speed-blue mb-0 text-nowrap"><span class="peso-symbol">&#8369;</span>{{ number_format($totalRevenue ?? 0, 2) }}</h3>
                            </div>
                            <div class="stat-icon bg-speed-blue text-white fs-4 shadow-sm">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Search and Filter Bar -->
                <div class="card speed-card rounded-4 p-3 mb-4">
                    <form method="GET" action="{{ route('admin.transactions') }}" id="searchFilterForm">
                        <input type="hidden" name="per_page" id="per_page_hidden" value="{{ request('per_page', method_exists($transactions, 'perPage') ? $transactions->perPage() : 20) }}">
                        <div class="row g-2">
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold text-light opacity-75 mb-1">Search Records</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text input-group-text-dark"><i class="bi bi-search text-speed-blue"></i></span>
                                    <input type="text" name="search" id="transactionSearchInput" class="form-control form-control-dark" placeholder="Customer, mechanic, plate..." value="{{ request('search') }}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small fw-semibold text-light opacity-75 mb-1">Vehicle Type</label>
                                <select name="vehicle_type" class="form-select form-select-sm form-select-dark" onchange="this.form.submit()">
                                    <option value="">All Vehicles</option>
                                    @php
                                        $vTypesList = (isset($vehicleTypes) && count($vehicleTypes) > 0) 
                                            ? $vehicleTypes 
                                            : ['Hatchback', 'Sedan', 'Coupe', 'Crossover', 'MPV', 'Wagon', 'SUV', 'Pickup Truck', 'Sports Car', 'Van', 'Supercar'];
                                    @endphp
                                    @foreach($vTypesList as $vType)
                                        @php 
                                            $vTypeName = is_object($vType) ? ($vType->vehicle_type ?? $vType->name ?? '') : (is_array($vType) ? ($vType['vehicle_type'] ?? $vType['name'] ?? '') : $vType); 
                                        @endphp
                                        <option value="{{ $vTypeName }}" {{ request('vehicle_type') == $vTypeName ? 'selected' : '' }}>{{ $vTypeName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small fw-semibold text-light opacity-75 mb-1">Vehicle Brand</label>
                                <select name="brand" class="form-select form-select-sm form-select-dark" onchange="this.form.submit()">
                                    <option value="">All Brands</option>
                                    @php
                                        $vBrandsList = (isset($vehicleBrands) && count($vehicleBrands) > 0) 
                                            ? $vehicleBrands 
                                            : ['Toyota', 'Porsche', 'Ford', 'Chevrolet'];
                                    @endphp
                                    @foreach($vBrandsList as $b)
                                        @php 
                                            $bName = is_object($b) ? ($b->brand ?? $b->name ?? '') : (is_array($b) ? ($b['brand'] ?? $b['name'] ?? '') : $b); 
                                        @endphp
                                        <option value="{{ $bName }}" {{ (request('brand') == $bName || request('vehicle_brand') == $bName) ? 'selected' : '' }}>{{ $bName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small fw-semibold text-light opacity-75 mb-1">Service Type</label>
                                <select name="service_type" class="form-select form-select-sm form-select-dark" onchange="this.form.submit()">
                                    <option value="">All Services</option>
                                    @php
                                        $vServicesList = (isset($availableServices) && count($availableServices) > 0) 
                                            ? $availableServices 
                                            : ['Ceramic Coating', 'Graphene Coating', 'PPF', 'Interior Detailing', 'Exterior Detailing', 'Washover', 'Undercoat'];
                                    @endphp
                                    @foreach($vServicesList as $srv)
                                        @php $srvName = is_object($srv) ? ($srv->name ?? '') : (is_array($srv) ? ($srv['name'] ?? '') : $srv); @endphp
                                        <option value="{{ $srvName }}" {{ request('service_type') == $srvName ? 'selected' : '' }}>
                                            {{ $srvName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small fw-semibold text-light opacity-75 mb-1">Date</label>
                                <input type="date" name="date" class="form-control form-control-sm form-control-dark" value="{{ request('date') }}" onchange="this.form.submit()">
                            </div>

                            <div class="col-md-1 d-flex align-items-end gap-1">
                                <button type="submit" class="btn btn-speed-gradient btn-sm rounded-3 w-100 fw-semibold" title="Apply Filters">
                                    <i class="bi bi-funnel"></i>
                                </button>
                                <a href="{{ route('admin.transactions') }}" class="btn btn-outline-light btn-sm rounded-3 px-2" title="Reset Filters">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Completed Transactions Table -->
                <div class="card speed-card rounded-4 p-4 mb-4">
                    @php
                        $requestedPerPage = (int) request('per_page', method_exists($transactions, 'perPage') ? $transactions->perPage() : 20);
                        $currentPage = (int) request('page', 1);

                        if (method_exists($transactions, 'hasPages') && $transactions->hasPages()) {
                            $displayTransactions = $transactions->take($requestedPerPage);
                        } elseif (method_exists($transactions, 'slice')) {
                            $offset = ($currentPage - 1) * $requestedPerPage;
                            $displayTransactions = $transactions->slice($offset, $requestedPerPage);
                        } elseif (is_array($transactions)) {
                            $offset = ($currentPage - 1) * $requestedPerPage;
                            $displayTransactions = array_slice($transactions, $offset, $requestedPerPage);
                        } else {
                            $displayTransactions = $transactions;
                        }

                        $displayCount = method_exists($displayTransactions, 'count') ? $displayTransactions->count() : count($displayTransactions);
                    @endphp
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold text-white mb-0 d-flex align-items-center gap-2 fs-6">
                            <i class="bi bi-file-earmark-text text-speed-pink"></i> Service Records Log
                        </h5>
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center gap-1">
                                <span class="text-secondary small me-1">Show:</span>
                                <select name="per_page" form="searchFilterForm" class="form-select form-select-sm form-select-dark py-1 px-2" style="width: auto;" onchange="if(document.getElementById('per_page_hidden')) { document.getElementById('per_page_hidden').value = this.value; } document.getElementById('searchFilterForm').submit();">
                                    <option value="10" {{ $requestedPerPage == 10 ? 'selected' : '' }}>10 per page</option>
                                    <option value="20" {{ $requestedPerPage == 20 ? 'selected' : '' }}>20 per page</option>
                                    <option value="30" {{ $requestedPerPage == 30 ? 'selected' : '' }}>30 per page</option>
                                    <option value="50" {{ $requestedPerPage == 50 ? 'selected' : '' }}>50 per page</option>
                                    <option value="100" {{ $requestedPerPage == 100 ? 'selected' : '' }}>100 per page</option>
                                </select>
                            </div>
                            <span class="badge bg-black bg-opacity-50 text-secondary border border-secondary border-opacity-25 px-3 py-2 rounded-pill small">
                                Showing {{ $displayCount }} record(s)
                            </span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle custom-admin-table mb-0" id="transactionsTable">
                            <thead>
                                <tr>
                                    <th>Tracking Code</th>
                                    <th>Customer Name</th>
                                    <th>Contact</th>
                                    <th>Vehicle</th>
                                    <th>Plate Number</th>
                                    <th>Assigned Mechanic</th>
                                    <th>Services Completed</th>
                                    <th>Date Registered</th>
                                    <th>Date Completed</th>
                                    <th class="text-nowrap">Total Cost</th>
                                    <th class="text-center pe-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                              @forelse($displayTransactions as $service)
    @php
        $mechanicName = $service->mechanic_assigned 
            ?? ($service->technician->name ?? $service->technician->full_name ?? null)
            ?? ($service->mechanic->name ?? $service->mechanic->full_name ?? null)
            ?? $service->technician_name 
            ?? $service->mechanic_name 
            ?? 'Unassigned';

        $customerName = $service->customer_name 
            ?? ($service->customer->name ?? null)
            ?? ($service->user->name ?? null)
            ?? $service->client_name 
            ?? $service->name 
            ?? 'N/A';

        $contactPhone = $service->contact_number 
            ?? $service->phone_number 
            ?? $service->customer_phone 
            ?? $service->phone 
            ?? ($service->customer->phone ?? 'N/A');

        $servicesArr = is_array($service->selected_services) 
            ? $service->selected_services 
            : json_decode($service->selected_services ?? '[]', true);

        if (!is_array($servicesArr)) {
            $servicesArr = array_filter(explode(', ', (string)($service->selected_services ?? '')));
        }

        $serviceNames = array_map(function($item) {
            return is_array($item) ? ($item['name'] ?? '') : $item;
        }, $servicesArr ?? []);
        $serviceNames = array_filter($serviceNames);

        // FILTER SPECIFIC SERVICE WHEN SERVICE_TYPE FILTER IS APPLIED
        $reqService = request('service_type');
        if (!empty($reqService)) {
            $serviceNames = array_values(array_filter($serviceNames, function($s) use ($reqService) {
                return stripos((string)$s, (string)$reqService) !== false;
            }));
        }

        $vehicleBrand = $service->vehicle_make ?? $service->vehicle_brand ?? $service->brand ?? $service->make ?? 'N/A';
        $vehicleModel = $service->vehicle_model ?? $service->model ?? 'N/A';
        $vehicleType  = $service->vehicle_type ?? $service->body_type ?? 'Sedan';
    @endphp
    <tr>
        <td class="fw-bold font-monospace text-speed-blue small">{{ $service->tracking_code }}</td>
        <td class="fw-semibold text-white">{{ $customerName }}</td>
        <td class="text-secondary small font-monospace">{{ $contactPhone }}</td>
        <td class="fw-medium text-white small">{{ $vehicleBrand }} {{ $vehicleModel }} ({{ $vehicleType }})</td>
        <td class="font-monospace text-uppercase small text-secondary fw-bold">{{ $service->plate_number ?? 'N/A' }}</td>
        <td>
            <span class="badge badge-mechanic rounded-pill px-3 py-1.5 small fw-semibold d-inline-flex align-items-center gap-1">
                <i class="bi bi-wrench-adjustable text-speed-blue"></i> {{ $mechanicName }}
            </span>
        </td>
        <td class="small text-truncate text-secondary" style="max-width: 180px;">
            {{ count($serviceNames) > 0 ? implode(', ', $serviceNames) : 'General Detailing' }}
        </td>
        <td class="small text-secondary">
            {{ \Carbon\Carbon::parse($service->created_at)->format('M d, Y') }}
        </td>
        <td class="small text-secondary">
            {{ \Carbon\Carbon::parse($service->updated_at)->format('M d, Y') }}
        </td>
        <td class="fw-bold font-monospace text-speed-pink text-nowrap">
            <span class="peso-symbol">&#8369;</span>{{ number_format((float)($service->total_cost ?? 0), 2) }}
        </td>
        <td class="text-center">
            <div class="d-flex justify-content-center gap-1">
                <button type="button" class="btn btn-outline-danger btn-sm rounded-2 px-2 py-1 d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#pdfPreviewModal{{ $service->id }}">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="11" class="text-center py-5 text-secondary">
            <i class="bi bi-inbox fs-2 text-secondary d-block mb-2"></i>
            No completed services found matching your filters.
        </td>
    </tr>
@endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Navigation Controls with Arrows -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 border-top border-secondary border-opacity-25 mt-3 gap-2">
                        <div class="text-secondary small">
                            @if(method_exists($transactions, 'firstItem') && $transactions->firstItem())
                                @php
                                    $firstItem = $transactions->firstItem();
                                    $lastItem = $firstItem ? ($firstItem + $displayCount - 1) : 0;
                                @endphp
                                Showing {{ $firstItem }} to {{ $lastItem }} of {{ $transactions->total() }} records
                            @else
                                @php
                                    $totalRecs = isset($completedCount) ? $completedCount : (method_exists($transactions, 'total') ? $transactions->total() : (method_exists($transactions, 'count') ? $transactions->count() : count($transactions)));
                                    $firstItem = $totalRecs > 0 ? (($currentPage - 1) * $requestedPerPage + 1) : 0;
                                    $lastItem = min($firstItem + $displayCount - 1, $totalRecs);
                                @endphp
                                Showing {{ $firstItem }} to {{ $lastItem }} of {{ $totalRecs }} records
                            @endif
                        </div>

                        <div>
                            @if(method_exists($transactions, 'hasPages') && $transactions->hasPages())
                                {{ $transactions->withQueryString()->links('pagination::bootstrap-5') }}
                            @else
                                @php
                                    $totalRecords = isset($completedCount) ? $completedCount : (method_exists($transactions, 'total') ? $transactions->total() : (method_exists($transactions, 'count') ? $transactions->count() : count($transactions)));
                                    $hasMorePages = ($currentPage * $requestedPerPage) < $totalRecords;
                                @endphp
                                <nav aria-label="Transaction pagination">
                                    <ul class="pagination pagination-sm mb-0">
                                        <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
                                            <a class="page-link px-3" href="{{ request()->fullUrlWithQuery(['page' => max(1, $currentPage - 1)]) }}">
                                                <i class="bi bi-arrow-left me-1"></i> Previous
                                            </a>
                                        </li>
                                        <li class="page-item active">
                                            <span class="page-link px-3">Page {{ $currentPage }}</span>
                                        </li>
                                        <li class="page-item {{ !$hasMorePages ? 'disabled' : '' }}">
                                            <a class="page-link px-3" href="{{ request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}">
                                                Next <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            @endif
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- RECORD MODALS LOOP -->
@foreach($displayTransactions as $service)
    @php
        $mechanicName = $service->mechanic_assigned 
            ?? ($service->technician->name ?? $service->technician->full_name ?? null)
            ?? ($service->mechanic->name ?? $service->mechanic->full_name ?? null)
            ?? $service->technician_name 
            ?? $service->mechanic_name 
            ?? 'Unassigned';

        $customerName = $service->customer_name 
            ?? ($service->customer->name ?? null)
            ?? ($service->user->name ?? null)
            ?? $service->client_name 
            ?? $service->name 
            ?? 'N/A';

        $contactPhone = $service->contact_number 
            ?? $service->phone_number 
            ?? $service->customer_phone 
            ?? $service->phone 
            ?? ($service->customer->phone ?? 'N/A');

        $servicesArr = is_array($service->selected_services) 
            ? $service->selected_services 
            : json_decode($service->selected_services ?? '[]', true);

        if (!is_array($servicesArr)) {
            $servicesArr = array_filter(explode(', ', (string)($service->selected_services ?? '')));
        }

        $serviceNames = array_map(function($item) {
            return is_array($item) ? ($item['name'] ?? '') : $item;
        }, $servicesArr ?? []);
        $serviceNames = array_filter($serviceNames);

        // FILTER SPECIFIC SERVICE WHEN SERVICE_TYPE FILTER IS APPLIED
        $reqService = request('service_type');
        if (!empty($reqService)) {
            $serviceNames = array_values(array_filter($serviceNames, function($s) use ($reqService) {
                return stripos((string)$s, (string)$reqService) !== false;
            }));
        }

        $vehicleBrand = $service->vehicle_make ?? $service->vehicle_brand ?? $service->brand ?? $service->make ?? 'N/A';
        $vehicleModel = $service->vehicle_model ?? $service->model ?? 'N/A';
        $vehicleType  = $service->vehicle_type ?? $service->body_type ?? 'Sedan';
        $vehicleYear  = $service->vehicle_year ?? $service->year ?? 'N/A';
        $plateNumber  = $service->plate_number ?? $service->plate_no ?? $service->plate ?? 'N/A';
    @endphp

    <!-- PDF Receipt Preview Modal (With Price Note & Thermal Receipt Direct Print) -->
    <div class="modal fade" id="pdfPreviewModal{{ $service->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content modal-content-dark rounded-4 shadow">
                <div class="modal-header border-bottom border-secondary border-opacity-25 py-3">
                    <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2 fs-6">
                        <i class="bi bi-file-earmark-pdf text-danger fs-5"></i> Official PDF Receipt ({{ $service->tracking_code }})
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-black bg-opacity-30">
                    <!-- Screen PDF Document View -->
                    <div class="printable-area p-4 border rounded-3 bg-white shadow-sm text-dark mx-auto" style="max-width: 750px;">
                        <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                            <div>
                                <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                                    <i class="bi bi-car-front-fill text-speed-pink"></i>
                                    <span><span class="text-speed-pink">SPEED</span><span class="text-speed-blue">LANE</span></span>
                                </h4>
                                <p class="text-muted small mb-0">Official Transaction & Service Record Receipt</p>
                            </div>
                            <div class="text-end">
                                <span class="badge badge-paid-pdf px-3 py-1.5 rounded-pill mb-1 fw-bold">PAID</span>
                                <p class="text-muted small mb-0">Tracking Code: <strong class="font-monospace text-dark">{{ $service->tracking_code }}</strong></p>
                            </div>
                        </div>

                        <div class="row g-3 mb-3 p-3 bg-light rounded-3 border-0 mx-0">
                            <div class="col-6">
                                <span class="text-muted extra-small d-block fw-semibold text-uppercase">Customer Information</span>
                                <strong class="text-dark fs-6">{{ $customerName }}</strong><br>
                                <small class="text-dark font-monospace"><i class="bi bi-telephone me-1"></i>{{ $contactPhone }}</small>
                            </div>
                            <div class="col-6 text-end">
                                <span class="text-muted extra-small d-block fw-semibold text-uppercase">Assigned Mechanic</span>
                                <strong class="text-dark fs-6"><i class="bi bi-wrench me-1 text-primary"></i>{{ $mechanicName }}</strong>
                            </div>
                        </div>

                        <div class="p-3 border rounded-3 bg-light-subtle mb-3">
                            <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2 border-bottom pb-2">
                                <i class="bi bi-card-heading text-primary"></i> Vehicle Information
                            </h6>
                            <div class="row g-3">
                                <div class="col-3">
                                    <span class="text-muted extra-small d-block text-uppercase fw-semibold">Brand & Model</span>
                                    <span class="fw-bold text-dark small">{{ $vehicleBrand }} {{ $vehicleModel }}</span>
                                </div>
                                <div class="col-3">
                                    <span class="text-muted extra-small d-block text-uppercase fw-semibold">Vehicle Type</span>
                                    <span class="fw-bold text-dark small">{{ $vehicleType }}</span>
                                </div>
                                <div class="col-3">
                                    <span class="text-muted extra-small d-block text-uppercase fw-semibold">Plate Number</span>
                                    <span class="fw-bold font-monospace text-uppercase text-dark small">{{ $plateNumber }}</span>
                                </div>
                                <div class="col-3">
                                    <span class="text-muted extra-small d-block text-uppercase fw-semibold">Year</span>
                                    <span class="fw-bold text-dark small">{{ $vehicleYear }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row g-2 mb-3 p-2 bg-light rounded-3 border-0 mx-0">
                            <div class="col-6">
                                <span class="text-muted extra-small d-block">Date Registered:</span>
                                <strong class="text-dark small">{{ \Carbon\Carbon::parse($service->created_at)->format('M d, Y h:i A') }}</strong>
                            </div>
                            <div class="col-6 text-end">
                                <span class="text-muted extra-small d-block">Date Completed:</span>
                                <strong class="text-dark small">{{ \Carbon\Carbon::parse($service->updated_at)->format('M d, Y h:i A') }}</strong>
                            </div>
                        </div>

                        <!-- Price Adjustment Note Box -->
                        <div class="p-3 border rounded-3 bg-light-subtle mb-3">
                            <span class="text-muted extra-small d-block text-uppercase fw-semibold mb-1">
                                <i class="bi bi-sticky me-1 text-primary"></i> Price Adjustment Note
                            </span>
                            <p class="mb-0 small fw-medium text-dark" style="word-break: break-word;">
                                {{ $service->price_adjustment_note ?? $service->adjustment_note ?? $service->price_note ?? $service->notes ?? $service->price_adjustment_reason ?? 'No price adjustment notes recorded for this transaction.' }}
                            </p>
                        </div>

                        <div class="table-responsive mb-3">
                            <table class="table table-sm table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr class="small text-dark">
                                        <th style="width: 40px;" class="text-center">#</th>
                                        <th>Completed Service Description</th>
                                        <th class="text-end" style="width: 120px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($serviceNames) > 0)
                                        @foreach($serviceNames as $idx => $sName)
                                            <tr>
                                                <td class="text-center small text-dark">{{ $idx + 1 }}</td>
                                                <td class="fw-semibold text-dark">{{ $sName }}</td>
                                                <td class="text-end text-dark small fw-bold">Completed</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center small text-dark">1</td>
                                            <td class="fw-semibold text-dark">General Detailing & Care Service</td>
                                            <td class="text-end text-dark small fw-bold">Completed</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="2" class="text-end fw-bold text-dark">Total Cost Paid:</td>
                                        <td class="text-end fw-bold text-dark font-monospace fs-5 text-nowrap">
                                            <span class="peso-symbol">&#8369;</span>{{ number_format((float)($service->total_cost ?? 0), 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="text-center extra-small text-muted pt-3 border-top">
                            Thank you for choosing SpeedLane AutoSpa! Keep this receipt for warranty records.
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top border-secondary border-opacity-25 py-2 d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-outline-secondary rounded-3 btn-sm px-3" data-bs-dismiss="modal">Close</button>
                    <div class="d-flex gap-2">
                        <!-- Direct Thermal Receipt Print Button -->
                        <button type="button" onclick="printThermalReceipt('{{ route('admin.transactions.thermal', $service->id) }}')" class="btn btn-outline-light btn-sm rounded-3 fw-semibold d-flex align-items-center gap-1">
                            <i class="bi bi-printer-fill"></i> Print Receipt
                        </button>
                        <a href="{{ route('admin.transactions.pdf', $service->id) }}" class="btn btn-danger btn-sm rounded-3 fw-semibold d-flex align-items-center gap-1" target="_blank">
                            <i class="bi bi-file-earmark-pdf-fill"></i> Download PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

    <!-- SYSTEM REPORT GENERATION MODAL -->
    <div class="modal fade" id="generateReportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content modal-content-dark border-0 rounded-4 shadow-lg overflow-hidden">
                <div class="modal-header border-bottom border-secondary border-opacity-25 py-3 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-speed-pink text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="bi bi-bar-chart-line-fill fs-6"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-white mb-0 fs-6">Business Report Generator</h5>
                            <span class="text-secondary extra-small">Select report type and options to evaluate operational analytics</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <form id="reportFilterForm">
                        @csrf
                        
                        <!-- 1. Report Category Selection -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-white small text-uppercase mb-2 d-flex align-items-center gap-2">
                                <span class="badge bg-speed-pink rounded-circle" style="width: 20px; height: 20px; line-height: 12px;">1</span>
                                Select Report Category
                            </label>
                            
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input class="form-check-input d-none" type="radio" name="report_type" id="type_financial" value="financial" checked onchange="toggleReportFilters()">
                                    <label class="w-100 report-card-label m-0" for="type_financial">
                                        <div class="report-card-option p-3 rounded-3 d-flex align-items-center gap-3">
                                            <div class="bg-speed-pink text-white p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; min-width: 38px;">
                                                <i class="bi bi-cash-stack fs-5"></i>
                                            </div>
                                            <div>
                                                <strong class="d-block text-white small">Financial & Revenue</strong>
                                                <span class="text-secondary extra-small">Gross revenue, pricing & profits</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <div class="col-md-6">
                                    <input class="form-check-input d-none" type="radio" name="report_type" id="type_technician" value="technician" onchange="toggleReportFilters()">
                                    <label class="w-100 report-card-label m-0" for="type_technician">
                                        <div class="report-card-option p-3 rounded-3 d-flex align-items-center gap-3">
                                            <div class="bg-speed-blue text-white p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; min-width: 38px;">
                                                <i class="bi bi-person-badge-fill fs-5"></i>
                                            </div>
                                            <div>
                                                <strong class="d-block text-white small">Technician Performance</strong>
                                                <span class="text-secondary extra-small">Jobs completed & mechanic output</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <div class="col-md-6">
                                    <input class="form-check-input d-none" type="radio" name="report_type" id="type_service" value="service_demand" onchange="toggleReportFilters()">
                                    <label class="w-100 report-card-label m-0" for="type_service">
                                        <div class="report-card-option p-3 rounded-3 d-flex align-items-center gap-3">
                                            <div class="bg-speed-pink text-white p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; min-width: 38px;">
                                                <i class="bi bi-pie-chart-fill fs-5"></i>
                                            </div>
                                            <div>
                                                <strong class="d-block text-white small">Service Demand Analytics</strong>
                                                <span class="text-secondary extra-small">Popular services & package volume</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <div class="col-md-6">
                                    <input class="form-check-input d-none" type="radio" name="report_type" id="type_queue" value="queue_log" onchange="toggleReportFilters()">
                                    <label class="w-100 report-card-label m-0" for="type_queue">
                                        <div class="report-card-option p-3 rounded-3 d-flex align-items-center gap-3">
                                            <div class="bg-speed-blue text-white p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; min-width: 38px;">
                                                <i class="bi bi-list-task fs-5"></i>
                                            </div>
                                            <div>
                                                <strong class="d-block text-white small">Service Audit & Queue Log</strong>
                                                <span class="text-secondary extra-small">Service logs & status progression</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <div class="col-md-6">
                                    <input class="form-check-input d-none" type="radio" name="report_type" id="type_customer" value="customer" onchange="toggleReportFilters()">
                                    <label class="w-100 report-card-label m-0" for="type_customer">
                                        <div class="report-card-option p-3 rounded-3 d-flex align-items-center gap-3">
                                            <div class="bg-speed-pink text-white p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; min-width: 38px;">
                                                <i class="bi bi-person-heart fs-5"></i>
                                            </div>
                                            <div>
                                                <strong class="d-block text-white small">Customer Retention</strong>
                                                <span class="text-secondary extra-small">Repeat visits & client loyalty</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <div class="col-md-6">
                                    <input class="form-check-input d-none" type="radio" name="report_type" id="type_vehicle" value="vehicle" onchange="toggleReportFilters()">
                                    <label class="w-100 report-card-label m-0" for="type_vehicle">
                                        <div class="report-card-option p-3 rounded-3 d-flex align-items-center gap-3">
                                            <div class="bg-speed-blue text-white p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; min-width: 38px;">
                                                <i class="bi bi-car-front-fill fs-5"></i>
                                            </div>
                                            <div>
                                                <strong class="d-block text-white small">Vehicle Segment Analysis</strong>
                                                <span class="text-secondary extra-small">Sedan, SUV & Pickup distribution</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Evaluation Timeframe Scope -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-white small text-uppercase mb-2 d-flex align-items-center gap-2">
                                <span class="badge bg-speed-pink rounded-circle" style="width: 20px; height: 20px; line-height: 12px;">2</span>
                                Timeframe Scope
                            </label>
                            
                            <div class="row g-2 align-items-start">
                                <div class="col-md-5">
                                    <label class="form-label extra-small text-secondary fw-bold mb-1 d-block">Select Timeframe</label>
                                    <select name="timeframe" id="filter_timeframe" class="form-select form-select-sm form-select-dark fw-semibold" onchange="toggleTimeframeFields()">
                                        <option value="all_time" {{ request('date') ? '' : 'selected' }}>All-Time Cumulative</option>
                                        <option value="monthly">Monthly Performance</option>
                                        <option value="weekly">Weekly Analysis (7 Days)</option>
                                        <option value="yearly">Yearly Overview</option>
                                        <option value="custom" {{ request('date') ? 'selected' : '' }}>Custom Date Range</option>
                                    </select>
                                </div>

                                <div class="col-md-7">
                                    <div id="field_weekly" style="display: none;">
                                        <label class="form-label extra-small text-secondary fw-bold mb-1 d-block">
                                            Date Started
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text input-group-text-dark small"><i class="bi bi-calendar3"></i></span>
                                            <input type="date" name="start_date" class="form-control form-control-dark" value="{{ date('Y-m-d', strtotime('-7 days')) }}">
                                        </div>
                                    </div>

                                    <div id="field_monthly" style="display: none;">
                                        <label class="form-label extra-small text-secondary fw-bold mb-1 d-block">Select Month</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text input-group-text-dark small"><i class="bi bi-calendar-month"></i></span>
                                            <input type="month" name="month_year" class="form-control form-control-dark" value="{{ date('Y-m') }}">
                                        </div>
                                    </div>

                                    <div id="field_yearly" style="display: none;">
                                        <label class="form-label extra-small text-secondary fw-bold mb-1 d-block">Select Year</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text input-group-text-dark small"><i class="bi bi-calendar-event"></i></span>
                                            <select name="year" class="form-select form-select-dark">
                                                @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                                    <option value="{{ $y }}">{{ $y }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div id="field_custom_start" style="display: none;">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <label class="form-label extra-small text-secondary fw-bold mb-1 d-block">
                                                    Date Started
                                                </label>
                                                <input type="date" name="date_from" class="form-control form-control-sm form-control-dark" value="{{ date('Y-m-01') }}">
                                            </div>
                                            <div class="col-6" id="field_custom_end">
                                                <label class="form-label extra-small text-secondary fw-bold mb-1 d-block">
                                                    Date Ended
                                                </label>
                                                <input type="date" name="date_to" class="form-control form-control-sm form-control-dark" value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Dynamic Contextual Report Filters -->
                        <div class="p-3 border border-secondary border-opacity-25 rounded-3 bg-black bg-opacity-40">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-bold text-white small text-uppercase mb-0 d-flex align-items-center gap-2">
                                    <span class="badge bg-speed-pink rounded-circle" style="width: 20px; height: 20px; line-height: 12px;">3</span>
                                    Target Filters
                                </label>
                                <span class="badge bg-black bg-opacity-50 text-secondary border border-secondary border-opacity-25 extra-small fw-normal" id="activeFilterBadge">
                                    Dynamic Filters Active
                                </span>
                            </div>

                            <div class="row g-2">
                                <div class="col-md-4 filter-group filter-status">
                                    <label class="form-label extra-small text-secondary fw-bold mb-1">Status Scope</label>
                                    <select name="status" class="form-select form-select-sm form-select-dark">
                                        <option value="">All Statuses</option>
                                        <option value="Completed" selected>Completed Only</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Pending Queue">Queued</option>
                                    </select>
                                </div>

                                <div class="col-md-4 filter-group filter-mechanic">
                                    <label class="form-label extra-small text-secondary fw-bold mb-1">Assigned Mechanic</label>
                                    <select name="technician_id" class="form-select form-select-sm form-select-dark">
                                        <option value="">All Mechanics</option>
                                        @if(isset($technicians) && count($technicians) > 0)
                                            @foreach($technicians as $tech)
                                                @php
                                                    $tId   = is_object($tech) ? ($tech->id ?? $tech->name) : (is_array($tech) ? ($tech['id'] ?? $tech['name']) : $tech);
                                                    $tName = is_object($tech) ? ($tech->name ?? $tId) : (is_array($tech) ? ($tech['name'] ?? $tId) : $tech);
                                                @endphp
                                                <option value="{{ $tId }}" {{ (string)request('technician_id') === (string)$tId || (string)request('technician_id') === (string)$tName ? 'selected' : '' }}>
                                                    {{ $tName }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-4 filter-group filter-service">
                                    <label class="form-label extra-small text-secondary fw-bold mb-1">Service Package</label>
                                    <select name="service_type" class="form-select form-select-sm form-select-dark">
                                        <option value="">All Offered Services</option>
                                        @php
                                            $modalServicesList = (isset($availableServices) && count($availableServices) > 0) 
                                                ? $availableServices 
                                                : ['Ceramic Coating', 'Graphene Coating', 'PPF', 'Interior Detailing', 'Exterior Detailing', 'Washover', 'Undercoat'];
                                        @endphp
                                        @foreach($modalServicesList as $srv)
                                            @php $sName = is_object($srv) ? ($srv->name ?? '') : (is_array($srv) ? ($srv['name'] ?? '') : $srv); @endphp
                                            <option value="{{ $sName }}" {{ request('service_type') == $sName ? 'selected' : '' }}>{{ $sName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 filter-group filter-vehicle-type">
                                    <label class="form-label extra-small text-secondary fw-bold mb-1">Vehicle Segment</label>
                                    <select name="vehicle_type" class="form-select form-select-sm form-select-dark">
                                        <option value="">All Vehicles</option>
                                        @php
                                            $modalTypesList = (isset($vehicleTypes) && count($vehicleTypes) > 0) 
                                                ? $vehicleTypes 
                                                : ['Hatchback', 'Sedan', 'Coupe', 'Crossover', 'MPV', 'Wagon', 'SUV', 'Pickup Truck', 'Sports Car', 'Van', 'Supercar'];
                                        @endphp
                                        @foreach($modalTypesList as $vSeg)
                                            @php $vSegName = is_object($vSeg) ? ($vSeg->vehicle_type ?? $vSeg->name ?? '') : (is_array($vSeg) ? ($vSeg['vehicle_type'] ?? $vSeg['name'] ?? '') : $vSeg); @endphp
                                            <option value="{{ $vSegName }}" {{ request('vehicle_type') == $vSegName ? 'selected' : '' }}>{{ $vSegName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 filter-group filter-brand">
                                    <label class="form-label extra-small text-secondary fw-bold mb-1">Vehicle Brand</label>
                                    <select name="brand" class="form-select form-select-sm form-select-dark">
                                        <option value="">All Brands</option>
                                        @php
                                            $modalBrandsList = (isset($vehicleBrands) && count($vehicleBrands) > 0) 
                                                ? $vehicleBrands 
                                                : ['Toyota', 'Porsche', 'Ford', 'Chevrolet'];
                                        @endphp
                                        @foreach($modalBrandsList as $b)
                                            @php $bSegName = is_object($b) ? ($b->brand ?? $b->name ?? '') : (is_array($b) ? ($b['brand'] ?? $b['name'] ?? '') : $b); @endphp
                                            <option value="{{ $bSegName }}" {{ (request('brand') == $bSegName || request('vehicle_brand') == $bSegName) ? 'selected' : '' }}>{{ $bSegName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 filter-group filter-customer">
                                    <label class="form-label extra-small text-secondary fw-bold mb-1">Customer Name</label>
                                    <input type="text" name="customer_name" id="customer_name_input" class="form-control form-control-sm form-control-dark" list="customer_datalist" placeholder="Filter customer..." value="{{ request('customer_name') }}">
                                    <datalist id="customer_datalist">
                                        @if(isset($customers) && count($customers) > 0)
                                            @foreach($customers as $cName)
                                                <option value="{{ $cName }}"></option>
                                            @endforeach
                                        @endif
                                    </datalist>
                                </div>

                                <div class="col-md-4 filter-group filter-keyword">
                                    <label class="form-label extra-small text-secondary fw-bold mb-1">Search Keyword</label>
                                    <input type="text" name="search_term" class="form-control form-control-sm form-control-dark" placeholder="Tracking, plate, notes..." value="{{ request('search') ?? request('search_term') }}">
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer border-top border-secondary border-opacity-25 py-3 d-flex justify-content-between px-4">
                    <button type="button" class="btn btn-outline-secondary rounded-3 px-4 fw-semibold btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="btnPreviewReport" class="btn btn-speed-gradient rounded-3 px-4 fw-semibold btn-sm d-flex align-items-center gap-2 shadow-sm">
                        <i class="bi bi-file-earmark-bar-graph"></i> Compile & Preview Executive Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- REPORT PREVIEW MODAL WITH ACTION TOOLBAR -->
    <div class="modal fade" id="reportPreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content modal-content-dark border-0 rounded-4 shadow">
                <div class="modal-header border-bottom border-secondary border-opacity-25 py-3">
                    <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2 fs-6">
                        <i class="bi bi-file-earmark-text-fill text-speed-pink"></i> Executive Decision Support System - Document Preview
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="bg-black bg-opacity-40 border-bottom border-secondary border-opacity-25 px-4 py-2 d-flex justify-content-between align-items-center">
                    <div class="text-secondary extra-small">
                        <i class="bi bi-info-circle me-1 text-speed-blue"></i> Document rendered dynamically based on selected database criteria.
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" id="btnPrintReportModal" class="btn btn-outline-light btn-sm rounded-2 fw-semibold d-flex align-items-center gap-1">
                            <i class="bi bi-printer"></i> Direct Print
                        </button>
                        <button type="button" id="btnDownloadPDF" class="btn btn-danger btn-sm rounded-2 fw-semibold d-flex align-items-center gap-1">
                            <i class="bi bi-file-earmark-pdf"></i> Download Official PDF
                        </button>
                    </div>
                </div>

                <div class="modal-body p-4 bg-black bg-opacity-30">
                    <div id="reportPreviewContainer" class="printable-area bg-white p-4 border rounded-3 shadow-sm text-dark mx-auto" style="max-width: 900px; min-height: 600px;">
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary mb-3" role="status"></div>
                            <p class="text-muted small">Compiling database analytics and rendering report...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top border-secondary border-opacity-25 py-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-3 px-4" data-bs-dismiss="modal">Close Document</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/theme-toggle.js') }}"></script>

    <script>
        // Thermal Receipt Printer via iframe
        function printThermalReceipt(url) {
            let iframe = document.getElementById('thermalPrintIframe');
            if (!iframe) {
                iframe = document.createElement('iframe');
                iframe.id = 'thermalPrintIframe';
                iframe.style.position = 'fixed';
                iframe.style.right = '0';
                iframe.style.bottom = '0';
                iframe.style.width = '0';
                iframe.style.height = '0';
                iframe.style.border = '0';
                iframe.style.visibility = 'hidden';
                document.body.appendChild(iframe);
            }
            
            iframe.src = url;
            
            iframe.onload = function() {
                setTimeout(function() {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                }, 300);
            };
        }

        // Direct Report Printable Document Print Handler via Dedicated Frame
        function printElement(target) {
            let el = (typeof target === 'string') ? document.getElementById(target) : target;
            if (!el) return;
            
            let printTarget = el.classList.contains('printable-area') 
                ? el 
                : (el.querySelector('.printable-area') || el);

            if (!printTarget) return;

            let iframe = document.getElementById('reportPrintIframe');
            if (!iframe) {
                iframe = document.createElement('iframe');
                iframe.id = 'reportPrintIframe';
                iframe.style.position = 'fixed';
                iframe.style.right = '0';
                iframe.style.bottom = '0';
                iframe.style.width = '0';
                iframe.style.height = '0';
                iframe.style.border = '0';
                iframe.style.visibility = 'hidden';
                document.body.appendChild(iframe);
            }

            // Copy all styles from current page head to guarantee visual parity
            let stylesHTML = '';
            document.querySelectorAll('style, link[rel="stylesheet"]').forEach(node => {
                stylesHTML += node.outerHTML;
            });

            let doc = iframe.contentWindow.document;
            doc.open();
            doc.write(`
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <title>Executive Business Report</title>
                    ${stylesHTML}
                    <style>
                        @page {
                            size: portrait;
                            margin: 10mm;
                        }
                        *, *::before, *::after {
                            -webkit-print-color-adjust: exact !important;
                            print-color-adjust: exact !important;
                            color-adjust: exact !important;
                        }
                        html, body {
                            background: #ffffff !important;
                            color: #1e293b !important;
                            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif !important;
                            padding: 0 !important;
                            margin: 0 !important;
                            height: auto !important;
                            min-height: 0 !important;
                            overflow: visible !important;
                        }
                        body *, .print-active, .print-active *, .printable-area, .printable-area * {
                            visibility: visible !important;
                        }
                        .printable-area {
                            width: 100% !important;
                            max-width: 100% !important;
                            margin: 0 !important;
                            padding: 0 !important;
                            border: none !important;
                            box-shadow: none !important;
                            background: #ffffff !important;
                            height: auto !important;
                            overflow: visible !important;
                        }
                        .table-responsive, div, section, article {
                            overflow: visible !important;
                            height: auto !important;
                            max-height: none !important;
                        }
                        .text-nowrap, td.text-nowrap, th.text-nowrap {
                            white-space: nowrap !important;
                        }
                        .peso-symbol, span.peso-symbol {
                            font-family: 'DejaVu Sans', Arial, sans-serif !important;
                            display: inline !important;
                            margin-right: 2px;
                            white-space: nowrap !important;
                        }
                        table {
                            width: 100% !important;
                            border-collapse: collapse !important;
                            page-break-inside: auto !important;
                            break-inside: auto !important;
                        }
                        tr, blockquote, img, svg {
                            page-break-inside: avoid !important;
                            break-inside: avoid !important;
                        }
                        thead {
                            display: table-header-group !important;
                        }
                        tfoot {
                            display: table-row-group !important;
                        }
                        .text-muted, .text-secondary {
                            color: #475569 !important;
                        }
                        .text-speed-pink {
                            color: #f42582 !important;
                        }
                        .text-speed-blue {
                            color: #00a2ff !important;
                        }
                        .bg-speed-pink {
                            background-color: #f42582 !important;
                            color: #ffffff !important;
                        }
                        .bg-speed-blue {
                            background-color: #00a2ff !important;
                            color: #ffffff !important;
                        }
                    </style>
                </head>
                <body>
                    <div class="printable-area print-active">
                        ${printTarget.innerHTML}
                    </div>
                </body>
                </html>
            `);
            doc.close();

            setTimeout(function() {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            }, 400);
        }

        function toggleTimeframeFields() {
            const timeframeSelect = document.getElementById('filter_timeframe');
            const val = timeframeSelect ? timeframeSelect.value : 'all_time';
            
            const fields = {
                weekly: document.getElementById('field_weekly'),
                monthly: document.getElementById('field_monthly'),
                yearly: document.getElementById('field_yearly'),
                custom: document.getElementById('field_custom_start')
            };

            Object.keys(fields).forEach(key => {
                const el = fields[key];
                if (!el) return;
                const isMatch = (val === key);
                el.style.display = isMatch ? 'block' : 'none';
                el.querySelectorAll('input, select').forEach(input => {
                    input.disabled = !isMatch;
                });
            });
        }

        function toggleReportFilters() {
            const reportTypeEl = document.querySelector('input[name="report_type"]:checked');
            if (!reportTypeEl) return;

            const selectedType = reportTypeEl.value;
            const allFilterGroups = document.querySelectorAll('.filter-group');

            allFilterGroups.forEach(el => {
                el.style.display = 'none';
                el.querySelectorAll('input, select').forEach(input => {
                    input.disabled = true;
                });
            });

            let activeClasses = [];
            switch (selectedType) {
                case 'financial':
                    activeClasses = ['.filter-status', '.filter-service', '.filter-customer'];
                    break;
                case 'technician':
                    activeClasses = ['.filter-status', '.filter-mechanic', '.filter-service'];
                    break;
                case 'service_demand':
                    activeClasses = ['.filter-service', '.filter-vehicle-type'];
                    break;
                case 'queue_log':
                    activeClasses = ['.filter-status', '.filter-mechanic', '.filter-customer', '.filter-keyword', '.filter-service'];
                    break;
                case 'customer':
                    activeClasses = ['.filter-customer', '.filter-keyword', '.filter-service'];
                    break;
                case 'vehicle':
                    activeClasses = ['.filter-vehicle-type', '.filter-brand', '.filter-service'];
                    break;
                default:
                    allFilterGroups.forEach(el => {
                        el.style.display = 'block';
                        el.querySelectorAll('input, select').forEach(input => {
                            input.disabled = false;
                        });
                    });
                    return;
            }

            activeClasses.forEach(cls => {
                const el = document.querySelector(cls);
                if (el) {
                    el.style.display = 'block';
                    el.querySelectorAll('input, select').forEach(input => {
                        input.disabled = false;
                    });
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleTimeframeFields();
            toggleReportFilters();

            const searchInput = document.getElementById('transactionSearchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.toLowerCase().trim();
                    const tableRows = document.querySelectorAll('#transactionsTable tbody tr');

                    tableRows.forEach(row => {
                        if (row.querySelector('td[colspan]')) return;

                        const rowText = row.textContent.toLowerCase();
                        if (rowText.includes(query)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            const btnPreview = document.getElementById('btnPreviewReport');
            if (btnPreview) {
                btnPreview.addEventListener('click', function() {
                    toggleTimeframeFields();
                    toggleReportFilters();

                    const form = document.getElementById('reportFilterForm');
                    const formData = new FormData(form);
                    const params = new URLSearchParams(formData).toString();

                    const container = document.getElementById('reportPreviewContainer');
                    container.innerHTML = `
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary mb-3" role="status"></div>
                            <p class="text-muted small fw-semibold">Filtering database & compiling decision analytics...</p>
                        </div>
                    `;

                    const genModalEl = document.getElementById('generateReportModal');
                    const genModal = bootstrap.Modal.getInstance(genModalEl);
                    if (genModal) genModal.hide();

                    const prevModalEl = document.getElementById('reportPreviewModal');
                    const prevModal = new bootstrap.Modal(prevModalEl);
                    prevModal.show();

                    fetch("{{ route('admin.reports.preview') }}?" + params)
                        .then(response => {
                            if (!response.ok) throw new Error('Network response failed');
                            return response.text();
                        })
                        .then(html => {
                            container.innerHTML = html;
                        })
                        .catch(err => {
                            container.innerHTML = `
                                <div class="alert alert-danger my-4 p-4 text-center">
                                    <i class="bi bi-exclamation-triangle-fill fs-3 d-block mb-2"></i>
                                    <h6 class="fw-bold">Failed to Generate Report View</h6>
                                    <p class="small mb-0">Please check filter conditions or database connectivity.</p>
                                </div>
                            `;
                        });
                });
            }

            const btnDownload = document.getElementById('btnDownloadPDF');
            if (btnDownload) {
                btnDownload.addEventListener('click', function() {
                    toggleTimeframeFields();
                    toggleReportFilters();

                    const form = document.getElementById('reportFilterForm');
                    const formData = new FormData(form);
                    const params = new URLSearchParams(formData).toString();
                    window.open("{{ route('admin.reports.pdf') }}?" + params, '_blank');
                });
            }

            const btnPrint = document.getElementById('btnPrintReportModal');
            if (btnPrint) {
                btnPrint.addEventListener('click', function() {
                    printElement('reportPreviewContainer');
                });
            }
        });
    </script>
</body>
</html>