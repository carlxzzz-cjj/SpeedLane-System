<!-- ========================================================================= -->
<!-- FILE LOCATION: resources/views/track-result.blade.php                      -->
<!-- ========================================================================= -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedLane - Service Status</title>

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
    
    <!-- Custom External CSS -->
    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
    <!-- Light Mode Toggle CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme-toggle.css') }}">
    
    <style>
        :root {
            --speed-pink: #f42582;
            --speed-blue: #00a2ff;
            --speed-dark-bg: #07090e;
            --speed-card-bg: #0e111a;
            --speed-card-border: rgba(255, 255, 255, 0.08);
        }

        body {
            background-color: var(--speed-dark-bg) !important;
            color: #e2e8f0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            background: radial-gradient(circle at 50% 0%, #121624 0%, #07090e 75%) !important;
            background-attachment: fixed;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Color Utility Classes */
        .text-speed-pink { color: var(--speed-pink) !important; }
        .text-speed-blue { color: #38bdf8 !important; } /* High-contrast bright blue for perfect dark mode text readability */
        .bg-speed-pink { background-color: var(--speed-pink) !important; }
        .bg-speed-blue { background-color: var(--speed-blue) !important; }

        /* High-Contrast Success/Green for Dark Mode Readability */
        .text-success { color: #4ade80 !important; }

        /* Soft High-Contrast Status Badges matching register-service.blade.php */
        .badge-status-completed {
            background-color: rgba(34, 197, 94, 0.18) !important;
            color: #4ade80 !important;
            border: 1px solid rgba(34, 197, 94, 0.4) !important;
            font-weight: 600;
        }

        .badge-status-blue {
            background-color: rgba(0, 162, 255, 0.18) !important;
            color: #99dbff !important;
            border: 1px solid rgba(0, 162, 255, 0.4) !important;
            font-weight: 600;
        }

        .badge-estimate {
            background-color: rgba(245, 158, 11, 0.18) !important;
            color: #fbbf24 !important;
            border: 1px solid rgba(245, 158, 11, 0.4) !important;
            font-weight: 600;
        }

        .extra-small {
            font-size: 0.75rem;
        }
        .pointer-none {
            pointer-events: none;
        }

        /* Top Navigation Header */
        .navbar-speed {
            background: rgba(7, 9, 14, 0.95);
            border-bottom: 1px solid var(--speed-card-border);
            backdrop-filter: blur(10px);
        }

        .brand-logo-text {
            font-size: 1.35rem;
            font-weight: 900;
            letter-spacing: 0.8px;
            font-style: italic;
            line-height: 1;
        }

        /* Speed Card Theme */
        .speed-card {
            background-color: var(--speed-card-bg) !important;
            border: 1px solid var(--speed-card-border) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        /* Easy-on-the-eyes Soft Action Buttons */
        .btn-status-completed {
            background-color: rgba(34, 197, 94, 0.18) !important;
            color: #4ade80 !important;
            border: 1px solid rgba(34, 197, 94, 0.4) !important;
        }

        .btn-status-progress {
            background-color: rgba(0, 162, 255, 0.18) !important;
            color: #99dbff !important;
            border: 1px solid rgba(0, 162, 255, 0.4) !important;
        }

        .btn-action-dark {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #e2e8f0 !important;
            transition: all 0.25s ease;
        }

        .btn-action-dark:hover {
            background-color: rgba(255, 255, 255, 0.12);
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.3);
        }

        .btn-action-primary {
            background: linear-gradient(90deg, var(--speed-pink) 0%, var(--speed-blue) 100%);
            border: none;
            color: #ffffff !important;
            font-weight: 600;
            transition: all 0.25s ease;
            box-shadow: 0 4px 15px rgba(244, 37, 130, 0.3);
        }

        .btn-action-primary:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }

        .hover-shadow {
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }
        .hover-shadow:hover {
            background-color: rgba(15, 19, 34, 0.8) !important;
            border-color: rgba(0, 162, 255, 0.4) !important;
        }

        /* Timeline Container */
        .timeline-container {
            position: relative;
            padding-left: 0.5rem;
        }
        .timeline-step {
            position: relative;
        }
        .timeline-step:not(:last-child)::before {
            content: '';
            position: absolute;
            left: 9px;
            top: 24px;
            bottom: -12px;
            width: 2px;
            background-color: rgba(255, 255, 255, 0.12);
            z-index: 0;
        }

        /* Dark Theme Toggle Button */
        #theme-toggle-btn {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.25s ease;
        }

        #theme-toggle-btn:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }

        /* LIGHT MODE HIGH-CONTRAST OVERRIDES */
        html.light-theme {
            --speed-dark-bg: #f8fafc;
            --speed-card-bg: #ffffff;
            --speed-card-border: rgba(0, 0, 0, 0.08);
        }

        html.light-theme body {
            background: #f8fafc !important;
            color: #1e293b !important;
        }

        html.light-theme .navbar-speed {
            background: rgba(255, 255, 255, 0.95) !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        html.light-theme #theme-toggle-btn {
            background-color: #e2e8f0 !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
        }

        html.light-theme #theme-toggle-btn:hover {
            background-color: #cbd5e1 !important;
        }

        html.light-theme .speed-card {
            background-color: #ffffff !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04) !important;
        }

        html.light-theme .text-white {
            color: #0f172a !important;
        }

        html.light-theme .text-secondary {
            color: #64748b !important;
        }

        html.light-theme .text-speed-blue {
            color: #0284c7 !important;
        }

        html.light-theme .text-speed-pink {
            color: #db2777 !important;
        }

        html.light-theme .text-success {
            color: #16a34a !important;
        }

        /* Light Mode Badges & Buttons */
        html.light-theme .badge-status-completed,
        html.light-theme .btn-status-completed {
            background-color: #dcfce7 !important;
            color: #15803d !important;
            border: 1px solid #86efac !important;
        }

        html.light-theme .badge-status-blue,
        html.light-theme .btn-status-progress {
            background-color: #e0f2fe !important;
            color: #0369a1 !important;
            border: 1px solid #38bdf8 !important;
        }

        html.light-theme .tracking-code-badge {
            background-color: #e0f2fe !important;
            color: #0369a1 !important;
            border-color: #7dd3fc !important;
        }

        html.light-theme .tracking-code-none {
            background-color: #f1f5f9 !important;
            color: #64748b !important;
            border-color: #cbd5e1 !important;
        }

        html.light-theme .btn-action-dark {
            background-color: #e2e8f0 !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
        }

        html.light-theme .btn-action-dark:hover {
            background-color: #cbd5e1 !important;
            color: #000000 !important;
        }

        /* Inner Boxes & Cards in Light Mode */
        html.light-theme .inner-dark-box {
            background-color: #f8fafc !important;
            border-color: rgba(0, 0, 0, 0.1) !important;
        }

        html.light-theme .hover-shadow {
            background-color: #f8fafc !important;
            border-color: rgba(0, 0, 0, 0.08) !important;
        }

        html.light-theme .hover-shadow:hover {
            background-color: #f1f5f9 !important;
            border-color: rgba(0, 162, 255, 0.4) !important;
        }

        /* Timeline in Light Mode */
        html.light-theme .timeline-step:not(:last-child)::before {
            background-color: rgba(0, 0, 0, 0.12) !important;
        }

        html.light-theme .timeline-step i {
            background-color: #ffffff !important;
        }

        /* Technician Progress Note in Light Mode */
        html.light-theme .tech-note-box {
            background-color: #e0f2fe !important;
            border-color: #7dd3fc !important;
        }

        html.light-theme .tech-note-box p {
            color: #0f172a !important;
        }

        /* Empty State Icon Wrapper */
        html.light-theme .empty-state-icon-wrapper {
            background-color: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
        }

        html.light-theme .empty-state-icon-wrapper i {
            color: #64748b !important;
        }

        /* Estimate Badge in Light Mode */
        html.light-theme .badge-estimate {
            background-color: #fef3c7 !important;
            color: #b45309 !important;
            border-color: #fcd34d !important;
        }
    </style>
</head>
<body class="min-vh-100 d-flex flex-column justify-content-between">

    <!-- Top Navigation Bar -->
    <header class="navbar navbar-dark navbar-speed px-4 py-3 sticky-top shadow-sm">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            
            <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center gap-2 text-white">
                <i class="bi bi-arrow-left fs-5 text-speed-pink"></i>
                <span class="brand-logo-text">
                    <span class="text-speed-pink">SPEED</span><span class="text-speed-blue">LANE</span>
                </span>
            </a>

            <div class="d-flex align-items-center gap-3">
                @if(isset($transactions) && $transactions->count() > 0)
                    <span class="badge bg-black bg-opacity-50 text-speed-blue font-monospace border border-secondary border-opacity-25 px-3 py-2 fs-6 rounded-pill tracking-code-badge">
                        Tracking Code: {{ $trackingCode }}
                    </span>
                @else
                    <span class="badge bg-secondary bg-opacity-25 text-secondary border border-secondary border-opacity-25 px-3 py-2 fs-6 rounded-pill tracking-code-none">
                        No Record Found
                    </span>
                @endif

                <!-- Light / Dark Mode Toggle Button -->
                <button id="theme-toggle-btn" type="button" class="btn d-flex align-items-center justify-content-center rounded-circle p-2" style="width: 40px; height: 40px;" title="Toggle Light/Dark Mode" aria-label="Toggle Light/Dark Mode" onclick="toggleSpeedLaneTheme()">
                    <i id="theme-toggle-icon" class="bi bi-sun-fill text-warning"></i>
                </button>
            </div>

        </div>
    </header>

    <!-- Main Content -->
    <main class="container my-4" style="max-width: 1000px;">
        
        <div class="mb-4">
            <h2 class="fw-bold text-white">Vehicle Service Progress</h2>
        </div>

        @if(isset($transactions) && $transactions->count() > 0)
            @php
                $customerInfo = $transactions->first();
                $grandTotalCost = $transactions->sum(function($item) {
                    return $item->total_cost ?? $item->cost ?? 0;
                });
                
                $parseProp = function($prop) {
                    if (is_string($prop)) {
                        $decoded = json_decode($prop, true);
                        return is_array($decoded) ? $decoded : [];
                    }
                    return is_array($prop) ? $prop : [];
                };

                // Check if all items across all vehicles are completed
                $allCompleted = $transactions->every(function($t) use ($parseProp) {
                    $rawServices = $parseProp($t->selected_services ?? $t->services ?? []);
                    if (empty($rawServices)) {
                        return str_contains(strtolower($t->status ?? ''), 'completed');
                    }
                    foreach ($rawServices as $srv) {
                        $status = is_array($srv) ? ($srv['status'] ?? '') : '';
                        if (!str_contains(strtolower($status), 'completed')) {
                            return false;
                        }
                    }
                    return true;
                });

                $contactNum = $customerInfo->contact_number ?? $customerInfo->phone_number ?? null;
            @endphp

            <!-- Customer & Order Overview -->
            <div class="row g-4 mb-4">
                
                <!-- Customer Details -->
                <div class="col-lg-7">
                    <div class="card speed-card border-0 shadow-sm rounded-4 p-4 h-100">
                        <div class="d-flex align-items-center gap-2 mb-3 text-speed-pink fw-bold">
                            <i class="bi bi-person-circle fs-5"></i>
                            <span>Customer Information</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <span class="text-secondary extra-small d-block">Customer Name</span>
                                <span class="fw-bold text-white fs-6">{{ $customerInfo->customer_name ?? 'N/A' }}</span>
                            </div>
                            <div class="col-6">
                                <span class="text-secondary extra-small d-block">Vehicles In Order</span>
                                <span class="fw-bold text-white fs-6">{{ $transactions->count() }} Vehicle(s)</span>
                            </div>

                            <div class="col-6">
                                <span class="text-secondary extra-small d-block">Contact Number</span>
                                @if($contactNum)
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactNum) }}" class="fw-bold text-speed-blue text-decoration-none fs-6">
                                        <i class="bi bi-telephone me-1"></i>{{ $contactNum }}
                                    </a>
                                @else
                                    <span class="fw-bold text-white fs-6">N/A</span>
                                @endif
                            </div>
                            <div class="col-6">
                                <span class="text-secondary extra-small d-block">Date Received</span>
                                <span class="fw-bold text-white fs-6">
                                    {{ $customerInfo->created_at ? \Carbon\Carbon::parse($customerInfo->created_at)->format('M d, Y • h:i A') : 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-5">
                    <div class="card speed-card border-0 shadow-sm rounded-4 p-4 h-100">
                        <div class="d-flex align-items-center gap-2 mb-3 text-speed-blue fw-bold">
                            <i class="bi bi-speedometer2 fs-5"></i>
                            <span>Order Summary</span>
                        </div>

                        <div class="mb-3 text-center">
                            @if($allCompleted)
                                <span class="btn btn-status-completed fw-bold rounded-3 px-4 py-2 w-100 fs-6 pointer-none shadow-sm">
                                    <i class="bi bi-check-circle-fill me-1"></i> All Vehicles Completed
                                </span>
                            @else
                                <span class="btn btn-status-progress fw-bold rounded-3 px-4 py-2 w-100 fs-6 pointer-none shadow-sm">
                                    <i class="bi bi-clock-history me-1"></i> Service In Progress
                                </span>
                            @endif
                        </div>

                        <!-- Dynamic Cost Label & Badge Switch -->
                        <div class="p-3 rounded-3 border border-secondary border-opacity-25 inner-dark-box" style="background-color: #06080d;">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-secondary extra-small font-monospace text-uppercase fw-semibold">
                                    {{ $allCompleted ? 'Final Total Cost' : 'Total Estimated Cost' }}
                                </span>
                                @if($allCompleted)
                                    <span class="badge badge-status-completed extra-small">
                                        <i class="bi bi-patch-check-fill me-1"></i>Final Bill
                                    </span>
                                @else
                                    <span class="badge badge-estimate extra-small">
                                        <i class="bi bi-hourglass-split me-1"></i>Estimate
                                    </span>
                                @endif
                            </div>
                            <h3 class="fw-bold {{ $allCompleted ? 'text-success' : 'text-speed-pink' }} mb-0 font-monospace">
                                ₱{{ number_format($grandTotalCost, 2) }}
                            </h3>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Vehicles Loop -->
            <h5 class="fw-bold text-white mb-3">
                <i class="bi bi-car-front-fill me-2 text-speed-blue"></i>Vehicles Registered Under Code: {{ $trackingCode }}
            </h5>
            
            @foreach($transactions as $index => $item)
                @php
                    $rawSelectedServices = $parseProp($item->selected_services ?? $item->services ?? []);
                    
                    $serviceItems = [];
                    foreach ($rawSelectedServices as $srv) {
                        if (is_array($srv)) {
                            $serviceItems[] = [
                                'name'   => $srv['name'] ?? $srv['service_name'] ?? 'Service',
                                'status' => $srv['status'] ?? 'Pending Queue',
                                'note'   => $srv['note'] ?? $srv['status_note'] ?? '',
                                'updated_at' => $srv['updated_at'] ?? null,
                                'stage_timestamps' => $srv['stage_timestamps'] ?? []
                            ];
                        } else {
                            $serviceItems[] = [
                                'name'   => (string)$srv,
                                'status' => 'Pending Queue',
                                'note'   => '',
                                'updated_at' => null,
                                'stage_timestamps' => []
                            ];
                        }
                    }

                    // Fallback if empty array
                    if (empty($serviceItems)) {
                        $serviceItems[] = [
                            'name'   => $item->service_type ?? 'General Service',
                            'status' => $item->status ?? 'Pending Queue',
                            'note'   => $item->note ?? '',
                            'updated_at' => null,
                            'stage_timestamps' => []
                        ];
                    }

                    $isVehicleCompleted = array_reduce($serviceItems, function($carry, $s) {
                        return $carry && str_contains(strtolower($s['status']), 'completed');
                    }, true);
                @endphp
                
                <div class="card speed-card border-0 shadow-sm rounded-4 p-4 mb-4">
                    
                    <!-- Vehicle Title -->
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom border-secondary border-opacity-25">
                        <h5 class="fw-bold text-white mb-0">
                            Vehicle #{{ $index + 1 }}: {{ $item->vehicle_name ?? $item->vehicle_model ?? $item->vehicle_brand ?? 'Vehicle' }}
                        </h5>
                        <span class="badge bg-black bg-opacity-50 text-speed-blue font-monospace fs-6 px-3 py-1.5 border border-secondary border-opacity-25 tracking-code-badge">{{ $item->plate_number }}</span>
                    </div>

                    <!-- Details -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <span class="text-secondary extra-small d-block">Service Type</span>
                            <span class="fw-bold text-white small">{{ $item->service_type ?? 'General Service' }}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="text-secondary extra-small d-block">Assigned Technician</span>
                            <span class="fw-bold text-white small">{{ $item->technician ?? $item->mechanic_assigned ?? 'Unassigned' }}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="text-secondary extra-small d-block">
                                {{ $isVehicleCompleted ? 'Vehicle Final Cost' : 'Vehicle Estimated Subtotal' }}
                            </span>
                            <span class="fw-bold {{ $isVehicleCompleted ? 'text-success' : 'text-speed-blue' }} small font-monospace">
                                ₱{{ number_format($item->total_cost ?? $item->cost ?? 0, 2) }}
                                @if($isVehicleCompleted)
                                    <span class="badge badge-status-completed ms-1 extra-small">Final</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-25 text-secondary border border-secondary border-opacity-25 ms-1 extra-small tracking-code-none">Estimated</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Service Items Timeline -->
                    <h6 class="fw-bold text-secondary small mb-3">
                        <i class="bi bi-clock-history me-1 text-speed-blue"></i>Service Timeline & Specific Stages
                    </h6>

                    @foreach($serviceItems as $sIdx => $sItem)
                        @php
                            $sName = $sItem['name'];
                            $sStatus = $sItem['status'];
                            $sNote = trim($sItem['note']);
                            $lowerName = strtolower($sName);

                            // Stage list definitions matching admin update.blade.php exactly
                            if (str_contains($lowerName, 'coating') || str_contains($lowerName, 'ceramic') || str_contains($lowerName, 'graphene')) {
                                $stages = [
                                    'Pending Queue',
                                    'Decontamination & Wash Prep',
                                    'Paint Correction & Polishing',
                                    'Coating Layer Application',
                                    'Curing Process',
                                    'Final Inspection',
                                    'Completed & Ready for Pick Up'
                                ];
                            } elseif (str_contains($lowerName, 'detail') || str_contains($lowerName, 'interior') || str_contains($lowerName, 'exterior')) {
                                $stages = [
                                    'Pending Queue',
                                    'Exterior Wash & Clay Bar',
                                    'Interior Vacuum & Steam Clean',
                                    'Leather & Plastic Conditioning',
                                    'Exterior Machine Polish',
                                    'Final Inspection',
                                    'Completed & Ready for Pick Up'
                                ];
                            } else {
                                $stages = [
                                    'Pending Queue',
                                    'Under Inspection & Diagnostics',
                                    'Awaiting Parts / Approval',
                                    'Repair In Progress',
                                    'Quality Testing',
                                    'Completed & Ready for Pick Up'
                                ];
                            }

                            // Match current stage index
                            $currentStageIdx = array_search($sStatus, $stages);
                            if ($currentStageIdx === false) {
                                $currentStageIdx = 0;
                                foreach ($stages as $stIdx => $stName) {
                                    if (str_contains(strtolower($sStatus), strtolower(explode(' ', $stName)[0]))) {
                                        $currentStageIdx = $stIdx;
                                        break;
                                    }
                                }
                            }
                        @endphp

                        <div class="p-3 rounded-3 border border-secondary border-opacity-25 mb-3 inner-dark-box" style="background-color: rgba(6, 8, 13, 0.6);">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom border-secondary border-opacity-25">
                                <span class="fw-bold text-white">
                                    <i class="bi bi-tools text-speed-pink me-1"></i> {{ $sName }}
                                </span>
                                <span class="badge badge-status-blue px-2.5 py-1 extra-small">
                                    Current Stage: {{ $sStatus }}
                                </span>
                            </div>

                            <div class="timeline-container ms-1">
                                @foreach($stages as $stIdx => $stageName)
                                    @php
                                        $isPassed = $stIdx < $currentStageIdx;
                                        $isCurrent = $stIdx === $currentStageIdx;
                                        $isStageCompleted = $isPassed || ($isCurrent && str_contains(strtolower($stageName), 'completed'));

                                        // Determine timestamp for this stage
                                        $stageTimestamp = null;
                                        if (isset($sItem['stage_timestamps'][$stageName])) {
                                            $stageTimestamp = \Carbon\Carbon::parse($sItem['stage_timestamps'][$stageName]);
                                        } elseif ($stIdx === 0 && $item->created_at) {
                                            $stageTimestamp = \Carbon\Carbon::parse($item->created_at);
                                        } elseif (($isCurrent || $isPassed) && $item->updated_at) {
                                            $stageTimestamp = \Carbon\Carbon::parse($item->updated_at);
                                        }
                                    @endphp

                                    <div class="timeline-step mb-3">
                                        <div class="d-flex align-items-start gap-3">
                                            <!-- Step Icon -->
                                            <div style="z-index: 1;">
                                                @if($isStageCompleted)
                                                    <i class="bi bi-check-circle-fill text-success fs-5 rounded-circle" style="background-color: #0e111a;"></i>
                                                @elseif($isCurrent)
                                                    <i class="bi bi-arrow-right-circle-fill text-speed-blue fs-5 rounded-circle" style="background-color: #0e111a;"></i>
                                                @else
                                                    <i class="bi bi-circle text-secondary fs-5 rounded-circle" style="background-color: #0e111a;"></i>
                                                @endif
                                            </div>

                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div>
                                                        <span class="fw-semibold small {{ $isStageCompleted ? 'text-white' : ($isCurrent ? 'text-speed-blue fw-bold' : 'text-secondary') }}">
                                                            Step {{ $stIdx + 1 }}: {{ $stageName }}
                                                        </span>

                                                        <!-- Stage Timestamp -->
                                                        @if($stageTimestamp)
                                                            <div class="extra-small text-secondary mt-0.5 d-flex align-items-center gap-1">
                                                                <i class="bi bi-clock me-1"></i>
                                                                @if($stIdx === 0)
                                                                    <span>Received: {{ $stageTimestamp->format('M d, Y • h:i A') }}</span>
                                                                @elseif($isStageCompleted)
                                                                    <span>Done: {{ $stageTimestamp->format('M d, Y • h:i A') }}</span>
                                                                @elseif($isCurrent)
                                                                    <span>Updated: {{ $stageTimestamp->format('M d, Y • h:i A') }}</span>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div class="extra-small text-secondary opacity-50 mt-0.5 d-flex align-items-center gap-1">
                                                                <i class="bi bi-dash-circle me-1"></i>
                                                                <span>Pending stage</span>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2">
                                                        @if($isCurrent && !str_contains(strtolower($stageName), 'completed'))
                                                            <span class="badge badge-status-blue extra-small">Current Stage</span>
                                                        @elseif($isStageCompleted && str_contains(strtolower($stageName), 'completed'))
                                                            <span class="badge badge-status-completed extra-small">Completed</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Render Admin / Technician Remarks Note if entered in update.blade -->
                                                @if($isCurrent && !empty($sNote))
                                                    <div class="mt-2 p-2.5 rounded-3 border border-info border-opacity-30 text-white shadow-sm tech-note-box" style="background-color: rgba(0, 162, 255, 0.08);">
                                                        <div class="d-flex align-items-center gap-1.5 fw-bold text-speed-blue mb-1 extra-small">
                                                            <i class="bi bi-chat-left-text-fill"></i> Technician Progress Note
                                                        </div>
                                                        <p class="mb-0 text-light" style="font-size: 0.85rem; line-height: 1.45;">
                                                            "{{ $sNote }}"
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                </div>
            @endforeach

            <!-- Action Navigation -->
            <div class="d-flex gap-2 mb-4">
                <a href="{{ url('/') }}" class="btn btn-action-dark px-4 py-2 fw-semibold rounded-3">
                    <i class="bi bi-arrow-left me-1"></i> Track Another Code
                </a>
            </div>

        @else
            <!-- Empty State -->
            <div class="card speed-card border-0 shadow-sm rounded-4 p-5 text-center mb-4">
                <div class="py-4">
                    <div class="bg-black bg-opacity-40 text-secondary d-inline-flex p-3 rounded-circle mb-3 border border-secondary border-opacity-25 empty-state-icon-wrapper">
                        <i class="bi bi-search fs-1 text-secondary"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-2">No Service Record Found</h5>
                    <p class="text-secondary small mx-auto mb-4" style="max-width: 450px;">
                        No active vehicles were found matching that tracking code or plate number.
                    </p>
                    <a href="{{ url('/') }}" class="btn btn-action-primary px-4 py-2 rounded-3 fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i> Return to Search
                    </a>
                </div>
            </div>
        @endif

        <!-- Support Card with Clickable Contacts -->
        <div class="card speed-card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h6 class="fw-bold text-white mb-1">Need Immediate Assistance?</h6>
            <p class="text-secondary small mb-3">Reach out to our customer support team for live updates regarding your vehicle's status.</p>

            <div class="row g-3">
                <!-- Phone Link -->
                <div class="col-md-6">
                    <a href="tel:+639171234567" class="text-decoration-none">
                        <div class="rounded-3 p-3 d-flex align-items-center gap-3 border border-secondary border-opacity-25 hover-shadow inner-dark-box" style="background-color: rgba(6, 8, 13, 0.6);">
                            <i class="bi bi-telephone-fill text-speed-pink fs-5"></i>
                            <div>
                                <span class="extra-small text-secondary d-block">Phone Support</span>
                                <span class="fw-bold text-white small">+63 917 123 4567</span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Email Link -->
                <div class="col-md-6">
                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=support@speedlane.com" target="_blank" class="text-decoration-none">
                        <div class="rounded-3 p-3 d-flex align-items-center gap-3 border border-secondary border-opacity-25 hover-shadow inner-dark-box" style="background-color: rgba(6, 8, 13, 0.6);">
                            <i class="bi bi-envelope-fill text-speed-blue fs-5"></i>
                            <div>
                                <span class="extra-small text-secondary d-block">Email Support</span>
                                <span class="fw-bold text-white small">support@speedlane.com</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </main>

    <footer class="text-center py-3 text-secondary extra-small">
        &copy; {{ date('Y') }} SpeedLane Service Center. All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Light Mode Toggle JS -->
    <script src="{{ asset('js/theme-toggle.js') }}"></script>
   
</body>
</html>