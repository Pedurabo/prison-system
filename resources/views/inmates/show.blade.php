@extends('layout.app')

@section('title', 'Inmate Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-user me-2"></i>
                    Inmate Details
                </h1>
                <div class="btn-group">
                    <a href="{{ route('inmates.edit', $inmate) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Edit
                    </a>
                    <a href="{{ route('inmates.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to List
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Inmate Information -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-circle me-2"></i>
                                Personal Information
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            @if($inmate->photo_path)
                                <img src="{{ asset('storage/' . $inmate->photo_path) }}"
                                     alt="{{ $inmate->full_name }}"
                                     class="rounded-circle mb-3"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                     style="width: 150px; height: 150px;">
                                    <i class="fas fa-user fa-3x text-white"></i>
                                </div>
                            @endif

                            <h4 class="mb-2">{{ $inmate->full_name }}</h4>
                            <p class="text-muted mb-3">Inmate #{{ $inmate->inmate_number }}</p>

                            <div class="row text-start">
                                <div class="col-6">
                                    <strong>Age:</strong>
                                </div>
                                <div class="col-6">
                                    {{ $inmate->age }} years
                                </div>

                                <div class="col-6">
                                    <strong>Gender:</strong>
                                </div>
                                <div class="col-6">
                                    {{ ucfirst($inmate->gender) }}
                                </div>

                                <div class="col-6">
                                    <strong>Nationality:</strong>
                                </div>
                                <div class="col-6">
                                    {{ $inmate->nationality }}
                                </div>

                                <div class="col-6">
                                    <strong>Status:</strong>
                                </div>
                                <div class="col-6">
                                    @php
                                        $statusColors = [
                                            'active' => 'success',
                                            'released' => 'info',
                                            'transferred' => 'warning',
                                            'deceased' => 'danger'
                                        ];
                                        $color = $statusColors[$inmate->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $color }}">
                                        {{ ucfirst($inmate->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Incarceration Details -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-gavel me-2"></i>
                                Incarceration Details
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Admission Date</label>
                                        <p class="mb-0">{{ $inmate->admission_date->format('F d, Y') }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Release Date</label>
                                        <p class="mb-0">
                                            @if($inmate->release_date)
                                                {{ $inmate->release_date->format('F d, Y') }}
                                                @if($inmate->release_date->isPast())
                                                    <span class="badge bg-success ms-2">Released</span>
                                                @elseif($inmate->release_date->diffInDays(now()) <= 30)
                                                    <span class="badge bg-warning ms-2">Upcoming</span>
                                                @endif
                                            @else
                                                <span class="text-muted">Not set</span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Sentence Length</label>
                                        <p class="mb-0">{{ $inmate->sentence_length }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Crime Category</label>
                                        <p class="mb-0">{{ $inmate->crime_category }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Security Level</label>
                                        <p class="mb-0">
                                            @php
                                                $levelColors = [
                                                    'minimum' => 'success',
                                                    'medium' => 'warning',
                                                    'maximum' => 'danger',
                                                    'supermax' => 'dark'
                                                ];
                                                $color = $levelColors[$inmate->security_level] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $color }} fs-6">
                                                {{ ucfirst($inmate->security_level) }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Cell Number</label>
                                        <p class="mb-0">{{ $inmate->cell_number }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Block</label>
                                        <p class="mb-0">Block {{ $inmate->block }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Time Served</label>
                                        <p class="mb-0">{{ $inmate->admission_date->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-address-book me-2"></i>
                                Contact Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Address Before Incarceration</label>
                                        <p class="mb-0">{{ $inmate->address_before_incarceration }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Emergency Contact</label>
                                        <p class="mb-0">{{ $inmate->emergency_contact }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Next of Kin</label>
                                        <p class="mb-0">{{ $inmate->next_of_kin }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Records Tabs -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="relatedRecordsTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="security-tab" data-bs-toggle="tab"
                                            data-bs-target="#security" type="button" role="tab">
                                        <i class="fas fa-shield-alt me-2"></i>
                                        Security Incidents ({{ $inmate->securityIncidents->count() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="medical-tab" data-bs-toggle="tab"
                                            data-bs-target="#medical" type="button" role="tab">
                                        <i class="fas fa-heartbeat me-2"></i>
                                        Medical Records ({{ $inmate->medicalRecords->count() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="rehabilitation-tab" data-bs-toggle="tab"
                                            data-bs-target="#rehabilitation" type="button" role="tab">
                                        <i class="fas fa-graduation-cap me-2"></i>
                                        Rehabilitation Programs ({{ $inmate->rehabilitationPrograms->count() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="visits-tab" data-bs-toggle="tab"
                                            data-bs-target="#visits" type="button" role="tab">
                                        <i class="fas fa-calendar-check me-2"></i>
                                        Visits ({{ $inmate->visits->count() }})
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="relatedRecordsTabContent">
                                <!-- Security Incidents -->
                                <div class="tab-pane fade show active" id="security" role="tabpanel">
                                    @if($inmate->securityIncidents->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Type</th>
                                                        <th>Severity</th>
                                                        <th>Location</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($inmate->securityIncidents as $incident)
                                                        <tr>
                                                            <td>{{ $incident->incident_date->format('M d, Y') }}</td>
                                                            <td>{{ ucfirst(str_replace('_', ' ', $incident->incident_type)) }}</td>
                                                            <td>
                                                                @php
                                                                    $severityColors = [
                                                                        'low' => 'success',
                                                                        'medium' => 'warning',
                                                                        'high' => 'danger',
                                                                        'critical' => 'dark'
                                                                    ];
                                                                    $color = $severityColors[$incident->severity_level] ?? 'secondary';
                                                                @endphp
                                                                <span class="badge bg-{{ $color }}">
                                                                    {{ ucfirst($incident->severity_level) }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $incident->location }}</td>
                                                            <td>
                                                                @if($incident->resolved_date)
                                                                    <span class="badge bg-success">Resolved</span>
                                                                @else
                                                                    <span class="badge bg-warning">Pending</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-shield-alt fa-2x text-muted mb-3"></i>
                                            <p class="text-muted">No security incidents recorded for this inmate.</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Medical Records -->
                                <div class="tab-pane fade" id="medical" role="tabpanel">
                                    @if($inmate->medicalRecords->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Symptoms</th>
                                                        <th>Treatment</th>
                                                        <th>Staff</th>
                                                        <th>Follow-up</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($inmate->medicalRecords as $record)
                                                        <tr>
                                                            <td>{{ $record->visit_date->format('M d, Y') }}</td>
                                                            <td>{{ Str::limit($record->symptoms, 50) }}</td>
                                                            <td>{{ Str::limit($record->treatment, 50) }}</td>
                                                            <td>{{ $record->attendingStaff->full_name ?? 'N/A' }}</td>
                                                            <td>
                                                                @if($record->follow_up_required)
                                                                    <span class="badge bg-warning">Required</span>
                                                                @else
                                                                    <span class="badge bg-success">None</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-heartbeat fa-2x text-muted mb-3"></i>
                                            <p class="text-muted">No medical records found for this inmate.</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Rehabilitation Programs -->
                                <div class="tab-pane fade" id="rehabilitation" role="tabpanel">
                                    @if($inmate->rehabilitationPrograms->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Program</th>
                                                        <th>Type</th>
                                                        <th>Enrollment Date</th>
                                                        <th>Status</th>
                                                        <th>Progress</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($inmate->rehabilitationPrograms as $program)
                                                        <tr>
                                                            <td>{{ $program->program_name }}</td>
                                                            <td>{{ ucfirst(str_replace('_', ' ', $program->program_type)) }}</td>
                                                            <td>{{ $program->pivot->enrollment_date->format('M d, Y') }}</td>
                                                            <td>
                                                                @php
                                                                    $statusColors = [
                                                                        'enrolled' => 'primary',
                                                                        'completed' => 'success',
                                                                        'dropped' => 'danger'
                                                                    ];
                                                                    $color = $statusColors[$program->pivot->status] ?? 'secondary';
                                                                @endphp
                                                                <span class="badge bg-{{ $color }}">
                                                                    {{ ucfirst($program->pivot->status) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @if($program->pivot->completion_date)
                                                                    <span class="badge bg-success">Completed</span>
                                                                @else
                                                                    <span class="badge bg-info">In Progress</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-graduation-cap fa-2x text-muted mb-3"></i>
                                            <p class="text-muted">No rehabilitation programs enrolled for this inmate.</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Visits -->
                                <div class="tab-pane fade" id="visits" role="tabpanel">
                                    @if($inmate->visits->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Visitor</th>
                                                        <th>Type</th>
                                                        <th>Duration</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($inmate->visits as $visit)
                                                        <tr>
                                                            <td>{{ $visit->visit_date->format('M d, Y') }}</td>
                                                            <td>{{ $visit->visitor_name }}</td>
                                                            <td>{{ ucfirst($visit->visit_type) }}</td>
                                                            <td>{{ $visit->duration_minutes }} minutes</td>
                                                            <td>
                                                                @php
                                                                    $statusColors = [
                                                                        'pending' => 'warning',
                                                                        'approved' => 'success',
                                                                        'rejected' => 'danger',
                                                                        'completed' => 'info',
                                                                        'cancelled' => 'secondary'
                                                                    ];
                                                                    $color = $statusColors[$visit->status] ?? 'secondary';
                                                                @endphp
                                                                <span class="badge bg-{{ $color }}">
                                                                    {{ ucfirst($visit->status) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-calendar-check fa-2x text-muted mb-3"></i>
                                            <p class="text-muted">No visits recorded for this inmate.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
