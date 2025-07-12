@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Security Incident Details</h3>
                    <div>
                        @if($securityIncident->status !== 'resolved')
                            <a href="{{ route('security-incidents.resolve', $securityIncident) }}" class="btn btn-success">
                                <i class="fas fa-check"></i> Resolve Incident
                            </a>
                        @endif
                        <a href="{{ route('security-incidents.edit', $securityIncident) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('security-incidents.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Incident Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Incident Number:</strong></td>
                                    <td>{{ $securityIncident->incident_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Type:</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $securityIncident->incident_type === 'fight' ? 'danger' : ($securityIncident->incident_type === 'escape_attempt' ? 'warning' : 'info') }}">
                                            {{ ucfirst(str_replace('_', ' ', $securityIncident->incident_type)) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Severity Level:</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $securityIncident->severity_level === 'critical' ? 'danger' : ($securityIncident->severity_level === 'high' ? 'warning' : 'info') }}">
                                            {{ ucfirst($securityIncident->severity_level) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $securityIncident->status === 'resolved' ? 'success' : 'warning' }}">
                                            {{ ucfirst($securityIncident->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Location:</strong></td>
                                    <td>{{ $securityIncident->location }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date & Time:</strong></td>
                                    <td>{{ $securityIncident->incident_date->format('F d, Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5>Personnel Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Reported By:</strong></td>
                                    <td>{{ $securityIncident->reportedByStaff->first_name }} {{ $securityIncident->reportedByStaff->last_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Department:</strong></td>
                                    <td>{{ $securityIncident->department->name }}</td>
                                </tr>
                                @if($securityIncident->inmate)
                                    <tr>
                                        <td><strong>Inmate Involved:</strong></td>
                                        <td>
                                            <a href="{{ route('inmates.show', $securityIncident->inmate) }}">
                                                {{ $securityIncident->inmate->first_name }} {{ $securityIncident->inmate->last_name }}
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                                @if($securityIncident->resolvedByStaff)
                                    <tr>
                                        <td><strong>Resolved By:</strong></td>
                                        <td>{{ $securityIncident->resolvedByStaff->first_name }} {{ $securityIncident->resolvedByStaff->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Resolved Date:</strong></td>
                                        <td>{{ $securityIncident->resolved_date->format('F d, Y H:i') }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h5>Description</h5>
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-text">{{ $securityIncident->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($securityIncident->investigation_notes)
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h5>Investigation Notes</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <p class="card-text">{{ $securityIncident->investigation_notes }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($securityIncident->resolution)
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h5>Resolution</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <p class="card-text">{{ $securityIncident->resolution }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h5>Actions</h5>
                            <div class="btn-group" role="group">
                                <a href="{{ route('security-incidents.edit', $securityIncident) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Incident
                                </a>
                                @if($securityIncident->status !== 'resolved')
                                    <a href="{{ route('security-incidents.resolve', $securityIncident) }}" class="btn btn-success">
                                        <i class="fas fa-check"></i> Resolve Incident
                                    </a>
                                @endif
                                <form action="{{ route('security-incidents.destroy', $securityIncident) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this security incident?')">
                                        <i class="fas fa-trash"></i> Delete Incident
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
