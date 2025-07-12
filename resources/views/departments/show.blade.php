@extends('layout.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $department->name }}</h1>
        <div>
            <a href="{{ route('departments.edit', $department) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit fa-sm"></i> Edit
            </a>
            <a href="{{ route('departments.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left fa-sm"></i> Back to Departments
            </a>
        </div>
    </div>

    <!-- Department Information -->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Department Details</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Basic Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $department->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $department->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($department->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Established:</strong></td>
                                    <td>{{ $department->established_date->format('F j, Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Budget:</strong></td>
                                    <td>${{ number_format($department->budget, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Department Head</h5>
                            @if($department->departmentHead)
                                <div class="card">
                                    <div class="card-body">
                                        <h6>{{ $department->departmentHead->full_name }}</h6>
                                        <p class="text-muted mb-1">{{ $department->departmentHead->position }}</p>
                                        <p class="text-muted mb-1">{{ $department->departmentHead->email }}</p>
                                        <p class="text-muted mb-0">{{ $department->departmentHead->phone }}</p>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted">No department head assigned</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Description</h5>
                        <p>{{ $department->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <!-- Department Statistics -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Department Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h4 text-primary">{{ $department->staff->count() }}</div>
                                <div class="text-xs text-muted">Staff Members</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h4 text-success">{{ $department->securityIncidents->count() }}</div>
                                <div class="text-xs text-muted">Security Incidents</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-primary btn-sm">
                            <i class="fas fa-users me-1"></i> View Staff
                        </a>
                        <a href="#" class="btn btn-warning btn-sm">
                            <i class="fas fa-exclamation-triangle me-1"></i> View Incidents
                        </a>
                        <a href="#" class="btn btn-info btn-sm">
                            <i class="fas fa-chart-bar me-1"></i> Generate Report
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Staff Members -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Department Staff</h6>
        </div>
        <div class="card-body">
            @if($department->staff->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($department->staff as $staff)
                            <tr>
                                <td>{{ $staff->full_name }}</td>
                                <td>{{ $staff->position }}</td>
                                <td>{{ $staff->email }}</td>
                                <td>{{ $staff->phone }}</td>
                                <td>
                                    <span class="badge bg-{{ $staff->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($staff->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center">No staff members assigned to this department.</p>
            @endif
        </div>
    </div>

    <!-- Recent Security Incidents -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Recent Security Incidents</h6>
        </div>
        <div class="card-body">
            @if($department->securityIncidents->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Severity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($department->securityIncidents->take(5) as $incident)
                            <tr>
                                <td>{{ $incident->incident_date->format('M j, Y') }}</td>
                                <td>{{ Str::limit($incident->description, 50) }}</td>
                                <td>
                                    <span class="badge bg-{{ $incident->severity === 'high' ? 'danger' : ($incident->severity === 'medium' ? 'warning' : 'info') }}">
                                        {{ ucfirst($incident->severity) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $incident->status === 'resolved' ? 'success' : 'warning' }}">
                                        {{ ucfirst($incident->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center">No security incidents reported for this department.</p>
            @endif
        </div>
    </div>
</div>
@endsection
