@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Pending Visit Approvals</h3>
                    <a href="{{ route('visits.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Visits
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($pendingVisits->count() > 0)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>{{ $pendingVisits->count() }} visit(s) pending approval.</strong>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Inmate</th>
                                        <th>Visitor Name</th>
                                        <th>Relationship</th>
                                        <th>Visit Date</th>
                                        <th>Visit Time</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingVisits as $visit)
                                        <tr>
                                            <td>
                                                <a href="{{ route('inmates.show', $visit->inmate) }}">
                                                    {{ $visit->inmate->first_name }} {{ $visit->inmate->last_name }}
                                                </a>
                                            </td>
                                            <td>{{ $visit->visitor_name }}</td>
                                            <td>{{ $visit->visitor_relationship }}</td>
                                            <td>{{ \Carbon\Carbon::parse($visit->visit_time)->format('M d, Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($visit->visit_time)->format('H:i') }}</td>
                                            <td>{{ ucfirst($visit->visit_type) }}</td>
                                            <td>
                                                <span class="badge badge-warning">Pending</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <form action="{{ route('visits.approve', $visit) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <select name="approved_by_staff_id" class="form-control form-control-sm d-inline w-auto" required>
                                                            <option value="">Approve By</option>
                                                            @foreach($staff as $member)
                                                                <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button type="submit" class="btn btn-sm btn-success ml-1">
                                                            <i class="fas fa-check"></i> Approve
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('visits.reject', $visit) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-danger ml-1" onclick="return confirm('Reject this visit request?')">
                                                            <i class="fas fa-times"></i> Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <strong>No pending visit requests at this time.</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
