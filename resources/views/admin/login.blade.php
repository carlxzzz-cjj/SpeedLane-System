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
            --speed-card-border: rgba(255, 255, 255, 0.07);
        }

        /* Dark Theme Default */
        body {
            background-color: var(--speed-dark-bg) !important;
            color: #e2e8f0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            background: radial-gradient(circle at 50% 0%, #121624 0%, #07090e 75%) !important;
            background-attachment: fixed;
            margin: 0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Light Mode Styling Overrides */
        html.light-theme {
            --speed-dark-bg: #f8fafc;
            --speed-card-bg: #ffffff;
            --speed-card-border: rgba(0, 0, 0, 0.1);
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

        html.light-theme h2.text-white,
        html.light-theme .admin-login-card h6 {
            color: #0f172a !important;
        }

        html.light-theme .admin-login-card {
            background-color: #ffffff !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06) !important;
        }

        html.light-theme .form-control-dark {
            background-color: #f1f5f9 !important;
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
            background: rgba(7, 9, 14, 0.95);
            border-bottom: 1px solid var(--speed-card-border);
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

        /* Login Card */
        .admin-login-card {
            background-color: var(--speed-card-bg) !important;
            border: 1px solid var(--speed-card-border) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
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
            box-shadow: 0 4px 15px rgba(244, 37, 130, 0.3);
        }

        .btn-speed-gradient:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 162, 255, 0.4);
            color: #ffffff !important;
        }

        /* Icon Badge Header */
        .icon-circle-theme {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(244, 37, 130, 0.15);
            border: 1px solid rgba(244, 37, 130, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--speed-pink);
            box-shadow: 0 0 15px rgba(244, 37, 130, 0.25);
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
    zoom: 80%; /* Adjusts the render scale across modern browsers */
  }
<
    </style>
</head>
<body>

    <!-- Top Navigation -->
    <div class="navbar-speed py-3 px-4 mb-5">
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

    <!-- Main Login Container -->
    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4 text-center">
                
                <!-- Lock Icon Badge -->
                <div class="icon-circle-theme mb-3 mx-auto">
                    <i class="bi bi-shield-lock-fill fs-4"></i>
                </div>
                
                <!-- Screen Headings -->
                <h2 class="fw-bold mb-1 text-white">
                    SpeedLane <span class="text-speed-pink">Admin</span> <span class="text-speed-blue">Login</span>
                </h2>
                <p class="text-secondary mb-4 small">Access the administrative dashboard</p>

                <!-- Login Form Card -->
                <div class="card border-0 rounded-4 text-start p-4 admin-login-card">
                    <h6 class="fw-bold mb-1 text-white fs-5">Administrator Access</h6>
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
                            <label class="form-label small fw-semibold text-secondary">Username</label>
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

                        <!-- Password Field with Forgot Password Link -->
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
                                       name="password" 
                                       class="form-control form-control-dark @error('password') is-invalid @enderror" 
                                       placeholder="Enter password" 
                                       required>
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
                                <input type="password" id="newPassword" name="password" class="form-control form-control-dark" placeholder="Minimum 8 characters" minlength="8" required>
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Confirm New Password <span class="text-speed-pink">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-lock-fill text-speed-pink"></i></span>
                                <input type="password" id="newPasswordConfirmation" name="password_confirmation" class="form-control form-control-dark" placeholder="Re-enter new password" required>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Light Mode Toggle JS -->
    <script src="{{ asset('js/theme-toggle.js') }}"></script>

    <!-- Modal Workflow JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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