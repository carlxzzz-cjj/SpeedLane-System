<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedLane - Admin Dashboard</title>

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
    
    <!-- Custom External Admin CSS Link -->
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

        /* Dark Theme Role Badges */
        .badge-super-admin {
            background-color: rgba(244, 37, 130, 0.2) !important;
            color: #ff99cc !important;
            border: 1px solid rgba(244, 37, 130, 0.5) !important;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-admin {
            background-color: rgba(0, 162, 255, 0.2) !important;
            color: #80d4ff !important;
            border: 1px solid rgba(0, 162, 255, 0.5) !important;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        /* Dark Theme Logout Button */
        .btn-logout {
            color: #ff6b81 !important;
            border: 1px solid rgba(255, 107, 129, 0.4) !important;
            background: rgba(255, 107, 129, 0.08) !important;
            transition: all 0.25s ease;
            font-weight: 600;
        }

        .btn-logout:hover {
            background: rgba(255, 107, 129, 0.25) !important;
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

        html.light-theme .speed-card h2,
        html.light-theme .speed-card h4,
        html.light-theme .speed-card h6 {
            color: #0f172a !important;
        }

        /* Light Mode Quick Action Buttons */
        html.light-theme .quick-action-card-btn {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #1e293b !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03) !important;
        }

        html.light-theme .quick-action-card-btn:hover {
            background-color: #f8fafc !important;
            border-color: var(--speed-blue) !important;
            color: #0f172a !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 162, 255, 0.15) !important;
        }

        html.light-theme .form-control-dark {
            background-color: #f1f5f9 !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
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

        html.light-theme .modal-title {
            color: #0f172a !important;
        }

        /* Modal Cancel Button Dynamic Theme */
        .btn-modal-cancel {
            color: #cbd5e1 !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            background-color: rgba(255, 255, 255, 0.05) !important;
            transition: all 0.2s ease;
        }

        .btn-modal-cancel:hover {
            background-color: rgba(255, 255, 255, 0.15) !important;
            color: #ffffff !important;
        }

        html.light-theme .btn-modal-cancel {
            color: #334155 !important;
            border: 1px solid #cbd5e1 !important;
            background-color: #f1f5f9 !important;
        }

        html.light-theme .btn-modal-cancel:hover {
            background-color: #e2e8f0 !important;
            color: #0f172a !important;
        }

        /* Light Mode Alerts */
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

        /* Color Utility Classes */
        .text-speed-pink { color: var(--speed-pink) !important; }
        .text-speed-blue { color: var(--speed-blue) !important; }
        .bg-speed-pink { background-color: var(--speed-pink) !important; }
        .bg-speed-blue { background-color: var(--speed-blue) !important; }

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

        .btn-speed-gradient:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 162, 255, 0.4);
            color: #ffffff !important;
        }

        .quick-action-card-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.25rem 1rem;
            border-radius: 0.75rem;
            background-color: #06080d;
            border: 1px solid var(--speed-card-border);
            color: #e2e8f0;
            transition: all 0.25s ease;
            text-decoration: none;
            height: 100%;
        }

        .quick-action-card-btn:hover {
            border-color: var(--speed-blue);
            background-color: #0f1322;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 162, 255, 0.2);
        }

        /* Inputs & Modals */
        .form-control-dark {
            background-color: #06080d !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            transition: all 0.25s ease;
        }

        .form-control-dark:focus {
            border-color: var(--speed-blue) !important;
            box-shadow: 0 0 12px rgba(0, 162, 255, 0.25) !important;
            color: #ffffff !important;
        }

        .form-control-dark::placeholder {
            color: #64748b !important;
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

        .modal-content-dark {
            background-color: var(--speed-card-bg);
            border: 1px solid var(--speed-card-border);
            color: #e2e8f0;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.85);
        }

        .extra-small {
            font-size: 0.75rem;
        }
    </style>
</head>
<body>

    <!-- TOP NAVIGATION HEADER BAR -->
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
                    <button type="submit" class="btn btn-logout btn-sm px-3 py-1.5 rounded-3 d-flex align-items-center gap-1">
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

    <!-- MAIN LAYOUT WRAPPER -->
    <div class="container-fluid">
        <div class="row">
            
            <!-- SIDEBAR NAVIGATION MENU -->
            <aside class="col-md-3 col-lg-2 admin-sidebar min-vh-100 p-3">
                <nav class="nav flex-column gap-2">
                    
                    <a class="nav-link admin-nav-link active rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
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

                    {{-- VISIBLE ONLY TO SUPER ADMIN --}}
                    @if(auth()->user()->isSuperAdmin())
                    <a class="nav-link admin-nav-link rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.manage-services.index') }}">
                        <i class="bi bi-gear-fill text-speed-pink"></i> Manage Services
                    </a>
                    @endif

                </nav>
            </aside>

            <!-- MAIN DASHBOARD CONTENT AREA -->
            <main class="col-md-9 col-lg-10 p-4">

                <!-- FLASH NOTIFICATIONS -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 bg-success bg-opacity-20 text-white border-success" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 bg-danger bg-opacity-20 text-white border-danger" role="alert">
                        <strong class="d-block mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i> Registration failed:</strong>
                        <ul class="mb-0 ps-3 small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- WELCOME BANNER -->
                <div class="card speed-card p-4 rounded-4 mb-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div>
                            <h4 class="fw-bold text-white mb-2">
                                Welcome back, <span class="text-speed-pink">{{ Auth::user()->name }}</span>! 👋
                            </h4>
                            <p class="text-secondary small mb-0">
                                <span class="me-3"><i class="bi bi-person-badge text-speed-blue me-1"></i> <strong>Username:</strong> {{ Auth::user()->username }}</span>
                                <span><i class="bi bi-envelope text-speed-pink me-1"></i> <strong>Email:</strong> {{ Auth::user()->email }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- SUMMARY METRICS CARDS -->
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="card speed-card rounded-4 p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="text-secondary small fw-medium">Vehicles Today</span>
                                <i class="bi bi-car-front text-speed-blue fs-4"></i>
                            </div>
                            <h2 class="fw-bold text-white mb-1">{{ $vehiclesToday ?? 0 }}</h2>
                            <span class="text-secondary extra-small">As of {{ date('M d, Y') }}</span>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card speed-card rounded-4 p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="text-secondary small fw-medium">Active Services</span>
                                <i class="bi bi-activity text-warning fs-4"></i>
                            </div>
                            <h2 class="fw-bold text-white mb-1">{{ $activeServices ?? 0 }}</h2>
                            <span class="text-secondary extra-small">Currently in progress</span>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card speed-card rounded-4 p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="text-secondary small fw-medium">Completed Services</span>
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                            <h2 class="fw-bold text-white mb-1">{{ $completedServices ?? 0 }}</h2>
                            <span class="text-secondary extra-small">This month</span>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card speed-card rounded-4 p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="text-secondary small fw-medium">Total Transactions</span>
                                <i class="bi bi-credit-card text-speed-pink fs-4"></i>
                            </div>
                            <h2 class="fw-bold text-white mb-1">{{ $totalTransactions ?? 0 }}</h2>
                            <span class="text-secondary extra-small">All time</span>
                        </div>
                    </div>
                </div>

                <!-- QUICK ACTIONS PANEL -->
                <div class="card speed-card rounded-4 p-4">
                    <h6 class="fw-bold text-white mb-3 fs-5">Quick Actions</h6>
                    
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('admin.register-service') }}" class="quick-action-card-btn">
                                <i class="bi bi-plus-circle text-speed-pink fs-3 mb-2"></i>
                                <span class="fw-semibold">Register New Service</span>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ route('admin.update') }}" class="quick-action-card-btn">
                                <i class="bi bi-arrow-repeat text-speed-blue fs-3 mb-2"></i>
                                <span class="fw-semibold">Update Status</span>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ route('admin.transactions') }}" class="quick-action-card-btn">
                                <i class="bi bi-file-earmark-text text-info fs-3 mb-2"></i>
                                <span class="fw-semibold">View Transactions</span>
                            </a>
                        </div>

                        {{-- SUPER ADMIN ONLY QUICK ACTION --}}
                        @if(auth()->user()->isSuperAdmin())
                        <div class="col-md-3">
                            <a href="{{ route('admin.manage-services.index') }}" class="quick-action-card-btn">
                                <i class="bi bi-gear-fill text-speed-pink fs-3 mb-2"></i>
                                <span class="fw-semibold">Manage Services</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- CREATE STAFF ACCOUNT MODAL -->
    @if(auth()->user()->isSuperAdmin())
    <div class="modal fade" id="createStaffModal" tabindex="-1" aria-labelledby="createStaffModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-dark rounded-4 p-2">
                <div class="modal-header border-bottom-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold text-white" id="createStaffModalLabel">
                            <i class="bi bi-shield-check text-speed-pink me-2"></i>Register New Staff Account
                        </h5>
                        <p class="text-secondary small mb-0">Only authorized SpeedLane personnel are allowed to create an account</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white align-self-start" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="{{ route('admin.register.store') }}" method="POST">
                    @csrf
                    <div class="modal-body py-3">
                        <div class="mb-3 text-start">
                            <label class="form-label small fw-semibold text-secondary">Full Name <span class="text-speed-pink">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-person text-speed-blue"></i></span>
                                <input type="text" name="name" class="form-control form-control-dark @error('name') is-invalid @enderror" placeholder="Enter full name" value="{{ old('name') }}" required>
                            </div>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label small fw-semibold text-secondary">Email Address <span class="text-speed-pink">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-envelope text-speed-blue"></i></span>
                                <input type="email" name="email" class="form-control form-control-dark @error('email') is-invalid @enderror" placeholder="yourname@speedlane.com" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label small fw-semibold text-secondary">Contact Number <span class="text-speed-pink">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-telephone text-speed-blue"></i></span>
                                <input type="text" name="contact_number" class="form-control form-control-dark @error('contact_number') is-invalid @enderror" placeholder="+63 912 345 6789" value="{{ old('contact_number') }}" required>
                            </div>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label small fw-semibold text-secondary">Username <span class="text-speed-pink">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-person-badge text-speed-pink"></i></span>
                                <input type="text" name="username" class="form-control form-control-dark @error('username') is-invalid @enderror" placeholder="Choose a username" value="{{ old('username') }}" required>
                            </div>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label small fw-semibold text-secondary">Password <span class="text-speed-pink">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-lock text-speed-pink"></i></span>
                                <input type="password" name="password" class="form-control form-control-dark @error('password') is-invalid @enderror" placeholder="Create a strong password" required>
                            </div>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label small fw-semibold text-secondary">Confirm Password <span class="text-speed-pink">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-lock-fill text-speed-pink"></i></span>
                                <input type="password" name="password_confirmation" class="form-control form-control-dark" placeholder="Re-enter your password" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-modal-cancel rounded-3 fw-semibold px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-speed-gradient rounded-3 fw-semibold px-4">
                            <i class="bi bi-check-lg me-1"></i> Create Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Light Mode Toggle JS -->
    <script src="{{ asset('js/theme-toggle.js') }}"></script>
</body>
</html>