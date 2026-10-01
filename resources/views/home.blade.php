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

    <style>
        :root {
            --speed-pink: #f42582;
            --speed-blue: #00a2ff;
            --speed-dark: #090a0f;
            --speed-card-bg: #12151e;
            --speed-card-border: rgba(255, 255, 255, 0.08);
        }

        body {
            background-color: var(--speed-dark);
            color: #e2e8f0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
        }

        /* Gradient & Typography Colors */
        .text-speed-pink { color: var(--speed-pink) !important; }
        .text-speed-blue { color: var(--speed-blue) !important; }
        .bg-speed-pink { background-color: var(--speed-pink) !important; }
        .bg-speed-blue { background-color: var(--speed-blue) !important; }

        .btn-speed-gradient {
            background: linear-gradient(135deg, var(--speed-pink) 0%, var(--speed-blue) 100%);
            border: none;
            color: #ffffff;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(244, 37, 130, 0.35);
        }

        .btn-speed-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(0, 162, 255, 0.5);
            color: #ffffff;
        }

        /* Glassmorphism Navbar */
        .navbar-speed {
            background: rgba(9, 10, 15, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--speed-card-border);
        }

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
        }

        /* Hero Section */
        .hero-section {
            min-height: 85vh;
            background: radial-gradient(circle at 50% 20%, rgba(244, 37, 130, 0.12) 0%, rgba(0, 162, 255, 0.08) 40%, rgba(9, 10, 15, 1) 80%);
            padding: 110px 0 60px;
        }

        /* Floating Tracking Card */
        .tracking-card {
            background: var(--speed-card-bg);
            border: 1px solid var(--speed-card-border);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
        }

        .tracking-input {
            background-color: #0b0d14 !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #ffffff !important;
            font-size: 1.1rem;
            letter-spacing: 1.5px;
            padding: 14px 18px;
            transition: all 0.3s ease;
        }

        .tracking-input:focus {
            border-color: var(--speed-blue) !important;
            box-shadow: 0 0 15px rgba(0, 162, 255, 0.3) !important;
        }

        /* Service Cards with Image Showcase */
        .service-card {
            background: var(--speed-card-bg);
            border: 1px solid var(--speed-card-border);
            border-radius: 18px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .service-card:hover {
            transform: translateY(-7px);
            border-color: rgba(244, 37, 130, 0.4);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5), 0 0 20px rgba(244, 37, 130, 0.15);
        }

        .service-img-wrapper {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .service-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .service-card:hover .service-img-wrapper img {
            transform: scale(1.08);
        }

        .service-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(9, 10, 15, 0.75);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Carousel Styles */
        .carousel-item img {
            height: 480px;
            object-fit: cover;
            filter: brightness(0.7);
            border-radius: 20px;
        }

        .carousel-caption-custom {
            background: rgba(9, 10, 15, 0.75);
            backdrop-filter: blur(8px);
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid var(--speed-pink);
        }

        /* Footer Links */
        .footer-link {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .footer-link:hover {
            color: var(--speed-blue);
        }

        /* Hamburger Menu Button */
        .navbar-toggler {
            border: 1px solid var(--speed-card-border);
            padding: 8px 12px;
        }
        .navbar-toggler-icon {
            filter: invert(1);
        }
    </style>
</head>
<body>

    <!-- Header Navigation (Simplified - Links Removed as Requested) -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-speed py-3">
        <div class="container">
            <!-- Logo Section -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="/">
                <div class="p-2 rounded-3 bg-speed-pink d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                    <i class="bi bi-car-front-fill text-white fs-5"></i>
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

            <!-- Nav Content: Only Admin Login Button inside Hamburger Menu -->
            <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item w-100 w-lg-auto">
                        <a class="btn btn-outline-light fw-bold px-4 py-2 rounded-3 admin-login-btn d-inline-flex align-items-center gap-2 w-100 justify-content-center" href="/admin/login">
                            <i class="bi bi-shield-lock-fill text-speed-pink"></i> Admin Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Hero Content Section -->
    <main class="hero-section d-flex align-items-center">
        <div class="container text-center">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-10">
                    <span class="badge rounded-pill px-3 py-2 bg-dark border border-secondary text-speed-blue fw-semibold mb-3">
                        <i class="bi bi-lightning-charge-fill me-1 text-speed-pink"></i> Premier Auto Care & Detailing
                    </span>
                    
                    <!-- Title Header -->
                    <h1 class="hero-title fw-bold mb-3 display-4" style="color: #ffffff !important;">
                        <span style="color: #ffffff !important; text-shadow: 0 0 20px rgba(255, 255, 255, 0.4);">SpeedLane</span> 
                        <span class="text-speed-pink">Service</span> 
                        <span class="text-speed-blue">Tracker</span>
                    </h1>

                    <!-- Subtitle Header -->
                    <p class="hero-subtitle text-secondary fs-5 mb-4 mx-auto" style="max-width: 650px;">
                        Track your vehicle service progress anytime, anywhere without calling the shop!
                    </p>
                </div>
            </div>

            <!-- Floating Tracking Card Component -->
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="tracking-card text-start p-4 p-md-5 rounded-4">
                        <h5 class="tracking-card-title d-flex align-items-center fw-bold text-white mb-4 fs-5">
                            <i class="bi bi-search text-speed-blue me-2 fs-4"></i> Track Your Vehicle
                        </h5>

                        <!-- Error Alert Message -->
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 bg-danger bg-opacity-20 text-white border-danger" role="alert">
                                <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form id="trackingForm" action="/track" method="GET">
                            <div class="mb-4">
                                <label for="trackingCode" class="form-label tracking-label fw-medium text-secondary small text-uppercase">Enter Tracking Code</label>
                                <!-- FIXED: Added name="tracking_code" -->
                                <input type="text" 
                                       name="tracking_code" 
                                       class="form-control tracking-input text-uppercase rounded-3" 
                                       id="trackingCode" 
                                       placeholder="e.g. SL-8921" 
                                       value="{{ old('tracking_code', request('tracking_code')) }}" 
                                       autocomplete="off" 
                                       required>
                                <div id="validationFeedback" class="invalid-feedback mt-2"></div>
                            </div>

                            <button type="submit" class="btn btn-speed-gradient w-100 tracking-btn d-flex align-items-center justify-content-center gap-2 py-3 rounded-3 fs-6">
                                <i class="bi bi-speedometer2"></i> Track Vehicle Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Services Section (Updated with Images & Expanded List) -->
    <section id="services" class="py-5 border-top border-dark">
        <div class="container py-4">
            <div class="text-center mb-5">
                <span class="text-speed-blue fw-bold text-uppercase tracking-wider">Premium Solutions</span>
                <h2 class="text-white fw-bold display-6 mt-1">Our Elite Auto Care Services</h2>
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
                            <h4 class="text-white fw-bold fs-5 mb-2">Graphene Coating</h4>
                            <p class="text-secondary small mb-0">Next-generation graphene matrix technology offering maximum heat reduction, water-spot prevention, and extreme 10H scratch resistance.</p>
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
                            <h4 class="text-white fw-bold fs-5 mb-2">Ceramic Coating</h4>
                            <p class="text-secondary small mb-0">High-grade 9H nano-ceramic protection delivering deep mirror reflections, hydrophobic water sheeting, and multi-year paint protection.</p>
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
                            <h4 class="text-white fw-bold fs-5 mb-2">Paint Protection Film (PPF)</h4>
                            <p class="text-secondary small mb-0">Ultra-clear TPU self-healing armor that shields your car's bodywork against rock chips, scratches, chemical stains, and UV fading.</p>
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
                            <h4 class="text-white fw-bold fs-5 mb-2">Complete Washover</h4>
                            <p class="text-secondary small mb-0">Full body automotive refinishing, panel dent repair, color change, and polyurethane clear coat application in our oven bake booth.</p>
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
                            <h4 class="text-white fw-bold fs-5 mb-2">Interior Deep Detailing</h4>
                            <p class="text-secondary small mb-0">Full steam extraction, carpet shampooing, leather conditioning, dashboard treatment, and anti-bacterial cabin sanitation.</p>
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
                            <h4 class="text-white fw-bold fs-5 mb-2">Exterior Detailing</h4>
                            <p class="text-secondary small mb-0">Multi-stage machine paint correction, swirl & hologram removal, clay bar decontamination, and high-gloss sealant finish.</p>
                        </div>
                    </div>
                </div>

                <!-- 7. Engine Bay Detailing -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card h-100">
                        <div class="service-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1486006920555-c77dce18193b?auto=format&fit=crop&w=800&q=80" alt="Engine Bay Detailing">
                            <span class="service-badge text-speed-pink"><i class="bi bi-cpu-fill me-1"></i> Precision Care</span>
                        </div>
                        <div class="p-4">
                            <h4 class="text-white fw-bold fs-5 mb-2">Engine Bay Detailing</h4>
                            <p class="text-secondary small mb-0">Safe low-moisture engine bay degreasing, grime removal, and non-greasy protective dressing for plastics and hoses.</p>
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
                            <h4 class="text-white fw-bold fs-5 mb-2">Glass Coating & Headlight Restoration</h4>
                            <p class="text-secondary small mb-0">Watermark stain removal, hydrophobic windshield rain-repellent coating, and UV lens wet-sanding for crystal clear night visibility.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Image Carousel Showcase -->
    <section id="showcase" class="py-5 bg-black bg-opacity-50">
        <div class="container py-4">
            <div class="text-center mb-4">
                <h2 class="text-white fw-bold display-6">Service Showcase Gallery</h2>
                <p class="text-secondary">Take a glimpse inside SpeedLane AutoSpa General Santos</p>
            </div>

            <div id="speedlaneCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#speedlaneCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#speedlaneCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#speedlaneCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>

                <div class="carousel-inner rounded-4">
                    <div class="carousel-item active" data-bs-interval="4000">
                        <img src="https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?auto=format&fit=crop&w=1200&q=80" class="d-block w-100" alt="Ceramic Coating Treatment">
                        <div class="carousel-caption d-none d-md-block text-start">
                            <div class="carousel-caption-custom">
                                <h5 class="text-white fw-bold fs-4">Precision Ceramic Coating</h5>
                                <p class="text-light mb-0">Unmatched mirror shine and long-lasting surface protection.</p>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item" data-bs-interval="4000">
                        <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=1200&q=80" class="d-block w-100" alt="Luxury Vehicles Services">
                        <div class="carousel-caption d-none d-md-block text-start">
                            <div class="carousel-caption-custom" style="border-left-color: var(--speed-blue);">
                                <h5 class="text-white fw-bold fs-4">Luxury Vehicle Care</h5>
                                <p class="text-light mb-0">Expert care engineered specifically for exotic and luxury vehicles.</p>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item" data-bs-interval="4000">
                        <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80" class="d-block w-100" alt="Real-Time Service Progress">
                        <div class="carousel-caption d-none d-md-block text-start">
                            <div class="carousel-caption-custom">
                                <h5 class="text-white fw-bold fs-4">Real-Time Queue Tracking</h5>
                                <p class="text-light mb-0">Always stay informed on your vehicle's current status.</p>
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
    <footer id="contact" class="pt-5 pb-4 border-top border-dark" style="background-color: #06070a;">
        <div class="container">
            <div class="row g-4 mb-4">
                <!-- Brand Info -->
                <div class="col-lg-5">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="p-2 rounded-3 bg-speed-pink d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="bi bi-car-front-fill text-white fs-6"></i>
                        </div>
                        <span class="brand-logo-text fs-5">
                            <span class="text-speed-pink">SPEED</span><span class="text-speed-blue">LANE</span>
                        </span>
                    </div>
                    <p class="text-secondary small pe-lg-4">
                        SpeedLane AutoSpa General Santos provides high-end detailing, paint correction, ceramic & graphene coatings, PPF, and transparent real-time vehicle service tracking.
                    </p>
                </div>

                <!-- Clickable Contact Information -->
                <div class="col-lg-7">
                    <h6 class="text-white fw-bold text-uppercase mb-3">Get In Touch</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-3">
                        <li>
                            <a href="https://maps.google.com/?q=General+Santos+City" target="_blank" class="footer-link d-flex align-items-start gap-2">
                                <i class="bi bi-geo-alt-fill text-speed-pink fs-6"></i>
                                <span>General Santos City, South Cotabato, Philippines</span>
                            </a>
                        </li>
                        <li>
                            <a href="tel:+639123456789" class="footer-link d-flex align-items-center gap-2">
                                <i class="bi bi-telephone-fill text-speed-blue fs-6"></i>
                                <span>+63 912 345 6789</span>
                            </a>
                        </li>
                        <li>
                            <a href="mailto:info@speedlane.ph" class="footer-link d-flex align-items-center gap-2">
                                <i class="bi bi-envelope-fill text-speed-pink fs-6"></i>
                                <span>info@speedlane.ph</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="border-secondary opacity-25">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small text-secondary pt-2">
                <p class="mb-2 mb-md-0">&copy; {{ date('Y') }} SpeedLane AutoSpa General Santos. All rights reserved.</p>
                <div class="d-flex gap-3">
                    <a href="#" class="footer-link fs-5"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="footer-link fs-5"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="footer-link fs-5"><i class="bi bi-messenger"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS Link -->
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>