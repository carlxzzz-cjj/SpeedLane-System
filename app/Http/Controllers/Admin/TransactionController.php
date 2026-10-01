<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRecord;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
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
            "MPV"          => ["full_body" => 18000, "front_half" => 12000, "hood_fenders" => 7000, "wheels" => 5000, "glass" => 5000, "trim" => 5000],
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
     * Display Completed Transactions Records
     */
    public function index(Request $request)
    {
        // STRICTLY COMPLETED SERVICES ONLY
        $query = ServiceRecord::where('status', 'Completed');

        // Safely eager-load technician/mechanic relationship if defined
        $relations = array_filter(['technician', 'mechanic', 'vehicleModel', 'vehicle'], fn($rel) => method_exists(ServiceRecord::class, $rel));
        if (!empty($relations)) {
            $query->with($relations);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                if (Schema::hasColumn('service_records', 'customer_name')) $q->orWhere('customer_name', 'like', "%{$search}%");
                if (Schema::hasColumn('service_records', 'tracking_code')) $q->orWhere('tracking_code', 'like', "%{$search}%");
                if (Schema::hasColumn('service_records', 'vehicle_type')) $q->orWhere('vehicle_type', 'like', "%{$search}%");
                if (Schema::hasColumn('service_records', 'vehicle_brand')) $q->orWhere('vehicle_brand', 'like', "%{$search}%");
                if (Schema::hasColumn('service_records', 'brand')) $q->orWhere('brand', 'like', "%{$search}%");
                if (Schema::hasColumn('service_records', 'make')) $q->orWhere('make', 'like', "%{$search}%");
                if (Schema::hasColumn('service_records', 'vehicle_model')) $q->orWhere('vehicle_model', 'like', "%{$search}%");
                if (Schema::hasColumn('service_records', 'plate_number')) $q->orWhere('plate_number', 'like', "%{$search}%");
                if (Schema::hasColumn('service_records', 'selected_services')) $q->orWhere('selected_services', 'like', "%{$search}%");
                if (Schema::hasColumn('service_records', 'mechanic_assigned')) $q->orWhere('mechanic_assigned', 'like', "%{$search}%");
                $q->orWhereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("DATE_FORMAT(created_at, '%M %d, %Y') LIKE ?", ["%{$search}%"]);
            });
        }

        if ($request->filled('vehicle_type')) {
            $this->applyVehicleTypeFilter($query, $request->vehicle_type);
        }

        $brandInput = $request->input('brand', $request->input('vehicle_brand', $request->input('vehicle_make')));
        if (!empty($brandInput)) {
            $this->applyBrandFilter($query, $brandInput);
        }

        if ($request->filled('service_type') && Schema::hasColumn('service_records', 'selected_services')) {
            $query->where('selected_services', 'like', "%" . trim($request->service_type) . "%");
        }

        // TECHNICIAN FILTER
        $techInput = $request->input('technician', $request->input('technician_id', $request->input('mechanic')));
        if (!empty($techInput)) {
            $this->applyTechnicianFilter($query, $techInput);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $transactions = $query->latest()->get();

        foreach ($transactions as $trx) {
            $this->repairTransactionPrices($trx);
        }

        $completedCount = $transactions->count();
        $totalRevenue   = $transactions->sum('total_cost');

        $availableServices = $this->getAvailableServices();
        $vehicleTypes      = $this->getVehicleTypes();
        $vehicleBrands     = $this->getVehicleBrands();
        $technicians       = $this->getTechnicians();
        $customers         = $this->getCustomers();

        return view('admin.transactions', compact(
            'completedCount',
            'totalRevenue',
            'transactions',
            'availableServices',
            'vehicleTypes',
            'vehicleBrands',
            'technicians',
            'customers'
        ));
    }

    /**
     * Generate Live Preview of System Reports (AJAX)
     */
    public function previewReport(Request $request)
    {
        $data = $this->getFilteredReportData($request);
        return view('admin.report-preview-partial', $data);
    }

    /**
     * Download PDF System Report
     */
   public function downloadReport(Request $request)
{
    // Passes query or POST parameters (report_type, timeframe, status, etc.) to report generator
    $data = $this->getFilteredReportData($request); 
    $pdf = Pdf::loadView('admin.report-pdf', $data);
    
    $reportType = $data['reportType'] ?? 'report';
    return $pdf->download("speedlane-{$reportType}-report-" . date('Y-m-d') . ".pdf");
}

    /**
     * Fetch report data filtered strictly by request options
     */
    private function getFilteredReportData(Request $request): array
    {
        $reportType   = $request->input('report_type', $request->input('type', 'financial'));
        $timeframe    = strtolower((string)$request->input('timeframe', ''));
        $statusFilter = $request->input('status', 'Completed');

        $query = ServiceRecord::query();

        // Eager-load technician/mechanic and vehicle relationships if defined
        $relations = array_filter(['technician', 'mechanic', 'vehicleModel', 'vehicle'], fn($rel) => method_exists(ServiceRecord::class, $rel));
        if (!empty($relations)) {
            $query->with($relations);
        }

        // 1. Status Filter Check
        $cleanStatus = strtolower(trim((string)$statusFilter));
        if ($cleanStatus !== '' && $cleanStatus !== 'all' && $cleanStatus !== 'all statuses' && $cleanStatus !== 'all_statuses') {
            if (Schema::hasColumn('service_records', 'status')) {
                $query->where('status', $statusFilter);
            }
        } else {
            $statusFilter = 'All Statuses';
        }

        $periodLabel = "All Time";

        // 2. Flexible Date / Timeframe Filtering
        $startDateInput = $request->input('custom_start', $request->input('start_date', $request->input('date_from')));
        $endDateInput   = $request->input('custom_end', $request->input('end_date', $request->input('date_to')));

        if ($timeframe === 'weekly') {
            $startDate = $startDateInput ? Carbon::parse($startDateInput)->startOfDay() : Carbon::now()->startOfWeek();
            $endDate   = $startDate->copy()->endOfWeek();
            $query->whereBetween('created_at', [$startDate, $endDate]);
            $periodLabel = "Weekly Period: " . $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y');
        } elseif ($timeframe === 'monthly' || ($timeframe === '' && $request->filled('month_year'))) {
            $monthYear = $request->input('month_year', date('Y-m'));
            $date = Carbon::parse($monthYear . '-01');
            $query->whereYear('created_at', $date->year)
                  ->whereMonth('created_at', $date->month);
            $periodLabel = "Monthly Period: " . $date->format('F Y');
        } elseif ($timeframe === 'yearly' || ($timeframe === '' && $request->filled('year'))) {
            $year = $request->input('year', date('Y'));
            $query->whereYear('created_at', $year);
            $periodLabel = "Annual Period: Year " . $year;
        } elseif ($timeframe === 'custom' || ($startDateInput && $endDateInput)) {
            if ($startDateInput && $endDateInput) {
                $sDate = Carbon::parse($startDateInput)->startOfDay();
                $eDate = Carbon::parse($endDateInput)->endOfDay();
                $query->whereBetween('created_at', [$sDate, $eDate]);
                $periodLabel = "Custom Range: " . $sDate->format('M d, Y') . " to " . $eDate->format('M d, Y');
            } elseif ($startDateInput) {
                $sDate = Carbon::parse($startDateInput)->startOfDay();
                $query->where('created_at', '>=', $sDate);
                $periodLabel = "From " . $sDate->format('M d, Y');
            } elseif ($endDateInput) {
                $eDate = Carbon::parse($endDateInput)->endOfDay();
                $query->where('created_at', '<=', $eDate);
                $periodLabel = "Up to " . $eDate->format('M d, Y');
            }
        } elseif ($timeframe === 'all' || $timeframe === 'all_time' || $timeframe === 'alltime') {
            $periodLabel = "All Time";
        }

        // 3. General Search Query
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                if (Schema::hasColumn('service_records', 'customer_name')) $q->orWhere('customer_name', 'like', "%{$search}%");
                if (Schema::hasColumn('service_records', 'tracking_code')) $q->orWhere('tracking_code', 'like', "%{$search}%");
                if (Schema::hasColumn('service_records', 'vehicle_type')) $q->orWhere('vehicle_type', 'like', "%{$search}%");
                if (Schema::hasColumn('service_records', 'vehicle_brand')) $q->orWhere('vehicle_brand', 'like', "%{$search}%");
                if (Schema::hasColumn('service_records', 'brand')) $q->orWhere('brand', 'like', "%{$search}%");
                if (Schema::hasColumn('service_records', 'make')) $q->orWhere('make', 'like', "%{$search}%");
                if (Schema::hasColumn('service_records', 'vehicle_model')) $q->orWhere('vehicle_model', 'like', "%{$search}%");
                if (Schema::hasColumn('service_records', 'plate_number')) $q->orWhere('plate_number', 'like', "%{$search}%");
                if (Schema::hasColumn('service_records', 'selected_services')) $q->orWhere('selected_services', 'like', "%{$search}%");
                if (Schema::hasColumn('service_records', 'mechanic_assigned')) $q->orWhere('mechanic_assigned', 'like', "%{$search}%");
            });
        }

        // 4. Input Specific Filters
        $customer = $request->input('customer', $request->input('customer_name'));
        if ($customer && Schema::hasColumn('service_records', 'customer_name')) {
            $query->where('customer_name', 'like', "%" . trim($customer) . "%");
        }

        $plate = $request->input('plate_number', $request->input('plate'));
        if ($plate && Schema::hasColumn('service_records', 'plate_number')) {
            $query->where('plate_number', 'like', "%" . trim($plate) . "%");
        }

        if ($request->filled('vehicle_type')) {
            $this->applyVehicleTypeFilter($query, $request->vehicle_type);
        }

        $brand = $request->input('brand', $request->input('vehicle_brand', $request->input('vehicle_make')));
        if (!empty($brand)) {
            $this->applyBrandFilter($query, $brand);
        }

        $service = $request->input('service_type', $request->input('service'));
        if ($service && Schema::hasColumn('service_records', 'selected_services')) {
            $query->where('selected_services', 'like', "%" . trim($service) . "%");
        }

        // TECHNICIAN FILTER
        $technician = $request->input('technician', $request->input('technician_id', $request->input('mechanic')));
        if (!empty($technician)) {
            $this->applyTechnicianFilter($query, $technician);
        }

        if ($request->filled('search_term')) {
            $searchTerm = trim($request->search_term);
            $query->where(function ($q) use ($searchTerm) {
                if (Schema::hasColumn('service_records', 'tracking_code')) $q->orWhere('tracking_code', 'like', "%{$searchTerm}%");
                if (Schema::hasColumn('service_records', 'plate_number')) $q->orWhere('plate_number', 'like', "%{$searchTerm}%");
                if (Schema::hasColumn('service_records', 'notes')) $q->orWhere('notes', 'like', "%{$searchTerm}%");
                if (Schema::hasColumn('service_records', 'vehicle_model')) $q->orWhere('vehicle_model', 'like', "%{$searchTerm}%");
                if (Schema::hasColumn('service_records', 'customer_name')) $q->orWhere('customer_name', 'like', "%{$searchTerm}%");
            });
        }

        $transactions = $query->latest()->get();

        foreach ($transactions as $trx) {
            $this->repairTransactionPrices($trx);
        }

        $totalCount   = $transactions->count();
        $totalRevenue = $transactions->sum('total_cost');

        // Build report-specific data structures
        $serviceBreakdown = [];
        if (in_array($reportType, ['service', 'service_demand', '3'])) {
            $title = "Completed Services & Revenue Report";

            foreach ($transactions as $trx) {
                $services = is_array($trx->selected_services) 
                    ? $trx->selected_services 
                    : json_decode($trx->selected_services ?? '[]', true);

                if (!is_array($services)) {
                    $services = array_filter(explode(', ', (string)($trx->selected_services ?? '')));
                }

                $pricesMap = is_array($trx->selected_services_prices) 
                    ? $trx->selected_services_prices 
                    : json_decode($trx->selected_services_prices ?? '[]', true);

                foreach ($services as $srv) {
                    $sName = is_array($srv) ? ($srv['name'] ?? '') : (string)$srv;
                    $sName = trim($sName);
                    if (empty($sName)) continue;

                    if ($service && stripos($sName, trim($service)) === false) {
                        continue;
                    }

                    $cost = (float) ($pricesMap[$sName] ?? 0);

                    if (!isset($serviceBreakdown[$sName])) {
                        $serviceBreakdown[$sName] = [
                            'name'            => $sName,
                            'times_completed' => 0,
                            'unit_price'      => $cost,
                            'total_revenue'   => 0.0
                        ];
                    }

                    $serviceBreakdown[$sName]['times_completed'] += 1;
                    $serviceBreakdown[$sName]['total_revenue']   += $cost;
                    if ($cost > 0 && $serviceBreakdown[$sName]['unit_price'] == 0) {
                        $serviceBreakdown[$sName]['unit_price'] = $cost;
                    }
                }
            }
        } elseif (in_array($reportType, ['financial', '1'])) {
            $title = "Revenue & Financial Summary Report";
        } elseif (in_array($reportType, ['technician', '2'])) {
            $title = "Technician Workload & Performance Report";
        } elseif (in_array($reportType, ['vehicle', '6'])) {
            $title = "Vehicle History Report";
        } elseif (in_array($reportType, ['customer', '5'])) {
            $title = "Customer Service History Report";
        } elseif (in_array($reportType, ['audit', 'queue', 'queue_log', '4'])) {
            $title = "Service Records & Operational Log Report";
        } else {
            $title = strtoupper(str_replace('_', ' ', $reportType)) . " REPORT";
        }

        $availableServices = $this->getAvailableServices();
        $vehicleTypes      = $this->getVehicleTypes();
        $vehicleBrands     = $this->getVehicleBrands();
        $technicians       = $this->getTechnicians();
        $customers         = $this->getCustomers();

        return [
            'reportType'       => $reportType,
            'title'            => $title,
            'periodLabel'      => $periodLabel,
            'timeframe'        => $timeframe,
            'statusFilter'     => $statusFilter,
            'transactions'     => $transactions,
            'serviceBreakdown' => $serviceBreakdown,
            'totalCount'       => $totalCount,
            'totalRevenue'     => $totalRevenue,
            'availableServices'=> $availableServices,
            'vehicleTypes'     => $vehicleTypes,
            'vehicleBrands'    => $vehicleBrands,
            'technicians'      => $technicians,
            'customers'        => $customers,
            'generatedAt'      => Carbon::now()->format('M d, Y h:i A')
        ];
    }

    /**
     * Helper to apply brand filter dynamically across multiple schema columns and models
     */
    private function applyBrandFilter($query, $brandInput): void
    {
        $brandTerm = trim((string)$brandInput);
        if ($brandTerm === '' || in_array(strtolower($brandTerm), ['all', 'all brands', 'all_brands'])) {
            return;
        }

        $query->where(function ($q) use ($brandTerm) {
            if (Schema::hasColumn('service_records', 'vehicle_brand')) {
                $q->orWhere('vehicle_brand', 'like', "%{$brandTerm}%");
            }
            if (Schema::hasColumn('service_records', 'brand')) {
                $q->orWhere('brand', 'like', "%{$brandTerm}%");
            }
            if (Schema::hasColumn('service_records', 'make')) {
                $q->orWhere('make', 'like', "%{$brandTerm}%");
            }
            if (Schema::hasColumn('service_records', 'vehicle_make')) {
                $q->orWhere('vehicle_make', 'like', "%{$brandTerm}%");
            }
            if (Schema::hasColumn('service_records', 'vehicle_model')) {
                $q->orWhere('vehicle_model', 'like', "%{$brandTerm}%");
            }
            if (Schema::hasColumn('service_records', 'model')) {
                $q->orWhere('model', 'like', "%{$brandTerm}%");
            }

            if (method_exists(ServiceRecord::class, 'vehicleModel')) {
                $q->orWhereHas('vehicleModel', function ($sub) use ($brandTerm) {
                    $sub->where('brand', 'like', "%{$brandTerm}%")
                        ->orWhere('make', 'like', "%{$brandTerm}%")
                        ->orWhere('name', 'like', "%{$brandTerm}%");
                });
            }
            if (method_exists(ServiceRecord::class, 'vehicle')) {
                $q->orWhereHas('vehicle', function ($sub) use ($brandTerm) {
                    $sub->where('brand', 'like', "%{$brandTerm}%")
                        ->orWhere('make', 'like', "%{$brandTerm}%")
                        ->orWhere('name', 'like', "%{$brandTerm}%");
                });
            }
        });
    }

    /**
     * Helper to apply vehicle type filter across columns
     */
    private function applyVehicleTypeFilter($query, $vehicleTypeInput): void
    {
        $vType = trim((string)$vehicleTypeInput);
        if ($vType === '' || in_array(strtolower($vType), ['all', 'all vehicles', 'all_vehicles'])) {
            return;
        }

        $query->where(function ($q) use ($vType) {
            if (Schema::hasColumn('service_records', 'vehicle_type')) {
                $q->orWhere('vehicle_type', 'like', "%{$vType}%");
            }
            if (Schema::hasColumn('service_records', 'body_type')) {
                $q->orWhere('body_type', 'like', "%{$vType}%");
            }
            if (Schema::hasColumn('service_records', 'type')) {
                $q->orWhere('type', 'like', "%{$vType}%");
            }
        });
    }

    /**
     * Helper to apply technician query filtering across multiple DB column variants
     */
    private function applyTechnicianFilter($query, $technicianInput): void
    {
        $techVal = trim((string)$technicianInput);

        if ($techVal === '' || in_array(strtolower($techVal), ['all', 'all mechanics', 'all technicians', 'all_technicians'])) {
            return;
        }

        $techNames = [$techVal];
        $techIds   = [$techVal];

        try {
            if (class_exists(\App\Models\Technician::class)) {
                $techModel = \App\Models\Technician::where('id', $techVal)
                    ->orWhere('name', $techVal)
                    ->orWhere('full_name', $techVal)
                    ->first();

                if ($techModel) {
                    if (!empty($techModel->name)) $techNames[] = $techModel->name;
                    if (!empty($techModel->full_name)) $techNames[] = $techModel->full_name;
                    if (!empty($techModel->id)) $techIds[] = (string)$techModel->id;
                }
            }
        } catch (\Throwable $e) {}

        try {
            if (class_exists(\App\Models\User::class)) {
                $userModel = \App\Models\User::where('id', $techVal)
                    ->orWhere('name', $techVal)
                    ->first();

                if ($userModel) {
                    if (!empty($userModel->name)) $techNames[] = $userModel->name;
                    if (!empty($userModel->id)) $techIds[] = (string)$userModel->id;
                }
            }
        } catch (\Throwable $e) {}

        $techNames = array_values(array_unique(array_filter($techNames)));
        $techIds   = array_values(array_unique(array_filter($techIds)));

        $query->where(function ($q) use ($techNames, $techIds) {
            if (Schema::hasColumn('service_records', 'mechanic_assigned')) {
                foreach ($techNames as $tn) {
                    $q->orWhere('mechanic_assigned', 'like', "%{$tn}%");
                }
                foreach ($techIds as $ti) {
                    $q->orWhere('mechanic_assigned', $ti);
                }
            }

            if (Schema::hasColumn('service_records', 'technician_id')) {
                foreach ($techIds as $ti) {
                    $q->orWhere('technician_id', $ti);
                }
                foreach ($techNames as $tn) {
                    $q->orWhere('technician_id', $tn);
                }
            }

            if (Schema::hasColumn('service_records', 'technician_name')) {
                foreach ($techNames as $tn) {
                    $q->orWhere('technician_name', 'like', "%{$tn}%");
                }
            }

            if (Schema::hasColumn('service_records', 'mechanic_name')) {
                foreach ($techNames as $tn) {
                    $q->orWhere('mechanic_name', 'like', "%{$tn}%");
                }
            }

            if (method_exists(ServiceRecord::class, 'technician')) {
                $q->orWhereHas('technician', function ($sub) use ($techNames, $techIds) {
                    $sub->whereIn('id', $techIds);
                    foreach ($techNames as $tn) {
                        $sub->orWhere('name', 'like', "%{$tn}%");
                    }
                });
            }

            if (method_exists(ServiceRecord::class, 'mechanic')) {
                $q->orWhereHas('mechanic', function ($sub) use ($techNames, $techIds) {
                    $sub->whereIn('id', $techIds);
                    foreach ($techNames as $tn) {
                        $sub->orWhere('name', 'like', "%{$tn}%");
                    }
                });
            }
        });
    }

    /**
     * Fetch list of distinct vehicle types dynamically from DB
     */
    private function getVehicleTypes()
    {
        $types = collect();

        if (Schema::hasTable('service_records')) {
            if (Schema::hasColumn('service_records', 'vehicle_type')) {
                $dbTypes = ServiceRecord::whereNotNull('vehicle_type')
                    ->where('vehicle_type', '!=', '')
                    ->pluck('vehicle_type')
                    ->unique();
                foreach ($dbTypes as $t) {
                    $types->push(trim($t));
                }
            }
        }

        try {
            if (class_exists(\App\Models\VehicleModel::class)) {
                if (Schema::hasColumn('vehicle_models', 'type')) {
                    $vmTypes = \App\Models\VehicleModel::whereNotNull('type')->pluck('type')->unique();
                    foreach ($vmTypes as $t) { $types->push(trim($t)); }
                } elseif (Schema::hasColumn('vehicle_models', 'vehicle_type')) {
                    $vmTypes = \App\Models\VehicleModel::whereNotNull('vehicle_type')->pluck('vehicle_type')->unique();
                    foreach ($vmTypes as $t) { $types->push(trim($t)); }
                }
            }
        } catch (\Throwable $e) {}

        $types = $types->unique()->filter()->values();

        if ($types->isEmpty()) {
            $types = collect(['Sedan', 'SUV', 'Pickup Truck', 'Hatchback', 'Van', 'Coupe', 'Crossover', 'MPV', 'Sports Car']);
        }

        return $types;
    }

    /**
     * Fetch list of distinct vehicle brands dynamically from DB
     */
    private function getVehicleBrands()
    {
        $brands = collect();

        // 1. Fetch distinct brands strictly from service_records columns
        if (Schema::hasTable('service_records')) {
            $brandCols = ['vehicle_brand', 'brand', 'make', 'vehicle_make'];
            
            foreach ($brandCols as $col) {
                if (Schema::hasColumn('service_records', $col)) {
                    $dbBrands = ServiceRecord::whereNotNull($col)
                        ->where($col, '!=', '')
                        ->pluck($col);

                    foreach ($dbBrands as $b) {
                        $brands->push(trim($b));
                    }
                }
            }
        }

        // 2. Fetch from VehicleModel table IF specific brand columns exist (excluding 'name')
        try {
            if (class_exists(\App\Models\VehicleModel::class) && Schema::hasTable('vehicle_models')) {
                foreach (['brand', 'make', 'vehicle_brand'] as $col) {
                    if (Schema::hasColumn('vehicle_models', $col)) {
                        $vmBrands = \App\Models\VehicleModel::whereNotNull($col)
                            ->where($col, '!=', '')
                            ->pluck($col);

                        foreach ($vmBrands as $b) {
                            $brands->push(trim($b));
                        }
                    }
                }
            }
        } catch (\Throwable $e) {}

        // Return unique, non-empty brands sorted alphabetically
        return $brands->filter()->unique()->values()->sort()->values();
    }

    /**
     * Fetch available services dynamically from DB
     */
    private function getAvailableServices()
    {
        $allServices = collect();

        // 1. Fetch Main Services
        try {
            if (class_exists(\App\Models\Service::class) && Schema::hasTable('services')) {
                $services = \App\Models\Service::whereNotNull('name')
                    ->where('name', '!=', '')
                    ->pluck('name');

                foreach ($services as $s) {
                    $allServices->push(trim($s));
                }
            }
        } catch (\Throwable $e) {}

        // 2. Fetch Service Options (checking both ServiceOption and ServicesOption models)
        try {
            $optionClass = class_exists(\App\Models\ServiceOption::class) 
                ? \App\Models\ServiceOption::class 
                : (class_exists(\App\Models\ServicesOption::class) ? \App\Models\ServicesOption::class : null);

            if ($optionClass) {
                foreach (['name', 'title', 'option_name'] as $col) {
                    if (Schema::hasColumn((new $optionClass)->getTable(), $col)) {
                        $options = $optionClass::whereNotNull($col)
                            ->where($col, '!=', '')
                            ->pluck($col);

                        foreach ($options as $opt) {
                            $allServices->push(trim($opt));
                        }
                    }
                }
            }
        } catch (\Throwable $e) {}

        return $allServices->filter()->unique()->sort()->values();
    }

    /**
     * Fetch list of technicians/mechanics
     */
    private function getTechnicians()
    {
        $technicians = collect();

        try {
            if (class_exists(\App\Models\Technician::class)) {
                $techs = \App\Models\Technician::all();
                foreach ($techs as $t) {
                    $technicians->push((object)[
                        'id'   => $t->id ?? $t->name,
                        'name' => $t->name ?? $t->full_name ?? ('Technician #' . $t->id)
                    ]);
                }
            }
        } catch (\Throwable $e) {}

        try {
            if (class_exists(\App\Models\User::class)) {
                $uTechs = \App\Models\User::whereIn('role', ['technician', 'mechanic', 'Technician', 'Mechanic'])->get();
                foreach ($uTechs as $u) {
                    $technicians->push((object)[
                        'id'   => $u->id,
                        'name' => $u->name ?? $u->full_name ?? ('Mechanic #' . $u->id)
                    ]);
                }
            }
        } catch (\Throwable $e) {}

        try {
            if (Schema::hasColumn('service_records', 'mechanic_assigned')) {
                $dbTechs = ServiceRecord::whereNotNull('mechanic_assigned')
                    ->where('mechanic_assigned', '!=', '')
                    ->where('mechanic_assigned', '!=', 'Unassigned')
                    ->pluck('mechanic_assigned')
                    ->unique();
                foreach ($dbTechs as $tName) {
                    $technicians->push((object)['id' => $tName, 'name' => $tName]);
                }
            }
        } catch (\Throwable $e) {}

        return $technicians->unique('name')->values();
    }

    /**
     * Fetch list of unique customer names
     */
    private function getCustomers()
    {
        $customers = collect();

        try {
            if (Schema::hasColumn('service_records', 'customer_name')) {
                $dbCusts = ServiceRecord::whereNotNull('customer_name')
                    ->where('customer_name', '!=', '')
                    ->pluck('customer_name')
                    ->unique();
                foreach ($dbCusts as $cName) {
                    $customers->push($cName);
                }
            }
        } catch (\Throwable $e) {}

        try {
            if (class_exists(\App\Models\User::class)) {
                $uCusts = \App\Models\User::pluck('name');
                foreach ($uCusts as $uName) {
                    if (!empty($uName)) {
                        $customers->push($uName);
                    }
                }
            }
        } catch (\Throwable $e) {}

        return $customers->unique()->filter()->values();
    }

    /**
     * Download individual receipt PDF
     */
    public function downloadPdf($id)
    {
        $service = ServiceRecord::findOrFail($id);
        $this->repairTransactionPrices($service);

        $pdf = Pdf::loadView('admin.receipt-pdf', compact('service'));
        return $pdf->download("Receipt-{$service->tracking_code}.pdf");
    }

    /**
     * Price Repair Logic
     */
    private function repairTransactionPrices(ServiceRecord $trx): void
    {
        $services = is_array($trx->selected_services) 
            ? $trx->selected_services 
            : json_decode($trx->selected_services ?? '[]', true);

        if (!is_array($services)) {
            $services = array_filter(explode(', ', (string)($trx->selected_services ?? '')));
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
        if (str_contains($s, 'undercoat') || str_contains($s, 'undercoating')) {
            if (str_contains($s, 'rubberized')) {
                return (float) ($matrix['undercoat'][$vType]['rubberized'] ?? 10000);
            }
            return (float) ($matrix['undercoat'][$vType]['epoxy'] ?? 6000);
        }
        if (str_contains($s, 'graphene')) {
            return (float) ($matrix['graphene_coating'][$vType]['full_body'] ?? 15000);
        }
        if (str_contains($s, 'ceramic')) {
            return (float) ($matrix['ceramic_coating'][$vType]['full_body'] ?? 11000);
        }
        if (str_contains($s, 'ppf') || str_contains($s, 'paint protection')) {
            return (float) ($matrix['ppf'][$vType]['full_front'] ?? 25000);
        }
        if (str_contains($s, 'washover')) {
            return (float) ($matrix['washover'][$vType]['hood'] ?? 7000);
        }

        return 5000.00;
    }
}