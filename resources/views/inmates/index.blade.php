@extends('layout.app')

@section('title', 'Inmate Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-user-tag me-2"></i>
                    Inmate Management
                </h1>
                <div class="btn-group">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inmateModal" id="addInmateBtn">
                        <i class="fas fa-plus me-2"></i>
                        Add New Inmate
                    </button>
                    <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="exportInmates('pdf')">
                            <i class="fas fa-file-pdf me-2"></i>Export to PDF
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="exportInmates('excel')">
                            <i class="fas fa-file-excel me-2"></i>Export to Excel
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" onclick="showBulkActions()">
                            <i class="fas fa-tasks me-2"></i>Bulk Actions
                        </a></li>
                    </ul>
                </div>
            </div>

            <!-- Enhanced Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Total Inmates</h6>
                                    <h3 class="mb-0" id="totalInmates">{{ $inmates->total() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-users fa-2x"></i>
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
                                    <h6 class="card-title">Active Inmates</h6>
                                    <h3 class="mb-0" id="activeInmates">{{ $inmates->where('status', 'active')->count() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-user-check fa-2x"></i>
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
                                    <h6 class="card-title">Upcoming Releases</h6>
                                    <h3 class="mb-0" id="upcomingReleases">{{ $inmates->where('release_date', '<=', now()->addDays(30))->count() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-calendar-alt fa-2x"></i>
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
                                    <h6 class="card-title">Recent Admissions</h6>
                                    <h3 class="mb-0" id="recentAdmissions">{{ $inmates->where('admission_date', '>=', now()->subDays(7))->count() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-user-plus fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Toolbar -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary btn-sm" onclick="showSecurityLevelChart()">
                                    <i class="fas fa-chart-pie me-1"></i>Security Distribution
                                </button>
                                <button class="btn btn-outline-success btn-sm" onclick="showReleaseChart()">
                                    <i class="fas fa-chart-line me-1"></i>Release Timeline
                                </button>
                                <button class="btn btn-outline-warning btn-sm" onclick="showBlockDistribution()">
                                    <i class="fas fa-chart-bar me-1"></i>Block Distribution
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll">Select All</label>
                            </div>
                            <button class="btn btn-danger btn-sm" id="bulkDeleteBtn" style="display: none;" onclick="bulkDelete()">
                                <i class="fas fa-trash me-1"></i>Delete Selected
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Search and Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('inmates.index') }}" class="row g-3" id="searchForm">
                        <div class="col-md-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}" placeholder="Search by name or inmate number">
                        </div>
                        <div class="col-md-2">
                            <label for="security_level" class="form-label">Security Level</label>
                            <select class="form-select" id="security_level" name="security_level">
                                <option value="">All Levels</option>
                                <option value="minimum" {{ request('security_level') == 'minimum' ? 'selected' : '' }}>Minimum</option>
                                <option value="medium" {{ request('security_level') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="maximum" {{ request('security_level') == 'maximum' ? 'selected' : '' }}>Maximum</option>
                                <option value="supermax" {{ request('security_level') == 'supermax' ? 'selected' : '' }}>Supermax</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="block" class="form-label">Block</label>
                            <select class="form-select" id="block" name="block">
                                <option value="">All Blocks</option>
                                @foreach(['A', 'B', 'C', 'D', 'E'] as $block)
                                    <option value="{{ $block }}" {{ request('block') == $block ? 'selected' : '' }}>Block {{ $block }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="released" {{ request('status') == 'released' ? 'selected' : '' }}>Released</option>
                                <option value="transferred" {{ request('status') == 'transferred' ? 'selected' : '' }}>Transferred</option>
                                <option value="deceased" {{ request('status') == 'deceased' ? 'selected' : '' }}>Deceased</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>
                                    Search
                                </button>
                                <a href="{{ route('inmates.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>
                                    Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Enhanced Inmates Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        Inmates List
                    </h5>
                </div>
                <div class="card-body">
                    @if($inmates->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="inmatesTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" class="form-check-input" id="selectAllTable">
                                        </th>
                                        <th>Inmate #</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Security Level</th>
                                        <th>Cell/Block</th>
                                        <th>Admission Date</th>
                                        <th>Release Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inmates as $inmate)
                                        <tr data-inmate-id="{{ $inmate->id }}">
                                            <td>
                                                <input type="checkbox" class="form-check-input inmate-checkbox" value="{{ $inmate->id }}">
                                            </td>
                                            <td>
                                                <strong>{{ $inmate->inmate_number }}</strong>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($inmate->photo_path)
                                                        <img src="{{ asset('storage/' . $inmate->photo_path) }}"
                                                             alt="{{ $inmate->full_name }}"
                                                             class="rounded-circle me-2"
                                                             style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-secondary rounded-circle me-2 d-flex align-items-center justify-content-center"
                                                             style="width: 40px; height: 40px;">
                                                            <i class="fas fa-user text-white"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <strong>{{ $inmate->full_name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $inmate->crime_category }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $inmate->age }} years</td>
                                            <td>
                                                @php
                                                    $levelColors = [
                                                        'minimum' => 'success',
                                                        'medium' => 'warning',
                                                        'maximum' => 'danger',
                                                        'supermax' => 'dark'
                                                    ];
                                                    $color = $levelColors[$inmate->security_level] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $color }}">
                                                    {{ ucfirst($inmate->security_level) }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong>{{ $inmate->cell_number }}</strong>
                                                <br>
                                                <small class="text-muted">Block {{ $inmate->block }}</small>
                                            </td>
                                            <td>{{ $inmate->admission_date->format('M d, Y') }}</td>
                                            <td>
                                                @if($inmate->release_date)
                                                    {{ $inmate->release_date->format('M d, Y') }}
                                                    @if($inmate->release_date->isPast())
                                                        <span class="badge bg-success ms-1">Released</span>
                                                    @elseif($inmate->release_date->diffInDays(now()) <= 30)
                                                        <span class="badge bg-warning ms-1">Soon</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">Not set</span>
                                                @endif
                                            </td>
                                            <td>
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
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('inmates.show', $inmate) }}"
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-warning editInmateBtn"
                                                            data-id="{{ $inmate->id }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#inmateModal"
                                                            title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger"
                                                            onclick="deleteInmate({{ $inmate->id }})"
                                                            title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
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
                                Showing {{ $inmates->firstItem() }} to {{ $inmates->lastItem() }}
                                of {{ $inmates->total() }} inmates
                            </div>
                            <div>
                                {{ $inmates->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No inmates found</h5>
                            <p class="text-muted">No inmates match your search criteria.</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inmateModal" id="addFirstInmateBtn">
                                <i class="fas fa-plus me-2"></i>
                                Add First Inmate
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Inmate Modal -->
<div class="modal fade" id="inmateModal" tabindex="-1" aria-labelledby="inmateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inmateModalLabel">Add/Edit Inmate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="inmateModalBody">
                <!-- Form will be loaded here via AJAX -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Modal -->
<div class="modal fade" id="chartsModal" tabindex="-1" aria-labelledby="chartsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chartsModalLabel">Analytics & Charts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="chartsModalBody">
                <!-- Charts will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Toast Notifications -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" id="successToastBody">
            Operation completed successfully.
        </div>
    </div>

    <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-white">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong class="me-auto">Error</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" id="errorToastBody">
            An error occurred. Please try again.
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this inmate? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Global variables
let selectedInmates = [];

// Load Add Inmate form in modal
document.getElementById('addInmateBtn').addEventListener('click', function() {
    document.getElementById('inmateModalLabel').innerText = 'Add New Inmate';
    loadForm("{{ route('inmates.create') }}");
});

// Load Edit Inmate form in modal
document.querySelectorAll('.editInmateBtn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        document.getElementById('inmateModalLabel').innerText = 'Edit Inmate';
        loadForm(`/inmates/${id}/edit`);
    });
});

// Enhanced form loading function
function loadForm(url) {
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(html => {
            document.getElementById('inmateModalBody').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading form:', error);
            showNotification('Error loading form. Please try again.', 'error');
        });
}

// Enhanced form submission
document.getElementById('inmateModal').addEventListener('submit', function(e) {
    if (e.target.tagName === 'FORM') {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const action = form.action;
        const method = form.method.toUpperCase();

        fetch(action, {
            method: method,
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                bootstrap.Modal.getInstance(document.getElementById('inmateModal')).hide();
                // Reload the page to show updated data
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification(data.message || 'An error occurred', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred. Please try again.', 'error');
        });
    }
});

// Bulk selection functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.inmate-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateBulkActions();
});

document.getElementById('selectAllTable').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.inmate-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateBulkActions();
});

// Update bulk actions visibility
function updateBulkActions() {
    const selectedCheckboxes = document.querySelectorAll('.inmate-checkbox:checked');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

    if (selectedCheckboxes.length > 0) {
        bulkDeleteBtn.style.display = 'inline-block';
        selectedInmates = Array.from(selectedCheckboxes).map(cb => cb.value);
    } else {
        bulkDeleteBtn.style.display = 'none';
        selectedInmates = [];
    }
}

// Add event listeners to individual checkboxes
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('inmate-checkbox')) {
        updateBulkActions();
    }
});

// Bulk delete function
function bulkDelete() {
    if (selectedInmates.length === 0) {
        showNotification('Please select inmates to delete', 'error');
        return;
    }

    if (confirm(`Are you sure you want to delete ${selectedInmates.length} inmate(s)?`)) {
        fetch('/inmates/bulk-delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ ids: selectedInmates })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        });
    }
}

// Export functionality
function exportInmates(format) {
    const searchParams = new URLSearchParams(window.location.search);
    const url = `/inmates/export/${format}?${searchParams.toString()}`;
    window.open(url, '_blank');
}

// Chart functions
function showSecurityLevelChart() {
    document.getElementById('chartsModalLabel').innerText = 'Security Level Distribution';
    document.getElementById('chartsModalBody').innerHTML = '<canvas id="securityChart"></canvas>';
    bootstrap.Modal.getInstance(document.getElementById('chartsModal')).show();

    // Load chart data via AJAX
    fetch('/inmates/security-level-chart')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('securityChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.data,
                        backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#343a40']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
}

function showReleaseChart() {
    document.getElementById('chartsModalLabel').innerText = 'Release Timeline';
    document.getElementById('chartsModalBody').innerHTML = '<canvas id="releaseChart"></canvas>';
    bootstrap.Modal.getInstance(document.getElementById('chartsModal')).show();

    fetch('/inmates/release-chart')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('releaseChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Releases',
                        data: data.data,
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
}

function showBlockDistribution() {
    document.getElementById('chartsModalLabel').innerText = 'Block Distribution';
    document.getElementById('chartsModalBody').innerHTML = '<canvas id="blockChart"></canvas>';
    bootstrap.Modal.getInstance(document.getElementById('chartsModal')).show();

    fetch('/inmates/block-chart')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('blockChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Inmates per Block',
                        data: data.data,
                        backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1']
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
}

// Notification system
function showNotification(message, type = 'success') {
    const toast = document.getElementById(type === 'success' ? 'successToast' : 'errorToast');
    const body = document.getElementById(type === 'success' ? 'successToastBody' : 'errorToastBody');
    body.textContent = message;

    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
}

// Enhanced delete function
function deleteInmate(inmateId) {
    if (confirm('Are you sure you want to delete this inmate? This action cannot be undone.')) {
        fetch(`/inmates/${inmateId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        });
    }
}

// Real-time search (optional enhancement)
let searchTimeout;
document.getElementById('search').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        document.getElementById('searchForm').submit();
    }, 500);
});
</script>
@endpush
@endsection
