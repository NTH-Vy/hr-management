
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Human Resource Management</h1>

    <!-- Quick Statistics -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Employees</div>
                <div class="card-body">
                    <h5 class="card-title">{{ \App\Models\User::count() }}</h5>
                    <p class="card-text">Current employees</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Job Positions</div>
                <div class="card-body">
                    <h5 class="card-title">{{ \App\Models\Position::count() }}</h5>
                    <p class="card-text">Total positions</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Today's Attendance</div>
                <div class="card-body">
                    <h5 class="card-title">{{ \App\Models\Attendance::whereDate('date', today())->count() }}</h5>
                    <p class="card-text">Employees present</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Late Today</div>
                <div class="card-body">
                    <h5 class="card-title">{{ \App\Models\Attendance::whereDate('date', today())->where('status', 'late')->count() }}</h5>
                    <p class="card-text">Employees late</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Employee Attendance -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Recent Employee Attendance</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Check-in Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Attendance::with('user.position')->orderBy('check_in', 'desc')->take(5)->get() as $attendance)
                            <tr>
                                <td>{{ $attendance->user->full_name ?? 'N/A' }}</td>
                                <td>{{ $attendance->user->position->name ?? 'N/A' }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($attendance->check_in)->format('d/m/Y H:i') }}
                                </td>
                                <td>
                                    <span class="badge {{ $attendance->status == 'on_time' ? 'bg-success' : 'bg-warning' }}">
                                        {{ $attendance->status == 'on_time' ? 'On Time' : 'Late' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Tools - Professional Version -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-semibold text-dark">Human Resource Management Tools</h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary py-2 px-3">Total: 2 tools</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Tool Buttons Column -->
                        <div class="col-lg-8">
                            <div class="d-flex flex-wrap gap-3">
                                <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-primary d-flex align-items-center p-3 rounded-3">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-2 me-3">
                                        <i class="fas fa-file-alt text-primary fs-4"></i>
                                    </div>
                                    <div class="text-start">
                                        <div class="fw-semibold">Attendance Reports</div>
                                        <small class="text-muted">View and export reports</small>
                                    </div>
                                </a>
                                
                                <a href="{{ url('/admin/leave-requests') }}" class="btn btn-outline-warning d-flex align-items-center p-3 rounded-3">
                                    <div class="bg-warning bg-opacity-10 p-3 rounded-2 me-3">
                                        <i class="fas fa-calendar-times text-warning fs-4"></i>
                                    </div>
                                    <div class="text-start">
                                        <div class="fw-semibold">Leave Requests</div>
                                        <small class="text-muted">Approve leave requests</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Quick Statistics Column -->
                        <div class="col-lg-4 mt-4 mt-lg-0">
                            <div class="card border-0 shadow-none bg-light">
                                <div class="card-body p-3">
                                    <h6 class="fw-semibold mb-3 text-dark">Quick Statistics</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-user-clock text-muted me-2 fs-6"></i>
                                                <span>New Employees</span>
                                            </div>
                                            <span class="badge bg-primary rounded-pill px-3 py-1">
                                                {{ \App\Models\User::where('created_at', '>=', now()->subDays(7))->count() }} week
                                            </span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-clock text-muted me-2 fs-6"></i>
                                                <span>Pending Requests</span>
                                            </div>
                                            <span class="badge bg-warning rounded-pill px-3 py-1">
                                                @if(class_exists('App\Models\LeaveRequest'))
                                                    {{ \App\Models\LeaveRequest::where('status', 'pending')->count() }}
                                                @else
                                                    0
                                                @endif
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Short Guide -->
                    <div class="mt-4">
                        <div class="alert alert-light border d-flex align-items-center p-3 mb-0">
                            <i class="fas fa-info-circle text-primary me-3 fs-5"></i>
                            <div>
                                <small class="d-block text-dark fw-medium">Quick access to management tools</small>
                                <small class="text-muted">Use the tools above to effectively monitor and manage daily HR activities.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Detailed Information -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">Attendance Statistics This Week</div>
                <div class="card-body">
                    <canvas id="attendanceChart"></canvas>
                    <p class="text-muted mt-2">The chart shows the number of employees present by day of the week</p>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Script for Chart (using Chart.js) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const attendanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            datasets: [{
                label: 'Number of Employees Present',
                data: [/* Sample data, replace with actual data */ 45, 50, 48, 52, 47, 30, 25],
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection