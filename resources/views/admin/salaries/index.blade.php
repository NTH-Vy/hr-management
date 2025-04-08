@extends('layouts.app')

@section('content')
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Salary Management</h1>
                <div>
                    <a href="/admin/salaries/create" class="btn" style="background-color: #bf9de3ff; color: #070917ff;">
                        <i class="fas fa-plus"></i> Create Salary
                    </a>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="fas fa-filter"></i> Filter
                    </a>
                </div>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Month</th>
                        <th>Base Salary</th>
                        <th>Bonus</th>
                        <th>Deduction</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salaries as $salary)
                    <tr>
                        <td>{{ $salary->user->full_name }}</td>
                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $salary->month)->format('F Y') }}</td>
                        <td>{{ number_format($salary->base_salary, 2) }}</td>
                        <td>{{ number_format($salary->bonus, 2) }}</td>
                        <td>{{ number_format($salary->deduction, 2) }}</td>
                        <td>{{ number_format($salary->total_salary, 2) }}</td>
                        <td>
                            @if($salary->status == 'paid')
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            <a href="/admin/salaries/{{ $salary->id }}" class="btn btn-sm" style="background-color: #bf9de3ff; color: #070917ff;">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/admin/salaries/{{ $salary->id }}/edit" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($salary->status == 'pending')
                                <form action="/admin/salaries/{{ $salary->id }}/pay" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" title="Mark as Paid">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        <div class="mt-3">
            {{ $salaries->links() }}
        </div>

        <!-- Filter Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #070917ff; color: white;">
                        <h5 class="modal-title" id="filterModalLabel">Filter Salaries</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="GET" action="/admin/salaries">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="employee" class="form-label">Employee</label>
                                <select class="form-select" id="employee" name="user_id">
                                    <option value="">All Employees</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->full_name }}
                                        </option>
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
                            <a href="/admin/salaries" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection