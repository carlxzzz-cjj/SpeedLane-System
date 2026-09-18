<!-- FILE: resources/views/admin/register.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedLane - Register Admin</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- External Admin CSS File Link -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="bg-light">

    <!-- Top Navigation -->
    <div class="container-fluid py-3 px-4 bg-white shadow-sm mb-4">
        <!-- FIXED LINE 21 -->
        <a href="{{ route('admin.login') }}" class="text-dark text-decoration-none fs-5 me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h4 class="text-brand d-inline fw-bold mb-0">SpeedLane</h4>
    </div>

    <!-- Main Registration Container -->
    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 text-center">
                
                <!-- Shield Icon Badge -->
                <div class="icon-circle mb-3 shadow-sm mx-auto bg-primary text-white d-flex align-items-center justify-content-center rounded-circle" style="width: 60px; height: 60px;">
                    <i class="bi bi-shield-check fs-2"></i>
                </div>
                
                <!-- Screen Headings -->
                <h2 class="fw-bold mb-1">Register New Admin Account</h2>
                <p class="text-muted mb-4 small">Create an authorized account for SpeedLane personnel</p>

                <!-- Form Card -->
                <div class="card border-0 shadow-sm rounded-4 text-start p-4">
                    <h6 class="fw-bold mb-1">Account Registration</h6>
                    <p class="text-muted small mb-4">Only authorized SpeedLane personnel are allowed to create an account</p>
                    
                    <form action="{{ route('admin.register.store') }}" method="POST">
                        @csrf
                        
                        <!-- 1. Full Name Field -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="Enter full name" 
                                       value="{{ old('name') }}" 
                                       required>
                            </div>
                            @error('name')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- 2. Email Address Field -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email" 
                                       name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       placeholder="yourname@speedlane.com" 
                                       value="{{ old('email') }}" 
                                       required>
                            </div>
                            @error('email')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- 3. Contact Number Field -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Contact Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-telephone text-muted"></i></span>
                                <input type="text" 
                                       name="contact_number" 
                                       class="form-control @error('contact_number') is-invalid @enderror" 
                                       placeholder="+63 912 345 6789" 
                                       value="{{ old('contact_number') }}" 
                                       required>
                            </div>
                            @error('contact_number')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- 4. Username Field -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Username <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person-badge text-muted"></i></span>
                                <input type="text" 
                                       name="username" 
                                       class="form-control @error('username') is-invalid @enderror" 
                                       placeholder="Choose a username" 
                                       value="{{ old('username') }}" 
                                       required>
                            </div>
                            @error('username')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- 5. Password Field -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password" 
                                       name="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="Create a strong password" 
                                       required>
                            </div>
                            @error('password')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- 6. Confirm Password Field -->
                        <div class="mb-4">
                            <label class="form-label small fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-lock-fill text-muted"></i></span>
                                <input type="password" 
                                       name="password_confirmation" 
                                       class="form-control" 
                                       placeholder="Re-enter your password" 
                                       required>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <!-- FIXED LINE 89 -->
                            <a href="{{ route('admin.login') }}" class="btn btn-outline-secondary w-50 py-2 fw-semibold rounded-3">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary w-50 py-2 fw-semibold rounded-3">
                                Create Account
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>