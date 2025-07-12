@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Medical History - {{ $inmate->first_name }} {{ $inmate->last_name }}</h3>
                    <div>
                        <a href="{{ route('medical-records.create') }}?inmate_id={{ $inmate->id }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Record
                        </a>
                        <a href="{{ route('medical-records.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Medical Records
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Patient Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $inmate->first_name }} {{ $inmate->last_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>ID:</strong></td>
                                    <td>{{ $inmate->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Records:</strong></td>
                                    <td>{{ $medicalHistory->count() }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Quick Actions</h5>
                            <div class="btn-group-vertical w-100">
                                <a href="{{ route('inmates.show', $inmate) }}" class="btn btn-info">
                                    <i class="fas fa-user"></i> View Inmate Profile
                                </a>
                                <a href="{{ route('medical-records.create') }}?inmate_id={{ $inmate->id }}" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Add Medical Record
                                </a>
                            </div>
                        </div>
                    </div>

                    @if($medicalHistory->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Attending Staff</th>
                                        <th>Symptoms</th>
                                        <th>Treatment</th>
                                        <th>Emergency Contact</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($medicalHistory as $record)
                                        <tr>
                                            <td>{{ $record->visit_date->format('M d, Y') }}</td>
                                            <td>{{ $record->attendingStaff->first_name }} {{ $record->attendingStaff->last_name }}</td>
                                            <td>{{ Str::limit($record->symptoms, 50) }}</td>
                                            <td>{{ Str::limit($record->treatment, 50) }}</td>
                                            <td>{{ $record->emergency_contact }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('medical-records.show', $record) }}"
                                                       class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('medical-records.edit', $record) }}"
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
                            <strong>No medical records found</strong> for this inmate.
                            <a href="{{ route('medical-records.create') }}?inmate_id={{ $inmate->id }}" class="alert-link">Add the first medical record</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
