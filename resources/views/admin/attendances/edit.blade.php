@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header" style="background-color: #070917ff; color: white;">
                <h3 class="mb-0">Edit Attendance Record</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="/admin/attendances/{{ $attendance->id }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Employee</label>
                        <input type="text" class="form-control" value="{{ $attendance->user->full_name }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ \Carbon\Carbon::parse($attendance->date)->format('Y-m-d') }}" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="check_in" class="form-label">Check In</label>
                            <input type="time" class="form-control" id="check_in" name="check_in" value="{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="check_out" class="form-label">Check Out</label>
                            <input type="time" class="form-control" id="check_out" name="check_out" value="{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '' }}">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="present" {{ $attendance->status == 'present' ? 'selected' : '' }}>Present</option>
                            <option value="absent" {{ $attendance->status == 'absent' ? 'selected' : '' }}>Absent</option>
                            <option value="late" {{ $attendance->status == 'late' ? 'selected' : '' }}>Late</option>
                            <option value="half_day" {{ $attendance->status == 'half_day' ? 'selected' : '' }}>Half Day</option>
                        </select>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn" style="background-color: #bf9de3ff; color: #070917ff;">Update Attendance</button>
                        <a href="/admin/attendances" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection