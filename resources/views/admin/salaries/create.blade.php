@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header" style="background-color: #070917ff; color: white;">
                <h3 class="mb-0">Create New Salary Record</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="/admin/salaries">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Employee</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <option value="">Select Employee</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->full_name }} ({{ $user->position ? $user->position->name : 'No Position' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="month" class="form-label">Month</label>
                        <input type="month" class="form-control" id="month" name="month" 
                               value="{{ old('month', date('Y-m')) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="base_salary" class="form-label">Base Salary</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" class="form-control" id="base_salary" name="base_salary" 
                                   value="{{ old('base_salary') }}" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="bonus" class="form-label">Bonus</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" class="form-control" id="bonus" name="bonus" 
                                   value="{{ old('bonus', 0) }}">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="deduction" class="form-label">Deduction</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" class="form-control" id="deduction" name="deduction" 
                                   value="{{ old('deduction', 0) }}">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="total_hours" class="form-label">Total Working Hours</label>
                        <input type="number" step="0.01" class="form-control" id="total_hours" name="total_hours" 
                               value="{{ old('total_hours') }}" required>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn" style="background-color: #bf9de3ff; color: #070917ff;">
                            Create Salary Record
                        </button>
                        <a href="/admin/salaries" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Automatically calculate total salary when values change
document.addEventListener('DOMContentLoaded', function() {
    const baseSalary = document.getElementById('base_salary');
    const bonus = document.getElementById('bonus');
    const deduction = document.getElementById('deduction');
    
    function calculateTotal() {
        const total = (parseFloat(baseSalary.value) || 0) + 
                     (parseFloat(bonus.value) || 0) - 
                     (parseFloat(deduction.value) || 0);
        document.getElementById('total_salary_preview').textContent = total.toFixed(2);
    }
    
    baseSalary.addEventListener('input', calculateTotal);
    bonus.addEventListener('input', calculateTotal);
    deduction.addEventListener('input', calculateTotal);
});
</script>
@endsection