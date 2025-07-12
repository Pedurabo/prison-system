@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Security Incidents</h3>
                    <a href="{{ route('security-incidents.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Report Incident
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Incident #</th>
                                    <th>Type</th>
                                    <th>Severity</th>
                                    <th>Location</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Reported By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($incidents as $incident)
                                    <tr class="{{ $incident->status === 'resolved' ? 'table-success' : ($incident->severity_level === 'critical' ? 'table-danger' : 'table-warning') }}">
                                        <td>{{ $incident->incident_number }}</td>
                                        <td>
                                            <span class="badge badge-{{ $incident->incident_type === 'fight' ? 'danger' : ($incident->incident_type === 'escape_attempt' ? 'warning' : 'info') }}">
                                                {{ ucfirst(str_replace('_', ' ', $incident->incident_type)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $incident->severity_level === 'critical' ? 'danger' : ($incident->severity_level === 'high' ? 'warning' : 'info') }}">
                                                {{ ucfirst($incident->severity_level) }}
                                            </span>
                                        </td>
                                        <td>{{ $incident->location }}</td>
                                        <td>{{ $incident->incident_date->format('M d, Y H:i') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $incident->status === 'resolved' ? 'success' : 'warning' }}">
                                                {{ ucfirst($incident->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $incident->reportedByStaff->first_name }} {{ $incident->reportedByStaff->last_name }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('security-incidents.show', $incident) }}"
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('security-incidents.edit', $incident) }}"
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($incident->status !== 'resolved')
                                                    <a href="{{ route('security-incidents.resolve', $incident) }}"
                                                       class="btn btn-sm btn-success">
                                                        <i class="fas fa-check"></i> Resolve
                                                    </a>
                                                @endif
                                                <form action="{{ route('security-incidents.destroy', $incident) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this security incident?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No security incidents found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $incidents->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
