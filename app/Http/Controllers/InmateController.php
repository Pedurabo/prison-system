<?php

namespace App\Http\Controllers;

use App\Models\Inmate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InmateController extends Controller
{
    public function index(Request $request)
    {
        $query = Inmate::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('inmate_number', 'like', "%{$search}%");
            });
        }

        // Filter by security level
        if ($request->filled('security_level')) {
            $query->where('security_level', $request->security_level);
        }

        // Filter by block
        if ($request->filled('block')) {
            $query->where('block', $request->block);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->active();
        }

        $inmates = $query->latest()->paginate(15);
        return view('inmates.index', compact('inmates'));
    }

    public function create()
    {
        return view('inmates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'inmate_number' => 'required|string|unique:inmates',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'admission_date' => 'required|date',
            'release_date' => 'nullable|date|after:admission_date',
            'sentence_length' => 'required|string',
            'crime_category' => 'required|string',
            'security_level' => 'required|in:minimum,medium,maximum,supermax',
            'cell_number' => 'required|string',
            'block' => 'required|string',
            'nationality' => 'required|string',
            'address_before_incarceration' => 'required|string',
            'emergency_contact' => 'required|string',
            'next_of_kin' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('inmate-photos', 'public');
            $data['photo_path'] = $photoPath;
        }

        Inmate::create($data);

        return redirect()->route('inmates.index')
            ->with('success', 'Inmate registered successfully.');
    }

    public function show(Inmate $inmate)
    {
        $inmate->load('securityIncidents', 'medicalRecords', 'rehabilitationPrograms', 'visits');
        return view('inmates.show', compact('inmate'));
    }

    public function edit(Inmate $inmate)
    {
        return view('inmates.edit', compact('inmate'));
    }

    public function update(Request $request, Inmate $inmate)
    {
        $request->validate([
            'inmate_number' => 'required|string|unique:inmates,inmate_number,' . $inmate->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'admission_date' => 'required|date',
            'release_date' => 'nullable|date|after:admission_date',
            'sentence_length' => 'required|string',
            'crime_category' => 'required|string',
            'security_level' => 'required|in:minimum,medium,maximum,supermax',
            'cell_number' => 'required|string',
            'block' => 'required|string',
            'status' => 'required|in:active,released,transferred,deceased',
            'nationality' => 'required|string',
            'address_before_incarceration' => 'required|string',
            'emergency_contact' => 'required|string',
            'next_of_kin' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($inmate->photo_path) {
                Storage::disk('public')->delete($inmate->photo_path);
            }

            $photoPath = $request->file('photo')->store('inmate-photos', 'public');
            $data['photo_path'] = $photoPath;
        }

        $inmate->update($data);

        return redirect()->route('inmates.index')
            ->with('success', 'Inmate information updated successfully.');
    }

    public function destroy(Inmate $inmate)
    {
        $inmate->delete();
        return redirect()->route('inmates.index')
            ->with('success', 'Inmate record deleted successfully.');
    }

    public function upcomingReleases()
    {
        $upcomingReleases = Inmate::releaseInNext(30)->get();
        return view('inmates.upcoming-releases', compact('upcomingReleases'));
    }

    public function bySecurityLevel($level)
    {
        $inmates = Inmate::bySecurityLevel($level)->active()->paginate(15);
        return view('inmates.by-security-level', compact('inmates', 'level'));
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:inmates,id'
        ]);

        $deletedCount = Inmate::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => "Successfully deleted {$deletedCount} inmate(s)."
        ]);
    }

    public function export($format, Request $request)
    {
        $query = Inmate::query();

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('inmate_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('security_level')) {
            $query->where('security_level', $request->security_level);
        }

        if ($request->filled('block')) {
            $query->where('block', $request->block);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $inmates = $query->get();

        if ($format === 'pdf') {
            return $this->exportToPdf($inmates);
        } else {
            return $this->exportToExcel($inmates);
        }
    }

    private function exportToPdf($inmates)
    {
        // Simple PDF export - you can enhance this with a proper PDF library
        $content = "Inmate Report\n\n";
        $content .= "Generated: " . now()->format('Y-m-d H:i:s') . "\n\n";

        foreach ($inmates as $inmate) {
            $content .= "Inmate #: {$inmate->inmate_number}\n";
            $content .= "Name: {$inmate->full_name}\n";
            $content .= "Security Level: {$inmate->security_level}\n";
            $content .= "Status: {$inmate->status}\n";
            $content .= "Cell: {$inmate->cell_number} (Block {$inmate->block})\n";
            $content .= "Admission: {$inmate->admission_date->format('Y-m-d')}\n";
            $content .= "Release: " . ($inmate->release_date ? $inmate->release_date->format('Y-m-d') : 'Not set') . "\n\n";
        }

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="inmates-report.txt"');
    }

    private function exportToExcel($inmates)
    {
        // Simple CSV export - you can enhance this with a proper Excel library
        $headers = [
            'Inmate Number',
            'First Name',
            'Last Name',
            'Date of Birth',
            'Gender',
            'Security Level',
            'Status',
            'Cell Number',
            'Block',
            'Admission Date',
            'Release Date',
            'Crime Category',
            'Nationality'
        ];

        $csv = implode(',', $headers) . "\n";

        foreach ($inmates as $inmate) {
            $row = [
                $inmate->inmate_number,
                $inmate->first_name,
                $inmate->last_name,
                $inmate->date_of_birth->format('Y-m-d'),
                $inmate->gender,
                $inmate->security_level,
                $inmate->status,
                $inmate->cell_number,
                $inmate->block,
                $inmate->admission_date->format('Y-m-d'),
                $inmate->release_date ? $inmate->release_date->format('Y-m-d') : '',
                $inmate->crime_category,
                $inmate->nationality
            ];
            $csv .= implode(',', $row) . "\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="inmates-report.csv"');
    }

    public function securityLevelChart()
    {
        $data = Inmate::selectRaw('security_level, COUNT(*) as count')
            ->groupBy('security_level')
            ->get();

        return response()->json([
            'labels' => $data->pluck('security_level')->map(fn($level) => ucfirst($level)),
            'data' => $data->pluck('count')
        ]);
    }

    public function releaseChart()
    {
        $data = Inmate::whereNotNull('release_date')
            ->where('release_date', '>=', now()->subMonths(6))
            ->where('release_date', '<=', now()->addMonths(6))
            ->selectRaw('DATE(release_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'labels' => $data->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('M d')),
            'data' => $data->pluck('count')
        ]);
    }

    public function blockChart()
    {
        $data = Inmate::selectRaw('block, COUNT(*) as count')
            ->groupBy('block')
            ->orderBy('block')
            ->get();

        return response()->json([
            'labels' => $data->pluck('block')->map(fn($block) => "Block {$block}"),
            'data' => $data->pluck('count')
        ]);
    }
}
