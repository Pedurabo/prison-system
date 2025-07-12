@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Staff Member Details</h3>
                    <div>
                        <a href="{{ route('staff.edit', $staff) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('staff.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Personal Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Employee ID:</strong></td>
                                    <td>{{ $staff->employee_id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $staff->first_name }} {{ $staff->last_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $staff->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td>{{ $staff->phone }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Address:</strong></td>
                                    <td>{{ $staff->address }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Emergency Contact:</strong></td>
                                    <td>{{ $staff->emergency_contact }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5>Employment Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Department:</strong></td>
                                    <td>
                                        <span class="badge badge-info">{{ $staff->department->name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Position:</strong></td>
                                    <td>{{ $staff->position }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Hire Date:</strong></td>
                                    <td>{{ $staff->hire_date->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Salary:</strong></td>
                                    <td>${{ number_format($staff->salary, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $staff->status === 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($staff->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Years of Service:</strong></td>
                                    <td>{{ $staff->hire_date->diffInYears(now()) }} years</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Security Incidents Reported</h5>
                            @if($staff->securityIncidents->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Incident #</th>
                                                <th>Type</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($staff->securityIncidents->take(5) as $incident)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('security-incidents.show', $incident) }}">
                                                            {{ $incident->incident_number }}
                                                        </a>
                                                    </td>
                                                    <td>{{ ucfirst(str_replace('_', ' ', $incident->incident_type)) }}</td>
                                                    <td>{{ $incident->incident_date->format('M d, Y') }}</td>
                                                    <td>
                                                        <span class="badge badge-{{ $incident->status === 'resolved' ? 'success' : 'warning' }}">
                                                            {{ ucfirst($incident->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($staff->securityIncidents->count() > 5)
                                    <p class="text-muted">Showing 5 of {{ $staff->securityIncidents->count() }} incidents</p>
                                @endif
                            @else
                                <p class="text-muted">No security incidents reported by this staff member.</p>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <h5>Medical Records Attended</h5>
                            @if($staff->medicalRecords->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Record #</th>
                                                <th>Patient</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($staff->medicalRecords->take(5) as $record)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('medical-records.show', $record) }}">
                                                            {{ $record->id }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $record->inmate->first_name }} {{ $record->inmate->last_name }}</td>
                                                    <td>{{ $record->visit_date->format('M d, Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($staff->medicalRecords->count() > 5)
                                    <p class="text-muted">Showing 5 of {{ $staff->medicalRecords->count() }} records</p>
                                @endif
                            @else
                                <p class="text-muted">No medical records attended by this staff member.</p>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h5>Actions</h5>
                            <div class="btn-group" role="group">
                                <a href="{{ route('staff.edit', $staff) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Staff Member
                                </a>
                                <form action="{{ route('staff.destroy', $staff) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this staff member?')">
                                        <i class="fas fa-trash"></i> Delete Staff Member
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
