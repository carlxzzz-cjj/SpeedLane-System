<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedLane - Admin Dashboard</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    
    <!-- Custom External Admin CSS Link -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="bg-light">

    <!-- TOP NAVIGATION HEADER BAR -->
<header class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 py-2 sticky-top shadow-sm">
    <div class="container-fluid">
        
        <!-- Brand Logo & App Subtitle -->
        <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('admin.dashboard') }}">
            <div class="bg-primary text-white p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="bi bi-car-front-fill fs-6"></i>
            </div>
            <div>
                <span class="fw-bold text-primary fs-5 d-block lh-1">SpeedLane</span>
                <span class="text-muted extra-small">Admin Overview</span>
            </div>
        </a>

        <!-- Right Nav Alignment -->
        <div class="d-flex align-items-center gap-3 ms-auto">
            
            {{-- ROLE BADGE --}}
            @if(auth()->check() && auth()->user()->isSuperAdmin())
                <span class="badge bg-light text-primary border border-primary px-3 py-2 rounded-pill">
                    <i class="bi bi-shield-check me-1"></i> Super Admin
                </span>
            @else
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                    <i class="bi bi-person-badge text-primary me-1"></i> Admin
                </span>
            @endif

            <!-- Logout Action Form -->
            <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm px-3 rounded-3 d-flex align-items-center gap-1">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>

        </div>

    </div>
</header>

    <!-- MAIN LAYOUT WRAPPER -->
    <div class="container-fluid">
        <div class="row">
            
            <!-- SIDEBAR NAVIGATION MENU -->
            <aside class="col-md-3 col-lg-2 bg-white border-end min-vh-100 p-3">
                <nav class="nav flex-column gap-2">
                    
                    <a class="nav-link admin-nav-link active rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>

                    <a class="nav-link admin-nav-link text-dark rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.register-service') }}">
                        <i class="bi bi-plus-circle"></i> Register Service
                    </a>

                    <a class="nav-link admin-nav-link text-dark rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.update') }}">
                        <i class="bi bi-arrow-repeat"></i> Update Service Status
                    </a>

                    <a class="nav-link admin-nav-link text-dark rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.transactions') }}">
                        <i class="bi bi-file-earmark-text"></i> Transaction Records
                    </a>

                    {{-- VISIBLE ONLY TO SUPER ADMIN --}}
                    @if(auth()->user()->isSuperAdmin())
                    <a class="nav-link admin-nav-link text-dark rounded-3 px-3 py-2 d-flex align-items-center gap-2" href="{{ route('admin.manage-services.index') }}">
                        <i class="bi bi-gear-fill text-primary"></i> Manage Services
                    </a>
                    @endif

                </nav>
            </aside>

            <!-- MAIN DASHBOARD CONTENT AREA -->
            <main class="col-md-9 col-lg-10 p-4">

                <!-- FLASH NOTIFICATIONS -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                        <strong class="d-block mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i> Registration failed:</strong>
                        <ul class="mb-0 ps-3 small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- WELCOME BANNER -->
                <div class="bg-white p-4 rounded-3 border shadow-sm mb-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div>
                            <h4 class="fw-bold text-dark mb-1">
                                Welcome back, {{ Auth::user()->name }}! 👋
                            </h4>
                            <p class="text-muted small mb-0">
                                <span class="me-3"><i class="bi bi-person-badge text-primary me-1"></i> <strong>Username:</strong> {{ Auth::user()->username }}</span>
                                <span><i class="bi bi-envelope text-primary me-1"></i> <strong>Email:</strong> {{ Auth::user()->email }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- SUMMARY METRICS CARDS -->
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="text-secondary small fw-medium">Vehicles Today</span>
                                <i class="bi bi-car-front text-primary fs-5"></i>
                            </div>
                            <h2 class="fw-bold text-dark mb-1">{{ $vehiclesToday ?? 0 }}</h2>
                            <span class="text-muted extra-small">As of {{ date('M d, Y') }}</span>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="text-secondary small fw-medium">Active Services</span>
                                <i class="bi bi-activity text-warning fs-5"></i>
                            </div>
                            <h2 class="fw-bold text-dark mb-1">{{ $activeServices ?? 0 }}</h2>
                            <span class="text-muted extra-small">Currently in progress</span>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="text-secondary small fw-medium">Completed Services</span>
                                <i class="bi bi-check-circle text-success fs-5"></i>
                            </div>
                            <h2 class="fw-bold text-dark mb-1">{{ $completedServices ?? 0 }}</h2>
                            <span class="text-muted extra-small">This month</span>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="text-secondary small fw-medium">Total Transactions</span>
                                <i class="bi bi-credit-card text-purple fs-5"></i>
                            </div>
                            <h2 class="fw-bold text-dark mb-1">{{ $totalTransactions ?? 0 }}</h2>
                            <span class="text-muted extra-small">All time</span>
                        </div>
                    </div>
                </div>

                <!-- QUICK ACTIONS PANEL -->
                <div class="card border-0 shadow-sm rounded-3 p-4">
                    <h6 class="fw-bold text-dark mb-3">Quick Actions</h6>
                    
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('admin.register-service') }}" class="quick-action-btn bg-primary text-white border-0 shadow-sm text-decoration-none">
                                <i class="bi bi-plus-circle fs-5 mb-1"></i>
                                <span>Register New Service</span>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ route('admin.update') }}" class="quick-action-btn bg-white text-dark border shadow-sm text-decoration-none">
                                <i class="bi bi-arrow-repeat fs-5 mb-1"></i>
                                <span>Update Status</span>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ route('admin.transactions') }}" class="quick-action-btn bg-white text-dark border shadow-sm text-decoration-none">
                                <i class="bi bi-file-earmark-text fs-5 mb-1"></i>
                                <span>View Transactions</span>
                            </a>
                        </div>

                        {{-- SUPER ADMIN ONLY QUICK ACTION --}}
                        @if(auth()->user()->isSuperAdmin())
                        <div class="col-md-3">
                            <a href="{{ route('admin.manage-services.index') }}" class="quick-action-btn bg-white text-dark border shadow-sm text-decoration-none">
                                <i class="bi bi-gear-fill text-primary fs-5 mb-1"></i>
                                <span>Manage Services</span>
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
            <div class="modal-content border-0 shadow rounded-4 p-2">
                <div class="modal-header border-bottom-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold text-dark" id="createStaffModalLabel">
                            <i class="bi bi-shield-check text-primary me-2"></i>Register New Staff Account
                        </h5>
                        <p class="text-muted small mb-0">Only authorized SpeedLane personnel are allowed to create an account</p>
                    </div>
                    <button type="button" class="btn-close align-self-start" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="{{ route('admin.register.store') }}" method="POST">
                    @csrf
                    <div class="modal-body py-3">
                        <div class="mb-3 text-start">
                            <label class="form-label small fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter full name" value="{{ old('name') }}" required>
                            </div>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label small fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="yourname@speedlane.com" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label small fw-semibold">Contact Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-telephone text-muted"></i></span>
                                <input type="text" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror" placeholder="+63 912 345 6789" value="{{ old('contact_number') }}" required>
                            </div>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label small fw-semibold">Username <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person-badge text-muted"></i></span>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Choose a username" value="{{ old('username') }}" required>
                            </div>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label small fw-semibold">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Create a strong password" required>
                            </div>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label small fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-lock-fill text-muted"></i></span>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter your password" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary rounded-3 fw-semibold px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-3 fw-semibold px-4">
                            <i class="bi bi-check-lg me-1"></i> Create Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>