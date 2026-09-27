<!-- FILE: resources/views/admin/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SpeedLane - Admin Login</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- External Admin CSS File Link -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="bg-light">

    <!-- Top Navigation (Back Arrow & Logo) -->
    <div class="container-fluid py-3 px-4 bg-white shadow-sm mb-5">
        <a href="/" class="text-dark text-decoration-none fs-5 me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h4 class="text-brand d-inline fw-bold mb-0">SpeedLane</h4>
    </div>

    <!-- Main Login Container -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4 text-center">
                
                <!-- Lock Icon Badge -->
                <div class="icon-circle mb-3 shadow-sm mx-auto">
                    <i class="bi bi-lock fs-2"></i>
                </div>
                
                <!-- Screen Headings -->
                <h2 class="fw-bold mb-1">SpeedLane Admin Login</h2>
                <p class="text-muted mb-4">Access the administrative dashboard</p>

                <!-- Login Form Card -->
                <div class="card border-0 shadow-sm rounded-4 text-start p-4">
                    <h6 class="fw-bold mb-1">Administrator Access</h6>
                    <p class="text-muted small mb-3">Enter your credentials to continue</p>

                    {{-- Session Success Alert --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show text-start mb-3 shadow-sm" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- General Error Alert --}}
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show text-start mb-3 shadow-sm" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.login.submit') }}" method="POST">
                        @csrf
                        
                        <!-- Username Field -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" 
                                       id="loginUsername"
                                       name="username" 
                                       class="form-control @error('username') is-invalid @enderror" 
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
                                <label class="form-label small fw-semibold mb-0">Password</label>
                                <a href="#" id="triggerForgotPassword" class="small text-decoration-none fw-semibold" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
                                    Forgot password?
                                </a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password" 
                                       name="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="Enter password" 
                                       required>
                            </div>

                            @error('password')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="btn btn-admin-submit w-100 py-2 fw-semibold rounded-3 mb-3">
                            Login
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!-- FORGOT PASSWORD / OTP MODAL -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold text-dark" id="forgotPasswordModalLabel">
                        <i class="bi bi-key text-primary me-2"></i>Reset Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 text-start">
                    <!-- Dynamic Alert Box -->
                    <div id="modalAlert" class="alert d-none shadow-sm" role="alert"></div>

                    <!-- STEP 1: Verify Username & Send OTP -->
                    <form id="step1Form">
                        <p class="text-muted small mb-3">
                            Enter your account username below. An OTP code will be sent to the registered Gmail account linked to this username.
                        </p>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Username <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" id="resetUsername" name="username" class="form-control" placeholder="Enter account username" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" id="btnSendOtp" class="btn btn-primary rounded-3 px-4 fw-semibold">
                                <span id="btnSendOtpText">Send OTP Code</span>
                                <span id="btnSendOtpSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        </div>
                    </form>

                    <!-- STEP 2: Verify OTP & Change Password -->
                    <form id="step2Form" class="d-none">
                        <p class="text-muted small mb-3">
                            Enter the 6-digit OTP code sent to your registered Gmail and set your new password.
                        </p>
                        
                        <!-- OTP Code Field -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">6-Digit OTP Code <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shield-check text-muted"></i></span>
                                <input type="text" id="otpCode" name="otp" class="form-control" placeholder="Enter 6-digit code" maxlength="6" required>
                            </div>
                        </div>

                        <!-- New Password Field -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">New Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password" id="newPassword" name="password" class="form-control" placeholder="Minimum 8 characters" minlength="8" required>
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Confirm New Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill text-muted"></i></span>
                                <input type="password" id="newPasswordConfirmation" name="password_confirmation" class="form-control" placeholder="Re-enter new password" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Cancel</button>
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
                alertBox.className = `alert alert-${type} shadow-sm`;
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

                    const data = await response.json();

                    if (response.ok && data.success) {
                        showAlert('success', '<i class="bi bi-check-circle-fill me-2"></i>' + data.message);
                        step1Form.classList.add('d-none');
                        step2Form.classList.remove('d-none');
                    } else {
                        const errMsg = data.message || (data.errors && data.errors.username ? data.errors.username[0] : 'Failed to send OTP.');
                        showAlert('danger', '<i class="bi bi-exclamation-triangle-fill me-2"></i>' + errMsg);
                    }
                } catch (error) {
                    showAlert('danger', '<i class="bi bi-exclamation-triangle-fill me-2"></i>An error occurred while reaching the server.');
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

                    const data = await response.json();

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
                    showAlert('danger', '<i class="bi bi-exclamation-triangle-fill me-2"></i>An error occurred while updating password.');
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