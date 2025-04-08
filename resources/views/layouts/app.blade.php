<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusHR | Modern Workforce Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/layouts.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap">
    <style>
    :root {
    --primary-500: #4361ee;
    --primary-600: #3a56d4;
    --secondary-500: #7209b7;
    --accent-400: #4cc9f0;
    --accent-500: #3aa8d1;
    --dark-800: #1a1a2e;
    --dark-700: #16213e;
    --light-100: #f8f9fa;
    --light-200: #e9ecef;
    --success-400: #4bb543;
    --danger-400: #f94144;
    --warning-400: #f8961e;
    --info-400: #2b9ed9;
    --border-radius: 12px;
    --box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
    --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    body {
        font-family: "Plus Jakarta Sans", sans-serif;
        background-color: var(--light-100);
        color: var(--dark-700);
        line-height: 1.6;
    }

    /* Glassmorphism Navigation */
    .navbar {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        box-shadow: var(--box-shadow);
        border-bottom: 1px solid rgba(255, 255, 255, 0.18);
        padding: 0.75rem 0;
    }

    .navbar-brand {
        font-weight: 700;
        font-size: 1.75rem;
        background: linear-gradient(
            135deg,
            var(--primary-500),
            var(--secondary-500)
        );
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        display: flex;
        align-items: center;
        letter-spacing: -0.5px;
    }

    .navbar-brand i {
        margin-right: 12px;
        font-size: 2rem;
        background: linear-gradient(
            135deg,
            var(--primary-500),
            var(--secondary-500)
        );
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .nav-link {
        font-weight: 600;
        padding: 0.625rem 1.25rem;
        border-radius: var(--border-radius);
        margin: 0 4px;
        transition: var(--transition);
        color: var(--dark-700);
        position: relative;
    }

    .nav-link:hover,
    .nav-link.active {
        color: var(--primary-500);
        background-color: rgba(67, 97, 238, 0.08);
    }

    .nav-link.active::after {
        content: "";
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 24px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-500), var(--accent-400));
        border-radius: 3px;
    }

    /* Floating dropdowns */
    .dropdown-menu {
        border: none;
        box-shadow: var(--box-shadow);
        border-radius: var(--border-radius);
        padding: 0.75rem 0;
        margin-top: 8px;
        border: 1px solid rgba(255, 255, 255, 0.18);
        background: rgba(255, 255, 255, 0.95);
    }

    .dropdown-item {
        padding: 0.625rem 1.5rem;
        transition: var(--transition);
        font-weight: 500;
        color: var(--dark-700);
    }

    .dropdown-item:hover {
        background-color: rgba(67, 97, 238, 0.08);
        color: var(--primary-500);
        transform: translateX(4px);
    }

    .dropdown-item i {
        width: 24px;
        text-align: center;
        margin-right: 8px;
        color: var(--primary-500);
    }

    /* User profile dropdown */
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-500), var(--accent-400));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-right: 12px;
        font-size: 1.1rem;
    }

    /* Main container */
    .container-fluid {
        max-width: 1600px;
        padding: 0 2rem;
    }

    /* Modern cards */
    .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        transition: var(--transition);
        margin-bottom: 1.75rem;
        overflow: hidden;
        background-color: white;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.12);
    }

    .card-header {
        background: linear-gradient(
            135deg,
            var(--primary-500),
            var(--secondary-500)
        );
        color: white;
        padding: 1.25rem 1.75rem;
        font-weight: 700;
        border-bottom: none;
    }

    .card-body {
        padding: 1.75rem;
    }

    /* Alerts with icons */
    .alert {
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        border: none;
        padding: 1rem 1.5rem;
    }

    .alert i {
        font-size: 1.25rem;
        margin-right: 12px;
    }

    /* Buttons */
    .btn {
        border-radius: var(--border-radius);
        font-weight: 600;
        padding: 0.75rem 1.75rem;
        transition: var(--transition);
        border: none;
    }

    .btn-primary {
        background: linear-gradient(
            135deg,
            var(--primary-500),
            var(--secondary-500)
        );
        box-shadow: 0 4px 14px rgba(67, 97, 238, 0.25);
    }

    .btn-primary:hover {
        background: linear-gradient(
            135deg,
            var(--primary-600),
            var(--secondary-500)
        );
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
    }

    /* Tables */
    .table {
        border-radius: var(--border-radius);
        overflow: hidden;
    }

    .table th {
        background-color: var(--light-200);
        font-weight: 700;
        padding: 1rem 1.5rem;
        border-bottom: none;
    }

    .table td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-top: 1px solid var(--light-200);
    }


    /* Glass panel */
    .glass-panel {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: var(--border-radius);
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: var(--box-shadow);
        padding: 2rem;
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .navbar-collapse {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-top: 12px;
            box-shadow: var(--box-shadow);
        }

        .nav-link {
            margin: 4px 0;
        }

        .nav-link.active::after {
            display: none;
        }
    }

    /* Custom animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out forwards;
    }

    .delay-1 {
        animation-delay: 0.1s;
    }
    .delay-2 {
        animation-delay: 0.2s;
    }
    .delay-3 {
        animation-delay: 0.3s;
    }
    </style>

</head>
<body>
    <!-- Floating Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="bi bi-people"></i>
                <span>NexusHR</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @if(session('user') && session('user')->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="/admin/dashboard">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-sliders me-1"></i> Management
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/admin/users"><i class="bi bi-person-badge"></i> Employee Management</a></li>
                                <li><a class="dropdown-item" href="/admin/positions"><i class="bi bi-diagram-3"></i> Positions</a></li>
                                <li><a class="dropdown-item" href="/admin/attendances"><i class="bi bi-clock-history"></i> Attendance</a></li>
                                <li><a class="dropdown-item" href="/admin/salaries"><i class="bi bi-currency-dollar"></i> Payroll</a></li>
                                <li><a class="dropdown-item" href="/admin/rewards-disciplines"><i class="bi bi-award"></i> Rewards</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> System Settings</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/reports') ? 'active' : '' }}" href="/admin/reports">
                                <i class="bi bi-bar-chart-line me-1"></i> Analytics
                            </a>
                        </li>
                    @elseif(session('user'))
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('employee/dashboard') ? 'active' : '' }}" href="/employee/dashboard">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('employee/attendance-history') ? 'active' : '' }}" href="/employee/attendance-history">
                                <i class="bi bi-calendar-check me-1"></i> My Attendance
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-wallet2 me-1"></i> Payslips
                            </a>
                        </li>
                    @endif
                </ul>
                
                @if(session('user'))
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <div class="user-avatar">
                                {{ substr(session('user')->full_name, 0, 1) }}
                            </div>
                            <div class="d-flex flex-column">
                                <span class="fw-bold">{{ session('user')->full_name }}</span>
                                <small class="text-muted">{{ ucfirst(session('user')->role) }}</small>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @auth
                                @if (auth()->user()->role === 'employee')
                                    <li>
                                        <a class="dropdown-item" href="/employee/profile">
                                            <i class="bi bi-person-circle"></i> My Profile
                                        </a>
                                    </li>
                                @endif
                            @endauth
                            <li><a class="dropdown-item" href="#"><i class="bi bi-bell"></i> Notifications <span class="badge bg-primary ms-2">3</span></a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-question-circle"></i> Help Center</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Sign Out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
                @endif
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container-fluid mt-4">
        <!-- Animated Alerts -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show animate-fade-in" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show animate-fade-in delay-1" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        <!-- Dynamic Content Section -->
        <div class="row animate-fade-in delay-2">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    animation: true,
                    delay: {show: 100, hide: 50}
                });
            });
            
            // Add smooth scroll to all links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
            
            // Animate elements when they come into view
            const animateOnScroll = () => {
                const elements = document.querySelectorAll('.animate-on-scroll');
                elements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const windowHeight = window.innerHeight;
                    
                    if (elementPosition < windowHeight - 100) {
                        element.classList.add('animate-fade-in');
                    }
                });
            };
            
            window.addEventListener('scroll', animateOnScroll);
            animateOnScroll(); // Run once on load
        });
    </script>
    @yield('scripts')
</body>
</html>