@extends('layout.app')

@section('title', 'Guard Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Guard Management Dashboard</h1>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Admin
                    </a>
                    <a href="{{ route('admin.shifts') }}" class="btn btn-info">
                        <i class="fas fa-clock"></i> Shift Monitoring
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Guard Statistics -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Guards</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalGuards }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shield-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Active Guards</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeGuards }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Departments with Guards</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $departmentsWithGuards }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Inactive Guards</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalGuards - $activeGuards }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Guards by Department -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Guards by Department</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($departments as $department)
                            @php
                                $departmentGuards = $guards->where('department_id', $department->id);
                                $activeDepartmentGuards = $departmentGuards->where('is_active', true);
                            @endphp
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="card border-left-info">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    {{ $department->name }}</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                    {{ $departmentGuards->count() }} Guards
                                                    <span class="text-success">({{ $activeDepartmentGuards->count() }} Active)</span>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Guards Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Guards</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createGuardModal">
                <i class="fas fa-plus"></i> Add Guard
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="guardsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guards as $guard)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                        <span class="text-white fw-bold">{{ substr($guard->name, 0, 1) }}</span>
                                    </div>
                                    {{ $guard->name }}
                                </div>
                            </td>
                            <td>{{ $guard->email }}</td>
                            <td>
                                <span class="badge bg-info">{{ $guard->department->name ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $guard->is_active ? 'success' : 'danger' }}">
                                    {{ $guard->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $guard->last_login_at ? $guard->last_login_at->diffForHumans() : 'Never' }}</td>
                            <td>{{ $guard->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-info" onclick="editGuard({{ $guard->id }})" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-{{ $guard->is_active ? 'warning' : 'success' }}"
                                            onclick="toggleGuardStatus({{ $guard->id }})"
                                            title="{{ $guard->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="fas fa-{{ $guard->is_active ? 'pause' : 'play' }}"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteGuard({{ $guard->id }})" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Guard Modal -->
<div class="modal fade" id="createGuardModal" tabindex="-1" aria-labelledby="createGuardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createGuardModalLabel">Add New Guard</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createGuardForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="department_id" class="form-label">Department</label>
                        <select class="form-control" id="department_id" name="department_id" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Guard</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Guard Modal -->
<div class="modal fade" id="editGuardModal" tabindex="-1" aria-labelledby="editGuardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGuardModalLabel">Edit Guard</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editGuardForm">
                <div class="modal-body">
                    <input type="hidden" id="edit_guard_id" name="guard_id">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_department_id" class="form-label">Department</label>
                        <select class="form-control" id="edit_department_id" name="department_id" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Password (leave blank to keep current)</label>
                        <input type="password" class="form-control" id="edit_password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="edit_password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Guard</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#guardsTable').DataTable({
        order: [[5, 'desc']], // Sort by created date
        pageLength: 10,
        responsive: true
    });

    // Create Guard Form Submission
    $('#createGuardForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("admin.guards.create") }}',
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#createGuardModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        const input = $('#' + key);
                        input.addClass('is-invalid');
                        input.siblings('.invalid-feedback').remove();
                        input.after('<div class="invalid-feedback">' + errors[key][0] + '</div>');
                    });
                }
            }
        });
    });

    // Edit Guard Form Submission
    $('#editGuardForm').on('submit', function(e) {
        e.preventDefault();

        const guardId = $('#edit_guard_id').val();

        $.ajax({
            url: '/admin/guards/' + guardId,
            method: 'PUT',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#editGuardModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        const input = $('#edit_' + key);
                        input.addClass('is-invalid');
                        input.siblings('.invalid-feedback').remove();
                        input.after('<div class="invalid-feedback">' + errors[key][0] + '</div>');
                    });
                }
            }
        });
    });
});

function editGuard(guardId) {
    // Fetch guard data and populate modal
    $.get('/admin/guards/' + guardId + '/edit', function(data) {
        $('#edit_guard_id').val(data.id);
        $('#edit_name').val(data.name);
        $('#edit_email').val(data.email);
        $('#edit_department_id').val(data.department_id);
        $('#editGuardModal').modal('show');
    });
}

function deleteGuard(guardId) {
    if (confirm('Are you sure you want to delete this guard? This action cannot be undone.')) {
        $.ajax({
            url: '/admin/guards/' + guardId,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    }
}

function toggleGuardStatus(guardId) {
    $.ajax({
        url: '/admin/guards/' + guardId + '/toggle-status',
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                location.reload();
            }
        }
    });
}
</script>
@endpush
