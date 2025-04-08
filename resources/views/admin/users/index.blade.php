@extends('layouts.app')

@section('content')
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Employee Management</h1>
            <a href="/admin/users/create" class="btn btn-primary">Add Employee</a>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Position</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->full_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->position ? $user->position->name : '-' }}</td>
                    <td>
                        <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                        <form action="/admin/users/{{ $user->id }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
@endsection