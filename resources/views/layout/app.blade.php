<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Prison Management System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            border-radius: 0.375rem;
            margin: 0.25rem 0;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        .navbar-brand {
            font-weight: bold;
            color: #1e3c72 !important;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-shield-alt me-2"></i>
                Prison Management System
            </a>

            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i> Admin
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                                <span>Core Departments</span>
                            </h6>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('departments.index') }}">
                                <i class="fas fa-building me-2"></i>
                                Departments
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('staff.index') }}">
                                <i class="fas fa-users me-2"></i>
                                Staff Management
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('inmates.index') }}">
                                <i class="fas fa-user-tag me-2"></i>
                                Inmate Management
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('security-incidents.index') }}">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Security Incidents
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('medical-records.index') }}">
                                <i class="fas fa-heartbeat me-2"></i>
                                Medical Records
                            </a>
                        </li>

                        <li class="nav-item">
                            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                                <span>Programs & Services</span>
                            </h6>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('rehabilitation-programs.index') }}">
                                <i class="fas fa-graduation-cap me-2"></i>
                                Rehabilitation Programs
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('visits.index') }}">
                                <i class="fas fa-calendar-check me-2"></i>
                                Visitations
                            </a>
                        </li>

                        <li class="nav-item">
                            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                                <span>Reports</span>
                            </h6>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('inmates.upcoming-releases') }}">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Upcoming Releases
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('visits.pending') }}">
                                <i class="fas fa-clock me-2"></i>
                                Pending Visits
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('medical-records.follow-up') }}">
                                <i class="fas fa-stethoscope me-2"></i>
                                Medical Follow-ups
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('page-title')</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        @yield('page-actions')
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
