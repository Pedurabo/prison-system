<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Inmate;
use App\Models\Staff;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function index()
    {
        $visits = Visit::with('inmate', 'approvedByStaff')
            ->latest('visit_date')
            ->paginate(15);

        return view('visits.index', compact('visits'));
    }

    public function create()
    {
        $inmates = Inmate::active()->get();
        return view('visits.create', compact('inmates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inmate_id' => 'required|exists:inmates,id',
            'visitor_name' => 'required|string|max:255',
            'visitor_relationship' => 'required|string',
            'visitor_id_number' => 'required|string',
            'visitor_phone' => 'required|string',
            'visit_date' => 'required|date|after_or_equal:today',
            'visit_time' => 'required|date_format:H:i',
            'duration_minutes' => 'required|integer|min:15|max:120',
            'visit_type' => 'required|in:family,legal,official,religious',
            'visitor_address' => 'required|string',
        ]);

        $visitDateTime = $request->visit_date . ' ' . $request->visit_time;

        $visitData = $request->all();
        $visitData['visit_time'] = $visitDateTime;

        Visit::create($visitData);

        return redirect()->route('visits.index')
            ->with('success', 'Visit request submitted successfully.');
    }

    public function show(Visit $visit)
    {
        $visit->load('inmate', 'approvedByStaff');
        return view('visits.show', compact('visit'));
    }

    public function edit(Visit $visit)
    {
        $inmates = Inmate::active()->get();
        return view('visits.edit', compact('visit', 'inmates'));
    }

    public function update(Request $request, Visit $visit)
    {
        $request->validate([
            'inmate_id' => 'required|exists:inmates,id',
            'visitor_name' => 'required|string|max:255',
            'visitor_relationship' => 'required|string',
            'visitor_id_number' => 'required|string',
            'visitor_phone' => 'required|string',
            'visit_date' => 'required|date|after_or_equal:today',
            'visit_time' => 'required|date_format:H:i',
            'duration_minutes' => 'required|integer|min:15|max:120',
            'visit_type' => 'required|in:family,legal,official,religious',
            'visitor_address' => 'required|string',
        ]);

        $visitDateTime = $request->visit_date . ' ' . $request->visit_time;

        $visitData = $request->all();
        $visitData['visit_time'] = $visitDateTime;

        $visit->update($visitData);

        return redirect()->route('visits.index')
            ->with('success', 'Visit updated successfully.');
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();
        return redirect()->route('visits.index')
            ->with('success', 'Visit deleted successfully.');
    }

    public function approve(Request $request, Visit $visit)
    {
        $request->validate([
            'approved_by_staff_id' => 'required|exists:staff,id',
        ]);

        $visit->update([
            'status' => 'approved',
            'approved_by_staff_id' => $request->approved_by_staff_id,
        ]);

        return redirect()->back()->with('success', 'Visit approved successfully.');
    }

    public function reject(Visit $visit)
    {
        $visit->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Visit rejected.');
    }

    public function pendingApprovals()
    {
        $pendingVisits = Visit::pending()->with('inmate')->get();
        $staff = Staff::active()->get();
        return view('visits.pending', compact('pendingVisits', 'staff'));
    }

    public function todaysVisits()
    {
        $todaysVisits = Visit::today()->approved()->with('inmate', 'approvedByStaff')->get();
        return view('visits.today', compact('todaysVisits'));
    }
}
