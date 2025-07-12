<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceRequest;
use App\Models\Department;

class MaintenanceController extends Controller
{
    public function dashboard()
    {
        $totalRequests = MaintenanceRequest::count();
        $pendingRequests = MaintenanceRequest::where('status', 'pending')->count();
        $inProgressRequests = MaintenanceRequest::where('status', 'in_progress')->count();
        $completedRequests = MaintenanceRequest::where('status', 'completed')->count();

        $recentRequests = MaintenanceRequest::with('department')->latest()->take(5)->get();

        return view('maintenance.dashboard', compact(
            'totalRequests',
            'pendingRequests',
            'inProgressRequests',
            'completedRequests',
            'recentRequests'
        ));
    }

    public function requests()
    {
        $requests = MaintenanceRequest::with('department')->paginate(15);
        return view('maintenance-requests.index', compact('requests'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('maintenance-requests.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'location' => 'required|string',
            'estimated_cost' => 'nullable|numeric',
        ]);

        $validated['status'] = 'pending';
        $validated['requested_by'] = auth()->user()->id;

        MaintenanceRequest::create($validated);

        return redirect()->route('maintenance.requests')->with('success', 'Maintenance request created successfully.');
    }

    public function updateStatus(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $maintenanceRequest->update($validated);

        return redirect()->back()->with('success', 'Request status updated successfully.');
    }
}
