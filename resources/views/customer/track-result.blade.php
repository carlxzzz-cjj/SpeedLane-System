<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedLane - Service Status</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    
    <!-- Custom External CSS -->
    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
</head>
<body class="bg-light min-vh-100 d-flex flex-column justify-content-between">

    <!-- Top Navigation Bar -->
    <header class="navbar navbar-light bg-white border-bottom px-4 py-3 shadow-sm">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            
            <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center gap-2 text-dark">
                <i class="bi bi-arrow-left fs-5"></i>
                <span class="fw-bold text-primary fs-4">SpeedLane</span>
            </a>

            <div>
                @if(isset($transactions) && $transactions->count() > 0)
                    <span class="badge bg-primary px-3 py-2 fs-6 rounded-pill">
                        Tracking Code: {{ $trackingCode }}
                    </span>
                @else
                    <span class="badge bg-secondary px-3 py-2 fs-6 rounded-pill opacity-50">
                        No Record Found
                    </span>
                @endif
            </div>

        </div>
    </header>

    <!-- Main Content -->
    <main class="container my-4" style="max-width: 1000px;">
        
        <div class="mb-4">
            <h2 class="fw-bold text-dark">Vehicle Service Progress</h2>
        </div>

        @if(isset($transactions) && $transactions->count() > 0)
            @php
                $customerInfo = $transactions->first();
                $grandTotalCost = $transactions->sum(function($item) {
                    return $item->total_cost ?? $item->cost ?? 0;
                });
                $highestStep = $transactions->max('current_step') ?? 1;
                $allCompleted = $transactions->every(fn($t) => $t->status === 'Completed');
                $contactNum = $customerInfo->contact_number ?? $customerInfo->phone_number ?? null;
            @endphp

            <!-- Customer & Order Overview -->
            <div class="row g-4 mb-4">
                
                <!-- Customer Details -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                        <div class="d-flex align-items-center gap-2 mb-3 text-primary fw-bold">
                            <i class="bi bi-person-circle fs-5"></i>
                            <span>Customer Information</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <span class="text-muted extra-small d-block">Customer Name</span>
                                <span class="fw-bold text-dark fs-6">{{ $customerInfo->customer_name ?? 'N/A' }}</span>
                            </div>
                            <div class="col-6">
                                <span class="text-muted extra-small d-block">Vehicles In Order</span>
                                <span class="fw-bold text-dark fs-6">{{ $transactions->count() }} Vehicle(s)</span>
                            </div>

                            <div class="col-6">
                                <span class="text-muted extra-small d-block">Contact Number</span>
                                @if($contactNum)
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactNum) }}" class="fw-bold text-primary text-decoration-none fs-6">
                                        <i class="bi bi-telephone me-1"></i>{{ $contactNum }}
                                    </a>
                                @else
                                    <span class="fw-bold text-dark fs-6">N/A</span>
                                @endif
                            </div>
                            <div class="col-6">
                                <span class="text-muted extra-small d-block">Date Received</span>
                                <span class="fw-bold text-dark fs-6">
                                    {{ $customerInfo->created_at ? $customerInfo->created_at->format('M d, Y') : 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                        <div class="d-flex align-items-center gap-2 mb-3 text-primary fw-bold">
                            <i class="bi bi-speedometer2 fs-5"></i>
                            <span>Order Summary</span>
                        </div>

                        <div class="mb-3 text-center">
                            @if($allCompleted)
                                <span class="btn btn-success fw-bold rounded-3 px-4 py-2 w-100 fs-6 pointer-none">
                                    <i class="bi bi-check-circle-fill me-1"></i> All Vehicles Completed
                                </span>
                            @else
                                <span class="btn btn-primary fw-bold rounded-3 px-4 py-2 w-100 fs-6 pointer-none">
                                    <i class="bi bi-clock-history me-1"></i> Service In Progress
                                </span>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between text-muted small fw-semibold mb-1">
                            <span>Highest Progress Stage</span>
                            <span class="text-primary fw-bold">Step {{ $highestStep }} of 5</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($highestStep / 5) * 100 }}%;"></div>
                        </div>

                        <div>
                            <span class="text-muted extra-small d-block">Total Estimated Cost</span>
                            <h3 class="fw-bold text-success mb-0">₱{{ number_format($grandTotalCost, 2) }}</h3>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Vehicles Loop -->
            <h5 class="fw-bold text-dark mb-3">
                <i class="bi bi-car-front-fill me-2 text-primary"></i>Vehicles Registered Under Code: {{ $trackingCode }}
            </h5>
            
            @foreach($transactions as $index => $item)
                @php $step = $item->current_step ?? 1; @endphp
                
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    
                    <!-- Vehicle Title -->
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h5 class="fw-bold text-dark mb-0">
                            Vehicle #{{ $index + 1 }}: {{ $item->vehicle_name ?? $item->vehicle_model ?? $item->vehicle_brand ?? 'Vehicle' }}
                        </h5>
                        <span class="badge bg-dark font-monospace fs-6 px-3 py-1.5">{{ $item->plate_number }}</span>
                    </div>

                    <!-- Details -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <span class="text-muted extra-small d-block">Service Type</span>
                            <span class="fw-bold text-dark small">{{ $item->service_type ?? 'General Service' }}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="text-muted extra-small d-block">Assigned Technician</span>
                            <span class="fw-bold text-dark small">{{ $item->technician ?? $item->mechanic_assigned ?? 'Unassigned' }}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="text-muted extra-small d-block">Vehicle Subtotal</span>
                            <span class="fw-bold text-success small">₱{{ number_format($item->total_cost ?? $item->cost ?? 0, 2) }}</span>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <h6 class="fw-bold text-secondary small mb-3">Service Timeline</h6>
                    <div class="timeline-container ms-2">
                        @php
                            $timezone = 'Asia/Manila';

                            $steps = [
                                [
                                    'number' => 1,
                                    'title' => 'Step 1: Vehicle Received',
                                    'timestamp' => $item->received_at ?? $item->created_at,
                                ],
                                [
                                    'number' => 2,
                                    'title' => 'Step 2: Inspection',
                                    'timestamp' => $item->inspected_at ?? ($step >= 2 ? $item->updated_at : null),
                                ],
                                [
                                    'number' => 3,
                                    'title' => 'Step 3: Repair / Coating In Progress',
                                    'timestamp' => $item->in_progress_at ?? ($step >= 3 ? $item->updated_at : null),
                                ],
                                [
                                    'number' => 4,
                                    'title' => 'Step 4: Quality Check / Ready for Pickup',
                                    'timestamp' => $item->ready_at ?? ($step >= 4 ? $item->updated_at : null),
                                ],
                                [
                                    'number' => 5,
                                    'title' => 'Step 5: Released / Completed',
                                    'timestamp' => $item->completed_at ?? ($step == 5 ? $item->updated_at : null),
                                ],
                            ];
                        @endphp

                        @foreach($steps as $s)
                            @php
                                $isDone = $step >= $s['number'];
                                $isCurrent = $step == $s['number'];
                                
                                $ts = ($isDone && $s['timestamp']) 
                                    ? \Carbon\Carbon::parse($s['timestamp'])->setTimezone($timezone)->format('M d, Y · h:i A') 
                                    : null;
                            @endphp

                            <div class="timeline-step mb-3">
                                <div class="d-flex align-items-center justify-content-between gap-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="bi {{ $isDone ? 'bi-check-circle-fill text-success' : 'bi-circle text-muted' }} fs-5"></i>
                                        <div>
                                            <span class="fw-semibold small {{ $isDone ? 'text-dark' : 'text-muted' }}">
                                                {{ $s['title'] }}
                                            </span>
                                            @if($isCurrent && $step < 5)
                                                <span class="badge bg-primary ms-2 extra-small">Current Stage</span>
                                            @elseif($step == 5 && $s['number'] == 5)
                                                <span class="badge bg-success ms-2 extra-small">Completed</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if($isDone && $ts)
                                        <span class="badge bg-light text-secondary border font-monospace fw-normal extra-small">
                                            <i class="bi bi-clock me-1"></i>{{ $ts }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- Action Navigation -->
            <div class="d-flex gap-2 mb-4">
                <a href="{{ url('/') }}" class="btn btn-outline-secondary px-4 py-2 fw-semibold rounded-3">
                    <i class="bi bi-arrow-left me-1"></i> Track Another Code
                </a>
            </div>

        @else
            <!-- Empty State -->
            <div class="card border-0 shadow-sm rounded-4 p-5 bg-white text-center mb-4">
                <div class="py-4">
                    <div class="bg-light text-muted d-inline-flex p-3 rounded-circle mb-3">
                        <i class="bi bi-search fs-1 text-secondary"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">No Service Record Found</h5>
                    <p class="text-muted small mx-auto mb-4" style="max-width: 450px;">
                        No active vehicles were found matching that tracking code or plate number.
                    </p>
                    <a href="{{ url('/') }}" class="btn btn-primary px-4 py-2 rounded-3 fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i> Return to Search
                    </a>
                </div>
            </div>
        @endif

        <!-- Support Card with Clickable Contacts -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h6 class="fw-bold text-dark mb-1">Need Immediate Assistance?</h6>
            <p class="text-muted small mb-3">Reach out to our customer support team for live updates regarding your vehicle's status.</p>

            <div class="row g-3">
                <!-- Phone Link -->
                <div class="col-md-6">
                    <a href="tel:+639171234567" class="text-decoration-none">
                        <div class="bg-light rounded-3 p-3 d-flex align-items-center gap-3 border border-transparent hover-shadow">
                            <i class="bi bi-telephone-fill text-primary fs-5"></i>
                            <div>
                                <span class="extra-small text-muted d-block">Phone Support</span>
                                <span class="fw-bold text-dark small">+63 917 123 4567</span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Email Link (Opens Gmail directly on web, or native mail app on mobile) -->
                <div class="col-md-6">
                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=support@speedlane.com" target="_blank" class="text-decoration-none">
                        <div class="bg-light rounded-3 p-3 d-flex align-items-center gap-3 border border-transparent hover-shadow">
                            <i class="bi bi-envelope-fill text-primary fs-5"></i>
                            <div>
                                <span class="extra-small text-muted d-block">Email Support</span>
                                <span class="fw-bold text-dark small">support@speedlane.com</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </main>

    <footer class="text-center py-3 text-muted extra-small">
        &copy; {{ date('Y') }} SpeedLane Service Center. All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>