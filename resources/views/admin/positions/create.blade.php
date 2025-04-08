@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header" style="background-color: #070917ff; color: white;">
                <h3 class="mb-0">Create New Position</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="/admin/positions">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Position Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="base_salary" class="form-label">Base Salary</label>
                        <input type="number" step="0.01" class="form-control" id="base_salary" name="base_salary" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn" style="background-color: #bf9de3ff; color: #070917ff;">Create Position</button>
                        <a href="/admin/positions" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection