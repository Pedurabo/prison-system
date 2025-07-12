@extends('layout.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-eye me-2"></i>Visit Details
        </h1>
        <div>
            <a href="{{ route('visits.edit', $visit) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('visits.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Visits
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Visit Details Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Visit Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Inmate:</th>
                                    <td>{{ $visit->inmate->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Visitor Name:</th>
                                    <td>{{ $visit->visitor_name }}</td>
                                </tr>
                                <tr>
                                    <th>Relationship:</th>
                                    <td>{{ $visit->visitor_relationship }}</td>
                                </tr>
                                <tr>
                                    <th>Visit Type:</th>
                                    <td>
                                        <span class="badge bg-{{ $visit->visit_type === 'family' ? 'primary' : ($visit->visit_type === 'legal' ? 'warning' : ($visit->visit_type === 'official' ? 'info' : 'success')) }}">
                                            {{ ucfirst($visit->visit_type) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge bg-{{ $visit->status === 'approved' ? 'success' : ($visit->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($visit->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Visit Date:</th>
                                    <td>{{ $visit->visit_date->format('M j, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Visit Time:</th>
                                    <td>{{ \Carbon\Carbon::parse($visit->visit_time)->format('H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Duration:</th>
                                    <td>{{ $visit->duration_minutes }} minutes</td>
                                </tr>
                                <tr>
                                    <th>Visitor ID:</th>
                                    <td>{{ $visit->visitor_id_number }}</td>
                                </tr>
                                <tr>
                                    <th>Visitor Phone:</th>
                                    <td>{{ $visit->visitor_phone }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="text-primary">Visitor Address:</h6>
                            <p>{{ $visit->visitor_address }}</p>
                        </div>
                    </div>

                    @if($visit->notes)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="text-primary">Notes:</h6>
                            <p>{{ $visit->notes }}</p>
                        </div>
                    </div>
                    @endif

                    @if($visit->approvedByStaff)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="text-primary">Approved By:</h6>
                            <p>{{ $visit->approvedByStaff->name }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Actions Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                </div>
                <div class="card-body">
                    @if($visit->status === 'pending')
                        <form action="{{ route('visits.approve', $visit) }}" method="POST" class="mb-2">
                            @csrf
                            <div class="mb-3">
                                <label for="approved_by_staff_id" class="form-label">Approve By:</label>
                                <select class="form-control" name="approved_by_staff_id" required>
                                    <option value="">Select Staff Member</option>
                                    @foreach(\App\Models\Staff::where('status', 'active')->get() as $staff)
                                        <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-check me-2"></i>Approve Visit
                            </button>
                        </form>

                        <form action="{{ route('visits.reject', $visit) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to reject this visit?')">
                                <i class="fas fa-times me-2"></i>Reject Visit
                            </button>
                        </form>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            This visit has been {{ $visit->status }}.
                        </div>
                    @endif

                    <hr>

                    <form action="{{ route('visits.destroy', $visit) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to delete this visit?')">
                            <i class="fas fa-trash me-2"></i>Delete Visit
                        </button>
                    </form>
                </div>
            </div>

            <!-- Inmate Information -->
            @if($visit->inmate)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Inmate Information</h6>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $visit->inmate->name }}</p>
                    <p><strong>ID:</strong> {{ $visit->inmate->inmate_id }}</p>
                    <p><strong>Security Level:</strong> {{ ucfirst($visit->inmate->security_level) }}</p>
                    <p><strong>Status:</strong>
                        <span class="badge bg-{{ $visit->inmate->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($visit->inmate->status) }}
                        </span>
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
