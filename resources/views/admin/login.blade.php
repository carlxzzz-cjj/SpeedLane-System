<!-- FILE: resources/views/admin/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

                    {{-- 
                        ===================================================================
                        1. SESSION SUCCESS ALERT (e.g., after registering or logging out)
                        ===================================================================
                    --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show text-start mb-3 shadow-sm" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- 
                        ===================================================================
                        2. GENERAL ERROR ALERT (e.g., flashed session errors)
                        ===================================================================
                    --}}
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show text-start mb-3 shadow-sm" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- 
                        FORM ACTION:
                        Submits data to the AuthController@login method.
                    --}}
                    <form action="{{ route('admin.login.submit') }}" method="POST">
                        @csrf
                        
                        <!-- Username Field -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" 
                                       name="username" 
                                       class="form-control @error('username') is-invalid @enderror" 
                                       placeholder="Enter username" 
                                       value="{{ old('username') }}" 
                                       required>
                            </div>

                            {{-- Field-level error message for incorrect username/credentials --}}
                            @error('username')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="mb-4">
                            <label class="form-label small fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password" 
                                       name="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="Enter password" 
                                       required>
                            </div>

                            {{-- Field-level error message for password failure --}}
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

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>