<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Inmate;
use App\Models\Staff;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $medicalRecords = MedicalRecord::with('inmate', 'attendingStaff')
            ->latest('visit_date')
            ->paginate(15);

        return view('medical-records.index', compact('medicalRecords'));
    }

    public function create()
    {
        $inmates = Inmate::active()->get();
        $medicalStaff = Staff::whereHas('department', function($q) {
            $q->where('name', 'like', '%Medical%');
        })->active()->get();

        return view('medical-records.create', compact('inmates', 'medicalStaff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inmate_id' => 'required|exists:inmates,id',
            'attending_staff_id' => 'required|exists:staff,id',
            'visit_date' => 'required|date',
            'symptoms' => 'required|string',
            'treatment' => 'required|string',
            'emergency_contact' => 'required|string',
        ]);

        MedicalRecord::create($request->all());

        return redirect()->route('medical-records.index')
            ->with('success', 'Medical record created successfully.');
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load('inmate', 'attendingStaff');
        return view('medical-records.show', compact('medicalRecord'));
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        $inmates = Inmate::active()->get();
        $medicalStaff = Staff::whereHas('department', function($q) {
            $q->where('name', 'like', '%Medical%');
        })->active()->get();

        return view('medical-records.edit', compact('medicalRecord', 'inmates', 'medicalStaff'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $request->validate([
            'inmate_id' => 'required|exists:inmates,id',
            'attending_staff_id' => 'required|exists:staff,id',
            'visit_date' => 'required|date',
            'symptoms' => 'required|string',
            'treatment' => 'required|string',
            'emergency_contact' => 'required|string',
        ]);

        $medicalRecord->update($request->all());

        return redirect()->route('medical-records.index')
            ->with('success', 'Medical record updated successfully.');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();
        return redirect()->route('medical-records.index')
            ->with('success', 'Medical record deleted successfully.');
    }

    public function followUpRequired()
    {
        $followUpRecords = MedicalRecord::requiresFollowUp()->with('inmate', 'attendingStaff')->get();
        return view('medical-records.follow-up', compact('followUpRecords'));
    }

    public function inmateHistory(Inmate $inmate)
    {
        $medicalHistory = $inmate->medicalRecords()->with('attendingStaff')->latest('visit_date')->get();
        return view('medical-records.inmate-history', compact('inmate', 'medicalHistory'));
    }
}
