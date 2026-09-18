<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ServiceRecord;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    /**
     * Display the public customer tracking home page.
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Search and track all vehicle transactions matching a tracking code or plate number.
     */
    public function track(Request $request)
    {
        // 1. Sanitize search input
        $searchQuery = strtoupper(trim($request->input('tracking_code', '')));

        if (empty($searchQuery)) {
            return redirect('/')->with('error', 'Please enter a valid tracking code or plate number.');
        }

        // 2. Locate initial match to get parent tracking code (in case searched by plate number)
        $initialMatch = ServiceRecord::where('tracking_code', $searchQuery)
            ->orWhere('plate_number', $searchQuery)
            ->latest()
            ->first();

        if (!$initialMatch) {
            return view('customer.track-result', [
                'transactions' => collect(),
                'trackingCode' => $searchQuery,
            ]);
        }

        $targetTrackingCode = $initialMatch->tracking_code;

        // 3. Retrieve ALL vehicle records tied to this tracking code
        $transactions = ServiceRecord::where('tracking_code', $targetTrackingCode)
            ->oldest()
            ->get();

        // 4. Map DB Statuses (including "Inspection" from dashboard) to Step Numbers
        $statusMap = [
            'Pending'              => 1,
            'Vehicle Received'     => 1,
            'Inspection'           => 2,
            'Inspection Completed' => 2,
            'In Progress'          => 3,
            'Repair In Progress'   => 3,
            'Quality Check'        => 4,
            'Ready for Pickup'     => 4,
            'Completed'            => 5,
        ];

        $transactions->transform(function ($item) use ($statusMap) {
            $item->current_step = $statusMap[$item->status] ?? 1;
            return $item;
        });

        // 5. Pass collection & tracking code to view
        return view('customer.track-result', [
            'transactions' => $transactions,
            'trackingCode' => $targetTrackingCode,
        ]);
    }

    /**
     * Alias method for routes calling search()
     */
    public function search(Request $request)
    {
        return $this->track($request);
    }
}