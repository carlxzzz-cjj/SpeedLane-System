<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceOption;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManageServiceController extends Controller
{
    private function authorizeSuperAdmin()
    {
        if (!auth()->check() || !auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access. Only Super Admins can manage services.');
        }
    }

    public function index()
    {
        $this->authorizeSuperAdmin();

        $services = Service::with('options')->latest()->get();
        $technicians = Technician::latest()->get();
        $staffs = User::latest()->get();

        return view('admin.manage-services', compact('services', 'technicians', 'staffs'));
    }

    public function storeService(Request $request)
    {
        $this->authorizeSuperAdmin();

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'notice'         => 'nullable|string',
            'selection_type' => 'required|in:single,multi,flat',
            'flat_price'     => 'nullable|numeric|min:0',
            'options'        => 'nullable|array',
            'options.*.name' => 'required_with:options|string',
            'options.*.price'=> 'required_with:options|numeric|min:0',
        ]);

        $service = Service::create([
            'name'           => $validated['name'],
            'description'    => $validated['description'] ?? null,
            'notice'         => $validated['notice'] ?? null,
            'selection_type' => $validated['selection_type'],
            'flat_price'     => $validated['flat_price'] ?? 0,
        ]);

        if ($validated['selection_type'] !== 'flat' && !empty($validated['options'])) {
            foreach ($validated['options'] as $option) {
                $service->options()->create([
                    'name'  => $option['name'],
                    'price' => $option['price'] ?? 0,
                ]);
            }
        }

        return back()->with('success', 'Service added successfully!');
    }

    public function updateService(Request $request, $id)
    {
        $this->authorizeSuperAdmin();

        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'notice'         => 'nullable|string',
            'selection_type' => 'required|in:single,multi,flat',
            'flat_price'     => 'nullable|numeric|min:0',
            'options'        => 'nullable|array',
            'options.*.name' => 'required_with:options|string',
            'options.*.price'=> 'required_with:options|numeric|min:0',
        ]);

        $service->update([
            'name'           => $validated['name'],
            'description'    => $validated['description'] ?? null,
            'notice'         => $validated['notice'] ?? null,
            'selection_type' => $validated['selection_type'],
            'flat_price'     => $validated['flat_price'] ?? 0,
        ]);

        $service->options()->delete();

        if ($validated['selection_type'] !== 'flat' && !empty($validated['options'])) {
            foreach ($validated['options'] as $option) {
                $service->options()->create([
                    'name'  => $option['name'],
                    'price' => $option['price'] ?? 0,
                ]);
            }
        }

        return back()->with('success', 'Service details updated successfully!');
    }

    public function destroyService($id)
    {
        $this->authorizeSuperAdmin();

        $service = Service::findOrFail($id);
        $service->options()->delete();
        $service->delete();

        return back()->with('success', 'Service deleted successfully.');
    }

    public function storeTechnician(Request $request)
    {
        $this->authorizeSuperAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Technician::create($validated);

        return back()->with('success', 'Technician added to roster.');
    }

    public function toggleTechnicianStatus($id)
    {
        $this->authorizeSuperAdmin();

        $technician = Technician::findOrFail($id);
        $technician->update([
            'is_active' => !$technician->is_active
        ]);

        $status = $technician->is_active ? 'enabled' : 'disabled';
        return redirect()->back()->with('success', "Technician {$technician->name} has been {$status}.");
    }

    public function destroyTechnician($id)
    {
        $this->authorizeSuperAdmin();

        Technician::findOrFail($id)->delete();
        return back()->with('success', 'Technician removed from roster.');
    }

    public function storeStaff(Request $request)
    {
        $this->authorizeSuperAdmin();

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'username'       => 'required|string|max:255|unique:users,username',
            'email'          => 'required|email|max:255|unique:users,email',
            'contact_number' => 'required|string|max:255',
            'password'       => 'required|string|min:8',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return back()->with('success', 'Staff account created successfully.');
    }

    public function updateStaff(Request $request, $id)
    {
        $this->authorizeSuperAdmin();

        $staff = User::findOrFail($id);

        if (method_exists($staff, 'isSuperAdmin') && $staff->isSuperAdmin()) {
            return back()->with('error', 'Super Admin accounts cannot be edited from this roster.');
        }

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255|unique:users,email,' . $staff->id,
            'contact_number' => 'required|string|max:255',
            'username'       => 'required|string|max:255|unique:users,username,' . $staff->id,
        ]);

        $staff->update($validated);

        return back()->with('success', 'Staff account details updated successfully.');
    }

    public function destroyStaff($id)
    {
        $this->authorizeSuperAdmin();

        $staff = User::findOrFail($id);

        if (method_exists($staff, 'isSuperAdmin') && $staff->isSuperAdmin()) {
            return back()->with('error', 'Super Admin accounts cannot be deleted.');
        }

        $staff->delete();

        return back()->with('success', 'Staff account deleted successfully.');
    }
}