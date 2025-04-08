@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Payroll Management</h1>
    <div>
        <a href="/admin/payroll/generate" class="btn" style="background-color: #bf9de3ff; color: #070917ff;">
            <i class="fas fa-calculator"></i> Generate Payroll
        </a>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
            <i class="fas fa-filter"></i> Filter
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header" style="background-color: #070917ff; color: white;">
        <h3 class="mb-0">Payroll Records</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Month</th>
                        <th>Base Salary</th>
                        <th>Bonus</th>
                        <th>Deduction</th>
                        <th>Total Salary</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payrolls as $payroll)
                    <tr>
                        <td>{{ $payroll->user->full_name }}</td>
                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $payroll->month)->format('F Y') }}</td>
                        <td>{{ number_format($payroll->base_salary, 2) }}</td>
                        <td>{{ number_format($payroll->bonus, 2) }}</td>
                        <td>{{ number_format($payroll->deduction, 2) }}</td>
                        <td>{{ number_format($payroll->total_salary, 2) }}</td>
                        <td>
                            @if($payroll->status == 'paid')
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            <a href="/admin/payroll/{{ $payroll->id }}" class="btn btn-sm" style="background-color: #bf9de3ff; color: #070917ff;">View</a>
                            <a href="/admin/payroll/{{ $payroll->id }}/edit" class="btn btn-sm btn-primary">Edit</a>
                            @if($payroll->status == 'pending')
                                <form action="/admin/payroll/{{ $payroll->id }}/pay" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Mark as Paid</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $payrolls->links() }}
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #070917ff; color: white;">
                <h5 class="modal-title" id="filterModalLabel">Filter Payroll</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="GET" action="/admin/payroll">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="employee" class="form-label">Employee</label>
                        <select class="form-select" id="employee" name="user_id">
                            <option value="">All Employees</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="month" class="form-label">Month</label>
                        <input type="month" class="form-control" id="month" name="month" value="{{ request('month') }}">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Statuses</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn" style="background-color: #bf9de3ff; color: #070917ff;">Apply Filter</button>
                    <a href="/admin/payroll" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection