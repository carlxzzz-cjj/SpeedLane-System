<?php

// =========================================================================
// FILE LOCATION: app/Http/Controllers/Admin/DashboardController.php
// PURPOSE: Handles data processing and dynamic calculations for Admin Dashboard
// =========================================================================

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRecord;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the Admin Main Overview Dashboard with real-time dynamic statistics.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // --------------------------------------------------------------------------
        // DYNAMIC METRICS CALCULATION FROM MYSQL DATABASE
        // --------------------------------------------------------------------------

        // Metric 1: Count of vehicles registered today (matching current calendar date)
        $vehiclesToday = ServiceRecord::whereDate('created_at', Carbon::today())->count();

        // Metric 2: Count of active services currently in progress (all non-Completed statuses)
        $activeServices = ServiceRecord::where('status', '!=', 'Completed')->count();

        // Metric 3: Count of services marked as 'Completed'
        $completedServices = ServiceRecord::where('status', 'Completed')->count();

        // Metric 4: Total count of all transaction records stored in system database
        $totalTransactions = ServiceRecord::count();

        // --------------------------------------------------------------------------
        // RETURN DASHBOARD VIEW WITH REAL-TIME BINDINGS
        // --------------------------------------------------------------------------
        return view('admin.dashboard', compact(
            'vehiclesToday',
            'activeServices',
            'completedServices',
            'totalTransactions'
        ));
    }
}