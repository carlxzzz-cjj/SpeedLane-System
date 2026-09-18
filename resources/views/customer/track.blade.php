<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedLane AutoSpa - Track Status</title>
    
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
</body>
</html>