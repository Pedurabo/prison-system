<?php

namespace App\Http\Controllers;

use App\Models\Inmate;
use App\Models\Staff;
use App\Models\Department;
use App\Models\SecurityIncident;
use App\Models\Visit;
use App\Models\MedicalRecord;
use App\Models\RehabilitationProgram;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic statistics
        $totalInmates = Inmate::active()->count();
        $totalStaff = Staff::active()->count();
        $totalDepartments = Department::active()->count();

        // Security statistics
        $openIncidents = SecurityIncident::open()->count();
        $criticalIncidents = SecurityIncident::highPriority()->count();
        $recentIncidents = SecurityIncident::recentIncidents()->count();

        // Medical statistics
        $followUpRequired = MedicalRecord::requiresFollowUp()->count();
        $recentMedicalVisits = MedicalRecord::recentVisits()->count();

        // Visit statistics
        $pendingVisits = Visit::pending()->count();
        $todaysVisits = Visit::today()->count();
        $upcomingVisits = Visit::upcoming()->count();

        // Rehabilitation statistics
        $activePrograms = RehabilitationProgram::active()->count();
        $upcomingPrograms = RehabilitationProgram::upcoming()->count();

        // Upcoming releases
        $upcomingReleases = Inmate::releaseInNext(30)->count();

        // Security level distribution
        $securityLevels = Inmate::active()
            ->selectRaw('security_level, COUNT(*) as count')
            ->groupBy('security_level')
            ->pluck('count', 'security_level')
            ->toArray();

        // Department staff distribution
        $departmentStats = Department::with('staff')->active()->get()->map(function($dept) {
            return [
                'name' => $dept->name,
                'staff_count' => $dept->staff()->active()->count(),
                'budget' => $dept->budget
            ];
        });

        return view('dashboard', compact(
            'totalInmates', 'totalStaff', 'totalDepartments',
            'openIncidents', 'criticalIncidents', 'recentIncidents',
            'followUpRequired', 'recentMedicalVisits',
            'pendingVisits', 'todaysVisits', 'upcomingVisits',
            'activePrograms', 'upcomingPrograms', 'upcomingReleases',
            'securityLevels', 'departmentStats'
        ));
    }

    public function securityDashboard()
    {
        $securityIncidents = SecurityIncident::with('reportedByStaff', 'inmate', 'department')
            ->latest('incident_date')
            ->limit(10)
            ->get();

        $incidentTypes = SecurityIncident::selectRaw('incident_type, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('incident_type')
            ->pluck('count', 'incident_type')
            ->toArray();

        return view('dashboards.security', compact('securityIncidents', 'incidentTypes'));
    }

    public function medicalDashboard()
    {
        $recentMedicalRecords = MedicalRecord::with('inmate', 'attendingStaff')
            ->latest('visit_date')
            ->limit(10)
            ->get();

        $followUpRequired = MedicalRecord::requiresFollowUp()
            ->with('inmate', 'attendingStaff')
            ->get();

        return view('dashboards.medical', compact('recentMedicalRecords', 'followUpRequired'));
    }

    public function inmateManagementDashboard()
    {
        $recentAdmissions = Inmate::where('admission_date', '>=', now()->subDays(7))
            ->latest('admission_date')
            ->get();

        $upcomingReleases = Inmate::releaseInNext(30)->get();

        $blockDistribution = Inmate::active()
            ->selectRaw('block, COUNT(*) as count')
            ->groupBy('block')
            ->pluck('count', 'block')
            ->toArray();

        return view('dashboards.inmate-management', compact(
            'recentAdmissions', 'upcomingReleases', 'blockDistribution'
        ));
    }
}
