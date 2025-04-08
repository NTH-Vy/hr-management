@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header" style="background-color: #070917ff; color: white;">
                <h3 class="mb-0">Today's Attendance</h3>
            </div>
            <div class="card-body text-center">
                @if($todayAttendance)
                    <div class="attendance-status mb-4">
                        <h4>
                            @if($todayAttendance->status == 'present')
                                <span class="badge bg-success">Present</span>
                            @elseif($todayAttendance->status == 'late')
                                <span class="badge bg-warning text-dark">Late</span>
                            @elseif($todayAttendance->status == 'half_day')
                                <span class="badge bg-info">Half Day</span>
                            @endif
                        </h4>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Check In</h5>
                                    <p class="display-6">{{ $todayAttendance->check_in ? \Carbon\Carbon::parse($todayAttendance->check_in)->format('H:i:s') : '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Check Out</h5>
                                    @if($todayAttendance->check_out)
                                        <p class="display-6">{{ $todayAttendance->check_out ? \Carbon\Carbon::parse($todayAttendance->check_out)->format('H:i:s') : '-' }}</p>

                                    @else
                                        <form action="/employee/check-out" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-lg" style="background-color: #dc3545; color: white;">
                                                <i class="fas fa-sign-out-alt"></i> Check Out
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($todayAttendance->check_out)
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Working Hours</h5>
                                <p class="display-6">{{ number_format($todayAttendance->total_hours, 2) }} hours</p>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="no-attendance">
                        <p class="lead mb-4">You haven't checked in today</p>
                        <p class="text-muted">Current Time: {{ \Carbon\Carbon::now()->format('H:i:s') }}</p> 
                        <form action="/employee/check-in" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-lg" style="background-color: #bf9de3ff; color: #070917ff;">
                                <i class="fas fa-sign-in-alt"></i> Check In Now
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header" style="background-color: #070917ff; color: white;">
                <h3 class="mb-0">This Month Summary</h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Present</h6>
                                <h4 class="mb-0">{{ $monthlySummary['present'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Late</h6>
                                <h4 class="mb-0">{{ $monthlySummary['late'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Absent</h6>
                                <h4 class="mb-0">{{ $monthlySummary['absent'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Half Day</h6>
                                <h4 class="mb-0">{{ $monthlySummary['half_day'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header" style="background-color: #070917ff; color: white;">
                <h3 class="mb-0">Quick Actions</h3>
            </div>
            <div class="card-body">
                <a href="/employee/attendance-history" class="btn btn-block mb-2" style="background-color: #bf9de3ff; color: #070917ff;">
                    <i class="fas fa-history"></i> Attendance History
                </a>
                <a href="/employee/profile" class="btn btn-block mb-2" style="background-color: #070917ff; color: white;">
                    <i class="fas fa-user"></i> My Profile
                </a>
            </div>
        </div>
    </div>
</div>
@endsection