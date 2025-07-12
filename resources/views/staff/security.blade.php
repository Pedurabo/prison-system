@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Security Staff</h3>
                    <a href="{{ route('staff.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to All Staff
                    </a>
                </div>
                <div class="card-body">
                    @if($securityStaff->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Hire Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($securityStaff as $member)
                                        <tr>
                                            <td>{{ $member->employee_id }}</td>
                                            <td>{{ $member->first_name }} {{ $member->last_name }}</td>
                                            <td>{{ $member->position }}</td>
                                            <td>{{ $member->email }}</td>
                                            <td>{{ $member->phone }}</td>
                                            <td>{{ $member->hire_date->format('M d, Y') }}</td>
                                            <td>
                                                <span class="badge badge-{{ $member->status === 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($member->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('staff.show', $member) }}"
                                                       class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('staff.edit', $member) }}"
                                                       class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>No security staff found.</strong>
                            <a href="{{ route('staff.create') }}" class="alert-link">Add security staff members</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
