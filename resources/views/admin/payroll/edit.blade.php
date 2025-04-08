@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header" style="background-color: #070917ff; color: white;">
                <h3 class="mb-0">Edit Payroll</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="/admin/payroll/{{ $payroll->id }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Employee</label>
                        <input type="text" class="form-control" value="{{ $payroll->user->full_name }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Month</label>
                        <input type="text" class="form-control" 
                               value="{{ \Carbon\Carbon::createFromFormat('Y-m', $payroll->month)->format('F Y') }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="base_salary" class="form-label">Base Salary</label>
                        <input type="number" step="0.01" class="form-control" id="base_salary" name="base_salary" 
                               value="{{ $payroll->base_salary }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="bonus" class="form-label">Bonus</label>
                        <input type="number" step="0.01" class="form-control" id="bonus" name="bonus" 
                               value="{{ $payroll->bonus }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="deduction" class="form-label">Deduction</label>
                        <input type="number" step="0.01" class="form-control" id="deduction" name="deduction" 
                               value="{{ $payroll->deduction }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Total Salary</label>
                        <input type="text" class="form-control" 
                               value="{{ number_format($payroll->base_salary + $payroll->bonus - $payroll->deduction, 2) }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" {{ $payroll->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $payroll->status == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn" style="background-color: #bf9de3ff; color: #070917ff;">Update Payroll</button>
                        <a href="/admin/payroll" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection