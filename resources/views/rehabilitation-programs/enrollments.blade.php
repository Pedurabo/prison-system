@extends('layout.app')

@section('title', 'Manage Enrollments')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-users me-2"></i>
                    Manage Enrollments - {{ $rehabilitationProgram->program_name }}
                </h1>
                <a href="{{ route('rehabilitation-programs.show', $rehabilitationProgram) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Program
                </a>
            </div>

            <!-- Program Summary -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6 class="text-muted">Total Capacity</h6>
                                <h3 class="text-primary">{{ $rehabilitationProgram->capacity }}</h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6 class="text-muted">Currently Enrolled</h6>
                                <h3 class="text-success">{{ $rehabilitationProgram->inmates->count() }}</h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6 class="text-muted">Available Spots</h6>
                                <h3 class="text-info">{{ $rehabilitationProgram->capacity - $rehabilitationProgram->inmates->count() }}</h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6 class="text-muted">Completion Rate</h6>
                                <h3 class="text-warning">
                                    {{ $rehabilitationProgram->inmates->count() > 0 ? round(($rehabilitationProgram->inmates->where('pivot.status', 'completed')->count() / $rehabilitationProgram->inmates->count()) * 100, 1) : 0 }}%
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Enroll New Participants -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-plus me-2"></i>
                                Enroll New Participants
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($rehabilitationProgram->inmates->count() < $rehabilitationProgram->capacity)
                                <form action="{{ route('rehabilitation-programs.enroll', $rehabilitationProgram) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="inmate_id" class="form-label">Select Inmate <span class="text-danger">*</span></label>
                                        <select class="form-select @error('inmate_id') is-invalid @enderror"
                                                id="inmate_id"
                                                name="inmate_id"
                                                required>
                                            <option value="">Choose an inmate...</option>
                                            @foreach($availableInmates as $inmate)
                                                <option value="{{ $inmate->id }}">
                                                    {{ $inmate->full_name }} ({{ $inmate->inmate_number }}) - {{ $inmate->block }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('inmate_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="enrollment_date" class="form-label">Enrollment Date <span class="text-danger">*</span></label>
                                        <input type="date"
                                               class="form-control @error('enrollment_date') is-invalid @enderror"
                                               id="enrollment_date"
                                               name="enrollment_date"
                                               value="{{ old('enrollment_date', date('Y-m-d')) }}"
                                               required>
                                        @error('enrollment_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="notes" class="form-label">Notes</label>
                                        <textarea class="form-control"
                                                  id="notes"
                                                  name="notes"
                                                  rows="3"
                                                  placeholder="Any additional notes about this enrollment...">{{ old('notes') }}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-user-plus me-2"></i>
                                        Enroll Participant
                                    </button>
                                </form>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">Program is Full</h6>
                                    <p class="text-muted">This program has reached its maximum capacity.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Current Enrollments -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-list me-2"></i>
                                Current Enrollments ({{ $rehabilitationProgram->inmates->count() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($rehabilitationProgram->inmates->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Inmate</th>
                                                <th>Status</th>
                                                <th>Enrolled</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rehabilitationProgram->inmates as $inmate)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="bg-secondary rounded-circle me-2 d-flex align-items-center justify-content-center"
                                                                 style="width: 25px; height: 25px;">
                                                                <i class="fas fa-user text-white" style="font-size: 12px;"></i>
                                                            </div>
                                                            <div>
                                                                <strong>{{ $inmate->full_name }}</strong>
                                                                <br>
                                                                <small class="text-muted">{{ $inmate->inmate_number }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
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
                                                        <small class="text-muted">
                                                            {{ $inmate->pivot->enrollment_date ? \Carbon\Carbon::parse($inmate->pivot->enrollment_date)->format('M d, Y') : 'N/A' }}
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <button type="button"
                                                                    class="btn btn-outline-primary btn-sm"
                                                                    onclick="updateEnrollmentStatus({{ $inmate->id }})"
                                                                    title="Update Status">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <form action="{{ route('rehabilitation-programs.unenroll', ['rehabilitationProgram' => $rehabilitationProgram, 'inmate' => $inmate]) }}"
                                                                  method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                        class="btn btn-outline-danger btn-sm"
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
                                    <h6 class="text-muted">No Enrollments</h6>
                                    <p class="text-muted">No participants are currently enrolled in this program.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrollment Statistics -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>
                        Enrollment Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="border rounded p-3">
                                    <h4 class="text-info mb-1">{{ $rehabilitationProgram->inmates->where('pivot.status', 'enrolled')->count() }}</h4>
                                    <small class="text-muted">Enrolled</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="border rounded p-3">
                                    <h4 class="text-primary mb-1">{{ $rehabilitationProgram->inmates->where('pivot.status', 'in_progress')->count() }}</h4>
                                    <small class="text-muted">In Progress</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="border rounded p-3">
                                    <h4 class="text-success mb-1">{{ $rehabilitationProgram->inmates->where('pivot.status', 'completed')->count() }}</h4>
                                    <small class="text-muted">Completed</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="border rounded p-3">
                                    <h4 class="text-danger mb-1">{{ $rehabilitationProgram->inmates->where('pivot.status', 'dropped')->count() }}</h4>
                                    <small class="text-muted">Dropped</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Update Enrollment Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateStatusForm" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="enrolled">Enrolled</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="dropped">Dropped</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="completion_date" class="form-label">Completion Date</label>
                        <input type="date" class="form-control" id="completion_date" name="completion_date">
                        <div class="form-text">Only required when status is 'Completed'</div>
                    </div>

                    <div class="mb-3">
                        <label for="progress_notes" class="form-label">Progress Notes</label>
                        <textarea class="form-control" id="progress_notes" name="progress_notes" rows="3"></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function updateEnrollmentStatus(inmateId) {
    // Set the form action
    document.getElementById('updateStatusForm').action = `/rehabilitation-programs/{{ $rehabilitationProgram->id }}/inmates/${inmateId}/status`;

    // Show the modal
    bootstrap.Modal.getInstance(document.getElementById('updateStatusModal')).show();
}

// Auto-fill completion date when status is set to completed
document.getElementById('status').addEventListener('change', function() {
    const completionDateField = document.getElementById('completion_date');
    if (this.value === 'completed') {
        completionDateField.value = new Date().toISOString().split('T')[0];
        completionDateField.required = true;
    } else {
        completionDateField.required = false;
    }
});
</script>
@endsection
