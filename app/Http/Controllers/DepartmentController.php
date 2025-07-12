<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Staff;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('departmentHead', 'staff')
            ->paginate(15);

        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        $staff = Staff::all();
        return view('departments.create', compact('staff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'department_head_id' => 'nullable|exists:staff,id',
            'budget' => 'required|numeric|min:0',
            'established_date' => 'required|date',
        ]);

        Department::create($request->all());

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function show(Department $department)
    {
        $department->load('departmentHead', 'staff', 'securityIncidents');
        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        $staff = Staff::all();
        return view('departments.edit', compact('department', 'staff'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'department_head_id' => 'nullable|exists:staff,id',
            'budget' => 'required|numeric|min:0',
            'established_date' => 'required|date',
        ]);

        $department->update($request->all());

        return redirect()->route('departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully.');
    }

    public function staffReport(Department $department)
    {
        $staff = $department->staff()->get();
        return view('departments.staff-report', compact('department', 'staff'));
    }
}
