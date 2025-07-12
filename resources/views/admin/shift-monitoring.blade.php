@extends('layout.app')

@section('title', 'Shift Monitoring')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Shift Monitoring</h1>
                <div>
                    <a href="{{ route('admin.guards') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Guards
                    </a>
                    <button class="btn btn-success" onclick="refreshStatus()">
                        <i class="fas fa-sync-alt"></i> Refresh Status
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Time and Shift Info -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-primary" id="currentTime"></h4>
                                <small class="text-muted">Current Time</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-success" id="currentShift">Morning</h4>
                                <small class="text-muted">Current Shift</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-info">{{ $guards->where('is_active', true)->count() }}</h4>
                                <small class="text-muted">Active Guards</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-warning">{{ $guards->count() - $guards->where('is_active', true)->count() }}</h4>
                                <small class="text-muted">Inactive Guards</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shift Cards -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-sun"></i> Morning Shift (6:00 AM - 2:00 PM)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="guard-list" id="morningShift">
                        @foreach($shifts['morning'] as $guard)
                        <div class="guard-item d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                            <div>
                                <strong>{{ $guard->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $guard->department->name ?? 'N/A' }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge badge-{{ $guard->is_active ? 'success' : 'danger' }}">
                                    {{ $guard->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <br>
                                <small class="text-muted">{{ $guard->email }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-cloud-sun"></i> Afternoon Shift (2:00 PM - 10:00 PM)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="guard-list" id="afternoonShift">
                        @foreach($shifts['afternoon'] as $guard)
                        <div class="guard-item d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                            <div>
                                <strong>{{ $guard->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $guard->department->name ?? 'N/A' }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge badge-{{ $guard->is_active ? 'success' : 'danger' }}">
                                    {{ $guard->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <br>
                                <small class="text-muted">{{ $guard->email }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-moon"></i> Night Shift (10:00 PM - 6:00 AM)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="guard-list" id="nightShift">
                        @foreach($shifts['night'] as $guard)
                        <div class="guard-item d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                            <div>
                                <strong>{{ $guard->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $guard->department->name ?? 'N/A' }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge badge-{{ $guard->is_active ? 'success' : 'danger' }}">
                                    {{ $guard->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <br>
                                <small class="text-muted">{{ $guard->email }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- All Guards Status Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Guards Status</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="guardsStatusTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Last Activity</th>
                            <th>Current Location</th>
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
                            <td>
                                <span class="badge bg-info">{{ $guard->department->name ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $guard->is_active ? 'success' : 'danger' }}">
                                    {{ $guard->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $guard->last_login_at ? $guard->last_login_at->diffForHumans() : 'Never' }}</span>
                            </td>
                            <td>
                                <span class="text-muted">Main Gate</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-info" onclick="viewGuardDetails({{ $guard->id }})" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-{{ $guard->is_active ? 'warning' : 'success' }}"
                                            onclick="toggleGuardStatus({{ $guard->id }})"
                                            title="{{ $guard->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="fas fa-{{ $guard->is_active ? 'pause' : 'play' }}"></i>
                                    </button>
                                    <button class="btn btn-sm btn-secondary" onclick="sendMessage({{ $guard->id }})" title="Send Message">
                                        <i class="fas fa-comment"></i>
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

    <!-- Activity Log -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Recent Activity Log</h6>
        </div>
        <div class="card-body">
            <div class="activity-log" id="activityLog">
                <div class="activity-item d-flex align-items-center mb-3 p-3 border rounded">
                    <div class="activity-icon bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                        <i class="fas fa-user-check text-white"></i>
                    </div>
                    <div class="activity-content">
                        <strong>John Doe</strong> logged in at <span class="text-muted">2:30 PM</span>
                        <br>
                        <small class="text-muted">Location: Main Gate</small>
                    </div>
                </div>

                <div class="activity-item d-flex align-items-center mb-3 p-3 border rounded">
                    <div class="activity-icon bg-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                        <i class="fas fa-exchange-alt text-white"></i>
                    </div>
                    <div class="activity-content">
                        <strong>Shift Change</strong> - Morning to Afternoon shift at <span class="text-muted">2:00 PM</span>
                        <br>
                        <small class="text-muted">5 guards transferred</small>
                    </div>
                </div>

                <div class="activity-item d-flex align-items-center mb-3 p-3 border rounded">
                    <div class="activity-icon bg-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                    <div class="activity-content">
                        <strong>Alert</strong> - Guard <strong>Jane Smith</strong> reported incident at <span class="text-muted">1:45 PM</span>
                        <br>
                        <small class="text-muted">Location: Block A</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Guard Details Modal -->
<div class="modal fade" id="guardDetailsModal" tabindex="-1" aria-labelledby="guardDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="guardDetailsModalLabel">Guard Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="guardDetailsContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editGuardFromModal()">Edit Guard</button>
            </div>
        </div>
    </div>
</div>

<!-- Send Message Modal -->
<div class="modal fade" id="sendMessageModal" tabindex="-1" aria-labelledby="sendMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendMessageModalLabel">Send Message to Guard</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="sendMessageForm">
                <div class="modal-body">
                    <input type="hidden" id="message_guard_id" name="guard_id">
                    <div class="mb-3">
                        <label for="message_subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="message_subject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="message_content" class="form-label">Message</label>
                        <textarea class="form-control" id="message_content" name="content" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="message_priority" class="form-label">Priority</label>
                        <select class="form-control" id="message_priority" name="priority">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Message</button>
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
    $('#guardsStatusTable').DataTable({
        order: [[2, 'desc']], // Sort by status
        pageLength: 10,
        responsive: true
    });

    // Update current time
    updateCurrentTime();
    setInterval(updateCurrentTime, 1000);

    // Send Message Form Submission
    $('#sendMessageForm').on('submit', function(e) {
        e.preventDefault();

        const guardId = $('#message_guard_id').val();

        $.ajax({
            url: '/admin/guards/' + guardId + '/send-message',
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#sendMessageModal').modal('hide');
                    alert('Message sent successfully!');
                }
            },
            error: function(xhr) {
                alert('Error sending message. Please try again.');
            }
        });
    });
});

function updateCurrentTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString();
    const dateString = now.toLocaleDateString();

    $('#currentTime').text(timeString);

    // Determine current shift
    const hour = now.getHours();
    let shift = '';
    if (hour >= 6 && hour < 14) {
        shift = 'Morning';
    } else if (hour >= 14 && hour < 22) {
        shift = 'Afternoon';
    } else {
        shift = 'Night';
    }

    $('#currentShift').text(shift);
}

function refreshStatus() {
    location.reload();
}

function viewGuardDetails(guardId) {
    // Load guard details into modal
    $.get('/admin/guards/' + guardId, function(data) {
        $('#guardDetailsContent').html(`
            <div class="row">
                <div class="col-md-6">
                    <h6>Personal Information</h6>
                    <p><strong>Name:</strong> ${data.name}</p>
                    <p><strong>Email:</strong> ${data.email}</p>
                    <p><strong>Department:</strong> ${data.department ? data.department.name : 'N/A'}</p>
                    <p><strong>Status:</strong> <span class="badge badge-${data.is_active ? 'success' : 'danger'}">${data.is_active ? 'Active' : 'Inactive'}</span></p>
                </div>
                <div class="col-md-6">
                    <h6>Activity Information</h6>
                    <p><strong>Last Login:</strong> ${data.last_login_at ? data.last_login_at : 'Never'}</p>
                    <p><strong>Created:</strong> ${data.created_at}</p>
                    <p><strong>Current Location:</strong> Main Gate</p>
                    <p><strong>Current Shift:</strong> Morning</p>
                </div>
            </div>
        `);
        $('#guardDetailsModal').modal('show');
    });
}

function sendMessage(guardId) {
    $('#message_guard_id').val(guardId);
    $('#sendMessageModal').modal('show');
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

function editGuardFromModal() {
    const guardId = $('#guardDetailsContent').data('guard-id');
    window.location.href = '/admin/guards/' + guardId + '/edit';
}
</script>
@endpush
