@extends('layout.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus me-2"></i>New Visit Request
        </h1>
        <a href="{{ route('visits.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Visits
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Visit Request Form</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('visits.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="inmate_id" class="form-label">Inmate *</label>
                            <select class="form-control @error('inmate_id') is-invalid @enderror" id="inmate_id" name="inmate_id" required>
                                <option value="">Select Inmate</option>
                                @foreach($inmates as $inmate)
                                    <option value="{{ $inmate->id }}" {{ old('inmate_id') == $inmate->id ? 'selected' : '' }}>
                                        {{ $inmate->name }} ({{ $inmate->inmate_id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('inmate_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="visit_type" class="form-label">Visit Type *</label>
                            <select class="form-control @error('visit_type') is-invalid @enderror" id="visit_type" name="visit_type" required>
                                <option value="">Select Visit Type</option>
                                <option value="family" {{ old('visit_type') == 'family' ? 'selected' : '' }}>Family Visit</option>
                                <option value="legal" {{ old('visit_type') == 'legal' ? 'selected' : '' }}>Legal Visit</option>
                                <option value="official" {{ old('visit_type') == 'official' ? 'selected' : '' }}>Official Visit</option>
                                <option value="religious" {{ old('visit_type') == 'religious' ? 'selected' : '' }}>Religious Visit</option>
                            </select>
                            @error('visit_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="visitor_name" class="form-label">Visitor Name *</label>
                            <input type="text" class="form-control @error('visitor_name') is-invalid @enderror"
                                   id="visitor_name" name="visitor_name" value="{{ old('visitor_name') }}" required>
                            @error('visitor_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="visitor_relationship" class="form-label">Relationship *</label>
                            <input type="text" class="form-control @error('visitor_relationship') is-invalid @enderror"
                                   id="visitor_relationship" name="visitor_relationship" value="{{ old('visitor_relationship') }}" required>
                            @error('visitor_relationship')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="visitor_id_number" class="form-label">Visitor ID Number *</label>
                            <input type="text" class="form-control @error('visitor_id_number') is-invalid @enderror"
                                   id="visitor_id_number" name="visitor_id_number" value="{{ old('visitor_id_number') }}" required>
                            @error('visitor_id_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="visitor_phone" class="form-label">Visitor Phone *</label>
                            <input type="tel" class="form-control @error('visitor_phone') is-invalid @enderror"
                                   id="visitor_phone" name="visitor_phone" value="{{ old('visitor_phone') }}" required>
                            @error('visitor_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="visit_date" class="form-label">Visit Date *</label>
                            <input type="date" class="form-control @error('visit_date') is-invalid @enderror"
                                   id="visit_date" name="visit_date" value="{{ old('visit_date') }}" required>
                            @error('visit_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="visit_time" class="form-label">Visit Time *</label>
                            <input type="time" class="form-control @error('visit_time') is-invalid @enderror"
                                   id="visit_time" name="visit_time" value="{{ old('visit_time') }}" required>
                            @error('visit_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="duration_minutes" class="form-label">Duration (minutes) *</label>
                            <select class="form-control @error('duration_minutes') is-invalid @enderror" id="duration_minutes" name="duration_minutes" required>
                                <option value="">Select Duration</option>
                                <option value="15" {{ old('duration_minutes') == '15' ? 'selected' : '' }}>15 minutes</option>
                                <option value="30" {{ old('duration_minutes') == '30' ? 'selected' : '' }}>30 minutes</option>
                                <option value="45" {{ old('duration_minutes') == '45' ? 'selected' : '' }}>45 minutes</option>
                                <option value="60" {{ old('duration_minutes') == '60' ? 'selected' : '' }}>1 hour</option>
                                <option value="90" {{ old('duration_minutes') == '90' ? 'selected' : '' }}>1.5 hours</option>
                                <option value="120" {{ old('duration_minutes') == '120' ? 'selected' : '' }}>2 hours</option>
                            </select>
                            @error('duration_minutes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="visitor_address" class="form-label">Visitor Address *</label>
                    <textarea class="form-control @error('visitor_address') is-invalid @enderror"
                              id="visitor_address" name="visitor_address" rows="3" required>{{ old('visitor_address') }}</textarea>
                    @error('visitor_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">Additional Notes</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror"
                              id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('visits.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Submit Visit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
