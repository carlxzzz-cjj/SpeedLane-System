<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt - {{ $service->tracking_code }}</title>
    <style>
        @page {
            margin: 10px;
        }
        body { 
            font-family: 'DejaVu Sans', sans-serif; 
            font-size: 8.5px; 
            color: #0f172a; 
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            line-height: 1.3;
        }

        /* Compact Receipt Slip Card */
        .receipt-card {
            max-width: 460px;
            margin: 0 auto;
            border: 1px solid #cbd5e1;
            border-top: 6px solid #0f172a;
            border-radius: 4px;
            padding: 14px 16px;
            background-color: #ffffff;
        }

        /* Header Layout */
        .header-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 2px solid #0f172a;
        }

        .brand-title { 
            font-size: 15px; 
            font-weight: 900; 
            color: #0f172a; 
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 1px;
        }

        .brand-subtitle { 
            font-size: 7.5px; 
            color: #64748b; 
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .badge-paid {
            display: inline-block;
            background-color: #15803d;
            color: #ffffff;
            font-size: 8px;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 2px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }

        .tracking-text {
            font-size: 8px;
            color: #64748b;
        }

        .tracking-code {
            font-family: 'DejaVu Sans Mono', monospace;
            font-weight: bold;
            color: #0f172a;
            background-color: #f1f5f9;
            padding: 1px 4px;
            border-radius: 2px;
            border: 1px solid #e2e8f0;
        }

        /* Customer & Mechanic Info Block */
        .info-block-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 3px;
            margin-bottom: 8px;
        }

        .info-block-table td {
            padding: 6px 8px;
            vertical-align: top;
        }

        .block-label {
            font-size: 7px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 2px;
            display: block;
        }

        .block-value {
            font-size: 9.5px;
            font-weight: 800;
            color: #0f172a;
        }

        .block-subvalue {
            font-size: 8px;
            color: #475569;
            font-family: 'DejaVu Sans Mono', monospace;
        }

        /* Vehicle Details Card */
        .vehicle-card {
            border: 1px solid #0f172a;
            border-radius: 3px;
            background-color: #f8fafc;
            padding: 6px 8px;
            margin-bottom: 8px;
        }

        .vehicle-title {
            font-size: 7.5px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #0f172a;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 3px;
            margin-bottom: 5px;
        }

        .vehicle-table {
            width: 100%;
            border-collapse: collapse;
        }

        .vehicle-table td {
            width: 25%;
            vertical-align: top;
            padding: 1px 0;
        }

        .veh-label {
            font-size: 6.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: #64748b;
            margin-bottom: 1px;
            display: block;
        }

        .veh-value {
            font-size: 8.5px;
            font-weight: 800;
            color: #0f172a;
        }

        /* Dates Info Row */
        .dates-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f1f5f9;
            border-radius: 3px;
            margin-bottom: 8px;
        }

        .dates-table td {
            padding: 5px 8px;
            font-size: 7.5px;
            color: #334155;
        }

        /* Price Adjustment Note Box */
        .note-card {
            border: 1px solid #e2e8f0;
            border-radius: 3px;
            background-color: #f8fafc;
            padding: 6px 8px;
            margin-bottom: 8px;
        }

        .note-label {
            font-size: 7px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 2px;
            display: block;
        }

        .note-value {
            font-size: 8px;
            font-weight: 600;
            color: #0f172a;
        }

        /* Services Table */
        .services-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 8px; 
        }

        .services-table th { 
            background-color: #0f172a; 
            color: #ffffff; 
            padding: 5px 6px; 
            font-size: 7.5px; 
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #0f172a;
            text-align: left;
        }

        .services-table td { 
            border: 1px solid #cbd5e1; 
            padding: 5px 6px; 
            font-size: 8.5px; 
            color: #0f172a;
        }

        .services-table tfoot td {
            background-color: #f8fafc;
            border: 1px solid #0f172a;
            padding: 6px 8px;
        }

        /* Utilities & Typography */
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .font-mono { font-family: 'DejaVu Sans Mono', monospace; }
        .fw-bold { font-weight: bold; }
        .text-muted { color: #64748b; }
        .text-primary { color: #0f172a; }
        .text-success { color: #15803d; }

        /* Footer Note */
        .footer-note { 
            margin-top: 10px; 
            text-align: center; 
            font-size: 7.5px; 
            color: #64748b; 
            border-top: 1px dashed #94a3b8; 
            padding-top: 6px; 
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
                    <div class="brand-title">SpeedLane</div>
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
                <td width="50%" style="border-right: 1px solid #cbd5e1;">
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
                    <td>
                        <span class="veh-label">Brand & Model</span>
                        <div class="veh-value">{{ $vehicleBrand }} {{ $vehicleModel }}</div>
                    </td>
                    <td>
                        <span class="veh-label">Vehicle Type</span>
                        <div class="veh-value">{{ $vehicleType }}</div>
                    </td>
                    <td>
                        <span class="veh-label">Plate Number</span>
                        <div class="veh-value font-mono">{{ $plateNumber }}</div>
                    </td>
                    <td>
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
                    <th width="30px" class="text-center">#</th>
                    <th>Completed Service Description</th>
                    <th width="100px" class="text-end">Status</th>
                </tr>
            </thead>
            <tbody>
                @if(count($serviceNames) > 0)
                    @foreach($serviceNames as $idx => $sName)
                        <tr>
                            <td class="text-center">{{ $idx + 1 }}</td>
                            <td class="fw-bold">{{ $sName }}</td>
                            <td class="text-end fw-bold text-success">Completed</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center">1</td>
                        <td class="fw-bold">General Detailing & Care Service</td>
                        <td class="text-end fw-bold text-success">Completed</td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-end fw-bold" style="font-size: 9px; text-transform: uppercase; letter-spacing: 0.3px;">Total Cost Paid:</td>
                    <td class="text-end fw-bold font-mono" style="font-size: 11px; color: #0f172a;">
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