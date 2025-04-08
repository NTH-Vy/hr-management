@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header" style="background-color: #070917ff; color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Payroll Details</h3>
                    <div>
                        @if($payroll->status == 'pending')
                            <form action="/admin/payroll/{{ $payroll->id }}/pay" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Mark as Paid</button>
                            </form>
                        @endif
                        <a href="/admin/payroll" class="btn btn-secondary btn-sm">Back</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Employee Information</h5>
                        <p><strong>Name:</strong> {{ $payroll->user->full_name }}</p>
                        <p><strong>Position:</strong> {{ $payroll->user->position->name ?? 'N/A' }}</p>
                        <p><strong>Base Salary:</strong> {{ number_format($payroll->base_salary, 2) }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Payroll Information</h5>
                        <p><strong>Month:</strong> {{ \Carbon\Carbon::createFromFormat('Y-m', $payroll->month)->format('F Y') }}</p>
                        <p><strong>Status:</strong> 
                            @if($payroll->status == 'paid')
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </p>
                        @if($payroll->payment_date)
                            <p><strong>Payment Date:</strong> {{ $payroll->payment_date->format('Y-m-d') }}</p>
                        @endif
                    </div>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Base Salary</td>
                                <td>{{ number_format($payroll->base_salary, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Bonus</td>
                                <td>{{ number_format($payroll->bonus, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Deduction</td>
                                <td>-{{ number_format($payroll->deduction, 2) }}</td>
                            </tr>
                            <tr class="table-active">
                                <td><strong>Total Salary</strong></td>
                                <td><strong>{{ number_format($payroll->total_salary, 2) }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-3">
                    <h5>Attendance Summary</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card text-white mb-3" style="background-color: #070917ff;">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Total Days</h6>
                                    <h4 class="mb-0">{{ $attendanceSummary['total_days'] }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white mb-3" style="background-color: #28a745;">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Present</h6>
                                    <h4 class="mb-0">{{ $attendanceSummary['present'] }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white mb-3" style="background-color: #dc3545;">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Absent</h6>
                                    <h4 class="mb-0">{{ $attendanceSummary['absent'] }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white mb-3" style="background-color: #ffc107; color: #070917ff;">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Late/Half Day</h6>
                                    <h4 class="mb-0">{{ $attendanceSummary['late'] + $attendanceSummary['half_day'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <h5>Rewards & Disciplines</h5>
                    @if($rewardsDisciplines->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rewardsDisciplines as $rd)
                                    <tr>
                                        <td>{{ $rd->date->format('Y-m-d') }}</td>
                                        <td>
                                            @if($rd->type == 'reward')
                                                <span class="badge bg-success">Reward</span>
                                            @else
                                                <span class="badge bg-danger">Discipline</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($rd->amount, 2) }}</td>
                                        <td>{{ Str::limit($rd->reason, 50) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No rewards or disciplines for this period.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection