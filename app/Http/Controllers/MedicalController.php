<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\Inmate;

class MedicalController extends Controller
{
    public function dashboard()
    {
        $totalRecords = MedicalRecord::count();
        $pendingFollowUps = MedicalRecord::where('follow_up_required', true)->count();
        $todayAppointments = MedicalRecord::whereDate('created_at', today())->count();
        $criticalCases = MedicalRecord::where('severity', 'critical')->count();

        $recentRecords = MedicalRecord::with('inmate')->latest()->take(5)->get();

        return view('medical.dashboard', compact(
            'totalRecords',
            'pendingFollowUps',
            'todayAppointments',
            'criticalCases',
            'recentRecords'
        ));
    }

    public function records()
    {
        $records = MedicalRecord::with('inmate')->paginate(15);
        return view('medical-records.index', compact('records'));
    }

    public function create()
    {
        $inmates = Inmate::all();
        return view('medical-records.create', compact('inmates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inmate_id' => 'required|exists:inmates,id',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'severity' => 'required|in:low,medium,high,critical',
            'follow_up_required' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        MedicalRecord::create($validated);

        return redirect()->route('medical.records')->with('success', 'Medical record created successfully.');
    }
}
