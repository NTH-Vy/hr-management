@extends('layouts.app')

@section('content')
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Rewards & Disciplines Management</h1>
                <a href="/admin/rewards-disciplines/create" class="btn" style="background-color: #bf9de3ff; color: #070917ff;">
                    <i class="fas fa-plus"></i> Add New Record
                </a>
            </div>
            <div class="btn-group">
                <a href="/admin/rewards-disciplines?type=reward" class="btn btn-sm {{ request('type') == 'reward' ? 'btn-primary' : 'btn-outline-primary' }}">Rewards</a>
                <a href="/admin/rewards-disciplines?type=discipline" class="btn btn-sm {{ request('type') == 'discipline' ? 'btn-primary' : 'btn-outline-primary' }}">Disciplines</a>
                <a href="/admin/rewards-disciplines" class="btn btn-sm {{ !request('type') ? 'btn-primary' : 'btn-outline-primary' }}">All</a>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Reason</th>
                        <th>Issued By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $record)
                    <tr>
                        <td>{{ $record->user->full_name }}</td>
                        <td>
                            @if($record->type == 'reward')
                                <span class="badge bg-success">Reward</span>
                            @else
                                <span class="badge bg-danger">Discipline</span>
                            @endif
                        </td>
                        <td>{{ number_format($record->amount, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($record->date)->format('Y-m-d') }}</td>
                        <td>{{ Str::limit($record->reason, 50) }}</td>
                        <td>{{ $record->issuedBy->full_name }}</td>
                        <td>
                            <a href="/admin/rewards-disciplines/{{ $record->id }}/edit" class="btn btn-sm" style="background-color: #bf9de3ff; color: #070917ff;">Edit</a>
                            <form action="/admin/rewards-disciplines/{{ $record->id }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        <div class="mt-3">
            {{ $records->links() }}
        </div>
@endsection