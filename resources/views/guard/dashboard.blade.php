@extends('layout.app')

@section('title', 'Guard Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Guard Dashboard</h1>
                <div>
                    <span class="badge badge-success me-2">Active</span>
                    <span class="text-muted">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Guard Information -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Current Shift</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="currentShift">Morning</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                                Assigned Location</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Main Gate</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
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
                                Department</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ auth()->user()->department->name ?? 'N/A' }}</div>
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
                                Shift Hours</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">6:00 AM - 2:00 PM</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <button class="btn btn-primary btn-lg w-100" onclick="reportIncident()">
                                <i class="fas fa-exclamation-triangle mb-2"></i>
                                <br>Report Incident
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <button class="btn btn-success btn-lg w-100" onclick="checkIn()">
                                <i class="fas fa-sign-in-alt mb-2"></i>
                                <br>Check In
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <button class="btn btn-info btn-lg w-100" onclick="viewAssignments()">
                                <i class="fas fa-tasks mb-2"></i>
                                <br>View Assignments
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <button class="btn btn-warning btn-lg w-100" onclick="requestSupport()">
                                <i class="fas fa-headset mb-2"></i>
                                <br>Request Support
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Assignments -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Today's Assignments</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Location</th>
                                    <th>Task</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>6:00 AM</td>
                                    <td>Main Gate</td>
                                    <td>Morning Security Check</td>
                                    <td><span class="badge badge-success">Completed</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info">View Details</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>8:00 AM</td>
                                    <td>Block A</td>
                                    <td>Inmate Count</td>
                                    <td><span class="badge badge-warning">In Progress</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-success">Mark Complete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>10:00 AM</td>
                                    <td>Recreation Area</td>
                                    <td>Supervise Recreation</td>
                                    <td><span class="badge badge-secondary">Pending</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary">Start Task</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>12:00 PM</td>
                                    <td>Dining Hall</td>
                                    <td>Lunch Supervision</td>
                                    <td><span class="badge badge-secondary">Pending</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary">Start Task</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Messages</h6>
                </div>
                <div class="card-body">
                    <div class="message-item mb-3 p-3 border rounded">
                        <div class="d-flex justify-content-between">
                            <strong>Admin</strong>
                            <small class="text-muted">2:30 PM</small>
                        </div>
                        <p class="mb-1">Please report to Block B for additional security check.</p>
                        <span class="badge badge-warning">Medium Priority</span>
                    </div>

                    <div class="message-item mb-3 p-3 border rounded">
                        <div class="d-flex justify-content-between">
                            <strong>Supervisor</strong>
                            <small class="text-muted">1:15 PM</small>
                        </div>
                        <p class="mb-1">Shift change reminder: Night shift starts at 10:00 PM.</p>
                        <span class="badge badge-info">Low Priority</span>
                    </div>

                    <div class="message-item mb-3 p-3 border rounded">
                        <div class="d-flex justify-content-between">
                            <strong>Security</strong>
                            <small class="text-muted">11:45 AM</small>
                        </div>
                        <p class="mb-1">Emergency drill scheduled for tomorrow at 9:00 AM.</p>
                        <span class="badge badge-danger">High Priority</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Log -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Today's Activity Log</h6>
                </div>
                <div class="card-body">
                    <div class="activity-log">
                        <div class="activity-item d-flex align-items-center mb-3 p-3 border rounded">
                            <div class="activity-icon bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-sign-in-alt text-white"></i>
                            </div>
                            <div class="activity-content">
                                <strong>Check In</strong> at <span class="text-muted">6:00 AM</span>
                                <br>
                                <small class="text-muted">Location: Main Gate</small>
                            </div>
                        </div>

                        <div class="activity-item d-flex align-items-center mb-3 p-3 border rounded">
                            <div class="activity-icon bg-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-shield-alt text-white"></i>
                            </div>
                            <div class="activity-content">
                                <strong>Security Check</strong> completed at <span class="text-muted">6:30 AM</span>
                                <br>
                                <small class="text-muted">All systems operational</small>
                            </div>
                        </div>

                        <div class="activity-item d-flex align-items-center mb-3 p-3 border rounded">
                            <div class="activity-icon bg-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-users text-white"></i>
                            </div>
                            <div class="activity-content">
                                <strong>Inmate Count</strong> started at <span class="text-muted">8:00 AM</span>
                                <br>
                                <small class="text-muted">Block A - In Progress</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Incident Modal -->
<div class="modal fade" id="reportIncidentModal" tabindex="-1" aria-labelledby="reportIncidentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportIncidentModalLabel">Report Incident</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="reportIncidentForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="incident_type" class="form-label">Incident Type</label>
                                <select class="form-control" id="incident_type" name="incident_type" required>
                                    <option value="">Select Type</option>
                                    <option value="security_breach">Security Breach</option>
                                    <option value="inmate_conflict">Inmate Conflict</option>
                                    <option value="medical_emergency">Medical Emergency</option>
                                    <option value="equipment_failure">Equipment Failure</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="incident_location" class="form-label">Location</label>
                                <select class="form-control" id="incident_location" name="incident_location" required>
                                    <option value="">Select Location</option>
                                    <option value="main_gate">Main Gate</option>
                                    <option value="block_a">Block A</option>
                                    <option value="block_b">Block B</option>
                                    <option value="recreation_area">Recreation Area</option>
                                    <option value="dining_hall">Dining Hall</option>
                                    <option value="medical_wing">Medical Wing</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="incident_description" class="form-label">Description</label>
                        <textarea class="form-control" id="incident_description" name="incident_description" rows="4" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="incident_severity" class="form-label">Severity Level</label>
                                <select class="form-control" id="incident_severity" name="incident_severity" required>
                                    <option value="low">Low</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="incident_priority" class="form-label">Priority</label>
                                <select class="form-control" id="incident_priority" name="incident_priority" required>
                                    <option value="low">Low</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Report Incident</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Check In Modal -->
<div class="modal fade" id="checkInModal" tabindex="-1" aria-labelledby="checkInModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkInModalLabel">Check In</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="checkInForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="checkin_location" class="form-label">Current Location</label>
                        <select class="form-control" id="checkin_location" name="checkin_location" required>
                            <option value="">Select Location</option>
                            <option value="main_gate">Main Gate</option>
                            <option value="block_a">Block A</option>
                            <option value="block_b">Block B</option>
                            <option value="recreation_area">Recreation Area</option>
                            <option value="dining_hall">Dining Hall</option>
                            <option value="medical_wing">Medical Wing</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="checkin_notes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="checkin_notes" name="checkin_notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Check In</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Update current time and shift
    updateCurrentTime();
    setInterval(updateCurrentTime, 1000);

    // Report Incident Form Submission
    $('#reportIncidentForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '/guard/report-incident',
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#reportIncidentModal').modal('hide');
                    alert('Incident reported successfully!');
                    location.reload();
                }
            },
            error: function(xhr) {
                alert('Error reporting incident. Please try again.');
            }
        });
    });

    // Check In Form Submission
    $('#checkInForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '/guard/check-in',
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#checkInModal').modal('hide');
                    alert('Check in successful!');
                    location.reload();
                }
            },
            error: function(xhr) {
                alert('Error checking in. Please try again.');
            }
        });
    });
});

function updateCurrentTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString();

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

function reportIncident() {
    $('#reportIncidentModal').modal('show');
}

function checkIn() {
    $('#checkInModal').modal('show');
}

function viewAssignments() {
    // Navigate to assignments page or show assignments modal
    alert('Viewing assignments...');
}

function requestSupport() {
    // Navigate to support request page or show support modal
    alert('Requesting support...');
}
</script>
@endpush
