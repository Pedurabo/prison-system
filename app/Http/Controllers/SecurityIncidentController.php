<?php

namespace App\Http\Controllers;

use App\Models\SecurityIncident;
use App\Models\Staff;
use App\Models\Inmate;
use App\Models\Department;
use Illuminate\Http\Request;

class SecurityIncidentController extends Controller
{
    public function index()
    {
        $incidents = SecurityIncident::with('reportedByStaff', 'inmate', 'department')
            ->latest('incident_date')
            ->paginate(15);

        return view('security-incidents.index', compact('incidents'));
    }

    public function create()
    {
        $staff = Staff::active()->get();
        $inmates = Inmate::active()->get();
        $departments = Department::active()->get();

        return view('security-incidents.create', compact('staff', 'inmates', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'incident_number' => 'required|string|unique:security_incidents',
            'incident_type' => 'required|in:fight,contraband,escape_attempt,self_harm,assault,disturbance,other',
            'severity_level' => 'required|in:low,medium,high,critical',
            'location' => 'required|string',
            'description' => 'required|string',
            'incident_date' => 'required|date',
            'reported_by_staff_id' => 'required|exists:staff,id',
            'inmate_id' => 'nullable|exists:inmates,id',
            'department_id' => 'required|exists:departments,id',
        ]);

        SecurityIncident::create($request->all());

        return redirect()->route('security-incidents.index')
            ->with('success', 'Security incident reported successfully.');
    }

    public function show(SecurityIncident $securityIncident)
    {
        $securityIncident->load('reportedByStaff', 'resolvedByStaff', 'inmate', 'department');
        return view('security-incidents.show', compact('securityIncident'));
    }

    public function edit(SecurityIncident $securityIncident)
    {
        $staff = Staff::active()->get();
        $inmates = Inmate::active()->get();
        $departments = Department::active()->get();

        return view('security-incidents.edit', compact('securityIncident', 'staff', 'inmates', 'departments'));
    }

    public function update(Request $request, SecurityIncident $securityIncident)
    {
        $request->validate([
            'incident_number' => 'required|string|unique:security_incidents,incident_number,' . $securityIncident->id,
            'incident_type' => 'required|in:fight,contraband,escape_attempt,self_harm,assault,disturbance,other',
            'severity_level' => 'required|in:low,medium,high,critical',
            'location' => 'required|string',
            'description' => 'required|string',
            'incident_date' => 'required|date',
            'reported_by_staff_id' => 'required|exists:staff,id',
            'inmate_id' => 'nullable|exists:inmates,id',
            'department_id' => 'required|exists:departments,id',
            'investigation_notes' => 'nullable|string',
            'resolution' => 'nullable|string',
            'resolved_date' => 'nullable|date',
            'resolved_by_staff_id' => 'nullable|exists:staff,id',
        ]);

        $securityIncident->update($request->all());

        return redirect()->route('security-incidents.index')
            ->with('success', 'Security incident updated successfully.');
    }

    public function destroy(SecurityIncident $securityIncident)
    {
        $securityIncident->delete();
        return redirect()->route('security-incidents.index')
            ->with('success', 'Security incident deleted successfully.');
    }

    public function resolve(SecurityIncident $securityIncident)
    {
        return view('security-incidents.resolve', compact('securityIncident'));
    }

    public function markResolved(Request $request, SecurityIncident $securityIncident)
    {
        $request->validate([
            'resolution' => 'required|string',
            'resolved_by_staff_id' => 'required|exists:staff,id',
        ]);

        $securityIncident->update([
            'status' => 'resolved',
            'resolution' => $request->resolution,
            'resolved_date' => now(),
            'resolved_by_staff_id' => $request->resolved_by_staff_id,
        ]);

        return redirect()->route('security-incidents.index')
            ->with('success', 'Security incident marked as resolved.');
    }
}
