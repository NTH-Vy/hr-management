@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header" style="background-color: #070917ff; color: white;">
                <h3 class="mb-0">Generate Payroll</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="/admin/payroll/generate">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="month" class="form-label">Select Month</label>
                        <input type="month" class="form-control" id="month" name="month" 
                               value="{{ old('month', now()->format('Y-m')) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="employee" class="form-label">Select Employee (Leave blank for all)</label>
                        <select class="form-select" id="employee" name="user_id">
                            <option value="">All Employees</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->full_name }} ({{ $user->position ? $user->position->name : 'No Position' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="include_rewards" name="include_rewards" checked>
                        <label class="form-check-label" for="include_rewards">
                            Include rewards and disciplines
                        </label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="include_attendance" name="include_attendance" checked>
                        <label class="form-check-label" for="include_attendance">
                            Include attendance adjustments
                        </label>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn" style="background-color: #bf9de3ff; color: #070917ff;">
                            <i class="fas fa-calculator"></i> Generate Payroll
                        </button>
                        <a href="/admin/payroll" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection