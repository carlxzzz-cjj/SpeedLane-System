<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SpeedLane - Admin Login</title>

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- External Admin CSS File Link -->
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
            --speed-glow-pink: rgba(244, 37, 130, 0.25);
            --speed-glow-blue: rgba(0, 162, 255, 0.25);
        }

        /* Hide browser default password reveal icons (Edge / IE) */
        input::-ms-reveal,
        input::-ms-clear {
            display: none;
        }

        /* Dark Theme Default with Minimal Automotive Vector Background */
        body {
            background-color: var(--speed-dark-bg) !important;
            color: #e2e8f0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            background-image: 
                radial-gradient(circle at 15% 20%, rgba(244, 37, 130, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 85% 80%, rgba(0, 162, 255, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 50% 0%, #121624 0%, #07090e 75%),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.015' fill-rule='evenodd'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E") !important;
            background-attachment: fixed;
            margin: 0;
            transition: background-color 0.3s ease, color 0.3s ease;
            position: relative;
            overflow-x: hidden;
        }

        /* Subtle Ambient Glow Orbs */
        .ambient-orb {
            position: absolute;
            width: 450px;
            height: 450px;
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
            z-index: 0;
            opacity: 0.6;
        }

        .ambient-orb-1 {
            top: -100px;
            left: -100px;
            background: radial-gradient(circle, var(--speed-pink) 0%, transparent 70%);
        }

        .ambient-orb-2 {
            bottom: -100px;
            right: -100px;
            background: radial-gradient(circle, var(--speed-blue) 0%, transparent 70%);
        }

        /* Light Mode Styling Overrides */
        html.light-theme {
            --speed-dark-bg: #f8fafc;
            --speed-card-bg: #ffffff;
            --speed-card-border: rgba(0, 0, 0, 0.08);
        }

        html.light-theme body {
            background-color: #f8fafc !important;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(244, 37, 130, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(0, 162, 255, 0.05) 0%, transparent 40%),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23000000' fill-opacity='0.02' fill-rule='evenodd'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E") !important;
            color: #1e293b !important;
        }

        html.light-theme .navbar-speed {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        html.light-theme h2.text-white,
        html.light-theme .admin-login-card h6 {
            color: #0f172a !important;
        }

        html.light-theme .form-label {
            color: #334155 !important;
        }

        html.light-theme .text-secondary {
            color: #475569 !important;
        }

        html.light-theme .admin-login-card {
            background-color: #ffffff !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06) !important;
        }

        html.light-theme .login-master-wrapper {
            background: #ffffff !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08) !important;
        }

        html.light-theme .form-control-dark {
            background-color: #f8fafc !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
        }

        html.light-theme .form-control-dark:focus {
            color: #0f172a !important;
            background-color: #ffffff !important;
        }

        html.light-theme .input-group-text-dark {
            background-color: #e2e8f0 !important;
            border: 1px solid #cbd5e1 !important;
            border-right: none !important;
        }

        html.light-theme .input-group-text-dark-right {
            background-color: #e2e8f0 !important;
            border: 1px solid #cbd5e1 !important;
            border-left: none !important;
        }

        html.light-theme .modal-content-dark {
            background-color: #ffffff !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            color: #0f172a !important;
        }

        html.light-theme .modal-title {
            color: #0f172a !important;
        }

        /* Back Button Dynamic Themes */
        .back-btn {
            background-color: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #ffffff;
            transition: all 0.25s ease;
        }

        .back-btn:hover {
            background-color: rgba(255, 255, 255, 0.18);
            color: #ffffff;
        }

        html.light-theme .back-btn {
            background-color: #e2e8f0 !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
        }

        html.light-theme .back-btn:hover {
            background-color: #cbd5e1 !important;
        }

        /* Theme Toggle Button */
        #theme-toggle-btn {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.25s ease;
        }

        #theme-toggle-btn:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }

        html.light-theme #theme-toggle-btn {
            background-color: #e2e8f0 !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
        }

        html.light-theme #theme-toggle-btn:hover {
            background-color: #cbd5e1 !important;
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

        /* Typography & Utility Colors */
        .text-speed-pink { color: var(--speed-pink) !important; }
        .text-speed-blue { color: var(--speed-blue) !important; }
        .bg-speed-pink { background-color: var(--speed-pink) !important; }

        /* Navigation Header */
        .navbar-speed {
            background: rgba(7, 9, 14, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--speed-card-border);
            position: relative;
            z-index: 10;
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
            letter-spacing: 2px;
            color: #94a3b8;
            font-weight: 700;
        }

        /* Master Split Container (Enterprise System Styling) */
        .login-master-wrapper {
            background-color: rgba(14, 17, 26, 0.75);
            backdrop-filter: blur(20px);
            border: 1px solid var(--speed-card-border);
            border-radius: 24px;
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.7), 0 0 40px rgba(0, 162, 255, 0.05);
            overflow: hidden;
            position: relative;
            z-index: 5;
        }

        /* AutoSpa Brand Showcase Side Panel */
        .autospa-brand-panel {
            background: linear-gradient(135deg, rgba(7, 9, 14, 0.95) 0%, rgba(18, 22, 36, 0.95) 100%);
            border-right: 1px solid var(--speed-card-border);
            position: relative;
            overflow: hidden;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        html.light-theme .autospa-brand-panel {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff !important;
        }

        html.light-theme .autospa-brand-panel .text-secondary {
            color: #cbd5e1 !important;
        }

        html.light-theme .autospa-brand-panel .text-white {
            color: #ffffff !important;
        }

        .autospa-brand-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(244, 37, 130, 0.15) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Decorative Speed Graphic Rings */
        .speed-ring-graphic {
            position: absolute;
            right: -80px;
            bottom: -80px;
            width: 320px;
            height: 320px;
            border: 2px dashed rgba(0, 162, 255, 0.15);
            border-radius: 50%;
            pointer-events: none;
            animation: spinRing 40s linear infinite;
        }

        @keyframes spinRing {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Feature Pill Badges */
        .system-feature-badge {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 6px 14px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #cbd5e1;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Form Inputs */
        .form-control-dark {
            background-color: #06080d !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            transition: all 0.25s ease;
        }

        .form-control-dark:focus {
            border-color: var(--speed-blue) !important;
            box-shadow: 0 0 14px rgba(0, 162, 255, 0.3) !important;
            color: #ffffff !important;
        }

        .form-control-dark::placeholder {
            color: #64748b !important;
        }

        .input-group-text-dark {
            background-color: #090c14 !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-right: none !important;
        }

        .input-group-text-dark-right {
            background-color: #090c14 !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-left: none !important;
            cursor: pointer;
        }

        .input-group .form-control-dark {
            border-left: none !important;
        }

        /* Submit Button Gradient */
        .btn-speed-gradient {
            background: linear-gradient(90deg, var(--speed-pink) 0%, var(--speed-blue) 100%);
            border: none;
            color: #ffffff !important;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(244, 37, 130, 0.35);
        }

        .btn-speed-gradient:hover {
            opacity: 0.95;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 162, 255, 0.45);
            color: #ffffff !important;
        }

        /* Icon Badge Header */
        .icon-circle-theme {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            background: rgba(244, 37, 130, 0.15);
            border: 1px solid rgba(244, 37, 130, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--speed-pink);
            box-shadow: 0 0 20px rgba(244, 37, 130, 0.25);
        }

        /* Dark Modal Styling */
        .modal-content-dark {
            background-color: var(--speed-card-bg);
            border: 1px solid var(--speed-card-border);
            color: #e2e8f0;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.85);
        }

        .modal-header-dark {
            border-bottom: 1px solid var(--speed-card-border);
        }

        .forgot-link {
            color: var(--speed-blue);
            transition: color 0.2s ease;
        }

        .forgot-link:hover {
            color: var(--speed-pink);
        }

        html.light-theme .forgot-link {
            color: #0284c7 !important;
        }

        html.light-theme .forgot-link:hover {
            color: #d946ef !important;
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

    <!-- Ambient Glow Orbs -->
    <div class="ambient-orb ambient-orb-1"></div>
    <div class="ambient-orb ambient-orb-2"></div>

    <!-- Top Navigation -->
    <div class="navbar-speed py-3 px-4 mb-4">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <a href="/" class="back-btn text-decoration-none d-flex align-items-center justify-content-center rounded-circle" style="width: 38px; height: 38px;" title="Back to Home">
                    <i class="bi bi-arrow-left text-speed-pink fs-6"></i>
                </a>
                <div class="d-flex align-items-center gap-2">
                    <div class="p-2 rounded-3 bg-speed-pink d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <i class="bi bi-car-front-fill text-white fs-6"></i>
                    </div>
                    <div>
                        <div class="brand-logo-text">
                            <span class="text-speed-pink">SPEED</span><span class="text-speed-blue">LANE</span>
                        </div>
                        <div class="brand-subtext">GENERAL SANTOS</div>
                    </div>
                </div>
            </div>

            <!-- Light / Dark Mode Toggle Button -->
            <button id="theme-toggle-btn" type="button" class="btn d-flex align-items-center justify-content-center rounded-circle p-2" style="width: 40px; height: 40px;" title="Toggle Light/Dark Mode" aria-label="Toggle Light/Dark Mode" onclick="toggleSpeedLaneTheme()">
                <i id="theme-toggle-icon" class="bi bi-sun-fill text-warning"></i>
            </button>
        </div>
    </div>

    <!-- Main Enterprise Split-Container -->
    <div class="container pb-5 my-auto">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-xl-10">
                
                <div class="login-master-wrapper">
                    <div class="row g-0">
                        
                        <!-- LEFT PANEL: Enterprise AutoSpa Visual Hero (Visible on Desktop) -->
                        <div class="col-lg-6 autospa-brand-panel d-none d-lg-flex">
                            <div class="speed-ring-graphic"></div>
                            
                            <!-- Top Brand Info -->
                            <div>
                                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill mb-4" style="background: rgba(244, 37, 130, 0.12); border: 1px solid rgba(244, 37, 130, 0.3);">
                                    <i class="bi bi-speedometer2 text-speed-pink"></i>
                                    <span class="text-speed-pink fw-bold uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">AutoSpa Management System</span>
                                </div>
                                <h2 class="fw-black display-6 mb-3" style="line-height: 1.15; font-weight: 900;">
                                    <span class="text-speed-pink">SPEED</span><span class="text-speed-blue">LANE</span> <span class="text-white">AUTOSPA</span>
                                    <span class="text-speed-pink fs-5 d-block mt-2 fw-bold text-uppercase" style="letter-spacing: 2px;">GENERAL SANTOS CITY</span>
                                </h2>
                                <p class="text-secondary small mb-4" style="max-width: 380px;">
                                    Delivering premier, high-quality auto care services — from luxury car washing and ceramic coating detailing to comprehensive interior and exterior vehicle care.
                                </p>
                            </div>

                            <!-- System Metrics & Feature Badges -->
                            <div>
                                <div class="d-flex flex-wrap gap-2 mb-4">
                                    <span class="system-feature-badge"><i class="bi bi-shield-check text-speed-blue"></i> Encrypted Access</span>
                                    <span class="system-feature-badge"><i class="bi bi-droplet-half text-speed-pink"></i> Ceramic Detailing</span>
                                    <span class="system-feature-badge"><i class="bi bi-kanban text-warning"></i> Wash Bay Control</span>
                                </div>

                                <div class="p-3 rounded-4 d-flex align-items-center gap-3" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <div class="p-2.5 rounded-circle bg-speed-pink bg-opacity-20 text-speed-pink">
                                        <i class="bi bi-check2-circle fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-white small">Authorized Personnel Portal</div>
                                        <div class="text-secondary" style="font-size: 0.725rem;">SpeedLane AutoSpa • General Santos City</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT PANEL: Login Form Container -->
                        <div class="col-12 col-lg-6 p-4 p-md-5">
                            <div class="text-center text-lg-start mb-4">
                                <!-- Lock Icon Badge -->
                                <div class="icon-circle-theme mb-3 mx-auto mx-lg-0">
                                    <i class="bi bi-shield-lock-fill fs-4"></i>
                                </div>
                                
                                <!-- Screen Headings -->
                                <h2 class="fw-bold mb-1 text-white">
                                    SpeedLane <span class="text-speed-pink">Admin</span> <span class="text-speed-blue">Login</span>
                                </h2>
                                <p class="text-secondary small">Access the administrative dashboard</p>
                            </div>

                            <!-- Login Form Card -->
                            <div class="card border-0 bg-transparent text-start admin-login-card p-0">
                                <h6 class="fw-bold mb-1 text-white fs-6">Administrator Access</h6>
                                <p class="text-secondary small mb-4">Enter your credentials to continue</p>

                                {{-- Session Success Alert --}}
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show text-start mb-3 bg-success bg-opacity-20 text-white border-success rounded-3" role="alert">
                                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                {{-- General Error Alert --}}
                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show text-start mb-3 bg-danger bg-opacity-20 text-white border-danger rounded-3" role="alert">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <form action="{{ route('admin.login.submit') }}" method="POST">
                                    @csrf
                                    
                                    <!-- Username Field -->
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-secondary">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text input-group-text-dark"><i class="bi bi-person text-speed-blue"></i></span>
                                            <input type="text" 
                                                   id="loginUsername"
                                                   name="username" 
                                                   class="form-control form-control-dark @error('username') is-invalid @enderror" 
                                                   placeholder="Enter username" 
                                                   value="{{ old('username') }}" 
                                                   required>
                                        </div>

                                        @error('username')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Password Field with Forgot Password Link & See Password Toggle -->
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label small fw-semibold text-secondary mb-0">Password</label>
                                            <a href="#" id="triggerForgotPassword" class="small text-decoration-none fw-semibold forgot-link" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
                                                Forgot password?
                                            </a>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text input-group-text-dark"><i class="bi bi-lock text-speed-pink"></i></span>
                                            <input type="password" 
                                                   id="loginPassword"
                                                   name="password" 
                                                   class="form-control form-control-dark @error('password') is-invalid @enderror" 
                                                   placeholder="Enter password" 
                                                   style="border-right: none !important;"
                                                   required>
                                            <button class="btn input-group-text-dark-right text-secondary" type="button" id="togglePassword" title="Toggle Password Visibility">
                                                <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                                            </button>
                                        </div>

                                        @error('password')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Login Button -->
                                    <button type="submit" class="btn btn-speed-gradient w-100 py-2.5 fw-bold rounded-3 mb-2 fs-6">
                                        Login to Dashboard
                                    </button>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- FORGOT PASSWORD / OTP MODAL -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-dark rounded-4">
                
                <div class="modal-header modal-header-dark">
                    <h5 class="modal-title fw-bold text-white fs-5" id="forgotPasswordModalLabel">
                        <i class="bi bi-key-fill text-speed-pink me-2"></i>Reset Password
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 text-start">
                    <!-- Dynamic Alert Box -->
                    <div id="modalAlert" class="alert d-none shadow-sm rounded-3" role="alert"></div>

                    <!-- STEP 1: Verify Username & Send OTP -->
                    <form id="step1Form">
                        <p class="text-secondary small mb-3">
                            Enter your account username below. An OTP code will be sent to the registered Gmail account linked to this username.
                        </p>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Username <span class="text-speed-pink">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-person text-speed-blue"></i></span>
                                <input type="text" id="resetUsername" name="username" class="form-control form-control-dark" placeholder="Enter account username" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-modal-cancel rounded-3 px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" id="btnSendOtp" class="btn btn-speed-gradient rounded-3 px-4 fw-semibold">
                                <span id="btnSendOtpText">Send OTP Code</span>
                                <span id="btnSendOtpSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        </div>
                    </form>

                    <!-- STEP 2: Verify OTP & Change Password -->
                    <form id="step2Form" class="d-none">
                        <p class="text-secondary small mb-3">
                            Enter the 6-digit OTP code sent to your registered Gmail and set your new password.
                        </p>
                        
                        <!-- OTP Code Field -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">6-Digit OTP Code <span class="text-speed-pink">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-shield-check text-speed-blue"></i></span>
                                <input type="text" id="otpCode" name="otp" class="form-control form-control-dark" placeholder="Enter 6-digit code" maxlength="6" required>
                            </div>
                        </div>

                        <!-- New Password Field -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">New Password <span class="text-speed-pink">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-lock text-speed-pink"></i></span>
                                <input type="password" id="newPassword" name="password" class="form-control form-control-dark" placeholder="Minimum 8 characters" minlength="8" style="border-right: none !important;" required>
                                <button class="btn input-group-text-dark-right text-secondary" type="button" id="toggleNewPassword" title="Toggle Password Visibility">
                                    <i class="bi bi-eye-slash" id="toggleNewPasswordIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Confirm New Password <span class="text-speed-pink">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-lock-fill text-speed-pink"></i></span>
                                <input type="password" id="newPasswordConfirmation" name="password_confirmation" class="form-control form-control-dark" placeholder="Re-enter new password" style="border-right: none !important;" required>
                                <button class="btn input-group-text-dark-right text-secondary" type="button" id="toggleConfirmPassword" title="Toggle Password Visibility">
                                    <i class="bi bi-eye-slash" id="toggleConfirmPasswordIcon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-modal-cancel rounded-3 px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" id="btnResetPassword" class="btn btn-success rounded-3 px-4 fw-semibold">
                                <span id="btnResetText">Update Password</span>
                                <span id="btnResetSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

     <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS Link -->
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- Light Mode Toggle JS -->
    <script src="{{ asset('js/theme-toggle.js') }}"></script>

    <!-- Failed Login Attempts & Rate-Limiting Security Mechanism -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginForm = document.querySelector('form[action*="login"]');
            const usernameInput = document.getElementById('loginUsername');
            const passwordInput = document.getElementById('loginPassword');
            const submitBtn = loginForm ? loginForm.querySelector('button[type="submit"]') : null;

            if (!loginForm) return;

            const WARN_ATTEMPTS = 3;
            const MAX_ATTEMPTS = 5;
            const LOCKOUT_TIME_MS = 60000; // 1 minute in milliseconds

            function checkLockoutStatus() {
                const lockoutUntil = parseInt(localStorage.getItem('speedlane_login_lockout_until') || '0', 10);
                const now = Date.now();

                if (now < lockoutUntil) {
                    const remainingSec = Math.ceil((lockoutUntil - now) / 1000);
                    
                    if (usernameInput) usernameInput.disabled = true;
                    if (passwordInput) passwordInput.disabled = true;
                    if (submitBtn) submitBtn.disabled = true;

                    const msg = `Too many failed login attempts! Restricted for ${remainingSec} second(s).`;
                    showLoginAlert('danger', msg);

                    setTimeout(checkLockoutStatus, 1000);
                    return true;
                } else {
                    if (lockoutUntil > 0) {
                        localStorage.removeItem('speedlane_login_lockout_until');
                        localStorage.setItem('speedlane_login_attempts', '0');
                    }
                    if (usernameInput) usernameInput.disabled = false;
                    if (passwordInput) passwordInput.disabled = false;
                    if (submitBtn) submitBtn.disabled = false;
                    clearLockoutAlert();
                    return false;
                }
            }

            function showLoginAlert(type, msg) {
                let alertBox = document.getElementById('loginLockoutAlertBox');
                if (!alertBox) {
                    alertBox = document.createElement('div');
                    alertBox.id = 'loginLockoutAlertBox';
                    loginForm.parentNode.insertBefore(alertBox, loginForm);
                }
                alertBox.className = `alert alert-${type} rounded-3 mb-3 bg-${type} bg-opacity-20 text-white border-${type} small shadow-sm`;
                alertBox.innerHTML = `<i class="bi bi-exclamation-triangle-fill me-2"></i> ${msg}`;
            }

            function clearLockoutAlert() {
                const alertBox = document.getElementById('loginLockoutAlertBox');
                if (alertBox) alertBox.remove();
            }

            // Detect if a server-side authentication success or failure occurred
            const hasSuccessAlert = document.querySelector('.alert-success') !== null;
            const hasServerError = document.querySelector('.alert-danger:not(#loginLockoutAlertBox)') !== null ||
                                   document.querySelector('.is-invalid') !== null ||
                                   document.querySelector('.text-danger') !== null;

            if (hasSuccessAlert) {
                localStorage.removeItem('speedlane_login_attempts');
                localStorage.removeItem('speedlane_login_lockout_until');
                clearLockoutAlert();
            } else if (hasServerError && !checkLockoutStatus()) {
                let attempts = parseInt(localStorage.getItem('speedlane_login_attempts') || '0', 10) + 1;
                localStorage.setItem('speedlane_login_attempts', attempts.toString());

                if (attempts >= MAX_ATTEMPTS) {
                    const lockoutTime = Date.now() + LOCKOUT_TIME_MS;
                    localStorage.setItem('speedlane_login_lockout_until', lockoutTime.toString());
                    localStorage.setItem('speedlane_login_attempts', '0');
                    checkLockoutStatus();
                } else if (attempts >= WARN_ATTEMPTS) {
                    showLoginAlert('warning', `Warning: ${attempts} failed login attempts recorded. Account access will be temporarily locked after ${MAX_ATTEMPTS} failed attempts.`);
                }
            } else {
                checkLockoutStatus();
                let attempts = parseInt(localStorage.getItem('speedlane_login_attempts') || '0', 10);
                if (attempts >= WARN_ATTEMPTS && !checkLockoutStatus()) {
                    showLoginAlert('warning', `Warning: ${attempts} failed login attempts recorded. Account access will be temporarily locked after ${MAX_ATTEMPTS} failed attempts.`);
                }
            }

            loginForm.addEventListener('submit', function(e) {
                if (checkLockoutStatus()) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>

    <!-- Modal Workflow JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Password Visibility Toggle Function
            function setupPasswordToggle(btnId, inputId, iconId) {
                const btn = document.getElementById(btnId);
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);

                if (btn && input && icon) {
                    btn.addEventListener('click', function () {
                        const isPassword = input.getAttribute('type') === 'password';
                        input.setAttribute('type', isPassword ? 'text' : 'password');
                        icon.classList.toggle('bi-eye', isPassword);
                        icon.classList.toggle('bi-eye-slash', !isPassword);
                    });
                }
            }

            setupPasswordToggle('togglePassword', 'loginPassword', 'togglePasswordIcon');
            setupPasswordToggle('toggleNewPassword', 'newPassword', 'toggleNewPasswordIcon');
            setupPasswordToggle('toggleConfirmPassword', 'newPasswordConfirmation', 'toggleConfirmPasswordIcon');

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const loginUsernameInput = document.getElementById('loginUsername');
            const resetUsernameInput = document.getElementById('resetUsername');
            
            const forgotPasswordModal = document.getElementById('forgotPasswordModal');
            const step1Form = document.getElementById('step1Form');
            const step2Form = document.getElementById('step2Form');
            const alertBox = document.getElementById('modalAlert');

            const btnSendOtp = document.getElementById('btnSendOtp');
            const btnSendOtpText = document.getElementById('btnSendOtpText');
            const btnSendOtpSpinner = document.getElementById('btnSendOtpSpinner');

            const btnResetPassword = document.getElementById('btnResetPassword');
            const btnResetText = document.getElementById('btnResetText');
            const btnResetSpinner = document.getElementById('btnResetSpinner');

            let targetUsername = '';

            // Automatically populate username from login form when opening modal
            forgotPasswordModal.addEventListener('show.bs.modal', function () {
                if (loginUsernameInput.value.trim() !== '') {
                    resetUsernameInput.value = loginUsernameInput.value.trim();
                }
            });

            function showAlert(type, message) {
                alertBox.className = `alert alert-${type} bg-${type} bg-opacity-20 text-white border-${type} shadow-sm`;
                alertBox.innerHTML = message;
                alertBox.classList.remove('d-none');
            }

            function hideAlert() {
                alertBox.classList.add('d-none');
            }

            // --- STEP 1: SEND OTP CODE TO REGISTERED GMAIL ---
            step1Form.addEventListener('submit', async function (e) {
                e.preventDefault();
                hideAlert();

                targetUsername = resetUsernameInput.value.trim();

                btnSendOtp.disabled = true;
                btnSendOtpText.classList.add('d-none');
                btnSendOtpSpinner.classList.remove('d-none');

                try {
                    const response = await fetch("{{ route('admin.send-otp') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ username: targetUsername })
                    });

                    const contentType = response.headers.get("content-type");
                    let data = {};

                    if (contentType && contentType.includes("application/json")) {
                        data = await response.json();
                    } else {
                        throw new Error(`Server returned error status (${response.status}). Check Render logs for details.`);
                    }

                    if (response.ok && data.success) {
                        showAlert('success', '<i class="bi bi-check-circle-fill me-2"></i>' + data.message);
                        step1Form.classList.add('d-none');
                        step2Form.classList.remove('d-none');
                    } else {
                        const errMsg = data.message || (data.errors && data.errors.username ? data.errors.username[0] : 'Failed to send OTP.');
                        showAlert('danger', '<i class="bi bi-exclamation-triangle-fill me-2"></i>' + errMsg);
                    }
                } catch (error) {
                    showAlert('danger', '<i class="bi bi-exclamation-triangle-fill me-2"></i>' + error.message);
                } finally {
                    btnSendOtp.disabled = false;
                    btnSendOtpText.classList.remove('d-none');
                    btnSendOtpSpinner.classList.add('d-none');
                }
            });

            // --- STEP 2: VERIFY OTP CODE & UPDATE PASSWORD ---
            step2Form.addEventListener('submit', async function (e) {
                e.preventDefault();
                hideAlert();

                const otp = document.getElementById('otpCode').value.trim();
                const password = document.getElementById('newPassword').value;
                const passwordConfirmation = document.getElementById('newPasswordConfirmation').value;

                if (password !== passwordConfirmation) {
                    showAlert('danger', '<i class="bi bi-exclamation-triangle-fill me-2"></i>Passwords do not match.');
                    return;
                }

                btnResetPassword.disabled = true;
                btnResetText.classList.add('d-none');
                btnResetSpinner.classList.remove('d-none');

                try {
                    const response = await fetch("{{ route('admin.reset-password-otp') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            username: targetUsername,
                            otp: otp,
                            password: password,
                            password_confirmation: passwordConfirmation
                        })
                    });

                    const contentType = response.headers.get("content-type");
                    let data = {};

                    if (contentType && contentType.includes("application/json")) {
                        data = await response.json();
                    } else {
                        throw new Error(`Server returned error status (${response.status}). Check Render logs for details.`);
                    }

                    if (response.ok && data.success) {
                        showAlert('success', '<i class="bi bi-check-circle-fill me-2"></i>' + data.message);
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        const errMsg = data.message || (data.errors ? Object.values(data.errors)[0][0] : 'Failed to update password.');
                        showAlert('danger', '<i class="bi bi-exclamation-triangle-fill me-2"></i>' + errMsg);
                    }
                } catch (error) {
                    showAlert('danger', '<i class="bi bi-exclamation-triangle-fill me-2"></i>' + error.message);
                } finally {
                    btnResetPassword.disabled = false;
                    btnResetText.classList.remove('d-none');
                    btnResetSpinner.classList.add('d-none');
                }
            });
        });
    </script>
</body>
</html>