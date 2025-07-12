@extends('layout.app')

@section('title', 'Rehabilitation Programs')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-graduation-cap me-2"></i>
                    Rehabilitation Programs
                </h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#programModal" id="addProgramBtn">
                    <i class="fas fa-plus me-2"></i>
                    Add New Program
                </button>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Total Programs</h6>
                                    <h3 class="mb-0">{{ $programs->total() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-graduation-cap fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Active Programs</h6>
                                    <h3 class="mb-0">{{ $programs->where('status', 'active')->count() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-play-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Upcoming Programs</h6>
                                    <h3 class="mb-0">{{ $programs->where('start_date', '>', now())->count() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-calendar-plus fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Completed Programs</h6>
                                    <h3 class="mb-0">{{ $programs->where('status', 'completed')->count() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('rehabilitation-programs.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}" placeholder="Search by program name">
                        </div>
                        <div class="col-md-2">
                            <label for="program_type" class="form-label">Program Type</label>
                            <select class="form-select" id="program_type" name="program_type">
                                <option value="">All Types</option>
                                <option value="substance_abuse" {{ request('program_type') == 'substance_abuse' ? 'selected' : '' }}>Substance Abuse</option>
                                <option value="education" {{ request('program_type') == 'education' ? 'selected' : '' }}>Education</option>
                                <option value="vocational_training" {{ request('program_type') == 'vocational_training' ? 'selected' : '' }}>Vocational Training</option>
                                <option value="anger_management" {{ request('program_type') == 'anger_management' ? 'selected' : '' }}>Anger Management</option>
                                <option value="life_skills" {{ request('program_type') == 'life_skills' ? 'selected' : '' }}>Life Skills</option>
                                <option value="other" {{ request('program_type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">All Status</option>
                                <option value="planned" {{ request('status') == 'planned' ? 'selected' : '' }}>Planned</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>
                                    Search
                                </button>
                                <a href="{{ route('rehabilitation-programs.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>
                                    Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Programs Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        Programs List
                    </h5>
                </div>
                <div class="card-body">
                    @if($programs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Program Name</th>
                                        <th>Type</th>
                                        <th>Instructor</th>
                                        <th>Capacity</th>
                                        <th>Duration</th>
                                        <th>Start Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($programs as $program)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong>{{ $program->program_name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ Str::limit($program->description, 50) }}</small>
                                                </div>
                                            </td>
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
                                                    $color = $typeColors[$program->program_type] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $color }}">
                                                    {{ ucwords(str_replace('_', ' ', $program->program_type)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-secondary rounded-circle me-2 d-flex align-items-center justify-content-center"
                                                         style="width: 30px; height: 30px;">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                    <div>
                                                        <strong>{{ $program->instructor->full_name ?? 'N/A' }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $program->instructor->position ?? '' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2">
                                                        <strong>{{ $program->inmates->count() }}/{{ $program->capacity }}</strong>
                                                    </div>
                                                    <div class="progress flex-grow-1" style="height: 6px;">
                                                        @php
                                                            $percentage = $program->capacity > 0 ? ($program->inmates->count() / $program->capacity) * 100 : 0;
                                                        @endphp
                                                        <div class="progress-bar bg-{{ $percentage >= 90 ? 'danger' : ($percentage >= 70 ? 'warning' : 'success') }}"
                                                             style="width: {{ $percentage }}%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $program->duration_weeks }} weeks</td>
                                            <td>
                                                {{ $program->start_date->format('M d, Y') }}
                                                @if($program->start_date->isPast() && $program->end_date->isFuture())
                                                    <span class="badge bg-success ms-1">Running</span>
                                                @elseif($program->start_date->isFuture())
                                                    <span class="badge bg-info ms-1">Upcoming</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'planned' => 'info',
                                                        'active' => 'success',
                                                        'completed' => 'primary',
                                                        'cancelled' => 'danger'
                                                    ];
                                                    $color = $statusColors[$program->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $color }}">
                                                    {{ ucfirst($program->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('rehabilitation-programs.show', $program) }}"
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('rehabilitation-programs.edit', $program) }}"
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-success"
                                                            onclick="showEnrollmentModal({{ $program->id }})"
                                                            title="Manage Enrollments">
                                                        <i class="fas fa-users"></i>
                                                    </button>
                                                    <form action="{{ route('rehabilitation-programs.destroy', $program) }}"
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('Are you sure you want to delete this program?')"
                                                                title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                Showing {{ $programs->firstItem() }} to {{ $programs->lastItem() }}
                                of {{ $programs->total() }} programs
                            </div>
                            <div>
                                {{ $programs->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No programs found</h5>
                            <p class="text-muted">No rehabilitation programs match your search criteria.</p>
                            <a href="{{ route('rehabilitation-programs.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Add First Program
                            </a>
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

<script>
function showEnrollmentModal(programId) {
    document.getElementById('enrollmentModalLabel').innerText = 'Manage Enrollments';
    fetch(`/rehabilitation-programs/${programId}/enrollments`)
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
</script>
@endsection
