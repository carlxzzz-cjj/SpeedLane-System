<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceOption;
use App\Models\ServiceRecord;
use App\Models\Technician;
use App\Models\User;
use App\Services\IprogSmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ManageServiceController extends Controller
{
    protected IprogSmsService $smsService;

    /**
     * Inject IprogSmsService into ManageServiceController constructor.
     */
    public function __construct(IprogSmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Display the Manage Services, Technicians, and Staff dashboard.
     */
    public function index()
    {
        $services = Service::with('options')->latest()->get();
        $technicians = Technician::latest()->get();
        $staffs = User::latest()->get();

        return view(
            'admin.manage-services',
            compact('services', 'technicians', 'staffs')
        );
    }

    /**
     * Update active service progress status, item costs,
     * and dispatch SMS notification if ready for pick-up.
     *
     * IMPORTANT:
     * This method works with service_records, not services.
     *
     * The services table contains the service catalog/pricing.
     * The service_records table contains the actual customer,
     * vehicle, tracking code, status, and contact information.
     */
    public function updateStatus(Request $request, $id)
    {
        /*
         * IMPORTANT:
         * The actual customer/service transaction is stored
         * in service_records.
         */
        $service = ServiceRecord::findOrFail($id);

        DB::beginTransaction();

        try {
            $submittedServices = $request->input('services', []);
            $markAsCompleted = $request->boolean('mark_as_completed');
            $sendSmsRequested = $request->boolean('send_sms');

            $updatedSelectedServices = [];
            $updatedPricesMap = [];
            $totalCalculatedCost = 0;
            $hasCompletedAndReady = false;

            /*
             * Process submitted service items.
             */
            if (is_array($submittedServices)) {
                foreach ($submittedServices as $vIdx => $serviceItems) {

                    /*
                     * Some forms may submit the services directly
                     * instead of nesting them by vehicle.
                     *
                     * Support both structures.
                     */
                    if (
                        isset($serviceItems['name']) ||
                        isset($serviceItems['status']) ||
                        isset($serviceItems['price'])
                    ) {
                        $serviceItems = [$serviceItems];
                    }

                    if (!is_array($serviceItems)) {
                        continue;
                    }

                    foreach ($serviceItems as $sIdx => $sData) {

                        if (!is_array($sData)) {
                            continue;
                        }

                        $sName = trim((string) ($sData['name'] ?? ''));
                        $sStatus = trim(
                            (string) ($sData['status'] ?? 'Pending Queue')
                        );
                        $sNote = trim(
                            (string) ($sData['note'] ?? '')
                        );
                        $sPrice = floatval(
                            $sData['price'] ?? 0
                        );

                        if (!empty($sName)) {

                            $updatedSelectedServices[] = [
                                'name'   => $sName,
                                'status' => $sStatus,
                                'note'   => $sNote,
                            ];

                            $updatedPricesMap[$sName] = $sPrice;

                            $totalCalculatedCost += $sPrice;

                            /*
                             * Detect pickup-ready status.
                             */
                            $stLower = strtolower($sStatus);

                            if (
                                str_contains(
                                    $stLower,
                                    'completed & ready for pick up'
                                ) ||
                                str_contains(
                                    $stLower,
                                    'ready for pick up'
                                ) ||
                                str_contains(
                                    $stLower,
                                    'ready for pickup'
                                )
                            ) {
                                $hasCompletedAndReady = true;
                            }
                        }
                    }
                }
            }

            /*
             * Save status and pricing information
             * to service_records.
             */
            $updatePayload = [
                'selected_services' => json_encode(
                    $updatedSelectedServices
                ),

                'selected_services_prices' => json_encode(
                    $updatedPricesMap
                ),

                'total_cost' => $totalCalculatedCost,
            ];

            /*
             * If the form explicitly marks the service
             * as completed, update the main record status.
             */
            if ($markAsCompleted) {
                $updatePayload['status'] = 'Completed';
            }

            /*
             * Preserve the existing price adjustment note.
             *
             * Depending on the Blade structure, this may be
             * submitted inside the first service/vehicle item.
             */
            $submittedVehicles = $request->input('vehicles', []);

            if (
                is_array($submittedVehicles) &&
                isset($submittedVehicles[0]['price_adjustment_note'])
            ) {
                $updatePayload['price_adjustment_note'] =
                    $submittedVehicles[0]['price_adjustment_note'];
            }

            /*
             * If price_adjustment_note is submitted directly,
             * also support that structure.
             */
            if ($request->has('price_adjustment_note')) {
                $updatePayload['price_adjustment_note'] =
                    $request->input('price_adjustment_note');
            }

            /*
             * Update the actual service record.
             */
            $service->update($updatePayload);

            /*
             * Refresh the model after updating it.
             */
            $service->refresh();

            /*
             * Commit the service update first.
             *
             * SMS failure must NOT undo the completed
             * service record update.
             */
            DB::commit();

            /*
             * =====================================================
             * SMS NOTIFICATION
             * =====================================================
             */

            $smsSent = false;

            /*
             * The actual phone number is stored in:
             *
             * service_records.contact_number
             */
            $contactPhone = trim(
                (string) $service->contact_number
            );

            /*
             * The actual customer name is stored in:
             *
             * service_records.customer_name
             */
            $customerName = trim(
                (string) $service->customer_name
            );

            if (empty($customerName)) {
                $customerName = 'Valued Customer';
            }

            /*
             * The actual tracking code is stored in:
             *
             * service_records.tracking_code
             */
            $trackingCode = trim(
                (string) $service->tracking_code
            );

            /*
             * Log the values before attempting SMS.
             *
             * This is useful for diagnosing SMS problems.
             */
            Log::info(
                'SpeedLane SMS evaluation', [
                    'service_record_id' => $service->id,
                    'tracking_code' => $trackingCode,
                    'customer_name' => $customerName,
                    'contact_number' => $contactPhone,
                    'send_sms_requested' => $sendSmsRequested,
                    'has_completed_and_ready' => $hasCompletedAndReady,
                ]
            );

            /*
             * Send SMS when:
             *
             * 1. Staff explicitly checked the SMS switch, OR
             * 2. A service was marked ready for pickup.
             */
            $shouldSendSms =
                $sendSmsRequested ||
                $hasCompletedAndReady;

            if ($shouldSendSms) {

                if (
                    empty($contactPhone) ||
                    strtoupper($contactPhone) === 'N/A'
                ) {

                    Log::warning(
                        'SpeedLane SMS skipped: customer has no valid contact number.',
                        [
                            'service_record_id' => $service->id,
                            'tracking_code' => $trackingCode,
                            'contact_number' => $contactPhone,
                        ]
                    );

                } else {

                    /*
                     * Build the SMS message.
                     */
                    $smsMessage =
                        "Hi {$customerName}! Your vehicle service " .
                        "(Code: {$trackingCode}) is COMPLETED and ready " .
                        "for pick-up at SpeedLane Autospa. " .
                        "Thank you for choosing us!";

                    Log::info(
                        'SpeedLane SMS attempt starting.',
                        [
                            'service_record_id' => $service->id,
                            'tracking_code' => $trackingCode,
                            'phone' => $contactPhone,
                            'message' => $smsMessage,
                        ]
                    );

                    try {

                        /*
                         * Send through iProgSMS.
                         */
                        $smsSent = $this->smsService->send(
                            $contactPhone,
                            $smsMessage
                        );

                        if ($smsSent) {

                            Log::info(
                                'SpeedLane SMS notification sent successfully.',
                                [
                                    'service_record_id' => $service->id,
                                    'tracking_code' => $trackingCode,
                                    'phone' => $contactPhone,
                                ]
                            );

                        } else {

                            Log::error(
                                'SpeedLane SMS notification failed.',
                                [
                                    'service_record_id' => $service->id,
                                    'tracking_code' => $trackingCode,
                                    'phone' => $contactPhone,
                                ]
                            );
                        }

                    } catch (\Throwable $smsException) {

                        /*
                         * SMS failure should NOT undo the
                         * successful service-status update.
                         */
                        Log::error(
                            'SpeedLane SMS notification exception.',
                            [
                                'service_record_id' => $service->id,
                                'tracking_code' => $trackingCode,
                                'phone' => $contactPhone,
                                'error' => $smsException->getMessage(),
                            ]
                        );

                        $smsSent = false;
                    }
                }

            } else {

                /*
                 * No SMS was requested and the service was not
                 * detected as ready for pickup.
                 */
                Log::info(
                    'SpeedLane SMS not requested.',
                    [
                        'service_record_id' => $service->id,
                        'tracking_code' => $trackingCode,
                    ]
                );
            }

            /*
             * =====================================================
             * SUCCESS MESSAGE
             * =====================================================
             */

            $successMsg =
                "Service record #{$trackingCode} " .
                "updated successfully!";

            if ($smsSent) {

                $successMsg .=
                    " SMS pick-up notification sent to " .
                    "{$contactPhone}.";

            } elseif ($shouldSendSms) {

                /*
                 * Tell the staff that the service update worked,
                 * but SMS was not confirmed as sent.
                 *
                 * This prevents the interface from falsely
                 * claiming that SMS was delivered.
                 */
                $successMsg .=
                    " However, the SMS notification could not " .
                    "be confirmed as sent. Please check the SMS log.";
            }

            return back()->with(
                'success',
                $successMsg
            );

        } catch (\Throwable $e) {

            /*
             * Only roll back if the database transaction
             * is still active.
             */
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            Log::error(
                'ManageServiceController@updateStatus error.',
                [
                    'service_record_id' => $id,
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Failed to update service status: ' .
                    $e->getMessage()
                );
        }
    }

    /**
     * Store a new service along with its vehicle pricing options.
     */
    public function storeService(Request $request)
    {
        if ($request->selection_type === 'flat') {
            $request->request->remove('options');

        } elseif (
            $request->has('options') &&
            is_array($request->options)
        ) {
            $filteredOptions = array_filter(
                $request->options,
                function ($opt) {
                    return isset($opt['name']) &&
                        trim((string) $opt['name']) !== '';
                }
            );

            if (empty($filteredOptions)) {
                $request->request->remove('options');
            } else {
                $request->merge([
                    'options' => array_values($filteredOptions)
                ]);
            }
        }

        $request->validate([
            'name'           => 'required|string|max:255',
            'vehicle_type'   => 'nullable|string|max:100',
            'description'    => 'nullable|string',
            'notice'         => 'nullable|string|max:255',
            'selection_type' => 'required|in:single,multi,flat',
            'flat_price'     => 'nullable|numeric|min:0',
            'options'        => 'nullable|array',
            'options.*.name' =>
                'required_with:options|string|max:255',
            'options.*.price' =>
                'required_with:options|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {

            $service = Service::create([
                'name' => $request->name,
                'vehicle_type' => $request->vehicle_type ?? 'All',
                'description' => $request->description,
                'notice' => $request->notice,
                'selection_type' => $request->selection_type,
                'flat_price' =>
                    $request->selection_type === 'flat'
                        ? $request->flat_price
                        : null,
                'is_active' => 1,
            ]);

            if (
                $request->selection_type !== 'flat' &&
                !empty($request->options)
            ) {

                foreach ($request->options as $optionData) {

                    ServiceOption::create([
                        'service_id' => $service->id,
                        'name' => $optionData['name'],
                        'vehicle_type' => $service->vehicle_type,
                        'price' => $optionData['price'],
                    ]);
                }
            }

            DB::commit();

            return back()->with(
                'success',
                "Service '{$service->name}' created successfully!"
            );

        } catch (\Throwable $e) {

            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            Log::error(
                'ManageServiceController@storeService error.',
                [
                    'error' => $e->getMessage(),
                ]
            );

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Failed to create service: ' .
                    $e->getMessage()
                );
        }
    }

    /**
     * Update an existing service and synchronize its pricing options.
     */
    public function updateService(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        if ($request->selection_type === 'flat') {
            $request->request->remove('options');

        } elseif (
            $request->has('options') &&
            is_array($request->options)
        ) {

            $filteredOptions = array_filter(
                $request->options,
                function ($opt) {
                    return isset($opt['name']) &&
                        trim((string) $opt['name']) !== '';
                }
            );

            if (empty($filteredOptions)) {
                $request->request->remove('options');
            } else {
                $request->merge([
                    'options' => array_values($filteredOptions)
                ]);
            }
        }

        $request->validate([
            'name'           => 'required|string|max:255',
            'vehicle_type'   => 'nullable|string|max:100',
            'description'    => 'nullable|string',
            'notice'         => 'nullable|string|max:255',
            'selection_type' => 'required|in:single,multi,flat',
            'flat_price'     => 'nullable|numeric|min:0',
            'options'        => 'nullable|array',
            'options.*.name' =>
                'required_with:options|string|max:255',
            'options.*.price' =>
                'required_with:options|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {

            $service->update([
                'name' => $request->name,
                'vehicle_type' => $request->vehicle_type ?? 'All',
                'description' => $request->description,
                'notice' => $request->notice,
                'selection_type' => $request->selection_type,
                'flat_price' =>
                    in_array(
                        $request->selection_type,
                        ['flat', 'single']
                    )
                        ? $request->flat_price
                        : null,
            ]);

            if ($request->selection_type !== 'flat') {

                $service->options()->delete();

                if (!empty($request->options)) {

                    foreach ($request->options as $optionData) {

                        ServiceOption::create([
                            'service_id' => $service->id,
                            'name' => $optionData['name'],
                            'vehicle_type' => $service->vehicle_type,
                            'price' => $optionData['price'],
                        ]);
                    }
                }

            } else {

                $service->options()->delete();
            }

            DB::commit();

            return back()->with(
                'success',
                "Service '{$service->name}' updated successfully!"
            );

        } catch (\Throwable $e) {

            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            Log::error(
                'ManageServiceController@updateService error.',
                [
                    'error' => $e->getMessage(),
                ]
            );

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Failed to update service: ' .
                    $e->getMessage()
                );
        }
    }

    /**
     * Delete a service and all associated sub-options.
     */
    public function destroyService($id)
    {
        try {

            $service = Service::findOrFail($id);

            $service->options()->delete();
            $service->delete();

            return back()->with(
                'success',
                'Service and associated options deleted successfully!'
            );

        } catch (\Throwable $e) {

            Log::error(
                'ManageServiceController@destroyService error.',
                [
                    'error' => $e->getMessage(),
                ]
            );

            return back()->with(
                'error',
                'Failed to delete service: ' .
                $e->getMessage()
            );
        }
    }

    /**
     * Add a new technician to the roster.
     */
    public function storeTechnician(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Technician::create([
            'name' => trim($request->name),
            'is_active' => 1,
        ]);

        return back()->with(
            'success',
            "Technician '{$request->name}' added successfully!"
        );
    }

    /**
     * Toggle technician status.
     */
    public function toggleTechnicianStatus($id)
    {
        $technician = Technician::findOrFail($id);

        $technician->is_active = !$technician->is_active;

        if (!$technician->is_active) {
            $technician->disabled_at = now();
        } else {
            $technician->disabled_at = null;
        }

        $technician->save();

        $statusLabel = $technician->is_active
            ? 'enabled'
            : 'disabled';

        return back()->with(
            'success',
            "Technician '{$technician->name}' has been {$statusLabel}."
        );
    }

    /**
     * Download or export Technician Report.
     */
    public function downloadTechnicianReport()
    {
        $technicians = Technician::latest()->get();

        return back()->with(
            'success',
            'Technician report download process initiated.'
        );
    }

    /**
     * Register a new user account.
     */
    public function storeStaff(Request $request)
    {
        $request->validate([
            'name' =>
                'required|string|max:255',

            'username' =>
                'required|string|max:255|unique:users,username',

            'email' =>
                'required|email|max:255|unique:users,email',

            'contact_number' =>
                'required|string|max:50',

            'password' =>
                'required|string|min:8',

            'role' =>
                'nullable|string|in:admin,staff,super_admin',
        ]);

        $role = $request->input('role', 'admin');

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);

        $roleLabel = ucfirst($role);

        return back()->with(
            'success',
            "{$roleLabel} account for '{$request->name}' created successfully!"
        );
    }

    /**
     * Update an existing account's details.
     */
    public function updateStaff(Request $request, $id)
    {
        $staff = User::findOrFail($id);

        $request->validate([
            'name' =>
                'required|string|max:255',

            'username' =>
                'required|string|max:255|unique:users,username,' .
                $staff->id,

            'email' =>
                'required|email|max:255|unique:users,email,' .
                $staff->id,

            'contact_number' =>
                'required|string|max:50',

            'role' =>
                'nullable|string|in:admin,staff',
        ]);

        $updateData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
        ];

        if ($request->filled('role')) {
            $updateData['role'] = $request->role;
        }

        $staff->update($updateData);

        return back()->with(
            'success',
            "Account '{$staff->name}' updated successfully!"
        );
    }

    /**
     * Toggle staff/admin account active status.
     */
    public function toggleStaffStatus($id)
    {
        $staff = User::findOrFail($id);

        if (
            method_exists($staff, 'isSuperAdmin') &&
            $staff->isSuperAdmin()
        ) {
            return back()->with(
                'error',
                'Super Admin status cannot be disabled.'
            );
        }

        $staff->is_active = !$staff->is_active;

        if (!$staff->is_active) {
            $staff->disabled_at = now();
        } else {
            $staff->disabled_at = null;
        }

        $staff->save();

        $statusLabel = $staff->is_active
            ? 'enabled'
            : 'disabled';

        return back()->with(
            'success',
            "Account '{$staff->name}' has been {$statusLabel}."
        );
    }

    /**
     * Delete an account.
     */
    public function destroyStaff($id)
    {
        $staff = User::findOrFail($id);

        if (
            method_exists($staff, 'isSuperAdmin') &&
            $staff->isSuperAdmin()
        ) {
            return back()->with(
                'error',
                'Super Admin accounts cannot be deleted.'
            );
        }

        $staff->delete();

        return back()->with(
            'success',
            'Account deleted successfully!'
        );
    }

    /**
     * Download or export Staff Report.
     */
    public function downloadStaffReport()
    {
        $staffs = User::latest()->get();

        return back()->with(
            'success',
            'Staff report download process initiated.'
        );
    }
}