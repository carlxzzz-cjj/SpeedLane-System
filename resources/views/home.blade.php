<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedLane AutoSpa - Home</title>

    <!-- Google Fonts for Racing / Automotive Vibe -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,700;0,800;0,900;1,700;1,800;1,900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

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

    <!-- Custom CSS Link -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Light Mode Toggle CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme-toggle.css') }}">

    <style>
        :root {
            --speed-pink: #f42582;
            --speed-blue: #00a2ff;
            --speed-dark: #090a0f;
            --speed-dark-card: #11141d;
            --speed-card-bg: #12151e;
            --speed-card-border: rgba(255, 255, 255, 0.12);
            --font-racing: 'Barlow Condensed', sans-serif;
            --font-body: 'Inter', system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: var(--speed-dark);
            color: #f1f5f9;
            font-family: var(--font-body);
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Racing Typography Headings */
        .font-racing {
            font-family: var(--font-racing);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Standard Brand Text Colors */
        .text-speed-pink { color: var(--speed-pink) !important; }
        .text-speed-blue { color: var(--speed-blue) !important; }
        .bg-speed-pink { background-color: var(--speed-pink) !important; }
        .bg-speed-blue { background-color: var(--speed-blue) !important; }

        /* Navbar Styling */
        .navbar-speed {
            background: rgba(9, 10, 15, 0.95);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        /* Reference Image Exact Logo Typography */
        .brand-logo-text {
            font-size: 1.6rem;
            font-weight: 900;
            letter-spacing: 1px;
            font-style: italic;
        }

        .brand-subtext {
            font-size: 0.65rem;
            letter-spacing: 3px;
            font-weight: 800;
            text-transform: uppercase;
            color: #ffffff;
            margin-top: -6px;
            transition: color 0.3s ease;
        }

        .nav-link-custom {
            color: #cbd5e1;
            font-family: var(--font-racing);
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 0.5rem 1rem;
            transition: color 0.2s ease;
            text-decoration: none;
        }

        .nav-link-custom:hover {
            color: var(--speed-pink);
        }

        .admin-login-btn {
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.25) !important;
        }

        /* Buttons */
        .btn-speed-pink {
            background-color: var(--speed-pink);
            border: none;
            color: #ffffff !important;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-family: var(--font-racing);
            padding: 12px 28px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(244, 37, 130, 0.4);
        }

        .btn-speed-pink:hover {
            background-color: #d81b6f;
            color: #ffffff !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(244, 37, 130, 0.6);
        }

        .btn-speed-outline {
            background: transparent;
            border: 1px solid var(--speed-pink);
            color: #ffffff;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-family: var(--font-racing);
            padding: 12px 28px;
            transition: all 0.3s ease;
        }

        .btn-speed-outline:hover {
            background: rgba(244, 37, 130, 0.15);
            border-color: var(--speed-pink);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .btn-speed-gradient {
            background: linear-gradient(135deg, var(--speed-pink) 0%, var(--speed-blue) 100%);
            border: none;
            color: #ffffff !important;
            font-weight: 800;
            font-family: var(--font-racing);
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(244, 37, 130, 0.35);
        }

        .btn-speed-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(0, 162, 255, 0.5);
            color: #ffffff !important;
        }

        /* Hero Section */
        .hero-section {
            min-height: 92vh;
            background: linear-gradient(180deg, rgba(9, 10, 15, 0.8) 0%, rgba(9, 10, 15, 0.92) 80%, rgba(9, 10, 15, 1) 100%), 
                        url('https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
            padding: 140px 0 80px;
            position: relative;
            transition: background 0.3s ease;
        }

        .hero-display-title {
            font-family: var(--font-racing);
            font-weight: 900;
            font-size: clamp(2.5rem, 6vw, 4.8rem);
            line-height: 1.05;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* High-Visibility Neon Hero Colors for Dark & Light Themes */
        .hero-pink-text {
            color: var(--speed-pink) !important;
            text-shadow: 0 0 12px rgba(244, 37, 130, 0.5), 0 3px 10px rgba(0, 0, 0, 0.8);
            transition: color 0.3s ease, text-shadow 0.3s ease;
        }

        .hero-blue-text {
            color: var(--speed-blue) !important;
            text-shadow: 0 0 12px rgba(0, 162, 255, 0.5), 0 3px 10px rgba(0, 0, 0, 0.8);
            transition: color 0.3s ease, text-shadow 0.3s ease;
        }

        .hero-subtitle {
            font-size: 1.15rem;
            color: #cbd5e1;
            font-weight: 400;
        }

        .hero-pill-badge {
            background-color: rgba(17, 20, 29, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #ffffff !important;
            backdrop-filter: blur(8px);
        }

        /* Tracking Card - High Contrast Dark & Light Support */
        .tracking-card {
            background: rgba(18, 21, 30, 0.92);
            border: 1px solid var(--speed-card-border);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(16px);
        }

        .tracking-card-title {
            color: #ffffff !important;
        }

        .tracking-label {
            color: #cbd5e1 !important;
        }

        .tracking-input {
            background-color: #0b0d14 !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
            font-size: 1.1rem;
            letter-spacing: 2px;
            padding: 14px 18px;
            font-family: var(--font-racing);
            transition: all 0.3s ease;
        }

        .tracking-input::placeholder {
            color: #64748b !important;
            opacity: 1;
        }

        .tracking-input:focus {
            border-color: var(--speed-pink) !important;
            box-shadow: 0 0 15px rgba(244, 37, 130, 0.35) !important;
        }

        /* Cards & Components */
        .service-card {
            background: var(--speed-dark-card);
            border: 1px solid var(--speed-card-border);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .service-card h4 {
            color: #ffffff;
        }

        .service-card p {
            color: #94a3b8;
        }

        .service-card:hover {
            transform: translateY(-8px);
            border-color: var(--speed-pink);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6), 0 0 25px rgba(244, 37, 130, 0.2);
        }

        .service-img-wrapper {
            position: relative;
            height: 210px;
            overflow: hidden;
        }

        .service-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .service-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(9, 10, 15, 0.85);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            font-family: var(--font-racing);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Carousel Styles */
        .carousel-item img {
            height: 500px;
            object-fit: cover;
            filter: brightness(0.8);
            border-radius: 16px;
        }

        .carousel-caption-custom {
            background: rgba(9, 10, 15, 0.88);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 22px;
            border-left: 4px solid var(--speed-pink);
            color: #ffffff;
        }

        .carousel-caption-custom h5 {
            color: #ffffff;
        }

        .carousel-caption-custom p {
            color: #cbd5e1;
        }

        /* Footer */
        footer {
            background-color: #06070a;
            color: #94a3b8;
        }

        footer h6 {
            color: #ffffff;
        }

        .footer-link {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .footer-link:hover {
            color: var(--speed-blue);
        }

        .social-box {
            width: 32px;
            height: 32px;
            background-color: var(--speed-pink);
            color: #ffffff !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            text-decoration: none;
            font-size: 0.85rem;
            transition: opacity 0.2s ease;
        }

        .social-box:hover {
            opacity: 0.85;
        }

        .navbar-toggler {
            border: 1px solid var(--speed-card-border);
            padding: 8px 12px;
        }
        .navbar-toggler-icon {
            filter: invert(1);
        }


        /* ==========================================================================
           LIGHT MODE OVERRIDES (Optimized Title Contrast & Clean Legibility)
           ========================================================================== */
        html.light-theme {
            --speed-dark: #f8fafc;
            --speed-card-bg: #ffffff;
            --speed-card-border: rgba(0, 0, 0, 0.1);
        }

        html.light-theme body {
            background-color: #f8fafc !important;
            color: #0f172a !important;
        }

        html.light-theme .navbar-speed {
            background: rgba(255, 255, 255, 0.92) !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
        }

        html.light-theme .brand-subtext {
            color: #0f172a !important;
        }

        html.light-theme .nav-link-custom {
            color: #0f172a !important;
        }

        html.light-theme .nav-link-custom:hover {
            color: var(--speed-pink) !important;
        }

        html.light-theme .admin-login-btn {
            color: #0f172a !important;
            border-color: #94a3b8 !important;
        }

        html.light-theme .admin-login-btn:hover {
            background-color: #e2e8f0 !important;
        }

        html.light-theme #theme-toggle-btn {
            border-color: #94a3b8 !important;
            color: #0f172a !important;
        }

        /* Light Mode Hero Section Overlay */
        html.light-theme .hero-section {
            background: linear-gradient(180deg, rgba(248, 250, 252, 0.55) 0%, rgba(248, 250, 252, 0.75) 100%), 
                        url('https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat !important;
        }

        /* Refined Crisp Punchy Brand Title Colors for Light Mode */
        html.light-theme .hero-pink-text {
            color: #e60067 !important;
            text-shadow: 0 1px 3px rgba(255, 255, 255, 0.9), 0 2px 10px rgba(230, 0, 103, 0.15) !important;
        }

        html.light-theme .hero-blue-text {
            color: #0070f3 !important;
            text-shadow: 0 1px 3px rgba(255, 255, 255, 0.9), 0 2px 10px rgba(0, 112, 243, 0.15) !important;
        }

        html.light-theme .hero-subtitle {
            color: #1e293b !important;
            font-weight: 500 !important;
            text-shadow: 0 1px 8px rgba(255, 255, 255, 0.8) !important;
        }

        html.light-theme .hero-pill-badge {
            background-color: rgba(255, 255, 255, 0.9) !important;
            border: 1px solid rgba(0, 162, 255, 0.3) !important;
            color: #0077cc !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        html.light-theme .btn-speed-outline {
            color: #0f172a !important;
            border-color: var(--speed-pink) !important;
        }

        html.light-theme .btn-speed-outline:hover {
            background: rgba(244, 37, 130, 0.1) !important;
            color: var(--speed-pink) !important;
        }

        html.light-theme .tracking-card {
            background: rgba(255, 255, 255, 0.95) !important;
            border: 1px solid rgba(0, 0, 0, 0.12) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12) !important;
        }

        html.light-theme .tracking-card-title {
            color: #0f172a !important;
        }

        html.light-theme .tracking-label {
            color: #475569 !important;
        }

        html.light-theme .tracking-input {
            background-color: #f1f5f9 !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
        }

        html.light-theme .tracking-input::placeholder {
            color: #94a3b8 !important;
        }

        html.light-theme #services h2,
        html.light-theme #showcase h2 {
            color: #0f172a !important;
        }

        html.light-theme #services p.text-secondary,
        html.light-theme #showcase p.text-secondary {
            color: #475569 !important;
        }

        html.light-theme .service-card {
            background: #ffffff !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04);
        }

        html.light-theme .service-card h4 {
            color: #0f172a !important;
        }

        html.light-theme .service-card p {
            color: #475569 !important;
        }

        html.light-theme .service-badge {
            background: rgba(255, 255, 255, 0.9) !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
        }

        html.light-theme #showcase {
            background-color: #f1f5f9 !important;
        }

        html.light-theme .carousel-caption-custom {
            background: rgba(255, 255, 255, 0.92) !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            color: #0f172a !important;
        }

        html.light-theme .carousel-caption-custom h5 {
            color: #0f172a !important;
        }

        html.light-theme .carousel-caption-custom p {
            color: #475569 !important;
        }

        html.light-theme footer {
            background-color: #e2e8f0 !important;
            color: #475569 !important;
        }

        html.light-theme footer h6 {
            color: #0f172a !important;
        }

        html.light-theme .footer-link {
            color: #475569 !important;
        }

        html.light-theme .footer-link:hover {
            color: var(--speed-pink) !important;
        }

        html.light-theme .navbar-toggler {
            border-color: rgba(0, 0, 0, 0.2);
        }

        html.light-theme .navbar-toggler-icon {
            filter: invert(0);
        }

  body {
    zoom: 80%; /* Adjusts the render scale across modern browsers */
  }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-speed py-3">
        <div class="container d-flex align-items-center justify-content-between">
            <!-- Brand Logo matching exact reference design -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="/">
                <div class="p-2 rounded-3 bg-speed-pink d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px;">
                    <i class="bi bi-car-front-fill text-white fs-4"></i>
                </div>
                <div class="d-flex flex-column">
                    <span class="brand-logo-text">
                        <span class="text-speed-pink">SPEED</span><span class="text-speed-blue">LANE</span>
                    </span>
                    <span class="brand-subtext">GENERAL SANTOS</span>
                </div>
            </a>

            <!-- Mobile Hamburger Toggle Menu -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Nav Content & Quick Links -->
            <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarNav">
                <ul class="navbar-nav mx-auto align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link-custom" href="#tracking">Track Vehicle</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom" href="#showcase">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom" href="#contact">Contact</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3 flex-row justify-content-end">
                    <!-- Admin Login Button -->
                    <a class="btn btn-outline-light fw-bold px-3 py-2 rounded-2 admin-login-btn d-inline-flex align-items-center gap-2 text-nowrap font-racing" href="/admin/login">
                        <i class="bi bi-shield-lock-fill text-speed-pink"></i> Admin Login
                    </a>

                    <!-- Light / Dark Mode Toggle Button -->
                    <button id="theme-toggle-btn" type="button" class="btn btn-outline-light d-flex align-items-center justify-content-center rounded-circle p-2" style="width: 38px; height: 38px;" title="Toggle Light/Dark Mode" aria-label="Toggle Light/Dark Mode" onclick="toggleSpeedLaneTheme()">
                        <i id="theme-toggle-icon" class="bi bi-sun-fill text-warning"></i>
                    </button>

                    <!-- Social Icons Box -->
                    <div class="d-none d-xl-flex gap-1 ms-2">
                        <a href="https://www.facebook.com/share/1DJhyH57La/" target="_blank" rel="noopener noreferrer" class="social-box"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-box"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-box"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Hero Content Section -->
    <main class="hero-section d-flex align-items-center">
        <div class="container text-center text-lg-start">
            <div class="row align-items-center justify-content-between g-5">
                
                <!-- Left Column: Big Bold Text + Action Button -->
                <div class="col-lg-7">
                    <!-- Premier Auto Care Badge -->
                    <span class="badge rounded-pill px-3 py-2 hero-pill-badge fw-semibold mb-3 font-racing">
                        <i class="bi bi-lightning-charge-fill me-1 text-speed-pink"></i> Premier Auto Care & Detailing
                    </span>
                    
                    <!-- Main Display Title (Styled in Neon Pink & Blue for High Contrast in Light/Dark Mode) -->
                    <h1 class="hero-display-title mb-3">
                        <span class="hero-pink-text">SPEEDLANE SERVICE</span> <br>
                        <span class="hero-pink-text">&</span> <span class="hero-blue-text">TRACKING EXPERTS</span>
                    </h1>

                    <!-- Subtitle Text -->
                    <p class="hero-subtitle mb-4 pe-lg-4">
                        You do the driving. We take care of the ultimate finish and real-time service updates.
                    </p>

                    <!-- Primary Action Button -->
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start gap-3">
                        <a href="#services" class="btn btn-speed-pink rounded-1">
                            Learn More
                        </a>
                    </div>
                </div>

                <!-- Right Column: Floating Tracking Card Component -->
                <div class="col-lg-5 col-xl-4" id="tracking">
                    <div class="tracking-card p-4 p-md-4 rounded-3 text-start">
                        <h5 class="tracking-card-title font-racing fs-4 d-flex align-items-center mb-3 fw-bold">
                            <i class="bi bi-speedometer2 text-speed-pink me-2 fs-3"></i> Track Your Vehicle
                        </h5>

                        <!-- Error Alert Message -->
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show rounded-2 mb-3 bg-danger bg-opacity-20 text-white border-danger" role="alert">
                                <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form id="trackingForm" action="/track" method="GET">
                            <div class="mb-4">
                                <label for="trackingCode" class="form-label tracking-label fw-bold small text-uppercase font-racing">Enter Tracking Code</label>
                                <input type="text" 
                                       name="tracking_code" 
                                       class="form-control tracking-input text-uppercase rounded-2" 
                                       id="trackingCode" 
                                       placeholder="e.g. SL-8921" 
                                       value="{{ old('tracking_code', request('tracking_code')) }}" 
                                       autocomplete="off" 
                                       required>
                                <div id="validationFeedback" class="invalid-feedback mt-2"></div>
                            </div>

                            <button type="submit" class="btn btn-speed-gradient w-100 tracking-btn d-flex align-items-center justify-content-center gap-2 py-3 rounded-2 fs-6">
                                <i class="bi bi-lightning-fill"></i> Track Vehicle Status
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Services Section -->
    <section id="services" class="py-5 border-top border-secondary border-opacity-10">
        <div class="container py-4">
            <div class="text-center mb-5">
                <span class="text-speed-blue font-racing fw-bold text-uppercase tracking-wider fs-5">Premium Solutions</span>
                <h2 class="font-racing fw-black display-5 mt-1">Our Elite Auto Care Services</h2>
                <p class="text-secondary mx-auto" style="max-width: 600px;">Crafted with cutting-edge technology and precision craftsmanship to protect and restore your vehicle.</p>
            </div>

            <div class="row g-4">
                <!-- 1. Graphene Coating -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card h-100">
                        <div class="service-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?auto=format&fit=crop&w=800&q=80" alt="Graphene Coating">
                            <span class="service-badge text-speed-pink"><i class="bi bi-shield-fill-check me-1"></i> Ultra Grade</span>
                        </div>
                        <div class="p-4">
                            <h4 class="font-racing fw-bold fs-4 mb-2">Graphene Coating</h4>
                            <p class="small mb-0">Next-generation graphene matrix technology offering maximum heat reduction, water-spot prevention, and extreme 10H scratch resistance.</p>
                        </div>
                    </div>
                </div>

                <!-- 2. Ceramic Coating -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card h-100">
                        <div class="service-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1607860108855-64acf2078ed9?auto=format&fit=crop&w=800&q=80" alt="Ceramic Coating">
                            <span class="service-badge text-speed-blue"><i class="bi bi-stars me-1"></i> High Gloss</span>
                        </div>
                        <div class="p-4">
                            <h4 class="font-racing fw-bold fs-4 mb-2">Ceramic Coating</h4>
                            <p class="small mb-0">High-grade 9H nano-ceramic protection delivering deep mirror reflections, hydrophobic water sheeting, and multi-year paint protection.</p>
                        </div>
                    </div>
                </div>

                <!-- 3. Paint Protection Film (PPF) -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card h-100">
                        <div class="service-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1520340356584-f9917d1eea6f?auto=format&fit=crop&w=800&q=80" alt="Paint Protection Film">
                            <span class="service-badge text-speed-pink"><i class="bi bi-shield-lock-fill me-1"></i> Self-Healing</span>
                        </div>
                        <div class="p-4">
                            <h4 class="font-racing fw-bold fs-4 mb-2">Paint Protection Film (PPF)</h4>
                            <p class="small mb-0">Ultra-clear TPU self-healing armor that shields your car's bodywork against rock chips, scratches, chemical stains, and UV fading.</p>
                        </div>
                    </div>
                </div>

                <!-- 4. Complete Washover & Repaint -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card h-100">
                        <div class="service-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?auto=format&fit=crop&w=800&q=80" alt="Washover & Paint Restoration">
                            <span class="service-badge text-speed-blue"><i class="bi bi-palette-fill me-1"></i> Full Renewal</span>
                        </div>
                        <div class="p-4">
                            <h4 class="font-racing fw-bold fs-4 mb-2">Complete Washover</h4>
                            <p class="small mb-0">Full body automotive refinishing, panel dent repair, color change, and polyurethane clear coat application in our oven bake booth.</p>
                        </div>
                    </div>
                </div>

                <!-- 5. Interior Detailing -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card h-100">
                        <div class="service-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1507136566006-cfc505b114fc?auto=format&fit=crop&w=800&q=80" alt="Interior Detailing">
                            <span class="service-badge text-speed-pink"><i class="bi bi-magic me-1"></i> Deep Clean</span>
                        </div>
                        <div class="p-4">
                            <h4 class="font-racing fw-bold fs-4 mb-2">Interior Deep Detailing</h4>
                            <p class="small mb-0">Full steam extraction, carpet shampooing, leather conditioning, dashboard treatment, and anti-bacterial cabin sanitation.</p>
                        </div>
                    </div>
                </div>

                <!-- 6. Exterior Detailing -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card h-100">
                        <div class="service-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1601362840469-51e4d8d58785?auto=format&fit=crop&w=800&q=80" alt="Exterior Detailing">
                            <span class="service-badge text-speed-blue"><i class="bi bi-gem me-1"></i> Paint Correction</span>
                        </div>
                        <div class="p-4">
                            <h4 class="font-racing fw-bold fs-4 mb-2">Exterior Detailing</h4>
                            <p class="small mb-0">Multi-stage machine paint correction, swirl & hologram removal, clay bar decontamination, and high-gloss sealant finish.</p>
                        </div>
                    </div>
                </div>

                <!-- 7. Engine Bay Detailing -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card h-100">
                        <div class="service-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=800&q=80" alt="Engine Bay Detailing">
                            <span class="service-badge text-speed-pink"><i class="bi bi-cpu-fill me-1"></i> Precision Care</span>
                        </div>
                        <div class="p-4">
                            <h4 class="font-racing fw-bold fs-4 mb-2">Engine Bay Detailing</h4>
                            <p class="small mb-0">Safe low-moisture engine bay degreasing, grime removal, and non-greasy protective dressing for plastics and hoses.</p>
                        </div>
                    </div>
                </div>

                <!-- 8. Glass & Headlight Restoration -->
                <div class="col-md-6 col-lg-8">
                    <div class="service-card h-100">
                        <div class="service-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80" alt="Glass and Headlight Restoration">
                            <span class="service-badge text-speed-blue"><i class="bi bi-eye-fill me-1"></i> Clarity Restoration</span>
                        </div>
                        <div class="p-4">
                            <h4 class="font-racing fw-bold fs-4 mb-2">Glass Coating & Headlight Restoration</h4>
                            <p class="small mb-0">Watermark stain removal, hydrophobic windshield rain-repellent coating, and UV lens wet-sanding for crystal clear night visibility.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Image Carousel Showcase -->
    <section id="showcase" class="py-5 border-top border-secondary border-opacity-10">
        <div class="container py-4">
            <div class="text-center mb-4">
                <h2 class="font-racing fw-bold display-6">Service Showcase Gallery</h2>
                <p class="text-secondary">Take a glimpse inside SpeedLane AutoSpa General Santos</p>
            </div>

            <div id="speedlaneCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#speedlaneCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#speedlaneCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#speedlaneCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>

                <div class="carousel-inner rounded-3">
                    <div class="carousel-item active" data-bs-interval="4000">
                        <img src="https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?auto=format&fit=crop&w=1200&q=80" class="d-block w-100" alt="Ceramic Coating Treatment">
                        <div class="carousel-caption d-none d-md-block text-start">
                            <div class="carousel-caption-custom">
                                <h5 class="font-racing fw-bold fs-4">Precision Ceramic Coating</h5>
                                <p class="mb-0">Unmatched mirror shine and long-lasting surface protection.</p>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item" data-bs-interval="4000">
                        <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=1200&q=80" class="d-block w-100" alt="Luxury Vehicles Services">
                        <div class="carousel-caption d-none d-md-block text-start">
                            <div class="carousel-caption-custom" style="border-left-color: var(--speed-blue);">
                                <h5 class="font-racing fw-bold fs-4">Luxury Vehicle Care</h5>
                                <p class="mb-0">Expert care engineered specifically for exotic and luxury vehicles.</p>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item" data-bs-interval="4000">
                        <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80" class="d-block w-100" alt="Real-Time Service Progress">
                        <div class="carousel-caption d-none d-md-block text-start">
                            <div class="carousel-caption-custom">
                                <h5 class="font-racing fw-bold fs-4">Real-Time Queue Tracking</h5>
                                <p class="mb-0">Always stay informed on your vehicle's current status.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#speedlaneCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#speedlaneCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer id="contact" class="pt-5 pb-4 border-top border-secondary border-opacity-10">
        <div class="container">
            <div class="row g-4 mb-4">
                <!-- Brand Info -->
                <div class="col-lg-5">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="p-2 rounded-2 bg-speed-pink d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="bi bi-car-front-fill text-white fs-6"></i>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="brand-logo-text">
                                <span class="text-speed-pink">SPEED</span><span class="text-speed-blue">LANE</span>
                            </span>
                            <span class="brand-subtext">GENERAL SANTOS</span>
                        </div>
                    </div>
                    <p class="small pe-lg-4">
                        SpeedLane AutoSpa General Santos provides high-end detailing, paint correction, ceramic & graphene coatings, PPF, and transparent real-time vehicle service tracking.
                    </p>
                </div>

                <!-- Clickable Contact Information -->
                <div class="col-lg-7">
                    <h6 class="font-racing fw-bold text-uppercase mb-3 fs-5">Get In Touch</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-3">
                        <li>
                            <a href="https://maps.google.com/?q=23+Ramos+St,+Brgy.+Dadiangas+East,+General+Santos+City,+Philippines,+9500" target="_blank" class="footer-link d-flex align-items-start gap-2">
                                <i class="bi bi-geo-alt-fill text-speed-pink fs-6"></i>
                                <span>23 Ramos St., Brgy. Dadiangas East, General Santos City, Philippines, 9500</span>
                            </a>
                        </li>
                        <li>
                            <a href="tel:+639380274988" class="footer-link d-flex align-items-center gap-2">
                                <i class="bi bi-telephone-fill text-speed-blue fs-6"></i>
                                <span>+63 938 027 4988</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=speedlaneperformance@gmail.com" target="_blank" rel="noopener noreferrer" class="footer-link d-flex align-items-center gap-2">
                                <i class="bi bi-envelope-fill text-speed-pink fs-6"></i>
                                <span>speedlaneperformance@gmail.com</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="border-secondary opacity-25">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small pt-2">
                <p class="mb-2 mb-md-0">&copy; {{ date('Y') }} SpeedLane AutoSpa General Santos. All rights reserved.</p>
                <div class="d-flex gap-2">
                    <a href="https://www.facebook.com/share/1DJhyH57La/" target="_blank" rel="noopener noreferrer" class="social-box"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-box"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="social-box"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS Link -->
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- Light Mode Toggle JS -->
    <script src="{{ asset('js/theme-toggle.js') }}"></script>

</body>
</html>