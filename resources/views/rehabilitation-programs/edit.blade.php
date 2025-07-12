@extends('layout.app')

@section('title', 'Edit Rehabilitation Program')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Edit Rehabilitation Program
                </h1>
                <a href="{{ route('rehabilitation-programs.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Programs
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Program Details
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('rehabilitation-programs.update', $rehabilitationProgram) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="program_name" class="form-label">Program Name <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('program_name') is-invalid @enderror"
                                           id="program_name"
                                           name="program_name"
                                           value="{{ old('program_name', $rehabilitationProgram->program_name) }}"
                                           required>
                                    @error('program_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="program_type" class="form-label">Program Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('program_type') is-invalid @enderror"
                                            id="program_type"
                                            name="program_type"
                                            required>
                                        <option value="">Select Program Type</option>
                                        <option value="substance_abuse" {{ old('program_type', $rehabilitationProgram->program_type) == 'substance_abuse' ? 'selected' : '' }}>
                                            Substance Abuse Treatment
                                        </option>
                                        <option value="education" {{ old('program_type', $rehabilitationProgram->program_type) == 'education' ? 'selected' : '' }}>
                                            Education Programs
                                        </option>
                                        <option value="vocational_training" {{ old('program_type', $rehabilitationProgram->program_type) == 'vocational_training' ? 'selected' : '' }}>
                                            Vocational Training
                                        </option>
                                        <option value="anger_management" {{ old('program_type', $rehabilitationProgram->program_type) == 'anger_management' ? 'selected' : '' }}>
                                            Anger Management
                                        </option>
                                        <option value="life_skills" {{ old('program_type', $rehabilitationProgram->program_type) == 'life_skills' ? 'selected' : '' }}>
                                            Life Skills Development
                                        </option>
                                        <option value="other" {{ old('program_type', $rehabilitationProgram->program_type) == 'other' ? 'selected' : '' }}>
                                            Other
                                        </option>
                                    </select>
                                    @error('program_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="4"
                                      required>{{ old('description', $rehabilitationProgram->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="instructor_staff_id" class="form-label">Instructor <span class="text-danger">*</span></label>
                                    <select class="form-select @error('instructor_staff_id') is-invalid @enderror"
                                            id="instructor_staff_id"
                                            name="instructor_staff_id"
                                            required>
                                        <option value="">Select Instructor</option>
                                        @foreach($instructors as $instructor)
                                            <option value="{{ $instructor->id }}"
                                                    {{ old('instructor_staff_id', $rehabilitationProgram->instructor_staff_id) == $instructor->id ? 'selected' : '' }}>
                                                {{ $instructor->full_name }} - {{ $instructor->position }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('instructor_staff_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('location') is-invalid @enderror"
                                           id="location"
                                           name="location"
                                           value="{{ old('location', $rehabilitationProgram->location) }}"
                                           required>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="capacity" class="form-label">Capacity <span class="text-danger">*</span></label>
                                    <input type="number"
                                           class="form-control @error('capacity') is-invalid @enderror"
                                           id="capacity"
                                           name="capacity"
                                           value="{{ old('capacity', $rehabilitationProgram->capacity) }}"
                                           min="1"
                                           required>
                                    @error('capacity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="duration_weeks" class="form-label">Duration (Weeks) <span class="text-danger">*</span></label>
                                    <input type="number"
                                           class="form-control @error('duration_weeks') is-invalid @enderror"
                                           id="duration_weeks"
                                           name="duration_weeks"
                                           value="{{ old('duration_weeks', $rehabilitationProgram->duration_weeks) }}"
                                           min="1"
                                           required>
                                    @error('duration_weeks')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="cost" class="form-label">Cost per Participant</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number"
                                               class="form-control @error('cost') is-invalid @enderror"
                                               id="cost"
                                               name="cost"
                                               value="{{ old('cost', $rehabilitationProgram->cost) }}"
                                               min="0"
                                               step="0.01">
                                    </div>
                                    @error('cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                    <input type="date"
                                           class="form-control @error('start_date') is-invalid @enderror"
                                           id="start_date"
                                           name="start_date"
                                           value="{{ old('start_date', $rehabilitationProgram->start_date->format('Y-m-d')) }}"
                                           required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                    <input type="date"
                                           class="form-control @error('end_date') is-invalid @enderror"
                                           id="end_date"
                                           name="end_date"
                                           value="{{ old('end_date', $rehabilitationProgram->end_date->format('Y-m-d')) }}"
                                           required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                            id="status"
                                            name="status">
                                        <option value="planned" {{ old('status', $rehabilitationProgram->status) == 'planned' ? 'selected' : '' }}>
                                            Planned
                                        </option>
                                        <option value="active" {{ old('status', $rehabilitationProgram->status) == 'active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="completed" {{ old('status', $rehabilitationProgram->status) == 'completed' ? 'selected' : '' }}>
                                            Completed
                                        </option>
                                        <option value="cancelled" {{ old('status', $rehabilitationProgram->status) == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="prerequisites" class="form-label">Prerequisites</label>
                            <textarea class="form-control @error('prerequisites') is-invalid @enderror"
                                      id="prerequisites"
                                      name="prerequisites"
                                      rows="3">{{ old('prerequisites', $rehabilitationProgram->prerequisites) }}</textarea>
                            <div class="form-text">Any requirements or prerequisites for participants</div>
                            @error('prerequisites')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input @error('certificate_provided') is-invalid @enderror"
                                       type="checkbox"
                                       id="certificate_provided"
                                       name="certificate_provided"
                                       value="1"
                                       {{ old('certificate_provided', $rehabilitationProgram->certificate_provided) ? 'checked' : '' }}>
                                <label class="form-check-label" for="certificate_provided">
                                    Certificate Provided upon Completion
                                </label>
                                @error('certificate_provided')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('rehabilitation-programs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Update Program
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-calculate end date based on start date and duration
document.getElementById('start_date').addEventListener('change', function() {
    calculateEndDate();
});

document.getElementById('duration_weeks').addEventListener('input', function() {
    calculateEndDate();
});

function calculateEndDate() {
    const startDate = document.getElementById('start_date').value;
    const durationWeeks = document.getElementById('duration_weeks').value;

    if (startDate && durationWeeks) {
        const start = new Date(startDate);
        const end = new Date(start.getTime() + (durationWeeks * 7 * 24 * 60 * 60 * 1000));
        document.getElementById('end_date').value = end.toISOString().split('T')[0];
    }
}

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const startDate = new Date(document.getElementById('start_date').value);
    const endDate = new Date(document.getElementById('end_date').value);

    if (endDate <= startDate) {
        e.preventDefault();
        alert('End date must be after start date.');
        return false;
    }
});
</script>
@endsection
