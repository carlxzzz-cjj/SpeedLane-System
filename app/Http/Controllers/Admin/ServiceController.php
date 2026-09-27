<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceOption;
use App\Models\ServiceRecord;
use App\Models\Technician;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    /**
     * Display the status update page with active service records (excludes completed).
     */
    public function index()
    {
        $query = ServiceRecord::query();

        // Exclude completed services so they automatically move to Transaction Records
        $query->where(function ($q) {
            $q->where('status', '!=', 'Completed')
              ->orWhereNull('status');
        });

        if (method_exists(ServiceRecord::class, 'vehicles')) {
            $query->with('vehicles');
        }

        $services = $query->latest()->get();

        return view('admin.update', compact('services'));
    }

    /**
     * Display service registration form.
     */
    public function create()
    {
        // Fetch active services eager-loading their options
        $services = Service::with('options')
            ->where('is_active', 1)
            ->get();

        // Fetch only active technicians for assignment
        $technicians = Technician::where('is_active', 1)->get();

        // Fetch vehicle models and group by brand/make safely
        $vehicleModels = VehicleModel::all()
            ->groupBy(function ($model) {
                return $model->brand ?? $model->make ?? 'Other';
            }) 
            ->map(function ($models) {
                return $models->pluck('name')->filter()->values();
            });

        return view('admin.register-service', compact('services', 'technicians', 'vehicleModels'));
    }

    /**
     * Store service registration record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'                     => 'required|string|max:255',
            'contact_number'                    => 'nullable|string|max:50',
            'customer_phone'                    => 'nullable|string|max:50',
            'tracking_code'                     => 'nullable|string|max:50',
            'vehicles'                          => 'required|array|min:1',
            'vehicles.*.plate_number'           => 'required|string|max:50',
            'vehicles.*.brand'                  => 'nullable|string|max:255',
            'vehicles.*.vehicle_make'           => 'nullable|string|max:255',
            'vehicles.*.vehicle_model'          => 'required|string|max:255',
            'vehicles.*.vehicle_type'           => 'nullable|string|max:255',
            'vehicles.*.vehicle_year'           => 'nullable|string|max:10',
            'vehicles.*.mechanic_assigned'      => 'required|string|max:255',
            'vehicles.*.services'               => 'nullable|array',
            'vehicles.*.price_adjustment_note' => 'nullable|string',
            'vehicles.*.total_cost'             => 'nullable|numeric',
        ]);

        $contactPhone = $request->input('contact_number') 
            ?? $request->input('customer_phone') 
            ?? $request->input('phone') 
            ?? 'N/A';

        $trackingCode = !empty($validated['tracking_code']) 
            ? strtoupper(trim($validated['tracking_code'])) 
            : ServiceRecord::generateUniqueTrackingCode();

        DB::beginTransaction();
        try {
            foreach ($validated['vehicles'] as $vehicleData) {
                $selectedServices = [];
                $servicePrices = [];
                $vehicleCalculatedTotal = 0.00;

                if (!empty($vehicleData['services']) && is_array($vehicleData['services'])) {
                    foreach ($vehicleData['services'] as $serviceId => $servicePayload) {
                        $isSelected = !empty($servicePayload['selected']);

                        if ($isSelected) {
                            $service = Service::find($serviceId);
                            $baseName = $service ? $service->name : "Service #{$serviceId}";
                            // Base flat price from the service model (if applicable)
                            $baseFlatPrice = floatval($service ? ($service->flat_price ?? 0) : 0);

                            $optionIds = [];
                            if (isset($servicePayload['option_id'])) {
                                $optionIds[] = $servicePayload['option_id'];
                            } elseif (!empty($servicePayload['options']) && is_array($servicePayload['options'])) {
                                $optionIds = $servicePayload['options'];
                            }

                            if (!empty($optionIds)) {
                                $options = ServiceOption::whereIn('id', $optionIds)->get();
                                $optionNames = $options->pluck('name')->toArray();
                                $optionPriceSum = $options->sum('price');

                                $itemTitle = $baseName . ' (' . implode(', ', $optionNames) . ')';
                                // Fixed double counting: add option prices to the base flat price
                                $itemPrice = $baseFlatPrice + $optionPriceSum;

                                $selectedServices[] = [
                                    'name'   => $itemTitle,
                                    'status' => 'Pending Queue',
                                    'note'   => ''
                                ];
                                $servicePrices[$itemTitle] = $itemPrice;
                                $vehicleCalculatedTotal += $itemPrice;
                            } else {
                                $itemPrice = $baseFlatPrice > 0 ? $baseFlatPrice : floatval($servicePayload['price'] ?? 0);
                                $selectedServices[] = [
                                    'name'   => $baseName,
                                    'status' => 'Pending Queue',
                                    'note'   => ''
                                ];
                                $servicePrices[$baseName] = $itemPrice;
                                $vehicleCalculatedTotal += $itemPrice;
                            }
                        }
                    }
                }

                if (empty($selectedServices)) {
                    $fallbackPrice = floatval($vehicleData['total_cost'] ?? 0.00);
                    $selectedServices[] = [
                        'name'   => 'General Inspection',
                        'status' => 'Pending Queue',
                        'note'   => ''
                    ];
                    $servicePrices['General Inspection'] = $fallbackPrice;
                    $vehicleCalculatedTotal = $fallbackPrice;
                }
                
                $finalVehicleCost = floatval($vehicleData['total_cost'] ?? 0);
                if ($finalVehicleCost <= 0) {
                    $finalVehicleCost = $vehicleCalculatedTotal;
                }

                $brandName = $vehicleData['brand'] ?? $vehicleData['vehicle_make'] ?? '';

                ServiceRecord::create([
                    'tracking_code'            => $trackingCode,
                    'customer_name'            => $validated['customer_name'],
                    'contact_number'           => $contactPhone,
                    'vehicle_make'             => $brandName,
                    'vehicle_model'            => $vehicleData['vehicle_model'] ?? '',
                    'vehicle_type'             => $vehicleData['vehicle_type'] ?? '',
                    'vehicle_year'             => $vehicleData['vehicle_year'] ?? '',
                    'plate_number'             => strtoupper($vehicleData['plate_number']),
                    'selected_services'        => $selectedServices,
                    'selected_services_prices' => $servicePrices,
                    'price_adjustment_note'    => $vehicleData['price_adjustment_note'] ?? null,
                    'total_cost'               => $finalVehicleCost,
                    'mechanic_assigned'        => $vehicleData['mechanic_assigned'],
                    'status'                   => 'Pending Queue',
                ]);
            }

            DB::commit();
            return back()->with('success', "Service registered successfully! Tracking Code: {$trackingCode}");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Service Registration Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to register service records: ' . $e->getMessage());
        }
    }

    /**
     * Update Service Stages, Progress Notes, and completion status.
     */
    public function updateStatus(Request $request, $id)
    {
        $service = ServiceRecord::findOrFail($id);

        $submittedServices = $request->input('services', []);
        $updatedServiceItems = [];

        // Parse nested service options and stage status notes sent from the update modal
        foreach ($submittedServices as $vServices) {
            if (is_array($vServices)) {
                foreach ($vServices as $sItem) {
                    $updatedServiceItems[] = [
                        'name'   => $sItem['name'] ?? 'Service',
                        'status' => $sItem['status'] ?? 'Pending Queue',
                        'note'   => $sItem['note'] ?? '',
                    ];
                }
            }
        }

        if (!empty($updatedServiceItems)) {
            $service->selected_services = $updatedServiceItems;
        }

        // Check if user toggled the "Mark as Completed" switch
        if ($request->has('mark_as_completed') && $request->input('mark_as_completed') == 1) {
            $service->status = 'Completed';
            $message = "Service record #{$service->tracking_code} marked as completed and moved to Transaction Records!";
        } else {
            $service->status = 'In Progress';
            $message = "Service status for #{$service->tracking_code} updated successfully!";
        }

        $service->save();

        return back()->with('success', $message);
    }

    /**
     * Add additional service item and update receipt total.
     */
    public function addAdditional(Request $request, $id)
    {
        $validated = $request->validate([
            'new_service' => 'required|string|max:255',
            'price'       => 'nullable|numeric|min:0',
        ]);

        $service = ServiceRecord::findOrFail($id);

        $currentServices = is_array($service->selected_services) 
            ? $service->selected_services 
            : (json_decode($service->selected_services, true) ?? []);

        if (!is_array($currentServices)) {
            $currentServices = !empty($service->selected_services) ? [$service->selected_services] : [];
        }

        $currentPrices = is_array($service->selected_services_prices)
            ? $service->selected_services_prices
            : (json_decode($service->selected_services_prices, true) ?? []);

        if (!is_array($currentPrices)) {
            $currentPrices = [];
        }

        $newService = trim($validated['new_service']);
        $addedPrice = floatval($validated['price'] ?? 0.00);

        $currentServices[] = [
            'name'   => $newService,
            'status' => 'Pending Queue',
            'note'   => ''
        ];
        $currentPrices[$newService] = $addedPrice;

        $service->selected_services        = $currentServices;
        $service->selected_services_prices = $currentPrices;
        $service->total_cost               = floatval($service->total_cost ?? 0) + $addedPrice;

        $service->save();

        return back()->with('success', "Additional service '{$newService}' added to vehicle '{$service->plate_number}'.");
    }
}