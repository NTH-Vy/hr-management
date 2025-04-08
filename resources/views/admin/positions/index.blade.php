@extends('layouts.app')

@section('content')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Position Management</h1>
            <a href="/admin/positions/create" class="btn btn-primary">Add New Position</a>
        </div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Position Name</th>
                        <th>Base Salary</th>
                        <th>description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($positions as $position)
                    <tr>
                        <td>{{ $position->id }}</td>
                        <td>{{ $position->name }}</td>
                        <td>{{ number_format($position->base_salary, 2) }}</td>
                        <td>{{ $position->description }}</td>
                        <td>
                            <a href="/admin/positions/{{ $position->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                            <form action="/admin/positions/{{ $position->id }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this position?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
@endsection