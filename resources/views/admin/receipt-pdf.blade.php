<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt - {{ $service->tracking_code }}</title>
    <style>
        body { font-family: sans-serif; font-size: 13px; color: #333; margin: 20px; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #0d6efd; padding-bottom: 10px; }
        .header h1 { color: #0d6efd; margin: 0; font-size: 24px; }
        .info-table, .services-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 6px 4px; vertical-align: top; }
        .services-table th, .services-table td { border: 1px solid #dee2e6; padding: 8px; text-align: left; }
        .services-table th { background-color: #f8f9fa; }
        .text-right { text-align: right; }
        .text-muted { color: #6c757d; }
        .total-box { font-size: 16px; font-weight: bold; color: #198754; text-align: right; margin-top: 15px; border-top: 2px solid #dee2e6; padding-top: 10px; }
    </style>
</head>
<body>

    @php
        // Dynamic Contact Phone Resolution
        $contactPhone = $service->contact_number 
            ?? $service->phone_number 
            ?? $service->customer_phone 
            ?? $service->phone 
            ?? $service->contact 
            ?? 'N/A';

        // Dynamic Vehicle Resolution (Brand/Model/Type/Year)
        $vehiclesList = $service->vehicles ?? collect();

        $formatVeh = function($v) {
            $brand = $v->vehicle_brand ?? $v->brand ?? $v->vehicle_make ?? '';
            $model = $v->vehicle_model ?? $v->model ?? '';
            $brandModel = trim($brand . ' ' . $model);

            $type = $v->vehicle_type ?? $v->type ?? '';
            $year = $v->vehicle_year ?? $v->year ?? '';

            $parts = array_filter([$brandModel, $type, $year]);
            return count($parts) > 0 ? implode(' ', $parts) : 'N/A';
        };

        if ($vehiclesList->count() > 0) {
            $vehicleSummary = $formatVeh($vehiclesList->first());
            if ($vehiclesList->count() > 1) {
                $vehicleSummary .= ' (+ ' . ($vehiclesList->count() - 1) . ' more)';
            }
        } else {
            $vehicleSummary = $formatVeh($service);
        }

        $mechanics = $vehiclesList->count() > 0 
            ? $vehiclesList->pluck('mechanic_assigned')->filter()->unique()->implode(', ')
            : ($service->mechanic_assigned ?? 'Unassigned');

        $plates = $vehiclesList->count() > 0 
            ? $vehiclesList->pluck('plate_number')->filter()->implode(', ')
            : ($service->plate_number ?? 'N/A');

        // Dynamic service parsing
        $servicesArr = is_array($service->selected_services) 
            ? $service->selected_services 
            : json_decode($service->selected_services ?? '[]', true);

        if (!is_array($servicesArr)) {
            $servicesArr = array_filter(explode(', ', (string)$service->selected_services));
        }

        $pricesMap = is_array($service->selected_services_prices) 
            ? $service->selected_services_prices 
            : json_decode($service->selected_services_prices ?? '[]', true);

        if (!is_array($pricesMap)) { $pricesMap = []; }

        // Date Parsing Helpers
        $dateReg = $service->created_at 
            ? \Carbon\Carbon::parse($service->created_at)->format('M d, Y') 
            : 'N/A';

        $dateComp = ($service->updated_at ?? $service->created_at) 
            ? \Carbon\Carbon::parse($service->updated_at ?? $service->created_at)->format('M d, Y') 
            : 'N/A';
    @endphp

    <div class="header">
        <h1>SpeedLane Auto Services</h1>
        <p style="margin: 3px 0;">Official Repair & Maintenance Receipt</p>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>Tracking Code:</strong> <span style="font-family: monospace;">{{ $service->tracking_code }}</span></td>
            <td class="text-right"><strong>Date Registered:</strong> {{ $dateReg }}</td>
        </tr>
        <tr>
            <td><strong>Customer Name:</strong> {{ $service->customer_name }}</td>
            <td class="text-right"><strong>Date Completed:</strong> {{ $dateComp }}</td>
        </tr>
        <tr>
            <td><strong>Contact Number:</strong> {{ $contactPhone }}</td>
            <td class="text-right"><strong>Plate Number:</strong> {{ $plates ?: 'N/A' }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Vehicle (Brand/Model/Type/Year):</strong> ({{ $vehicleSummary }})</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Assigned Technician:</strong> {{ $mechanics ?: 'Unassigned' }}</td>
        </tr>
    </table>

    <table class="services-table">
        <thead>
            <tr>
                <th>Service Name</th>
                <th class="text-right" style="width: 140px;">Price</th>
            </tr>
        </thead>
        <tbody>
            @forelse($servicesArr as $idx => $srv)
                @php
                    $srvName = is_array($srv) ? ($srv['name'] ?? $srv['service_name'] ?? '') : (string)$srv;
                    $srvTrim = trim($srvName);

                    $itemPrice = $pricesMap[$srvTrim] 
                        ?? $pricesMap[$srvName] 
                        ?? $pricesMap[$idx] 
                        ?? 0;
                @endphp
                <tr>
                    <td>{{ $srvName }}</td>
                    <td class="text-right" style="font-family: monospace;">PHP {{ number_format((float)$itemPrice, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" style="text-align: center;" class="text-muted">No individual services listed.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total-box">
        Grand Total Paid: PHP {{ number_format((float)($service->total_cost ?? 0), 2) }}
    </div>

</body>
</html>