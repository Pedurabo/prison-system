@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Medical Record Details</h3>
                    <div>
                        <a href="{{ route('medical-records.edit', $medicalRecord) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('medical-records.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Patient Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Inmate:</strong></td>
                                    <td>
                                        <a href="{{ route('inmates.show', $medicalRecord->inmate) }}">
                                            {{ $medicalRecord->inmate->first_name }} {{ $medicalRecord->inmate->last_name }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Inmate ID:</strong></td>
                                    <td>{{ $medicalRecord->inmate->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Visit Date:</strong></td>
                                    <td>{{ $medicalRecord->visit_date->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Emergency Contact:</strong></td>
                                    <td>{{ $medicalRecord->emergency_contact }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5>Medical Staff Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Attending Staff:</strong></td>
                                    <td>{{ $medicalRecord->attendingStaff->first_name }} {{ $medicalRecord->attendingStaff->last_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Department:</strong></td>
                                    <td>{{ $medicalRecord->attendingStaff->department->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Staff ID:</strong></td>
                                    <td>{{ $medicalRecord->attendingStaff->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Record ID:</strong></td>
                                    <td>{{ $medicalRecord->id }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Symptoms</h5>
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-text">{{ $medicalRecord->symptoms }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5>Treatment</h5>
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-text">{{ $medicalRecord->treatment }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h5>Actions</h5>
                            <div class="btn-group" role="group">
                                <a href="{{ route('medical-records.edit', $medicalRecord) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Record
                                </a>
                                <a href="{{ route('medical-records.inmate-history', $medicalRecord->inmate) }}" class="btn btn-info">
                                    <i class="fas fa-history"></i> View Patient History
                                </a>
                                <form action="{{ route('medical-records.destroy', $medicalRecord) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this medical record?')">
                                        <i class="fas fa-trash"></i> Delete Record
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
