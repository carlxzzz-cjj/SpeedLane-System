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

        // Fetch vehicle models and include both name and type
        $vehicleModels = VehicleModel::all()
            ->groupBy(function ($model) {
                return $model->brand ?? $model->make ?? 'Other';
            }) 
            ->map(function ($models) {
                return $models->map(function ($model) {
                    return [
                        'name' => $model->name,
                        'type' => $model->type ?? $model->vehicle_type ?? '',
                        'year_start' => $model->year_start ?? $model->start_year ?? 1990,
                        'year_end'   => $model->year_end ?? $model->end_year ?? date('Y'),
                    ];
                })->values();
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
            'vehicles.*.technician_id'          => 'nullable|integer',
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
                                $itemPrice = isset($servicePayload['price']) && $servicePayload['price'] !== ''
                                    ? floatval($servicePayload['price'])
                                    : ($baseFlatPrice + $optionPriceSum);

                                $selectedServices[] = [
                                    'name'   => $itemTitle,
                                    'status' => 'Pending Queue',
                                    'note'   => ''
                                ];
                                $servicePrices[$itemTitle] = $itemPrice;
                                $vehicleCalculatedTotal += $itemPrice;
                            } else {
                                $itemPrice = isset($servicePayload['price']) && $servicePayload['price'] !== ''
                                    ? floatval($servicePayload['price'])
                                    : ($baseFlatPrice > 0 ? $baseFlatPrice : 0.00);

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

                $record = new ServiceRecord();

                // 1. Assign currently logged-in Admin / Super Admin ID
                $record->user_id = auth()->id();

                // 2. Resolve and assign Technician ID
                $mechanicInput = $vehicleData['mechanic_assigned'] ?? null;
                $techIdInput   = $vehicleData['technician_id'] ?? null;

                if (!empty($techIdInput)) {
                    $record->technician_id = $techIdInput;
                    $tech = Technician::find($techIdInput);
                    $record->mechanic_assigned = $tech ? $tech->name : $mechanicInput;
                } elseif (!empty($mechanicInput)) {
                    if (is_numeric($mechanicInput)) {
                        $record->technician_id = (int)$mechanicInput;
                        $tech = Technician::find($mechanicInput);
                        $record->mechanic_assigned = $tech ? $tech->name : "Technician #{$mechanicInput}";
                    } else {
                        $record->mechanic_assigned = $mechanicInput;
                        $tech = Technician::where('name', $mechanicInput)->first();
                        if ($tech) {
                            $record->technician_id = $tech->id;
                        }
                    }
                }

                $record->tracking_code            = $trackingCode;
                $record->customer_name            = $validated['customer_name'];
                $record->contact_number           = $contactPhone;
                $record->vehicle_make             = $brandName;
                $record->vehicle_model            = $vehicleData['vehicle_model'] ?? '';
                $record->vehicle_type             = $vehicleData['vehicle_type'] ?? '';
                $record->vehicle_year             = $vehicleData['vehicle_year'] ?? '';
                $record->plate_number             = strtoupper($vehicleData['plate_number']);
                $record->price_adjustment_note    = $vehicleData['price_adjustment_note'] ?? null;
                $record->total_cost               = $finalVehicleCost;
                $record->status                   = 'Pending Queue';

                if ($record->hasCast('selected_services')) {
                    $record->selected_services = $selectedServices;
                } else {
                    $record->selected_services = json_encode($selectedServices);
                }

                if ($record->hasCast('selected_services_prices')) {
                    $record->selected_services_prices = $servicePrices;
                } else {
                    $record->selected_services_prices = json_encode($servicePrices);
                }

                $record->save();
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
     * Update Service Stages, Progress Notes, Prices, and Completion Status.
     */
    public function updateStatus(Request $request, $id)
    {
        // Target the exact service record requested
        $service = ServiceRecord::findOrFail($id);

        $submittedServices = $request->input('services', []);
        $submittedVehicles = $request->input('vehicles', []);
        $isCompleted = $request->has('mark_as_completed') && $request->input('mark_as_completed') == 1;

        // Safely extract the service array submitted for this modal
        $vServices = isset($submittedServices[0]) ? $submittedServices[0] : $submittedServices;

        $vPriceNote = $submittedVehicles[0]['price_adjustment_note'] 
            ?? $request->input('price_adjustment_note');
        
        $vTotalOverride = isset($submittedVehicles[0]['total_cost']) && $submittedVehicles[0]['total_cost'] !== '' 
            ? floatval($submittedVehicles[0]['total_cost']) 
            : ($request->filled('total_cost') ? floatval($request->input('total_cost')) : null);

        $rawPrices = $service->selected_services_prices;
        $existingPrices = is_array($rawPrices) 
            ? $rawPrices 
            : (json_decode($rawPrices ?? '[]', true) ?? []);

        $updatedServiceItems = [];
        $updatedPricesMap = [];
        $vehicleCalculatedTotal = 0.00;

        if (is_array($vServices)) {
            foreach ($vServices as $sItem) {
                if (!is_array($sItem)) continue;

                $sName   = trim($sItem['name'] ?? 'Service');
                $sStatus = trim($sItem['status'] ?? 'Pending Queue');
                $sNote   = trim($sItem['note'] ?? '');

                if (isset($sItem['price']) && $sItem['price'] !== '') {
                    $sPrice = floatval($sItem['price']);
                } else {
                    $sPrice = floatval($existingPrices[$sName] ?? 0.00);
                }

                $updatedServiceItems[] = [
                    'name'   => $sName,
                    'status' => $sStatus,
                    'note'   => $sNote,
                ];
                $updatedPricesMap[$sName] = $sPrice;
                $vehicleCalculatedTotal += $sPrice;
            }
        }

        if (!empty($updatedServiceItems)) {
            if ($service->hasCast('selected_services')) {
                $service->selected_services = $updatedServiceItems;
            } else {
                $service->selected_services = json_encode($updatedServiceItems);
            }

            if ($service->hasCast('selected_services_prices')) {
                $service->selected_services_prices = $updatedPricesMap;
            } else {
                $service->selected_services_prices = json_encode($updatedPricesMap);
            }

            $service->total_cost = $vTotalOverride ?? $vehicleCalculatedTotal;
        }

        if ($vPriceNote !== null) {
            $service->price_adjustment_note = $vPriceNote;
        }

        // Compute overarching record status based on service stage statuses
        $itemStatuses = array_map(function($item) {
            return strtolower($item['status']);
        }, $updatedServiceItems);

        $allCompleted = !empty($itemStatuses) && array_reduce($itemStatuses, function($carry, $st) {
            return $carry && (str_contains($st, 'completed') || str_contains($st, 'ready'));
        }, true);

        $allPending = !empty($itemStatuses) && array_reduce($itemStatuses, function($carry, $st) {
            return $carry && (str_contains($st, 'pending') || str_contains($st, 'queue'));
        }, true);

        if ($isCompleted || $allCompleted) {
            $service->status = 'Completed';
        } elseif ($allPending) {
            $service->status = 'Pending Queue';
        } else {
            $service->status = 'In Progress';
        }

        $service->save();

        if ($isCompleted) {
            $message = "Service record #{$service->tracking_code} marked as completed and moved to Transaction Records!";
        } else {
            $message = "Service status and price for #{$service->tracking_code} updated successfully!";
        }

        return back()->with('success', $message);
    }


    public function destroy($id)
{
    try {
        $record = ServiceRecord::findOrFail($id);

        // Delete associated vehicles if applicable
        if (method_exists($record, 'vehicles')) {
            $record->vehicles()->delete();
        }

        $record->delete();

        return back()->with('success', 'Queued service record deleted successfully!');
    } catch (\Exception $e) {
        return back()->with('error', 'Failed to delete record: ' . $e->getMessage());
    }
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
            : (json_decode($service->selected_services ?? '[]', true) ?? []);

        if (!is_array($currentServices)) {
            $currentServices = !empty($service->selected_services) ? [$service->selected_services] : [];
        }

        $currentPrices = is_array($service->selected_services_prices)
            ? $service->selected_services_prices
            : (json_decode($service->selected_services_prices ?? '[]', true) ?? []);

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

        if ($service->hasCast('selected_services')) {
            $service->selected_services = $currentServices;
        } else {
            $service->selected_services = json_encode($currentServices);
        }

        if ($service->hasCast('selected_services_prices')) {
            $service->selected_services_prices = $currentPrices;
        } else {
            $service->selected_services_prices = json_encode($currentPrices);
        }

        $service->total_cost = floatval($service->total_cost ?? 0) + $addedPrice;
        $service->save();

        return back()->with('success', "Additional service '{$newService}' added to vehicle '{$service->plate_number}'.");
    }
}