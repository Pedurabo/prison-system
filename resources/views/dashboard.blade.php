@extends('layout.app')

@section('title', 'Dashboard')
@section('page-title', 'Prison Management Dashboard')

@section('content')
<div class="row">
    <!-- Quick Stats -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <h3 class="mb-0">{{ $totalInmates }}</h3>
                    <p class="mb-0">Total Inmates</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <h3 class="mb-0">{{ $totalStaff }}</h3>
                    <p class="mb-0">Staff Members</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-tie fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <h3 class="mb-0">{{ $openIncidents }}</h3>
                    <p class="mb-0">Open Incidents</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <h3 class="mb-0">{{ $pendingVisits }}</h3>
                    <p class="mb-0">Pending Visits</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Security Overview -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shield-alt me-2"></i>
                    Security Overview
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-warning">{{ $criticalIncidents }}</h4>
                            <p class="mb-0">Critical Incidents</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-info">{{ $recentIncidents }}</h4>
                            <p class="mb-0">Recent (7 days)</p>
                        </div>
                    </div>
                </div>
                <hr>
                <a href="{{ route('security-incidents.index') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye me-1"></i>View All Incidents
                </a>
            </div>
        </div>
    </div>

    <!-- Medical Overview -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-heartbeat me-2"></i>
                    Medical Overview
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-danger">{{ $followUpRequired }}</h4>
                            <p class="mb-0">Follow-ups Due</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-info">{{ $recentMedicalVisits }}</h4>
                            <p class="mb-0">Recent Visits</p>
                        </div>
                    </div>
                </div>
                <hr>
                <a href="{{ route('medical-records.index') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-eye me-1"></i>View Medical Records
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Security Level Distribution -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Security Level Distribution
                </h5>
            </div>
            <div class="card-body">
                @if(!empty($securityLevels))
                    @foreach($securityLevels as $level => $count)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-capitalize">{{ str_replace('_', ' ', $level) }}</span>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-secondary me-2">{{ $count }}</span>
                                <div class="progress" style="width: 100px; height: 8px;">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: {{ ($count / array_sum($securityLevels)) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No inmates currently recorded.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Department Overview -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-building me-2"></i>
                    Department Overview
                </h5>
            </div>
            <div class="card-body">
                @foreach($departmentStats as $dept)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0">{{ $dept['name'] }}</h6>
                            <small class="text-muted">{{ $dept['staff_count'] }} staff members</small>
                        </div>
                        <span class="badge bg-primary">${{ number_format($dept['budget']) }}</span>
                    </div>
                @endforeach
                <hr>
                <a href="{{ route('departments.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-eye me-1"></i>View All Departments
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Quick Actions -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('inmates.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-2"></i>Add New Inmate
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('security-incidents.create') }}" class="btn btn-warning w-100">
                            <i class="fas fa-exclamation-triangle me-2"></i>Report Incident
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('visits.create') }}" class="btn btn-info w-100">
                            <i class="fas fa-calendar-plus me-2"></i>Schedule Visit
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('medical-records.create') }}" class="btn btn-success w-100">
                            <i class="fas fa-plus-square me-2"></i>Add Medical Record
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Important Alerts -->
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bell me-2"></i>
                    Important Alerts
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @if($upcomingReleases > 0)
                        <div class="col-md-4 mb-2">
                            <div class="alert alert-info mb-0">
                                <strong>{{ $upcomingReleases }}</strong> inmates scheduled for release in the next 30 days
                                <a href="{{ route('inmates.upcoming-releases') }}" class="alert-link">View List</a>
                            </div>
                        </div>
                    @endif

                    @if($todaysVisits > 0)
                        <div class="col-md-4 mb-2">
                            <div class="alert alert-primary mb-0">
                                <strong>{{ $todaysVisits }}</strong> visits scheduled for today
                                <a href="{{ route('visits.today') }}" class="alert-link">View Schedule</a>
                            </div>
                        </div>
                    @endif

                    @if($followUpRequired > 0)
                        <div class="col-md-4 mb-2">
                            <div class="alert alert-warning mb-0">
                                <strong>{{ $followUpRequired }}</strong> medical follow-ups required
                                <a href="{{ route('medical-records.follow-up') }}" class="alert-link">Review</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
