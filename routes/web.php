<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\InmateController;
use App\Http\Controllers\SecurityIncidentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\RehabilitationProgramController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);

// Test route to check if admin exists
Route::get('/test-admin', function() {
    $admin = App\Models\User::where('role', 'admin')->first();
    if ($admin) {
        return response()->json([
            'admin_exists' => true,
            'email' => $admin->email,
            'name' => $admin->name
        ]);
    }
    return response()->json(['admin_exists' => false]);
});

// Main Dashboard Routes
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.main');

// Specialized Dashboards
Route::get('/dashboard/security', [DashboardController::class, 'securityDashboard'])->name('dashboard.security');
Route::get('/dashboard/medical', [DashboardController::class, 'medicalDashboard'])->name('dashboard.medical');
Route::get('/dashboard/inmate-management', [DashboardController::class, 'inmateManagementDashboard'])->name('dashboard.inmate-management');

// Department Management Routes
Route::resource('departments', DepartmentController::class);
Route::get('/departments/{department}/staff-report', [DepartmentController::class, 'staffReport'])->name('departments.staff-report');

// Staff Management Routes
Route::resource('staff', StaffController::class);
Route::get('/staff/security/list', [StaffController::class, 'securityStaff'])->name('staff.security');

// Inmate Management Routes
Route::resource('inmates', InmateController::class);
Route::get('/inmates/reports/upcoming-releases', [InmateController::class, 'upcomingReleases'])->name('inmates.upcoming-releases');
Route::get('/inmates/security-level/{level}', [InmateController::class, 'bySecurityLevel'])->name('inmates.by-security-level');
Route::post('/inmates/bulk-delete', [InmateController::class, 'bulkDelete'])->name('inmates.bulk-delete');
Route::get('/inmates/export/{format}', [InmateController::class, 'export'])->name('inmates.export');
Route::get('/inmates/security-level-chart', [InmateController::class, 'securityLevelChart'])->name('inmates.security-level-chart');
Route::get('/inmates/release-chart', [InmateController::class, 'releaseChart'])->name('inmates.release-chart');
Route::get('/inmates/block-chart', [InmateController::class, 'blockChart'])->name('inmates.block-chart');

// Security Department Routes
Route::resource('security-incidents', SecurityIncidentController::class);
Route::get('/security-incidents/{securityIncident}/resolve', [SecurityIncidentController::class, 'resolve'])->name('security-incidents.resolve');
Route::patch('/security-incidents/{securityIncident}/mark-resolved', [SecurityIncidentController::class, 'markResolved'])->name('security-incidents.mark-resolved');

// Medical Department Routes
Route::resource('medical-records', MedicalRecordController::class);
Route::get('/medical-records/reports/follow-up', [MedicalRecordController::class, 'followUpRequired'])->name('medical-records.follow-up');
Route::get('/medical-records/inmate/{inmate}/history', [MedicalRecordController::class, 'inmateHistory'])->name('medical-records.inmate-history');

// Rehabilitation Programs Routes
Route::resource('rehabilitation-programs', RehabilitationProgramController::class);
Route::post('/rehabilitation-programs/{rehabilitationProgram}/enroll', [RehabilitationProgramController::class, 'enrollInmate'])->name('rehabilitation-programs.enroll');
Route::delete('/rehabilitation-programs/{rehabilitationProgram}/inmates/{inmate}', [RehabilitationProgramController::class, 'unenrollInmate'])->name('rehabilitation-programs.unenroll');
Route::get('/rehabilitation-programs/{rehabilitationProgram}/enrollments', [RehabilitationProgramController::class, 'enrollments'])->name('rehabilitation-programs.enrollments');
Route::patch('/rehabilitation-programs/{rehabilitationProgram}/inmates/{inmate}/status', [RehabilitationProgramController::class, 'updateEnrollmentStatus'])->name('rehabilitation-programs.update-status');
Route::get('/rehabilitation-programs/{rehabilitationProgram}/export', [RehabilitationProgramController::class, 'export'])->name('rehabilitation-programs.export');
Route::get('/rehabilitation-programs/{rehabilitationProgram}/report', [RehabilitationProgramController::class, 'report'])->name('rehabilitation-programs.report');

// Visit Management Routes
Route::resource('visits', VisitController::class);
Route::patch('/visits/{visit}/approve', [VisitController::class, 'approve'])->name('visits.approve');
Route::patch('/visits/{visit}/reject', [VisitController::class, 'reject'])->name('visits.reject');
Route::get('/visits/reports/pending', [VisitController::class, 'pendingApprovals'])->name('visits.pending');
Route::get('/visits/reports/today', [VisitController::class, 'todaysVisits'])->name('visits.today');

// Admin Management Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/guards', [AdminController::class, 'guardDashboard'])->name('admin.guards');
    Route::get('/admin/shifts', [AdminController::class, 'shiftMonitoring'])->name('admin.shifts');

    // Guard CRUD operations
    Route::post('/admin/guards', [AdminController::class, 'createGuard'])->name('admin.guards.create');
    Route::get('/admin/guards/{user}/edit', [AdminController::class, 'editGuard'])->name('admin.guards.edit');
    Route::put('/admin/guards/{user}', [AdminController::class, 'updateGuard'])->name('admin.guards.update');
    Route::delete('/admin/guards/{user}', [AdminController::class, 'deleteGuard'])->name('admin.guards.delete');
    Route::patch('/admin/guards/{user}/toggle-status', [AdminController::class, 'toggleGuardStatus'])->name('admin.guards.toggle-status');
});

// Guard Routes
Route::middleware(['auth', 'role:guard'])->group(function () {
    Route::get('/guard/dashboard', function () {
        return view('guard.dashboard');
    })->name('guard.dashboard');
});

// Profile and Settings routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile', ['user' => auth()->user()]);
    })->name('profile');
    Route::get('/settings', function () {
        return view('settings', ['user' => auth()->user()]);
    })->name('settings');
});
