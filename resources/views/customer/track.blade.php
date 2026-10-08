<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SpeedLane AutoSpa - Track Status</title>
        
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
        
        <!-- Link to your central CSS file -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body>

        <!-- Simplified Utility Header with Figma Back Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 border-bottom-subtle shadow-sm">
            <div class="container justify-content-start">
                <!-- Figma Back Arrow Icon linking to the previous page -->
                <a href="/" class="text-secondary d-flex align-items-center text-decoration-none me-3 back-arrow-btn">
                    <i class="bi bi-arrow-left fs-4"></i>
                </a>
                
                <!-- Logo Section -->
                <a class="navbar-brand d-flex align-items-center" href="/">
                    <span class="logo-text">SpeedLane</span>
                </a>
            </div>
        </nav>

        <!-- Center Stage Container -->
        <main class="container py-5 mt-4">
            <div class="row justify-content-center text-center mb-4">
                <div class="col-md-9 col-lg-7">
                    <!-- Figma Header Title -->
                    <h1 class="fw-bold tracking-main-title mb-2">Track Your Vehicle Status</h1>
                    <!-- Figma Subtitle Message -->
                    <p class="text-muted tracking-main-subtitle">
                        Enter the tracking code provided by the service shop to monitor the progress of your vehicle repair.
                    </p>
                </div>
            </div>

            <!-- The Track Request Core Card -->
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-6">
                    <div class="tracking-card border-0 bg-white">
                        
                        <!-- Card Sub-Header Component -->
                        <h5 class="fw-semibold text-dark d-flex align-items-center mb-1 gap-2">
                            <i class="bi bi-search text-primary fs-5"></i> Tracking Code
                        </h5>
                        <p class="text-muted small mb-4">Enter your tracking code to view your vehicle service status</p>
                        
                        <!-- Submission Form (This will forward to your track-result page later) -->
                        <form id="trackingForm" action="/track-result" method="GET">
                            <div class="mb-4">
                                <!-- Field Label -->
                                <label for="trackingCode" class="form-label tracking-label fw-semibold text-dark">Tracking Code</label>
                                <!-- Tracking Input Box -->
                                <input type="text" class="form-control tracking-input text-muted" id="trackingCode" placeholder="e.g., SL-2026-001" autocomplete="off" required>
                                <div id="validationFeedback" class="invalid-feedback mt-2"></div>
                            </div>
                            
                            <!-- Status Action Submission Button (Uses Figma's light blue color scheme) -->
                            <button type="submit" class="btn btn-status-check w-100 d-flex align-items-center justify-content-center gap-2 mb-4">
                                <i class="bi bi-search"></i> Check Status
                            </button>
                        </form>

                        <!-- Figma Information Alert Banner Footer Component -->
                        <div class="info-alert-banner d-flex align-items-center justify-content-center gap-2 py-3 rounded-3">
                            <i class="bi bi-info-square-fill text-primary"></i>
                            <span class="info-alert-text text-primary fw-medium">No login required. Simply enter your tracking code.</span>
                        </div>

                    </div>
                </div>
            </div>
        </main>

        <!-- Bootstrap 5 JS Bundle CDN -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Reusing your central JS validation layer -->
        <script src="{{ asset('js/main.js') }}"></script>

        <!-- Rate-Limiting Brute-Force Protection Mechanism (5 Failed Attempts = 1 Min Lockout) -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const trackingForm = document.getElementById('trackingForm');
                const trackingInput = document.getElementById('trackingCode');
                const validationFeedback = document.getElementById('validationFeedback');
                const submitBtn = trackingForm ? trackingForm.querySelector('button[type="submit"]') : null;

                if (!trackingForm || !trackingInput) return;

                const MAX_ATTEMPTS = 5;
                const LOCKOUT_TIME_MS = 60000; // 1 minute in milliseconds

                function checkLockoutStatus() {
                    const lockoutUntil = parseInt(localStorage.getItem('speedlane_lockout_until') || '0', 10);
                    const now = Date.now();

                    if (now < lockoutUntil) {
                        const remainingSec = Math.ceil((lockoutUntil - now) / 1000);
                        
                        trackingInput.disabled = true;
                        if (submitBtn) submitBtn.disabled = true;

                        const warningMsg = `Too many failed tracking attempts! Please wait ${remainingSec} second(s) before trying again.`;
                        showWarning(warningMsg);

                        setTimeout(checkLockoutStatus, 1000);
                        return true;
                    } else {
                        if (lockoutUntil > 0) {
                            localStorage.removeItem('speedlane_lockout_until');
                            localStorage.setItem('speedlane_track_attempts', '0');
                        }
                        trackingInput.disabled = false;
                        if (submitBtn) submitBtn.disabled = false;
                        clearWarning();
                        return false;
                    }
                }

                function showWarning(msg) {
                    if (validationFeedback) {
                        validationFeedback.textContent = msg;
                        validationFeedback.style.display = 'block';
                        validationFeedback.className = 'invalid-feedback d-block mt-2 text-danger fw-bold';
                    } else {
                        let errAlert = document.getElementById('lockoutAlertBox');
                        if (!errAlert) {
                            errAlert = document.createElement('div');
                            errAlert.id = 'lockoutAlertBox';
                            errAlert.className = 'alert alert-danger rounded-2 mb-3 bg-danger bg-opacity-20 text-white border-danger small';
                            trackingForm.parentNode.insertBefore(errAlert, trackingForm);
                        }
                        errAlert.innerHTML = `<i class="bi bi-exclamation-triangle-fill me-2"></i> ${msg}`;
                    }
                }

                function clearWarning() {
                    if (validationFeedback) {
                        validationFeedback.textContent = '';
                        validationFeedback.style.display = 'none';
                    }
                    const errAlert = document.getElementById('lockoutAlertBox');
                    if (errAlert) errAlert.remove();
                }

                // Check for server-side error return
                const hasServerError = document.querySelector('.alert-danger') !== null;
                if (hasServerError && !checkLockoutStatus()) {
                    let attempts = parseInt(localStorage.getItem('speedlane_track_attempts') || '0', 10) + 1;
                    localStorage.setItem('speedlane_track_attempts', attempts.toString());

                    if (attempts >= MAX_ATTEMPTS) {
                        const lockoutTime = Date.now() + LOCKOUT_TIME_MS;
                        localStorage.setItem('speedlane_lockout_until', lockoutTime.toString());
                        localStorage.setItem('speedlane_track_attempts', '0');
                        checkLockoutStatus();
                    }
                } else {
                    checkLockoutStatus();
                }

                trackingForm.addEventListener('submit', function(e) {
                    if (checkLockoutStatus()) {
                        e.preventDefault();
                        return false;
                    }
                });
            });
        </script>
    </body>
    </html>