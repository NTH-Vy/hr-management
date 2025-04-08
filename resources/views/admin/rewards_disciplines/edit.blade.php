@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header" style="background-color: #070917ff; color: white;">
                <h3 class="mb-0">Edit Record</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="/admin/rewards-disciplines/{{ $record->id }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Employee</label>
                        <input type="text" class="form-control" value="{{ $record->user->full_name }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="reward" {{ $record->type == 'reward' ? 'selected' : '' }}>Reward</option>
                            <option value="discipline" {{ $record->type == 'discipline' ? 'selected' : '' }}>Discipline</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ $record->amount }}" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ \Carbon\Carbon::parse($record->date)->format('Y-m-d') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" required>{{ $record->reason }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Issued By</label>
                        <input type="text" class="form-control" value="{{ $record->issuedBy->full_name }}" readonly>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn" style="background-color: #bf9de3ff; color: #070917ff;">Update</button>
                        <a href="/admin/rewards-disciplines" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection