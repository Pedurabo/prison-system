@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Report Security Incident</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('security-incidents.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="incident_number">Incident Number <span class="text-danger">*</span></label>
                                    <input type="text" name="incident_number" id="incident_number"
                                           class="form-control @error('incident_number') is-invalid @enderror"
                                           value="{{ old('incident_number') }}"
                                           placeholder="e.g., INC-2024-001" required>
                                    @error('incident_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="incident_type">Incident Type <span class="text-danger">*</span></label>
                                    <select name="incident_type" id="incident_type" class="form-control @error('incident_type') is-invalid @enderror" required>
                                        <option value="">Select Incident Type</option>
                                        <option value="fight" {{ old('incident_type') == 'fight' ? 'selected' : '' }}>Fight</option>
                                        <option value="contraband" {{ old('incident_type') == 'contraband' ? 'selected' : '' }}>Contraband</option>
                                        <option value="escape_attempt" {{ old('incident_type') == 'escape_attempt' ? 'selected' : '' }}>Escape Attempt</option>
                                        <option value="self_harm" {{ old('incident_type') == 'self_harm' ? 'selected' : '' }}>Self Harm</option>
                                        <option value="assault" {{ old('incident_type') == 'assault' ? 'selected' : '' }}>Assault</option>
                                        <option value="disturbance" {{ old('incident_type') == 'disturbance' ? 'selected' : '' }}>Disturbance</option>
                                        <option value="other" {{ old('incident_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('incident_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="severity_level">Severity Level <span class="text-danger">*</span></label>
                                    <select name="severity_level" id="severity_level" class="form-control @error('severity_level') is-invalid @enderror" required>
                                        <option value="">Select Severity Level</option>
                                        <option value="low" {{ old('severity_level') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('severity_level') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('severity_level') == 'high' ? 'selected' : '' }}>High</option>
                                        <option value="critical" {{ old('severity_level') == 'critical' ? 'selected' : '' }}>Critical</option>
                                    </select>
                                    @error('severity_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="incident_date">Incident Date & Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="incident_date" id="incident_date"
                                           class="form-control @error('incident_date') is-invalid @enderror"
                                           value="{{ old('incident_date', now()->format('Y-m-d\TH:i')) }}" required>
                                    @error('incident_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location">Location <span class="text-danger">*</span></label>
                                    <input type="text" name="location" id="location"
                                           class="form-control @error('location') is-invalid @enderror"
                                           value="{{ old('location') }}"
                                           placeholder="e.g., Cell Block A, Dining Hall, Yard" required>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reported_by_staff_id">Reported By <span class="text-danger">*</span></label>
                                    <select name="reported_by_staff_id" id="reported_by_staff_id" class="form-control @error('reported_by_staff_id') is-invalid @enderror" required>
                                        <option value="">Select Staff Member</option>
                                        @foreach($staff as $member)
                                            <option value="{{ $member->id }}" {{ old('reported_by_staff_id') == $member->id ? 'selected' : '' }}>
                                                {{ $member->first_name }} {{ $member->last_name }} - {{ $member->department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('reported_by_staff_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inmate_id">Inmate Involved (Optional)</label>
                                    <select name="inmate_id" id="inmate_id" class="form-control @error('inmate_id') is-invalid @enderror">
                                        <option value="">Select Inmate (if applicable)</option>
                                        @foreach($inmates as $inmate)
                                            <option value="{{ $inmate->id }}" {{ old('inmate_id') == $inmate->id ? 'selected' : '' }}>
                                                {{ $inmate->first_name }} {{ $inmate->last_name }} (ID: {{ $inmate->id }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('inmate_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_id">Department <span class="text-danger">*</span></label>
                                    <select name="department_id" id="department_id" class="form-control @error('department_id') is-invalid @enderror" required>
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" rows="6"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Provide a detailed description of the incident..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Report Incident
                            </button>
                            <a href="{{ route('security-incidents.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
