<?php

namespace App\Http\Controllers;

use App\Models\RehabilitationProgram;
use App\Models\Staff;
use App\Models\Inmate;
use Illuminate\Http\Request;

class RehabilitationProgramController extends Controller
{
    public function index()
    {
        $programs = RehabilitationProgram::with('instructor')
            ->latest('start_date')
            ->paginate(15);

        return view('rehabilitation-programs.index', compact('programs'));
    }

    public function create()
    {
        $instructors = Staff::active()->get();
        return view('rehabilitation-programs.create', compact('instructors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_name' => 'required|string|max:255',
            'program_type' => 'required|in:substance_abuse,education,vocational_training,anger_management,life_skills,other',
            'description' => 'required|string',
            'instructor_staff_id' => 'required|exists:staff,id',
            'capacity' => 'required|integer|min:1',
            'duration_weeks' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string',
        ]);

        RehabilitationProgram::create($request->all());

        return redirect()->route('rehabilitation-programs.index')
            ->with('success', 'Rehabilitation program created successfully.');
    }

    public function show(RehabilitationProgram $rehabilitationProgram)
    {
        $rehabilitationProgram->load('instructor', 'inmates');
        return view('rehabilitation-programs.show', compact('rehabilitationProgram'));
    }

    public function edit(RehabilitationProgram $rehabilitationProgram)
    {
        $instructors = Staff::active()->get();
        return view('rehabilitation-programs.edit', compact('rehabilitationProgram', 'instructors'));
    }

    public function update(Request $request, RehabilitationProgram $rehabilitationProgram)
    {
        $request->validate([
            'program_name' => 'required|string|max:255',
            'program_type' => 'required|in:substance_abuse,education,vocational_training,anger_management,life_skills,other',
            'description' => 'required|string',
            'instructor_staff_id' => 'required|exists:staff,id',
            'capacity' => 'required|integer|min:1',
            'duration_weeks' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string',
        ]);

        $rehabilitationProgram->update($request->all());

        return redirect()->route('rehabilitation-programs.index')
            ->with('success', 'Rehabilitation program updated successfully.');
    }

    public function destroy(RehabilitationProgram $rehabilitationProgram)
    {
        $rehabilitationProgram->delete();
        return redirect()->route('rehabilitation-programs.index')
            ->with('success', 'Rehabilitation program deleted successfully.');
    }

    public function enrollInmate(Request $request, RehabilitationProgram $rehabilitationProgram)
    {
        $request->validate([
            'inmate_id' => 'required|exists:inmates,id',
            'enrollment_date' => 'required|date',
        ]);

        $rehabilitationProgram->inmates()->attach($request->inmate_id, [
            'enrollment_date' => $request->enrollment_date,
            'status' => 'enrolled'
        ]);

        return redirect()->back()->with('success', 'Inmate enrolled successfully.');
    }

    public function unenrollInmate(RehabilitationProgram $rehabilitationProgram, Inmate $inmate)
    {
        $rehabilitationProgram->inmates()->detach($inmate->id);
        return redirect()->back()->with('success', 'Inmate unenrolled successfully.');
    }

    public function enrollments(RehabilitationProgram $rehabilitationProgram)
    {
        $rehabilitationProgram->load('inmates');

        // Get available inmates (not already enrolled in this program)
        $enrolledInmateIds = $rehabilitationProgram->inmates->pluck('id')->toArray();
        $availableInmates = Inmate::active()
            ->whereNotIn('id', $enrolledInmateIds)
            ->get();

        return view('rehabilitation-programs.enrollments', compact('rehabilitationProgram', 'availableInmates'));
    }

    public function updateEnrollmentStatus(Request $request, RehabilitationProgram $rehabilitationProgram, Inmate $inmate)
    {
        $request->validate([
            'status' => 'required|in:enrolled,in_progress,completed,dropped,suspended',
            'completion_date' => 'nullable|date',
            'progress_notes' => 'nullable|string'
        ]);

        $data = [
            'status' => $request->status,
            'progress_notes' => $request->progress_notes
        ];

        if ($request->status === 'completed' && $request->completion_date) {
            $data['completion_date'] = $request->completion_date;
        }

        $rehabilitationProgram->inmates()->updateExistingPivot($inmate->id, $data);

        return redirect()->back()->with('success', 'Enrollment status updated successfully.');
    }

    public function export(RehabilitationProgram $rehabilitationProgram)
    {
        $rehabilitationProgram->load('inmates');

        $filename = "program_{$rehabilitationProgram->id}_enrollments_" . date('Y-m-d') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($rehabilitationProgram) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, ['Inmate ID', 'Name', 'Enrollment Date', 'Status', 'Completion Date', 'Progress Notes']);

            foreach ($rehabilitationProgram->inmates as $inmate) {
                fputcsv($file, [
                    $inmate->inmate_number,
                    $inmate->full_name,
                    $inmate->pivot->enrollment_date,
                    $inmate->pivot->status,
                    $inmate->pivot->completion_date ?? '',
                    $inmate->pivot->progress_notes ?? ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function report(RehabilitationProgram $rehabilitationProgram)
    {
        $rehabilitationProgram->load('inmates');

        $stats = [
            'total_enrolled' => $rehabilitationProgram->inmates->count(),
            'completed' => $rehabilitationProgram->inmates->where('pivot.status', 'completed')->count(),
            'in_progress' => $rehabilitationProgram->inmates->where('pivot.status', 'in_progress')->count(),
            'dropped' => $rehabilitationProgram->inmates->where('pivot.status', 'dropped')->count(),
            'completion_rate' => $rehabilitationProgram->inmates->count() > 0 ?
                round(($rehabilitationProgram->inmates->where('pivot.status', 'completed')->count() / $rehabilitationProgram->inmates->count()) * 100, 1) : 0
        ];

        return view('rehabilitation-programs.report', compact('rehabilitationProgram', 'stats'));
    }
}
