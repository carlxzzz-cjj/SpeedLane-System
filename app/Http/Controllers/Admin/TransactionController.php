<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Master pricing matrix
     */
    private array $speedlanePrices = [
        "ceramic_coating" => [
            "Hatchback"    => ["full_body" => 10000, "front_half" => 6000, "hood_fenders" => 4500, "wheels" => 4000, "glass" => 2500, "trim" => 3500],
            "Sedan"        => ["full_body" => 11000, "front_half" => 7000, "hood_fenders" => 5000, "wheels" => 4000, "glass" => 2500, "trim" => 3500],
            "Coupe"        => ["full_body" => 11000, "front_half" => 7000, "hood_fenders" => 5000, "wheels" => 4000, "glass" => 2500, "trim" => 3500],
            "Crossover"    => ["full_body" => 12000, "front_half" => 7500, "hood_fenders" => 5500, "wheels" => 4000, "glass" => 2500, "trim" => 3500],
            "MPV"          => ["full_body" => 12000, "front_half" => 8000, "hood_fenders" => 6000, "wheels" => 4000, "glass" => 2500, "trim" => 3500],
            "Wagon"        => ["full_body" => 12000, "front_half" => 7500, "hood_fenders" => 5500, "wheels" => 4000, "glass" => 2500, "trim" => 3500],
            "SUV"          => ["full_body" => 13000, "front_half" => 7000, "hood_fenders" => 6000, "wheels" => 4000, "glass" => 2500, "trim" => 3500],
            "Pickup Truck" => ["full_body" => 13000, "front_half" => 7500, "hood_fenders" => 6000, "wheels" => 4000, "glass" => 2500, "trim" => 4000],
            "Sports Car"   => ["full_body" => 14000, "front_half" => 8000, "hood_fenders" => 6000, "wheels" => 4500, "glass" => 2500, "trim" => 3500],
            "Van"          => ["full_body" => 15000, "front_half" => 8500, "hood_fenders" => 6500, "wheels" => 4000, "glass" => 3000, "trim" => 4000],
        ],
        "graphene_coating" => [
            "Hatchback"    => ["full_body" => 14000, "front_half" => 10000, "hood_fenders" => 5500, "wheels" => 5000, "glass" => 2500, "trim" => 5000],
            "Sedan"        => ["full_body" => 15000, "front_half" => 11000, "hood_fenders" => 6000, "wheels" => 5000, "glass" => 2500, "trim" => 5000],
            "Coupe"        => ["full_body" => 15000, "front_half" => 11000, "hood_fenders" => 6000, "wheels" => 5000, "glass" => 2500, "trim" => 5000],
            "Crossover"    => ["full_body" => 17000, "front_half" => 11500, "hood_fenders" => 6500, "wheels" => 5000, "glass" => 2500, "trim" => 5000],
            "MPV"          => ["full_body" => 18000, "front_half" => 12000, "hood_fenders" => 7000, "wheels" => 5000, "glass" => 2500, "trim" => 5000],
            "Wagon"        => ["full_body" => 17000, "front_half" => 11500, "hood_fenders" => 6500, "wheels" => 5000, "glass" => 2500, "trim" => 5000],
            "SUV"          => ["full_body" => 19000, "front_half" => 12500, "hood_fenders" => 8000, "wheels" => 5000, "glass" => 2500, "trim" => 5000],
            "Pickup Truck" => ["full_body" => 19000, "front_half" => 12000, "hood_fenders" => 7500, "wheels" => 5000, "glass" => 2500, "trim" => 5000],
            "Sports Car"   => ["full_body" => 20000, "front_half" => 12000, "hood_fenders" => 7500, "wheels" => 5000, "glass" => 2500, "trim" => 5000],
            "Van"          => ["full_body" => 22000, "front_half" => 13000, "hood_fenders" => 8000, "wheels" => 5000, "glass" => 3000, "trim" => 5500],
        ],
        "ppf" => [
            "Hatchback"    => ["full_front" => 25000, "hood_only" => 8000, "front_bumper" => 8000, "fenders_pair" => 8000, "mirrors_pair" => 2500, "door_cups" => 2000, "door_edges" => 2000, "headlights" => 4000],
            "Sedan"        => ["full_front" => 25000, "hood_only" => 8000, "front_bumper" => 8000, "fenders_pair" => 8000, "mirrors_pair" => 2500, "door_cups" => 2000, "door_edges" => 2000, "headlights" => 4000],
            "Coupe"        => ["full_front" => 25000, "hood_only" => 8000, "front_bumper" => 8000, "fenders_pair" => 8000, "mirrors_pair" => 2500, "door_cups" => 1500, "door_edges" => 1500, "headlights" => 4000],
            "Crossover"    => ["full_front" => 25000, "hood_only" => 8000, "front_bumper" => 8000, "fenders_pair" => 8000, "mirrors_pair" => 2500, "door_cups" => 2000, "door_edges" => 2000, "headlights" => 4000],
            "MPV"          => ["full_front" => 25000, "hood_only" => 8000, "front_bumper" => 8000, "fenders_pair" => 8000, "mirrors_pair" => 2500, "door_cups" => 2000, "door_edges" => 2000, "headlights" => 4000],
            "Wagon"        => ["full_front" => 25000, "hood_only" => 8000, "front_bumper" => 8000, "fenders_pair" => 8000, "mirrors_pair" => 2500, "door_cups" => 2000, "door_edges" => 2000, "headlights" => 4000],
            "Sports Car"   => ["full_front" => 28000, "hood_only" => 9000, "front_bumper" => 9000, "fenders_pair" => 9000, "mirrors_pair" => 2500, "door_cups" => 1500, "door_edges" => 1500, "headlights" => 4000],
            "Pickup Truck" => ["full_front" => 25000, "hood_only" => 8000, "front_bumper" => 8000, "fenders_pair" => 8000, "mirrors_pair" => 2500, "door_cups" => 2000, "door_edges" => 2000, "headlights" => 4000],
            "SUV"          => ["full_front" => 25000, "hood_only" => 8000, "front_bumper" => 8000, "fenders_pair" => 8000, "mirrors_pair" => 2500, "door_cups" => 2000, "door_edges" => 2000, "headlights" => 4000],
            "Van"          => ["full_front" => 28000, "hood_only" => 9000, "front_bumper" => 9000, "fenders_pair" => 9000, "mirrors_pair" => 2500, "door_cups" => 2000, "door_edges" => 2000, "headlights" => 4000],
        ],
        "interior_detailing" => [
            "Hatchback" => 5500, "Coupe" => 6000, "Sedan" => 6500, "Crossover" => 6500, "MPV" => 6500, "Wagon" => 6500, "SUV" => 6500, "Pickup Truck" => 6500, "Sports Car" => 7000, "Van" => 8500
        ],
        "exterior_detailing" => [
            "Hatchback" => 5500, "Coupe" => 6000, "Sedan" => 6500, "Crossover" => 6500, "MPV" => 6500, "Wagon" => 6500, "SUV" => 6500, "Pickup Truck" => 7000, "Sports Car" => 7500, "Van" => 8000
        ],
        "washover" => [
            "Hatchback"    => ["hood" => 7000, "roof" => 7000, "front_bumper" => 5500, "rear_bumper" => 5500, "fl_door" => 4500, "fr_door" => 4500, "rl_door" => 4500, "rr_door" => 4500, "fl_fender" => 4500, "fr_fender" => 4500, "rl_fender" => 4500, "rr_fender" => 4500, "trunk" => 5500, "spot_repair" => 4000],
            "Sedan"        => ["hood" => 8000, "roof" => 8000, "front_bumper" => 6000, "rear_bumper" => 6000, "fl_door" => 5000, "fr_door" => 5000, "rl_door" => 5000, "rr_door" => 5000, "fl_fender" => 5000, "fr_fender" => 5000, "rl_fender" => 5000, "rr_fender" => 5000, "trunk" => 6000, "spot_repair" => 4500],
            "Coupe"        => ["hood" => 8000, "roof" => 8000, "front_bumper" => 6000, "rear_bumper" => 6000, "fl_door" => 6000, "fr_door" => 6000, "rl_door" => 6000, "rr_door" => 6000, "fl_fender" => 5000, "fr_fender" => 5000, "rl_fender" => 5000, "rr_fender" => 5000, "trunk" => 6000, "spot_repair" => 4500],
            "Crossover"    => ["hood" => 8000, "roof" => 8000, "front_bumper" => 6000, "rear_bumper" => 6000, "fl_door" => 5000, "fr_door" => 5000, "rl_door" => 5000, "rr_door" => 5000, "fl_fender" => 5000, "fr_fender" => 5000, "rl_fender" => 5000, "rr_fender" => 5000, "trunk" => 6000, "spot_repair" => 4500],
            "Wagon"        => ["hood" => 8000, "roof" => 8500, "front_bumper" => 6000, "rear_bumper" => 6000, "fl_door" => 5000, "fr_door" => 5000, "rl_door" => 5000, "rr_door" => 5000, "fl_fender" => 5000, "fr_fender" => 5000, "rl_fender" => 5000, "rr_fender" => 5000, "trunk" => 6000, "spot_repair" => 4500],
            "MPV"          => ["hood" => 8000, "roof" => 8000, "front_bumper" => 6000, "rear_bumper" => 6000, "fl_door" => 5000, "fr_door" => 5000, "rl_door" => 5000, "rr_door" => 5000, "fl_fender" => 5000, "fr_fender" => 5000, "rl_fender" => 5000, "rr_fender" => 5000, "trunk" => 6000, "spot_repair" => 4500],
            "Sports Car"   => ["hood" => 9000, "roof" => 8000, "front_bumper" => 7000, "rear_bumper" => 7000, "fl_door" => 6000, "fr_door" => 6000, "rl_door" => 6000, "rr_door" => 6000, "fl_fender" => 5500, "fr_fender" => 5500, "rl_fender" => 5500, "rr_fender" => 5500, "trunk" => 6000, "spot_repair" => 5000],
            "Pickup Truck" => ["hood" => 8000, "roof" => 7500, "front_bumper" => 6000, "rear_bumper" => 5000, "fl_door" => 5000, "fr_door" => 5000, "rl_door" => 5000, "rr_door" => 5000, "fl_fender" => 5000, "fr_fender" => 5000, "rl_fender" => 5000, "rr_fender" => 5000, "trunk" => 5000, "spot_repair" => 4500],
            "SUV"          => ["hood" => 8000, "roof" => 8000, "front_bumper" => 6000, "rear_bumper" => 6000, "fl_door" => 5000, "fr_door" => 5000, "rl_door" => 5000, "rr_door" => 5000, "fl_fender" => 5000, "fr_fender" => 5000, "rl_fender" => 5000, "rr_fender" => 5000, "trunk" => 6000, "spot_repair" => 4500],
            "Van"          => ["hood" => 6000, "roof" => 12000, "front_bumper" => 6000, "rear_bumper" => 6000, "fl_door" => 5000, "fr_door" => 5000, "rl_door" => 5000, "rr_door" => 5000, "fl_fender" => 5000, "fr_fender" => 5000, "rl_fender" => 5000, "rr_fender" => 5000, "trunk" => 7000, "spot_repair" => 5000],
        ],
        "undercoat" => [
            "Hatchback"    => ["epoxy" => 5000, "rubberized" => 9500],
            "Sedan"        => ["epoxy" => 5500, "rubberized" => 10000],
            "Coupe"        => ["epoxy" => 5500, "rubberized" => 10000],
            "Crossover"    => ["epoxy" => 6000, "rubberized" => 10000],
            "MPV"          => ["epoxy" => 6000, "rubberized" => 10000],
            "Wagon"        => ["epoxy" => 6000, "rubberized" => 10000],
            "Sports Car"   => ["epoxy" => 6000, "rubberized" => 10000],
            "SUV"          => ["epoxy" => 6500, "rubberized" => 10000],
            "Pickup Truck" => ["epoxy" => 7000, "rubberized" => 11000],
            "Van"          => ["epoxy" => 7500, "rubberized" => 12000],
        ]
    ];

    /**
     * Display Transactions Overview & Unified Multi-field Search
     */
    public function index(Request $request)
    {
        $query = ServiceRecord::where('status', 'Completed');

        // 1. Keyword Search across Name, Tracking Code, Vehicle, Model, Plate, Service & Date
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('tracking_code', 'like', "%{$search}%")
                  ->orWhere('vehicle_type', 'like', "%{$search}%")
                  ->orWhere('vehicle_model', 'like', "%{$search}%")
                  ->orWhere('plate_number', 'like', "%{$search}%")
                  ->orWhere('selected_services', 'like', "%{$search}%")
                  ->orWhereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("DATE_FORMAT(created_at, '%M %d, %Y') LIKE ?", ["%{$search}%"]);
            });
        }

        // 2. Specific Vehicle Type Dropdown
        if ($request->filled('vehicle_type')) {
            $query->where('vehicle_type', 'like', "%{$request->vehicle_type}%");
        }

        // 3. Specific Service Dropdown
        if ($request->filled('service_type')) {
            $query->where('selected_services', 'like', "%{$request->service_type}%");
        }

        // 4. Specific Date Picker Filter
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $transactions = $query->latest()->get();

        // Self-Healing: Repair missing/zero prices
        foreach ($transactions as $trx) {
            $this->repairTransactionPrices($trx);
        }

        // Global KPI Metrics
        $totalTransactions     = ServiceRecord::count();
        $completedTransactions = $transactions->count();
        $completedCount        = $completedTransactions;
        $totalRevenue          = $transactions->sum('total_cost');

        // Report Statistics Metrics
        $now = Carbon::now();

        // Weekly metrics
        $weeklyQuery = ServiceRecord::where('status', 'Completed')
            ->whereBetween('created_at', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()]);
        $weeklyCount   = $weeklyQuery->count();
        $weeklyRevenue = $weeklyQuery->sum('total_cost');

        // Monthly metrics
        $monthlyQuery = ServiceRecord::where('status', 'Completed')
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month);
        $monthlyCount   = $monthlyQuery->count();
        $monthlyRevenue = $monthlyQuery->sum('total_cost');

        // Yearly metrics
        $yearlyQuery = ServiceRecord::where('status', 'Completed')
            ->whereYear('created_at', $now->year);
        $yearlyCount   = $yearlyQuery->count();
        $yearlyRevenue = $yearlyQuery->sum('total_cost');

        $availableServices = [
            'Ceramic Coating',
            'Graphene Coating',
            'Paint Protection Film',
            'Interior Detailing',
            'Exterior Detailing',
            'Washover',
            'Undercoat'
        ];

        return view('admin.transactions', compact(
            'totalTransactions',
            'completedTransactions',
            'completedCount',
            'totalRevenue',
            'transactions',
            'weeklyCount',
            'weeklyRevenue',
            'monthlyCount',
            'monthlyRevenue',
            'yearlyCount',
            'yearlyRevenue',
            'availableServices'
        ));
    }

    /**
     * Download Weekly, Monthly, or Yearly Report PDF
     */
    public function downloadReport(Request $request)
    {
        $type = $request->input('type', 'weekly');
        $query = ServiceRecord::where('status', 'Completed');

        $title = "Transaction Report";
        $periodLabel = "";

        if ($type === 'weekly') {
            $startDate = $request->filled('start_date') 
                ? Carbon::parse($request->start_date)->startOfDay() 
                : Carbon::now()->startOfWeek();
            $endDate = $startDate->copy()->endOfWeek();

            $query->whereBetween('created_at', [$startDate, $endDate]);
            $title = "Weekly Transaction Report";
            $periodLabel = $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y');

        } elseif ($type === 'monthly') {
            $monthYear = $request->input('month_year', date('Y-m'));
            $date = Carbon::parse($monthYear . '-01');

            $query->whereYear('created_at', $date->year)
                  ->whereMonth('created_at', $date->month);
            $title = "Monthly Transaction Report";
            $periodLabel = $date->format('F Y');

        } elseif ($type === 'yearly') {
            $year = $request->input('year', date('Y'));

            $query->whereYear('created_at', $year);
            $title = "Yearly Transaction Report";
            $periodLabel = "Year " . $year;
        }

        $transactions = $query->latest()->get();

        foreach ($transactions as $trx) {
            $this->repairTransactionPrices($trx);
        }

        $totalRevenue = $transactions->sum('total_cost');
        $totalCount   = $transactions->count();

        $pdf = Pdf::loadView('admin.report-pdf', compact(
            'transactions',
            'title',
            'periodLabel',
            'totalRevenue',
            'totalCount',
            'type'
        ));

        return $pdf->download("{$type}-report-" . date('Y-m-d') . ".pdf");
    }

    /**
     * Generate and download PDF receipt for a specific transaction
     */
    public function downloadPdf($id)
    {
        $service = ServiceRecord::findOrFail($id);

        $this->repairTransactionPrices($service);

        $pdf = Pdf::loadView('admin.receipt-pdf', compact('service'));
        
        return $pdf->download("Receipt-{$service->tracking_code}.pdf");
    }

    /**
     * Repairs zero/missing prices for individual items and total costs using body-type matching
     */
    private function repairTransactionPrices(ServiceRecord $trx): void
    {
        $services = is_array($trx->selected_services) 
            ? $trx->selected_services 
            : json_decode($trx->selected_services ?? '[]', true);

        if (!is_array($services)) {
            $services = array_filter(explode(', ', (string) $trx->selected_services));
        }

        $pricesMap = is_array($trx->selected_services_prices) 
            ? $trx->selected_services_prices 
            : json_decode($trx->selected_services_prices ?? '[]', true);

        if (!is_array($pricesMap)) {
            $pricesMap = [];
        }

        $vehicleType = $this->normalizeVehicleType(
            $trx->vehicle_type ?? $trx->vehicle_model ?? 'Sedan'
        );

        $totalCalculated = 0.00;
        $updatedPricesMap = [];
        $needsSave = false;

        foreach ($services as $key => $srv) {
            $serviceName = is_array($srv) ? ($srv['name'] ?? '') : (string) $srv;
            $trimmedName = trim($serviceName);

            if (empty($trimmedName)) {
                continue;
            }

            $price = (float) ($pricesMap[$trimmedName] ?? $pricesMap[$key] ?? 0);

            if ($price <= 0) {
                $price = $this->calculateExactPrice($trimmedName, $vehicleType);
                $needsSave = true;
            }

            $updatedPricesMap[$trimmedName] = $price;
            $totalCalculated += $price;
        }

        if ((float) $trx->total_cost <= 0) {
            $trx->total_cost = $totalCalculated;
            $needsSave = true;
        }

        if ($needsSave || empty($trx->selected_services_prices)) {
            $trx->selected_services_prices = $updatedPricesMap;
            $trx->save();
        }
    }

    /**
     * Normalizes free-form vehicle input strings into supported body type keys
     */
    private function normalizeVehicleType(string $input): string
    {
        $types = ["Hatchback", "Coupe", "Crossover", "MPV", "Wagon", "SUV", "Pickup Truck", "Sports Car", "Van", "Sedan"];
        foreach ($types as $type) {
            if (stripos($input, $type) !== false) {
                return $type;
            }
        }
        return "Sedan";
    }

    /**
     * Looks up exact sub-option pricing using service string and vehicle body type
     */
    private function calculateExactPrice(string $serviceName, string $vType): float
    {
        $s = strtolower($serviceName);
        $matrix = $this->speedlanePrices;

        if (str_contains($s, 'interior detailing')) {
            return (float) ($matrix['interior_detailing'][$vType] ?? 6500);
        }
        if (str_contains($s, 'exterior detailing')) {
            return (float) ($matrix['exterior_detailing'][$vType] ?? 6500);
        }

        if (str_contains($s, 'undercoat') || str_contains($s, 'rustproof')) {
            $sub = str_contains($s, 'rubberized') ? 'rubberized' : 'epoxy';
            return (float) ($matrix['undercoat'][$vType][$sub] ?? 6000);
        }

        if (str_contains($s, 'ceramic')) {
            $sub = 'full_body';
            if (str_contains($s, 'front half')) $sub = 'front_half';
            elseif (str_contains($s, 'hood') && str_contains($s, 'fender')) $sub = 'hood_fenders';
            elseif (str_contains($s, 'wheel')) $sub = 'wheels';
            elseif (str_contains($s, 'glass')) $sub = 'glass';
            elseif (str_contains($s, 'trim') || str_contains($s, 'plastic')) $sub = 'trim';

            return (float) ($matrix['ceramic_coating'][$vType][$sub] ?? 11000);
        }

        if (str_contains($s, 'graphene')) {
            $sub = 'full_body';
            if (str_contains($s, 'front half')) $sub = 'front_half';
            elseif (str_contains($s, 'hood') && str_contains($s, 'fender')) $sub = 'hood_fenders';
            elseif (str_contains($s, 'wheel')) $sub = 'wheels';
            elseif (str_contains($s, 'glass')) $sub = 'glass';
            elseif (str_contains($s, 'trim') || str_contains($s, 'plastic')) $sub = 'trim';

            return (float) ($matrix['graphene_coating'][$vType][$sub] ?? 15000);
        }

        if (str_contains($s, 'ppf') || str_contains($s, 'film')) {
            $sub = 'full_front';
            if (str_contains($s, 'hood only')) $sub = 'hood_only';
            elseif (str_contains($s, 'front bumper')) $sub = 'front_bumper';
            elseif (str_contains($s, 'fender')) $sub = 'fenders_pair';
            elseif (str_contains($s, 'mirror')) $sub = 'mirrors_pair';
            elseif (str_contains($s, 'cup')) $sub = 'door_cups';
            elseif (str_contains($s, 'edge')) $sub = 'door_edges';
            elseif (str_contains($s, 'headlight')) $sub = 'headlights';

            return (float) ($matrix['ppf'][$vType][$sub] ?? 25000);
        }

        if (str_contains($s, 'washover') || str_contains($s, 'repaint')) {
            $sub = 'spot_repair';
            if (str_contains($s, 'hood')) $sub = 'hood';
            elseif (str_contains($s, 'roof')) $sub = 'roof';
            elseif (str_contains($s, 'front bumper')) $sub = 'front_bumper';
            elseif (str_contains($s, 'rear bumper')) $sub = 'rear_bumper';
            elseif (str_contains($s, 'trunk') || str_contains($s, 'tailgate')) $sub = 'trunk';

            return (float) ($matrix['washover'][$vType][$sub] ?? 5000);
        }

        return 0.00;
    }
}