@extends('layout.app')

@section('title', 'Program Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-graduation-cap me-2"></i>
                    {{ $rehabilitationProgram->program_name }}
                </h1>
                <div class="btn-group" role="group">
                    <a href="{{ route('rehabilitation-programs.edit', $rehabilitationProgram) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Edit Program
                    </a>
                    <button type="button" class="btn btn-success" onclick="showEnrollmentModal()">
                        <i class="fas fa-users me-2"></i>
                        Manage Enrollments
                    </button>
                    <a href="{{ route('rehabilitation-programs.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to Programs
                    </a>
                </div>
            </div>

            <!-- Program Status Banner -->
            <div class="alert alert-{{ $rehabilitationProgram->status == 'active' ? 'success' : ($rehabilitationProgram->status == 'completed' ? 'info' : ($rehabilitationProgram->status == 'cancelled' ? 'danger' : 'warning')) }} mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Status:</strong> {{ ucfirst($rehabilitationProgram->status) }}
                        @if($rehabilitationProgram->status == 'active')
                            <span class="badge bg-success ms-2">Currently Running</span>
                        @elseif($rehabilitationProgram->start_date->isFuture())
                            <span class="badge bg-info ms-2">Upcoming</span>
                        @elseif($rehabilitationProgram->end_date->isPast())
                            <span class="badge bg-secondary ms-2">Ended</span>
                        @endif
                    </div>
                    <div>
                        <strong>Duration:</strong> {{ $rehabilitationProgram->duration_weeks }} weeks
                        <span class="ms-3">
                            <strong>Capacity:</strong> {{ $rehabilitationProgram->inmates->count() }}/{{ $rehabilitationProgram->capacity }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Program Details -->
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Program Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Program Type:</strong></td>
                                            <td>
                                                @php
                                                    $typeColors = [
                                                        'substance_abuse' => 'danger',
                                                        'education' => 'primary',
                                                        'vocational_training' => 'success',
                                                        'anger_management' => 'warning',
                                                        'life_skills' => 'info',
                                                        'other' => 'secondary'
                                                    ];
                                                    $color = $typeColors[$rehabilitationProgram->program_type] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $color }}">
                                                    {{ ucwords(str_replace('_', ' ', $rehabilitationProgram->program_type)) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Instructor:</strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-secondary rounded-circle me-2 d-flex align-items-center justify-content-center"
                                                         style="width: 30px; height: 30px;">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                    <div>
                                                        <strong>{{ $rehabilitationProgram->instructor->full_name ?? 'N/A' }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $rehabilitationProgram->instructor->position ?? '' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Location:</strong></td>
                                            <td>{{ $rehabilitationProgram->location }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Cost per Participant:</strong></td>
                                            <td>${{ number_format($rehabilitationProgram->cost, 2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Start Date:</strong></td>
                                            <td>{{ $rehabilitationProgram->start_date->format('M d, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>End Date:</strong></td>
                                            <td>{{ $rehabilitationProgram->end_date->format('M d, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Duration:</strong></td>
                                            <td>{{ $rehabilitationProgram->duration_weeks }} weeks</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Certificate:</strong></td>
                                            <td>
                                                @if($rehabilitationProgram->certificate_provided)
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h6>Description</h6>
                                <p class="text-muted">{{ $rehabilitationProgram->description }}</p>
                            </div>

                            @if($rehabilitationProgram->prerequisites)
                                <div class="mt-4">
                                    <h6>Prerequisites</h6>
                                    <p class="text-muted">{{ $rehabilitationProgram->prerequisites }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Enrollment Progress -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-line me-2"></i>
                                Enrollment Progress
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-6">
                                    <h6 class="mb-2">Enrollment Status</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <strong>{{ $rehabilitationProgram->inmates->count() }}/{{ $rehabilitationProgram->capacity }}</strong>
                                        </div>
                                        <div class="progress flex-grow-1" style="height: 20px;">
                                            @php
                                                $percentage = $rehabilitationProgram->capacity > 0 ? ($rehabilitationProgram->inmates->count() / $rehabilitationProgram->capacity) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar bg-{{ $percentage >= 90 ? 'danger' : ($percentage >= 70 ? 'warning' : 'success') }}"
                                                 style="width: {{ $percentage }}%">
                                                {{ round($percentage, 1) }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="border rounded p-2">
                                                <h6 class="mb-0 text-success">{{ $rehabilitationProgram->inmates->where('pivot.status', 'enrolled')->count() }}</h6>
                                                <small class="text-muted">Enrolled</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="border rounded p-2">
                                                <h6 class="mb-0 text-primary">{{ $rehabilitationProgram->inmates->where('pivot.status', 'in_progress')->count() }}</h6>
                                                <small class="text-muted">In Progress</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="border rounded p-2">
                                                <h6 class="mb-0 text-info">{{ $rehabilitationProgram->inmates->where('pivot.status', 'completed')->count() }}</h6>
                                                <small class="text-muted">Completed</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <!-- Quick Actions -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-bolt me-2"></i>
                                Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button class="btn btn-success btn-sm" onclick="showEnrollmentModal()">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Add Participant
                                </button>
                                <button class="btn btn-info btn-sm" onclick="exportProgramData()">
                                    <i class="fas fa-download me-2"></i>
                                    Export Data
                                </button>
                                <button class="btn btn-warning btn-sm" onclick="generateReport()">
                                    <i class="fas fa-file-alt me-2"></i>
                                    Generate Report
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Program Statistics -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-chart-bar me-2"></i>
                                Statistics
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class="border rounded p-2">
                                        <h6 class="mb-0 text-primary">{{ $rehabilitationProgram->inmates->count() }}</h6>
                                        <small class="text-muted">Total Enrolled</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="border rounded p-2">
                                        <h6 class="mb-0 text-success">{{ $rehabilitationProgram->capacity - $rehabilitationProgram->inmates->count() }}</h6>
                                        <small class="text-muted">Available Spots</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="border rounded p-2">
                                        <h6 class="mb-0 text-info">{{ $rehabilitationProgram->inmates->where('pivot.status', 'completed')->count() }}</h6>
                                        <small class="text-muted">Completed</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="border rounded p-2">
                                        <h6 class="mb-0 text-warning">{{ $rehabilitationProgram->inmates->where('pivot.status', 'dropped')->count() }}</h6>
                                        <small class="text-muted">Dropped</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-calendar me-2"></i>
                                Program Timeline
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">Program Start</h6>
                                        <small class="text-muted">{{ $rehabilitationProgram->start_date->format('M d, Y') }}</small>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-success"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">Program End</h6>
                                        <small class="text-muted">{{ $rehabilitationProgram->end_date->format('M d, Y') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrolled Participants -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>
                        Enrolled Participants ({{ $rehabilitationProgram->inmates->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    @if($rehabilitationProgram->inmates->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Inmate</th>
                                        <th>Enrollment Date</th>
                                        <th>Status</th>
                                        <th>Progress</th>
                                        <th>Completion Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rehabilitationProgram->inmates as $inmate)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-secondary rounded-circle me-2 d-flex align-items-center justify-content-center"
                                                         style="width: 30px; height: 30px;">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                    <div>
                                                        <strong>{{ $inmate->full_name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $inmate->inmate_number }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $inmate->pivot->enrollment_date ? \Carbon\Carbon::parse($inmate->pivot->enrollment_date)->format('M d, Y') : 'N/A' }}</td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'enrolled' => 'info',
                                                        'in_progress' => 'primary',
                                                        'completed' => 'success',
                                                        'dropped' => 'danger',
                                                        'suspended' => 'warning'
                                                    ];
                                                    $color = $statusColors[$inmate->pivot->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $color }}">
                                                    {{ ucwords(str_replace('_', ' ', $inmate->pivot->status)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 6px;">
                                                    @php
                                                        $progress = 0;
                                                        if ($inmate->pivot->status == 'completed') {
                                                            $progress = 100;
                                                        } elseif ($inmate->pivot->status == 'in_progress') {
                                                            $progress = 50;
                                                        } elseif ($inmate->pivot->status == 'enrolled') {
                                                            $progress = 25;
                                                        }
                                                    @endphp
                                                    <div class="progress-bar bg-{{ $progress == 100 ? 'success' : ($progress >= 50 ? 'primary' : 'info') }}"
                                                         style="width: {{ $progress }}%"></div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $inmate->pivot->completion_date ? \Carbon\Carbon::parse($inmate->pivot->completion_date)->format('M d, Y') : 'N/A' }}
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-primary"
                                                            onclick="viewInmateDetails({{ $inmate->id }})"
                                                            title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-warning"
                                                            onclick="updateEnrollmentStatus({{ $inmate->id }})"
                                                            title="Update Status">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('rehabilitation-programs.unenroll', ['rehabilitationProgram' => $rehabilitationProgram, 'inmate' => $inmate]) }}"
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('Are you sure you want to unenroll this inmate?')"
                                                                title="Unenroll">
                                                            <i class="fas fa-user-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">No participants enrolled</h6>
                            <p class="text-muted">Start by enrolling participants in this program.</p>
                            <button class="btn btn-primary" onclick="showEnrollmentModal()">
                                <i class="fas fa-user-plus me-2"></i>
                                Enroll First Participant
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enrollment Modal -->
<div class="modal fade" id="enrollmentModal" tabindex="-1" aria-labelledby="enrollmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enrollmentModalLabel">Manage Enrollments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="enrollmentModalBody">
                <!-- Enrollment content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 3px #dee2e6;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: -29px;
    top: 12px;
    width: 2px;
    height: calc(100% + 8px);
    background-color: #dee2e6;
}
</style>

<script>
function showEnrollmentModal() {
    document.getElementById('enrollmentModalLabel').innerText = 'Manage Enrollments';
    fetch(`/rehabilitation-programs/{{ $rehabilitationProgram->id }}/enrollments`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('enrollmentModalBody').innerHTML = html;
            bootstrap.Modal.getInstance(document.getElementById('enrollmentModal')).show();
        })
        .catch(error => {
            console.error('Error loading enrollments:', error);
            alert('Error loading enrollments. Please try again.');
        });
}

function viewInmateDetails(inmateId) {
    window.open(`/inmates/${inmateId}`, '_blank');
}

function updateEnrollmentStatus(inmateId) {
    // This would open a modal to update enrollment status
    alert('Update enrollment status functionality would be implemented here.');
}

function exportProgramData() {
    window.open(`/rehabilitation-programs/{{ $rehabilitationProgram->id }}/export`, '_blank');
}

function generateReport() {
    window.open(`/rehabilitation-programs/{{ $rehabilitationProgram->id }}/report`, '_blank');
}
</script>
@endsection
