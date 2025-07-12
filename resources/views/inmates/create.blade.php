@extends('layout.app')

@section('title', 'Add New Inmate')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-user-plus me-2"></i>
                    Add New Inmate
                </h1>
                <a href="{{ route('inmates.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Inmates
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Inmate Registration Form
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('inmates.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Personal Information -->
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-user me-2"></i>
                                    Personal Information
                                </h6>

                                <div class="mb-3">
                                    <label for="inmate_number" class="form-label">Inmate Number *</label>
                                    <input type="text" class="form-control @error('inmate_number') is-invalid @enderror"
                                           id="inmate_number" name="inmate_number" value="{{ old('inmate_number') }}"
                                           placeholder="Enter unique inmate number" required>
                                    @error('inmate_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">First Name *</label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                                   id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Last Name *</label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                                   id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="date_of_birth" class="form-label">Date of Birth *</label>
                                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                                   id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                            @error('date_of_birth')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="gender" class="form-label">Gender *</label>
                                            <select class="form-select @error('gender') is-invalid @enderror"
                                                    id="gender" name="gender" required>
                                                <option value="">Select Gender</option>
                                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="nationality" class="form-label">Nationality *</label>
                                    <input type="text" class="form-control @error('nationality') is-invalid @enderror"
                                           id="nationality" name="nationality" value="{{ old('nationality') }}" required>
                                    @error('nationality')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Incarceration Details -->
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-gavel me-2"></i>
                                    Incarceration Details
                                </h6>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="admission_date" class="form-label">Admission Date *</label>
                                            <input type="date" class="form-control @error('admission_date') is-invalid @enderror"
                                                   id="admission_date" name="admission_date" value="{{ old('admission_date') }}" required>
                                            @error('admission_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="release_date" class="form-label">Release Date</label>
                                            <input type="date" class="form-control @error('release_date') is-invalid @enderror"
                                                   id="release_date" name="release_date" value="{{ old('release_date') }}">
                                            @error('release_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="sentence_length" class="form-label">Sentence Length *</label>
                                    <input type="text" class="form-control @error('sentence_length') is-invalid @enderror"
                                           id="sentence_length" name="sentence_length" value="{{ old('sentence_length') }}"
                                           placeholder="e.g., 5 years, Life sentence" required>
                                    @error('sentence_length')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="crime_category" class="form-label">Crime Category *</label>
                                    <input type="text" class="form-control @error('crime_category') is-invalid @enderror"
                                           id="crime_category" name="crime_category" value="{{ old('crime_category') }}"
                                           placeholder="e.g., Violent crime, Drug offense" required>
                                    @error('crime_category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="security_level" class="form-label">Security Level *</label>
                                    <select class="form-select @error('security_level') is-invalid @enderror"
                                            id="security_level" name="security_level" required>
                                        <option value="">Select Security Level</option>
                                        <option value="minimum" {{ old('security_level') == 'minimum' ? 'selected' : '' }}>Minimum</option>
                                        <option value="medium" {{ old('security_level') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="maximum" {{ old('security_level') == 'maximum' ? 'selected' : '' }}>Maximum</option>
                                        <option value="supermax" {{ old('security_level') == 'supermax' ? 'selected' : '' }}>Supermax</option>
                                    </select>
                                    @error('security_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Housing Information -->
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-home me-2"></i>
                                    Housing Information
                                </h6>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cell_number" class="form-label">Cell Number *</label>
                                            <input type="text" class="form-control @error('cell_number') is-invalid @enderror"
                                                   id="cell_number" name="cell_number" value="{{ old('cell_number') }}" required>
                                            @error('cell_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="block" class="form-label">Block *</label>
                                            <input type="text" class="form-control @error('block') is-invalid @enderror"
                                                   id="block" name="block" value="{{ old('block') }}"
                                                   placeholder="e.g., A, B, C" required>
                                            @error('block')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-address-book me-2"></i>
                                    Contact Information
                                </h6>

                                <div class="mb-3">
                                    <label for="address_before_incarceration" class="form-label">Address Before Incarceration *</label>
                                    <textarea class="form-control @error('address_before_incarceration') is-invalid @enderror"
                                              id="address_before_incarceration" name="address_before_incarceration"
                                              rows="2" required>{{ old('address_before_incarceration') }}</textarea>
                                    @error('address_before_incarceration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="emergency_contact" class="form-label">Emergency Contact *</label>
                                    <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror"
                                           id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact') }}"
                                           placeholder="Name and phone number" required>
                                    @error('emergency_contact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="next_of_kin" class="form-label">Next of Kin *</label>
                                    <input type="text" class="form-control @error('next_of_kin') is-invalid @enderror"
                                           id="next_of_kin" name="next_of_kin" value="{{ old('next_of_kin') }}"
                                           placeholder="Name and relationship" required>
                                    @error('next_of_kin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-camera me-2"></i>
                                    Additional Information
                                </h6>

                                <div class="mb-3">
                                    <label for="photo" class="form-label">Inmate Photo</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                           id="photo" name="photo" accept="image/*">
                                    <div class="form-text">Upload a recent photo of the inmate (optional)</div>
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('inmates.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Register Inmate
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set default admission date to today
    if (!document.getElementById('admission_date').value) {
        document.getElementById('admission_date').value = new Date().toISOString().split('T')[0];
    }

    // Auto-generate inmate number if empty
    const inmateNumberField = document.getElementById('inmate_number');
    if (!inmateNumberField.value) {
        const timestamp = Date.now().toString().slice(-6);
        inmateNumberField.value = 'INM' + timestamp;
    }
});
</script>
@endsection
