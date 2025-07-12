@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Resolve Security Incident</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Incident:</strong> {{ $securityIncident->incident_number }} - {{ ucfirst(str_replace('_', ' ', $securityIncident->incident_type)) }}
                    </div>

                    <form action="{{ route('security-incidents.mark-resolved', $securityIncident) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="resolved_by_staff_id">Resolved By <span class="text-danger">*</span></label>
                                    <select name="resolved_by_staff_id" id="resolved_by_staff_id" class="form-control @error('resolved_by_staff_id') is-invalid @enderror" required>
                                        <option value="">Select Staff Member</option>
                                        @foreach($staff as $member)
                                            <option value="{{ $member->id }}" {{ old('resolved_by_staff_id') == $member->id ? 'selected' : '' }}>
                                                {{ $member->first_name }} {{ $member->last_name }} - {{ $member->department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('resolved_by_staff_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="resolution">Resolution Details <span class="text-danger">*</span></label>
                            <textarea name="resolution" id="resolution" rows="6"
                                      class="form-control @error('resolution') is-invalid @enderror"
                                      placeholder="Provide detailed resolution information..." required>{{ old('resolution') }}</textarea>
                            @error('resolution')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Mark as Resolved
                            </button>
                            <a href="{{ route('security-incidents.show', $securityIncident) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Incident
                            </a>
                        </div>
                    </form>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Incident Summary</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Type:</strong></td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $securityIncident->incident_type)) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Severity:</strong></td>
                                    <td>{{ ucfirst($securityIncident->severity_level) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Location:</strong></td>
                                    <td>{{ $securityIncident->location }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date:</strong></td>
                                    <td>{{ $securityIncident->incident_date->format('F d, Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5>Description</h5>
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-text">{{ $securityIncident->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
