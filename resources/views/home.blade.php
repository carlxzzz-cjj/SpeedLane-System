<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedLane AutoSpa - Home</title>
    
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    
    <!-- Custom CSS Link -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
        <div class="container">
            <!-- Logo Section -->
            <a class="navbar-brand d-flex align-items-center" href="/">
                <div class="logo-icon me-2">
                    <i class="bi bi-car-front-fill text-white fs-5"></i>
                </div>
                <span class="logo-text">SpeedLane</span>
            </a>
            
            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Nav Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link active-link me-3" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link me-3" href="/track">Track Vehicle</a></li>
                    <li class="nav-item"><a class="nav-link me-3" href="/about">About</a></li>
                    <li class="nav-item"><a class="nav-link me-3" href="/contact">Contact</a></li>
                    <li class="nav-item"><a class="nav-link admin-login-btn text-primary fw-semibold" href="/admin/login">Admin Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Hero Content Section -->
    <main class="hero-section d-flex align-items-center">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Title Header -->
                    <h1 class="hero-title fw-bold text-dark mb-3">
                        SpeedLane Service Tracker!
                    </h1>
                    <!-- Subtitle Header -->
                    <p class="hero-subtitle text-muted mb-5">
                        Track your vehicle service progress anytime without calling the shop!
                    </p>
                </div>
            </div>

            <!-- Floating Tracking Card Component -->
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-6">
                    <div class="tracking-card border-0 bg-white text-start shadow-sm p-4 rounded-4">
                        <h5 class="tracking-card-title d-flex align-items-center fw-semibold mb-4">
                            <i class="bi bi-search text-primary me-2"></i> Track Your Vehicle
                        </h5>
                        
                        <!-- Error Alert Message -->
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3" role="alert">
                                <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form id="trackingForm" action="/track" method="GET">
                            <div class="mb-4">
                                <label for="trackingCode" class="form-label tracking-label fw-medium text-dark">Enter Tracking Code</label>
                                <!-- FIXED: Added name="tracking_code" -->
                                <input type="text" 
                                       name="tracking_code" 
                                       class="form-control tracking-input text-uppercase" 
                                       id="trackingCode" 
                                       placeholder="" 
                                       value="{{ old('tracking_code', request('tracking_code')) }}" 
                                       autocomplete="off" 
                                       required>
                                <div id="validationFeedback" class="invalid-feedback mt-2"></div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 tracking-btn d-flex align-items-center justify-content-center gap-2 py-2.5 fw-semibold rounded-3">
                                <i class="bi bi-search"></i> Track Vehicle
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS Link -->
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>