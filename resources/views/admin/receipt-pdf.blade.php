<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt - {{ $service->tracking_code }}</title>
    <style>
        @page {
            size: letter portrait;
            margin: 12mm 15mm;
        }
        body { 
            font-family: 'DejaVu Sans', sans-serif; 
            font-size: 9.5px; 
            color: #0f172a; 
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            line-height: 1.35;
        }

        /* DomPDF Safe Container - NO width: 100% so padding doesn't overflow page */
        .receipt-card {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 16px 18px;
            background-color: #ffffff;
        }

        /* Base Table Reset for DomPDF */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        /* Header Layout */
        .header-table { 
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1.5px solid #e2e8f0;
        }

        .brand-title { 
            font-size: 18px; 
            font-weight: 900; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
            font-style: italic;
        }

        .brand-pink { color: #f42582; }
        .brand-blue { color: #00a2ff; }

        .brand-subtitle { 
            font-size: 8.5px; 
            color: #64748b; 
            font-weight: 600;
        }

        .badge-paid {
            display: inline-block;
            background-color: #15803d;
            color: #ffffff;
            font-size: 8.5px;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .tracking-text {
            font-size: 8.5px;
            color: #64748b;
        }

        .tracking-code {
            font-family: 'DejaVu Sans Mono', monospace;
            font-weight: bold;
            color: #0f172a;
            background-color: #f1f5f9;
            padding: 1px 5px;
            border-radius: 3px;
            border: 1px solid #cbd5e1;
        }

        /* Customer & Mechanic Info Block */
        .info-block-table {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .info-block-table td {
            padding: 8px 12px;
            vertical-align: top;
        }

        .block-label {
            font-size: 7.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 2px;
            display: block;
        }

        .block-value {
            font-size: 10px;
            font-weight: 800;
            color: #0f172a;
        }

        .block-subvalue {
            font-size: 8.5px;
            color: #475569;
            font-family: 'DejaVu Sans Mono', monospace;
            margin-top: 2px;
        }

        /* Vehicle Details Card */
        .vehicle-card {
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            background-color: #f8fafc;
            padding: 8px 12px;
            margin-bottom: 10px;
        }

        .vehicle-title {
            font-size: 9px;
            font-weight: 800;
            color: #0f172a;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
            margin-bottom: 6px;
        }

        .vehicle-table td {
            vertical-align: top;
            padding: 2px 0;
            word-wrap: break-word;
        }

        .veh-label {
            font-size: 7px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #64748b;
            margin-bottom: 2px;
            display: block;
        }

        .veh-value {
            font-size: 9px;
            font-weight: 800;
            color: #0f172a;
        }

        /* Dates Info Row */
        .dates-table {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .dates-table td {
            padding: 6px 12px;
            font-size: 8px;
            color: #475569;
        }

        /* Price Adjustment Note Box */
        .note-card {
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            background-color: #f8fafc;
            padding: 8px 12px;
            margin-bottom: 10px;
        }

        .note-label {
            font-size: 7.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 2px;
            display: block;
        }

        .note-value {
            font-size: 8.5px;
            font-weight: 600;
            color: #0f172a;
        }

        /* Services Table */
        .services-table { 
            margin-bottom: 10px; 
        }

        .services-table th { 
            background-color: #f8fafc; 
            color: #0f172a; 
            padding: 6px 8px; 
            font-size: 8px; 
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border: 1px solid #cbd5e1;
            text-align: left;
        }

        .services-table td { 
            border: 1px solid #cbd5e1; 
            padding: 6px 8px; 
            font-size: 9px; 
            color: #0f172a;
        }

        .services-table tfoot td {
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            padding: 8px;
        }

        /* Utilities & Typography */
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .font-mono { font-family: 'DejaVu Sans Mono', monospace; }
        .fw-bold { font-weight: bold; }
        .text-muted { color: #64748b; }

        /* Footer Note */
        .footer-note { 
            margin-top: 12px; 
            text-align: center; 
            font-size: 8px; 
            color: #64748b; 
            border-top: 1px dashed #cbd5e1; 
            padding-top: 8px; 
            letter-spacing: 0.2px;
        }
    </style>
</head>
<body>

    @php
        // Resolve Customer Name
        $customerName = $service->customer_name 
            ?? ($service->customer->name ?? null)
            ?? ($service->user->name ?? null)
            ?? $service->client_name 
            ?? $service->name 
            ?? 'N/A';

        // Resolve Contact Number
        $contactPhone = $service->contact_number 
            ?? $service->phone_number 
            ?? $service->customer_phone 
            ?? $service->phone 
            ?? ($service->customer->phone ?? 'N/A');

        // Resolve Assigned Mechanic
        $mechanicName = $service->mechanic_assigned 
            ?? ($service->technician->name ?? $service->technician->full_name ?? null)
            ?? ($service->mechanic->name ?? $service->mechanic->full_name ?? null)
            ?? $service->technician_name 
            ?? $service->mechanic_name 
            ?? 'Unassigned';

        // Resolve Vehicle Details
        $vehicleBrand = $service->vehicle_make ?? $service->vehicle_brand ?? $service->brand ?? $service->make ?? 'N/A';
        $vehicleModel = $service->vehicle_model ?? $service->model ?? 'N/A';
        $vehicleType  = $service->vehicle_type ?? $service->body_type ?? 'Sedan';
        $vehicleYear  = $service->vehicle_year ?? $service->year ?? 'N/A';
        $plateNumber  = $service->plate_number ?? $service->plate_no ?? $service->plate ?? 'N/A';

        // Resolve Price Adjustment Note
        $priceAdjustmentNote = $service->price_adjustment_note 
            ?? $service->adjustment_note 
            ?? $service->price_note 
            ?? $service->notes 
            ?? $service->price_adjustment_reason 
            ?? 'No price adjustment notes recorded for this transaction.';

        // Resolve Selected Services Array
        $servicesArr = is_array($service->selected_services) 
            ? $service->selected_services 
            : json_decode($service->selected_services ?? '[]', true);

        if (!is_array($servicesArr)) {
            $servicesArr = array_filter(explode(', ', (string)($service->selected_services ?? '')));
        }

        $serviceNames = array_map(function($item) {
            return is_array($item) ? ($item['name'] ?? $item['service_name'] ?? '') : $item;
        }, $servicesArr ?? []);
        $serviceNames = array_values(array_filter($serviceNames));
    @endphp

    <div class="receipt-card">
        <!-- Header Info Block -->
        <table class="header-table">
            <tr>
                <td width="60%" style="vertical-align: top;">
                    <div class="brand-title"><span class="brand-pink">SPEED</span><span class="brand-blue">LANE</span></div>
                    <div class="brand-subtitle">Official Transaction & Service Record Receipt</div>
                </td>
                <td width="40%" style="vertical-align: top;" class="text-end">
                    <div><span class="badge-paid">PAID</span></div>
                    <div class="tracking-text">
                        Tracking Code: <strong class="tracking-code">{{ $service->tracking_code }}</strong>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Customer & Mechanic Info Block -->
        <table class="info-block-table">
            <tr>
                <td width="50%">
                    <span class="block-label">Customer Information</span>
                    <div class="block-value">{{ $customerName }}</div>
                    <div class="block-subvalue">{{ $contactPhone }}</div>
                </td>
                <td width="50%" class="text-end">
                    <span class="block-label">Assigned Mechanic</span>
                    <div class="block-value">{{ $mechanicName }}</div>
                </td>
            </tr>
        </table>

        <!-- Vehicle Details Card -->
        <div class="vehicle-card">
            <div class="vehicle-title">Vehicle Information</div>
            <table class="vehicle-table">
                <tr>
                    <td width="30%">
                        <span class="veh-label">Brand & Model</span>
                        <div class="veh-value">{{ $vehicleBrand }} {{ $vehicleModel }}</div>
                    </td>
                    <td width="25%">
                        <span class="veh-label">Vehicle Type</span>
                        <div class="veh-value">{{ $vehicleType }}</div>
                    </td>
                    <td width="25%">
                        <span class="veh-label">Plate Number</span>
                        <div class="veh-value font-mono">{{ $plateNumber }}</div>
                    </td>
                    <td width="20%">
                        <span class="veh-label">Year</span>
                        <div class="veh-value">{{ $vehicleYear }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Dates Info Row -->
        <table class="dates-table">
            <tr>
                <td width="50%">
                    <span class="text-muted">Date Registered:</span>
                    <strong>{{ \Carbon\Carbon::parse($service->created_at)->format('M d, Y h:i A') }}</strong>
                </td>
                <td width="50%" class="text-end">
                    <span class="text-muted">Date Completed:</span>
                    <strong>{{ \Carbon\Carbon::parse($service->updated_at)->format('M d, Y h:i A') }}</strong>
                </td>
            </tr>
        </table>

        <!-- Price Adjustment Note Box -->
        <div class="note-card">
            <span class="note-label">Price Adjustment Note</span>
            <div class="note-value">{{ $priceAdjustmentNote }}</div>
        </div>

        <!-- Services Table -->
        <table class="services-table">
            <thead>
                <tr>
                    <th width="35px" class="text-center">#</th>
                    <th>Completed Service Description</th>
                    <th width="110px" class="text-end">Status</th>
                </tr>
            </thead>
            <tbody>
                @if(count($serviceNames) > 0)
                    @foreach($serviceNames as $idx => $sName)
                        <tr>
                            <td class="text-center">{{ $idx + 1 }}</td>
                            <td class="fw-bold">{{ $sName }}</td>
                            <td class="text-end fw-bold">Completed</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center">1</td>
                        <td class="fw-bold">General Detailing & Care Service</td>
                        <td class="text-end fw-bold">Completed</td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-end fw-bold" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.3px;">Total Cost Paid:</td>
                    <td class="text-end fw-bold font-mono" style="font-size: 13px; color: #0f172a;">
                        &#8369;{{ number_format((float)($service->total_cost ?? 0), 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- Footer Note -->
        <div class="footer-note">
            Thank you for choosing SpeedLane AutoSpa! Keep this receipt for warranty records.
        </div>
    </div>

</body>
</html>