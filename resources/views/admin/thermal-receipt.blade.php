<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thermal Receipt - {{ $service->tracking_code }}</title>
    <style>
        /* =========================================================
           GLOBAL STYLES & THERMAL PIXEL RENDER FIX
        ========================================================== */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: none !important;
            -moz-osx-font-smoothing: unset !important;
            text-rendering: geometricPrecision !important;
        }

        html, body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            font-family: 'Courier New', Courier, monospace !important;
            color: #000000;
        }

        /* SCREEN VIEW STYLES */
        .no-print-bar {
            width: 100%;
            max-width: 360px;
            margin: 15px auto 10px auto;
            display: flex;
            gap: 8px;
        }

        .no-print-bar button {
            flex: 1;
            padding: 10px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            border: 1px solid #000000;
            border-radius: 6px;
        }

        .btn-print { background-color: #0d6efd; color: #ffffff; border-color: #0d6efd !important; }
        .btn-close { background-color: #ffffff; color: #333333; }

        .receipt-wrapper {
            width: 100%;
            max-width: 360px;
            margin: 0 auto;
            padding: 10px 0 30px 0;
        }

        .receipt-container {
            width: 100%;
            padding: 16px 14px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .text-uppercase { text-transform: uppercase; }
        .fw-bold { font-weight: bold; }
        .nowrap { white-space: nowrap; }

        .divider {
            border-bottom: 1px dashed #000000;
            margin: 6px 0;
            width: 100%;
        }

        table.receipt-table {
            width: 100%;
            border-collapse: collapse;
            margin: 2px 0;
        }

        table.receipt-table td {
            padding: 2px 0;
            font-size: 11px;
            line-height: 1.3;
            vertical-align: top;
            color: #000000;
        }

        .col-label { width: 30%; }
        .col-val { width: 70%; }

        .note-box {
            border: 1px solid #000000;
            padding: 6px;
            font-size: 10px;
            line-height: 1.3;
            white-space: pre-wrap;
            word-break: break-word;
            margin-top: 4px;
        }

        /* =========================================================
           PRINT MEDIA QUERIES (58MM THERMAL MONOSPACE FIX)
        ========================================================== */
      @media print {

    @page {
        size: 58mm 200mm;
        margin: 0 !important;
    }

    html,
    body {
        width: 58mm !important;
        min-width: 58mm !important;
        max-width: 58mm !important;

        margin: 0 !important;
        padding: 0 !important;

        background: #ffffff !important;

        font-family: "Courier New", Courier, monospace !important;
        letter-spacing: 0 !important;

        overflow: visible !important;
    }

    .no-print-bar {
        display: none !important;
    }

    .receipt-wrapper {
        width: 48mm !important;
        max-width: 48mm !important;
        min-width: 48mm !important;

        margin: 0 auto !important;
        padding: 0 !important;
    }

    .receipt-container {
        width: 48mm !important;
        max-width: 48mm !important;
        min-width: 48mm !important;

        margin: 0 !important;
        padding: 1mm 0 !important;

        background: #ffffff !important;

        border: none !important;
        border-radius: 0 !important;
        box-shadow: none !important;
    }

    .divider {
        width: 100% !important;

        border: 0 !important;
        border-bottom: 1px dashed #000000 !important;

        margin: 1.5mm 0 !important;
    }

    table.receipt-table {
        width: 48mm !important;
        max-width: 48mm !important;

        table-layout: fixed !important;
        border-collapse: collapse !important;

        margin: 2px 0 !important;
    }

    table.receipt-table td {
        font-size: 8.5px !important;
        line-height: 1.2 !important;

        padding: 1px 0 !important;

        vertical-align: top !important;

        overflow-wrap: break-word !important;
        word-break: normal !important;
    }

    .col-label {
        width: 30% !important;
    }

    .col-val {
        width: 70% !important;
    }

    .nowrap {
        white-space: normal !important;
    }

    .note-box {
        width: 48mm !important;
        max-width: 48mm !important;

        border: 1px solid #000000 !important;

        padding: 1mm !important;

        font-size: 8px !important;
        line-height: 1.2 !important;

        white-space: pre-wrap !important;
        overflow-wrap: break-word !important;
        word-break: normal !important;

        margin-top: 1mm !important;
    }

    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
}
    </style>
</head>
<body>

    @php
        $mechanicName = $service->mechanic_assigned 
            ?? ($service->technician->name ?? $service->technician->full_name ?? null)
            ?? ($service->mechanic->name ?? $service->mechanic->full_name ?? null)
            ?? $service->technician_name 
            ?? $service->mechanic_name 
            ?? 'Unassigned';

        $customerName = $service->customer_name 
            ?? ($service->customer->name ?? null)
            ?? ($service->user->name ?? null)
            ?? $service->client_name 
            ?? $service->name 
            ?? 'N/A';

        $contactPhone = $service->contact_number 
            ?? $service->phone_number 
            ?? $service->customer_phone 
            ?? $service->phone 
            ?? ($service->customer->phone ?? 'N/A');

        $servicesArr = is_array($service->selected_services) 
            ? $service->selected_services 
            : json_decode($service->selected_services ?? '[]', true);

        if (!is_array($servicesArr)) {
            $servicesArr = array_filter(explode(', ', (string)($service->selected_services ?? '')));
        }

        $serviceNames = array_map(function($item) {
            return is_array($item) ? ($item['name'] ?? '') : $item;
        }, $servicesArr ?? []);
        $serviceNames = array_filter($serviceNames);

        $vehicleBrand = $service->vehicle_make ?? $service->vehicle_brand ?? $service->brand ?? $service->make ?? 'N/A';
        $vehicleModel = $service->vehicle_model ?? $service->model ?? 'N/A';
        $plateNumber  = $service->plate_number ?? $service->plate_no ?? $service->plate ?? 'N/A';
        $adjustmentNote = $service->price_adjustment_note ?? $service->adjustment_note ?? $service->price_note ?? $service->notes ?? $service->price_adjustment_reason ?? 'No price adjustment notes recorded for this transaction.';
    @endphp

    <div class="no-print-bar">
        <button onclick="window.print()" class="btn-print">Print Receipt</button>
        <button onclick="window.close()" class="btn-close">Close</button>
    </div>

    <div class="receipt-wrapper">
        <div class="receipt-container">
            <!-- HEADER -->
            <div class="text-center">
                <div class="fw-bold text-uppercase" style="font-size: 13px;">SPEEDLANE AUTOSPA</div>
                <div style="font-size: 9px; line-height: 1.2; margin-top: 2px;">23 Ramos St., Brgy. Dadiangas East, General Santos City, 9500</div>
                <div class="fw-bold text-uppercase" style="font-size: 10px; margin-top: 3px;">Official Service Receipt</div>
                <div style="font-size: 9px;">Tel: 0938-027-4988</div>
            </div>

            <div class="divider"></div>

            <!-- DETAILS TABLE -->
            <table class="receipt-table">
                <tr>
                    <td class="text-left col-label">Receipt #:</td>
                    <td class="text-right fw-bold text-uppercase col-val">{{ $service->tracking_code }}</td>
                </tr>
                <tr>
                    <td class="text-left col-label">Date Reg:</td>
                    <td class="text-right nowrap col-val">{{ \Carbon\Carbon::parse($service->created_at)->format('m/d/Y h:i A') }}</td>
                </tr>
                <tr>
                    <td class="text-left col-label">Date Done:</td>
                    <td class="text-right nowrap col-val">{{ \Carbon\Carbon::parse($service->updated_at)->format('m/d/Y h:i A') }}</td>
                </tr>
                <tr>
                    <td class="text-left col-label">Customer:</td>
                    <td class="text-right fw-bold col-val">{{ $customerName }}</td>
                </tr>
                <tr>
                    <td class="text-left col-label">Phone:</td>
                    <td class="text-right col-val">{{ $contactPhone }}</td>
                </tr>
                <tr>
                    <td class="text-left col-label">Vehicle:</td>
                    <td class="text-right col-val">{{ $vehicleBrand }} {{ $vehicleModel }}</td>
                </tr>
                <tr>
                    <td class="text-left col-label">Plate No:</td>
                    <td class="text-right fw-bold text-uppercase col-val">{{ $plateNumber }}</td>
                </tr>
                <tr>
                    <td class="text-left col-label">Mechanic:</td>
                    <td class="text-right col-val">{{ $mechanicName }}</td>
                </tr>
            </table>

            <div class="divider"></div>

            <!-- SERVICES TABLE -->
            <table class="receipt-table">
                <tr class="fw-bold">
                    <td class="text-left" style="width: 60%;">SERVICES</td>
                    <td class="text-right" style="width: 40%;">PRICE</td>
                </tr>
                @if(count($serviceNames) > 0)
                    @foreach($serviceNames as $sName)
                        <tr>
                            <td class="text-left">{{ $sName }}</td>
                            <td class="text-right fw-bold">P{{ number_format((float)($service->total_cost ?? 0) / count($serviceNames), 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-left">General Detailing</td>
                        <td class="text-right fw-bold">P{{ number_format((float)($service->total_cost ?? 0), 2) }}</td>
                    </tr>
                @endif
            </table>

            <div class="divider"></div>

            <!-- TOTAL & STATUS -->
            <table class="receipt-table">
                <tr class="fw-bold">
                    <td class="text-left" style="width: 40%; font-size: 11px;">TOTAL:</td>
                    <td class="text-right" style="font-size: 12px;">P{{ number_format((float)($service->total_cost ?? 0), 2) }}</td>
                </tr>
                <tr>
                    <td class="text-left">STATUS:</td>
                    <td class="text-right fw-bold text-uppercase">PAID</td>
                </tr>
            </table>

            <div class="divider"></div>

            <!-- PRICE ADJUSTMENT NOTE -->
            <div style="margin: 4px 0;">
                <div class="fw-bold text-uppercase" style="font-size: 9px;">PRICE ADJUSTMENT NOTE:</div>
                <div class="note-box">{{ $adjustmentNote }}</div>
            </div>

            <div class="divider"></div>

            <!-- FOOTER -->
            <div class="text-center fw-bold text-uppercase" style="font-size: 9px; margin-top: 4px;">
                THANK YOU FOR CHOOSING SPEEDLANE!
            </div>
            <div class="text-center" style="font-size: 8px; margin-top: 2px;">
                Keep this receipt for warranty records.
            </div>
        </div>
    </div>

    <script>
        /*
         * Printing is controlled by transactions.blade.php.
         * This page must NOT call window.print() on load because it is
         * loaded inside the hidden thermal-print iframe.
         *
         * The parent page loads this exact thermal-receipt Blade and then
         * invokes print() once. This prevents duplicate print commands.
         */
    </script>
</body>
</html>