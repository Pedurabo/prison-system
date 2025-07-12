<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Department;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::with('department')
            ->active()
            ->paginate(15);

        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        $departments = Department::active()->get();
        return view('staff.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|string|unique:staff',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff',
            'phone' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'position' => 'required|string',
            'hire_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'address' => 'required|string',
            'emergency_contact' => 'required|string',
        ]);

        Staff::create($request->all());

        return redirect()->route('staff.index')
            ->with('success', 'Staff member created successfully.');
    }

    public function show(Staff $staff)
    {
        $staff->load('department', 'securityIncidents', 'medicalRecords');
        return view('staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $departments = Department::active()->get();
        return view('staff.edit', compact('staff', 'departments'));
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'employee_id' => 'required|string|unique:staff,employee_id,' . $staff->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'phone' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'position' => 'required|string',
            'hire_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'address' => 'required|string',
            'emergency_contact' => 'required|string',
        ]);

        $staff->update($request->all());

        return redirect()->route('staff.index')
            ->with('success', 'Staff member updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index')
            ->with('success', 'Staff member deleted successfully.');
    }

    public function securityStaff()
    {
        $securityStaff = Staff::security()->active()->get();
        return view('staff.security', compact('securityStaff'));
    }
}
