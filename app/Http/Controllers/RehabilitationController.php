<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RehabilitationProgram;
use App\Models\Inmate;

class RehabilitationController extends Controller
{
    public function dashboard()
    {
        $totalPrograms = RehabilitationProgram::count();
        $activePrograms = RehabilitationProgram::where('status', 'active')->count();
        $totalEnrollments = RehabilitationProgram::withCount('inmates')->get()->sum('inmates_count');
        $completionRate = $this->calculateCompletionRate();

        $recentPrograms = RehabilitationProgram::latest()->take(5)->get();

        return view('rehabilitation.dashboard', compact(
            'totalPrograms',
            'activePrograms',
            'totalEnrollments',
            'completionRate',
            'recentPrograms'
        ));
    }

    public function programs()
    {
        $programs = RehabilitationProgram::withCount('inmates')->paginate(15);
        return view('rehabilitation-programs.index', compact('programs'));
    }

    public function create()
    {
        $inmates = Inmate::all();
        return view('rehabilitation-programs.create', compact('inmates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|integer',
            'capacity' => 'required|integer',
            'status' => 'required|in:active,inactive,completed',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        RehabilitationProgram::create($validated);

        return redirect()->route('rehabilitation.programs')->with('success', 'Rehabilitation program created successfully.');
    }

    private function calculateCompletionRate()
    {
        $totalPrograms = RehabilitationProgram::count();
        $completedPrograms = RehabilitationProgram::where('status', 'completed')->count();

        return $totalPrograms > 0 ? round(($completedPrograms / $totalPrograms) * 100, 1) : 0;
    }
}
