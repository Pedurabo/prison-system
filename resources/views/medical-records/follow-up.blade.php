@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Medical Records Requiring Follow-up</h3>
                    <a href="{{ route('medical-records.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Medical Records
                    </a>
                </div>
                <div class="card-body">
                    @if($followUpRecords->count() > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Attention:</strong> There are {{ $followUpRecords->count() }} medical records that require follow-up attention.
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Inmate</th>
                                        <th>Attending Staff</th>
                                        <th>Visit Date</th>
                                        <th>Symptoms</th>
                                        <th>Treatment</th>
                                        <th>Emergency Contact</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($followUpRecords as $record)
                                        <tr class="table-warning">
                                            <td>{{ $record->id }}</td>
                                            <td>
                                                <a href="{{ route('inmates.show', $record->inmate) }}">
                                                    {{ $record->inmate->first_name }} {{ $record->inmate->last_name }}
                                                </a>
                                            </td>
                                            <td>{{ $record->attendingStaff->first_name }} {{ $record->attendingStaff->last_name }}</td>
                                            <td>{{ $record->visit_date->format('M d, Y') }}</td>
                                            <td>{{ Str::limit($record->symptoms, 50) }}</td>
                                            <td>{{ Str::limit($record->treatment, 50) }}</td>
                                            <td>{{ $record->emergency_contact }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('medical-records.show', $record) }}"
                                                       class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    <a href="{{ route('medical-records.edit', $record) }}"
                                                       class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i> Update
                                                    </a>
                                                    <a href="{{ route('medical-records.inmate-history', $record->inmate) }}"
                                                       class="btn btn-sm btn-secondary">
                                                        <i class="fas fa-history"></i> History
                                                    </a>
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
                            <strong>Great!</strong> All medical records are up to date. No follow-up required.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
