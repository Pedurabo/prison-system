@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Medical Records</h3>
                    <a href="{{ route('medical-records.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Medical Record
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
                                @forelse($medicalRecords as $record)
                                    <tr>
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
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('medical-records.edit', $record) }}"
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('medical-records.destroy', $record) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this medical record?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No medical records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $medicalRecords->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
