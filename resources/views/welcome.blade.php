<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prison Management System - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero-section {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem;
            margin: 2rem 0 3rem 0;
            color: white;
        }
        .explore-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(102,126,234,0.08);
            padding: 2rem 1.5rem;
            text-align: center;
            transition: all 0.2s;
            cursor: pointer;
            border: 2px solid transparent;
        }
        .explore-card:hover {
            border-color: #667eea;
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 16px 40px rgba(102,126,234,0.15);
        }
        .explore-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #667eea;
        }
        .footer {
            background: rgba(255,255,255,0.95);
            color: #333;
            padding: 1.5rem 0 0.5rem 0;
            text-align: center;
            border-top: 1px solid #e9ecef;
            margin-top: 3rem;
        }
        .btn-cta {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 14px 36px;
            font-size: 1.2rem;
            font-weight: 600;
            margin-top: 2rem;
            transition: all 0.2s;
        }
        .btn-cta:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: #fff;
            transform: translateY(-2px) scale(1.04);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-shield-alt me-2"></i>
                Prison Management System
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="#explore">Explore</a>
                <a class="nav-link" href="#features">Features</a>
                <a class="nav-link" href="#contact">Contact</a>
                <a class="btn btn-cta ms-2" href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center" style="margin-top: 90px;">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fas fa-shield-alt me-3"></i>
                Prison Management System
            </h1>
            <p class="lead mb-4">
                The all-in-one digital platform for secure, efficient, and modern correctional facility management.
            </p>
            <a href="#explore" class="btn btn-cta">Get Started <i class="fas fa-arrow-down ms-2"></i></a>
        </div>
    </section>

    <!-- Explore Section -->
    <section id="explore" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Explore the System</h2>
                <p class="text-muted">Quick access to all major modules</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="{{ route('departments.index') }}" class="explore-card d-block">
                        <div class="explore-icon"><i class="fas fa-building"></i></div>
                        <div class="fw-bold">Departments</div>
                        <div class="text-muted small">Manage all departments</div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="{{ route('staff.index') }}" class="explore-card d-block">
                        <div class="explore-icon"><i class="fas fa-users"></i></div>
                        <div class="fw-bold">Staff</div>
                        <div class="text-muted small">Staff management</div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="{{ route('inmates.index') }}" class="explore-card d-block">
                        <div class="explore-icon"><i class="fas fa-user-tag"></i></div>
                        <div class="fw-bold">Inmates</div>
                        <div class="text-muted small">Inmate records</div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="{{ route('security-incidents.index') }}" class="explore-card d-block">
                        <div class="explore-icon"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="fw-bold">Security</div>
                        <div class="text-muted small">Incident management</div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="{{ route('medical-records.index') }}" class="explore-card d-block">
                        <div class="explore-icon"><i class="fas fa-heartbeat"></i></div>
                        <div class="fw-bold">Medical</div>
                        <div class="text-muted small">Medical records</div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="{{ route('rehabilitation-programs.index') }}" class="explore-card d-block">
                        <div class="explore-icon"><i class="fas fa-graduation-cap"></i></div>
                        <div class="fw-bold">Rehabilitation</div>
                        <div class="text-muted small">Programs & education</div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="{{ route('visits.index') }}" class="explore-card d-block">
                        <div class="explore-icon"><i class="fas fa-calendar-check"></i></div>
                        <div class="fw-bold">Visits</div>
                        <div class="text-muted small">Visitations</div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="{{ route('inmates.upcoming-releases') }}" class="explore-card d-block">
                        <div class="explore-icon"><i class="fas fa-chart-line"></i></div>
                        <div class="fw-bold">Reports</div>
                        <div class="text-muted small">Analytics & reports</div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Key Features</h2>
                <p class="text-muted">Everything you need for modern prison management</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <i class="fas fa-users fa-3x text-primary mb-3"></i>
                        <h5 class="fw-bold">Staff Management</h5>
                        <p class="text-muted">Comprehensive staff tracking, scheduling, and performance monitoring.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <i class="fas fa-user-tag fa-3x text-success mb-3"></i>
                        <h5 class="fw-bold">Inmate Management</h5>
                        <p class="text-muted">Complete inmate records, classification, and movement tracking.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                        <h5 class="fw-bold">Security Incidents</h5>
                        <p class="text-muted">Real-time incident reporting and response management.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <i class="fas fa-heartbeat fa-3x text-danger mb-3"></i>
                        <h5 class="fw-bold">Medical Records</h5>
                        <p class="text-muted">Comprehensive healthcare tracking and medical history.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <i class="fas fa-graduation-cap fa-3x text-info mb-3"></i>
                        <h5 class="fw-bold">Rehabilitation Programs</h5>
                        <p class="text-muted">Educational programs and skill development tracking.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <i class="fas fa-chart-bar fa-3x text-secondary mb-3"></i>
                        <h5 class="fw-bold">Analytics & Reports</h5>
                        <p class="text-muted">Comprehensive reporting and data analytics tools.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="mb-2">
                <a href="#" class="text-decoration-none text-primary fw-bold">
                    <i class="fas fa-shield-alt me-1"></i> Prison Management System
                </a>
            </div>
            <div class="mb-2">
                &copy; {{ date('Y') }} All rights reserved.
            </div>
            <div id="contact" class="small text-muted">
                Contact: <a href="mailto:admin@prison.com" class="text-decoration-none">admin@prison.com</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
