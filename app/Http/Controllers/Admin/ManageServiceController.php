<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceOption;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ManageServiceController extends Controller
{
    /**
     * Display the Manage Services, Technicians, and Staff dashboard.
     */
    public function index()
    {
        $services = Service::with('options')->latest()->get();
        $technicians = Technician::latest()->get();
        $staffs = User::latest()->get();

        return view('admin.manage-services', compact('services', 'technicians', 'staffs'));
    }

    /**
     * Store a new service along with its vehicle pricing options.
     */
    public function storeService(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'vehicle_type'   => 'nullable|string|max:100',
            'description'    => 'nullable|string',
            'notice'         => 'nullable|string|max:255',
            'selection_type' => 'required|in:single,multi,flat',
            'flat_price'     => 'nullable|numeric|min:0',
            'options'        => 'nullable|array',
            'options.*.name'  => 'required_with:options|string|max:255',
            'options.*.price' => 'required_with:options|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $service = Service::create([
                'name'           => $request->name,
                'vehicle_type'   => $request->vehicle_type ?? 'All',
                'description'    => $request->description,
                'notice'         => $request->notice,
                'selection_type' => $request->selection_type,
                'flat_price'     => $request->selection_type === 'flat' ? $request->flat_price : null,
                'is_active'      => 1,
            ]);

            if ($request->selection_type !== 'flat' && !empty($request->options)) {
                foreach ($request->options as $optionData) {
                    ServiceOption::create([
                        'service_id'   => $service->id,
                        'name'         => $optionData['name'],
                        'vehicle_type' => $service->vehicle_type,
                        'price'        => $optionData['price'],
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', "Service '{$service->name}' created successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ManageServiceController@storeService error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create service: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing service and synchronize its pricing options.
     */
    public function updateService(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'name'           => 'required|string|max:255',
            'vehicle_type'   => 'nullable|string|max:100',
            'description'    => 'nullable|string',
            'notice'         => 'nullable|string|max:255',
            'selection_type' => 'required|in:single,multi,flat',
            'flat_price'     => 'nullable|numeric|min:0',
            'options'        => 'nullable|array',
            'options.*.name'  => 'required_with:options|string|max:255',
            'options.*.price' => 'required_with:options|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $service->update([
                'name'           => $request->name,
                'vehicle_type'   => $request->vehicle_type ?? 'All',
                'description'    => $request->description,
                'notice'         => $request->notice,
                'selection_type' => $request->selection_type,
                'flat_price'     => $request->selection_type === 'flat' ? $request->flat_price : null,
            ]);

            if ($request->selection_type !== 'flat') {
                $service->options()->delete();

                if (!empty($request->options)) {
                    foreach ($request->options as $optionData) {
                        ServiceOption::create([
                            'service_id'   => $service->id,
                            'name'         => $optionData['name'],
                            'vehicle_type' => $service->vehicle_type,
                            'price'        => $optionData['price'],
                        ]);
                    }
                }
            } else {
                $service->options()->delete();
            }

            DB::commit();
            return back()->with('success', "Service '{$service->name}' updated successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ManageServiceController@updateService error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update service: ' . $e->getMessage());
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

            return back()->with('success', 'Service and associated options deleted successfully!');
        } catch (\Exception $e) {
            Log::error('ManageServiceController@destroyService error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete service: ' . $e->getMessage());
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
            'name'      => trim($request->name),
            'is_active' => 1,
        ]);

        return back()->with('success', "Technician '{$request->name}' added successfully!");
    }

    /**
     * Toggle technician status (Active / Disabled).
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

        $statusLabel = $technician->is_active ? 'enabled' : 'disabled';
        return back()->with('success', "Technician '{$technician->name}' has been {$statusLabel}.");
    }

    /**
     * Register a new user account (Admin/Staff).
     */
    public function storeStaff(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'username'       => 'required|string|max:255|unique:users,username',
            'email'          => 'required|email|max:255|unique:users,email',
            'contact_number' => 'required|string|max:50',
            'password'       => 'required|string|min:8',
            'role'           => 'nullable|string|in:admin,staff',
        ]);

        $role = $request->input('role', 'admin');

        User::create([
            'name'           => $request->name,
            'username'       => $request->username,
            'email'          => $request->email,
            'contact_number' => $request->contact_number,
            'password'       => Hash::make($request->password),
            'role'           => $role,
        ]);

        $roleLabel = ucfirst($role);
        return back()->with('success', "{$roleLabel} account for '{$request->name}' created successfully!");
    }

    /**
     * Update an existing account's details.
     */
    public function updateStaff(Request $request, $id)
    {
        $staff = User::findOrFail($id);

        $request->validate([
            'name'           => 'required|string|max:255',
            'username'       => 'required|string|max:255|unique:users,username,' . $staff->id,
            'email'          => 'required|email|max:255|unique:users,email,' . $staff->id,
            'contact_number' => 'required|string|max:50',
            'role'           => 'nullable|string|in:admin,staff',
        ]);

        $updateData = [
            'name'           => $request->name,
            'username'       => $request->username,
            'email'          => $request->email,
            'contact_number' => $request->contact_number,
        ];

        if ($request->filled('role')) {
            $updateData['role'] = $request->role;
        }

        $staff->update($updateData);

        return back()->with('success', "Account '{$staff->name}' updated successfully!");
    }

    /**
     * Delete an account.
     */
    public function destroyStaff($id)
    {
        $staff = User::findOrFail($id);

        if (method_exists($staff, 'isSuperAdmin') && $staff->isSuperAdmin()) {
            return back()->with('error', 'Super Admin accounts cannot be deleted.');
        }

        $staff->delete();

        return back()->with('success', 'Account deleted successfully!');
    }
}